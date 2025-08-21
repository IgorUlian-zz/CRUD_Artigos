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

    public $name, $email, $senority, $tags;
    public $password, $password_confirmation;
    public $developer_id;
    public $isOpen = false;
    public $showForm = false;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Developer::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('senority', 'like', '%' . $this->search . '%')
                ->orWhere('tags', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.developer.livewire-developer', [
            'showForm' => $this->showForm,
            'developers' => $query->latest()->paginate(5)
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
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->senority = 'Jr'; // Valor padrão
        $this->tags = '';
        $this->developer_id = null; // A CORREÇÃO: Usar null em vez de ''
    }

    public function store()
    {
        $validationRules = [
            'name' => 'required',
            'senority' => 'required',
            'tags' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('developers')->ignore($this->developer_id),
            ],
        ];

        if ($this->developer_id) {
            $developer = Developer::find($this->developer_id);
            if ($developer) {
                $user = User::where('email', $developer->getOriginal('email'))->first();
                $validationRules['email'][] = Rule::unique('users')->ignore($user->id ?? null);
            }
        } else {
            $validationRules['email'][] = Rule::unique('users');
            $validationRules['password'] = 'required|min:8|confirmed';
        }

        $this->validate($validationRules);

        $developerData = [
            'name' => $this->name,
            'email' => $this->email,
            'senority' => $this->senority,
            'tags' => is_array($this->tags) ? $this->tags : explode(',', $this->tags),
        ];

        if (!empty($this->password)) {
            $developerData['password'] = $this->password;
        }

        $developer = Developer::updateOrCreate(['id' => $this->developer_id], $developerData);

        if (!$this->developer_id) {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
        } else {
            $user = User::where('email', $developer->getOriginal('email'))->first();
            if ($user) {
                $user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                ]);
            }
        }

        session()->flash('message',
            $this->developer_id ? 'Desenvolvedor atualizado com sucesso.' : 'Desenvolvedor e conta de utilizador criados com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $developer = Developer::findOrFail($id);
        $this->developer_id = $id;
        $this->name = $developer->name;
        $this->email = $developer->email;

        // A CORREÇÃO ESTÁ AQUI:
        // Atribui o valor da senioridade do developer à propriedade do componente.
        $this->senority = $developer->senority;

        $this->tags = is_array($developer->tags) ? implode(',', $developer->tags) : '';
        $this->password = '';

        $this->openModal();
    }

    public function delete($id)
    {
        $developer = Developer::find($id);

        if ($developer) {
            $user = User::where('email', $developer->email)->first();
            if ($user) {
                $user->delete();
            }

            $developer->delete();
            session()->flash('message', 'Desenvolvedor e conta de utilizador deletados com sucesso.');
        }
    }
}
