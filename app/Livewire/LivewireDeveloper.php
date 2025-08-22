<?php

namespace App\Livewire;

use App\Models\Developer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class LivewireDeveloper extends Component
{
    use WithPagination;

    // Propriedades do formulário
    public $name, $email, $seniority, $tags;
    public $password, $password_confirmation;

    // Propriedades de controle
    public $developer_id;
    public $isOpen = false;
    public $search = '';

    // COMENTÁRIO: Este método do Livewire é chamado sempre que a propriedade 'search' é atualizada.
    // Ele garante que a paginação volte para a primeira página ao iniciar uma nova busca.
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Developer::query();

        if ($this->search) {
            // COMENTÁRIO: Convertemos o termo de busca para minúsculas aqui, uma única vez.
            $searchTerm = strtolower($this->search);

            $query->where(function ($q) use ($searchTerm) {
                // ANTES: $q->where('name', 'like', '%' . $this->search . '%');
                // DEPOIS: Usamos whereRaw para aplicar a função LOWER() na coluna do banco.
                $q->whereRaw('LOWER(seniority) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereRaw('LOWER(tags) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->whereRaw('LOWER(email) LIKE ?', ['%' . $searchTerm . '%']);
                  })
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
                  });
            });
        }

        return view('livewire.developer.livewire-developer', [
            'developers' => $query->with('user')->latest()->paginate(5)
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->developer_id = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->seniority = 'Jr'; // Valor padrão para o select/radio no formulário.
        $this->tags = '';
    }

    public function store()
    {
        // 1. REGRAS DE VALIDAÇÃO
        $validationRules = [
            'seniority' => 'required',
            'tags' => 'required',
        ];

        // ALTERAÇÃO: A validação do email foi simplificada e agora foca apenas na tabela 'users'.
        if ($this->developer_id) {
            // ATUALIZAÇÃO: Encontra o usuário pelo relacionamento para ignorá-lo na validação de email único.
            $developer = Developer::find($this->developer_id);
            $userIdToIgnore = $developer->user ? $developer->user->id : null;
            $validationRules['email'] = ['required', 'email', Rule::unique('users')->ignore($userIdToIgnore)];
        } else {
            // CRIAÇÃO: O email deve ser único na tabela 'users' e a senha é obrigatória.
            $validationRules['email'] = ['required', 'email', Rule::unique('users')];
            $validationRules['password'] = 'required|min:8|confirmed';
        }

        $this->validate($validationRules);

        // 2. LÓGICA DE CRIAÇÃO OU ATUALIZAÇÃO
        // ALTERAÇÃO: O array de dados do Developer foi limpo. Ele não contém mais 'email'.
        $developerData = [
            'seniority' => $this->seniority,
            // COMENTÁRIO: Transforma a string de tags (separada por vírgulas) em um array para salvar no DB.
            'tags' => is_array($this->tags) ? $this->tags : array_map('trim', explode(',', $this->tags)),
        ];

        // SE ESTIVER ATUALIZANDO
        if ($this->developer_id) {
            $developer = Developer::findOrFail($this->developer_id);
            $developer->update($developerData);

            // Atualiza os dados da conta User associada, usando o relacionamento.
            if ($developer->user) {
                $developer->user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                ]);
            }
            session()->flash('message', 'Desenvolvedor atualizado com sucesso.');

        // SE ESTIVER CRIANDO
        } else {
            // Primeiro, cria a conta de User para o login.
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            // Segundo, cria o perfil de Developer associado ao User.
            // O método 'create' no relacionamento já preenche o 'user_id' automaticamente.
            $user->developer()->create($developerData);

            session()->flash('message', 'Desenvolvedor e conta de utilizador criados com sucesso.');
        }

        // 3. FINALIZAÇÃO
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $developer = Developer::with('user')->findOrFail($id);

        $this->developer_id = $id;
        $this->seniority = $developer->seniority;

        // ALTERAÇÃO: O email agora é buscado a partir do relacionamento com o User.
        $this->email = $developer->user->email;
        $this->name = $developer->user->name;

        // COMENTÁRIO: Transforma o array de tags de volta em uma string para exibir no campo de texto.
        $this->tags = is_array($developer->tags) ? implode(', ', $developer->tags) : '';

        // Limpa os campos de senha ao abrir o modal de edição.
        $this->password = '';
        $this->password_confirmation = '';

        $this->openModal();
    }

    public function delete($id)
    {
        $developer = Developer::with('user')->find($id);

        if ($developer) {
            // ALTERAÇÃO: A lógica de exclusão agora é muito mais simples e segura.
            // Ao deletar o 'User', o banco de dados (se configurado com onDelete('cascade'))
            // irá automaticamente deletar o perfil 'Developer' associado.
            if ($developer->user) {
                $developer->user->delete();
            } else {
                // Caso exista um Developer "órfão" (sem User), deleta apenas ele.
                $developer->delete();
            }
            session()->flash('message', 'Desenvolvedor e conta de utilizador deletados com sucesso.');
        }
    }
}
