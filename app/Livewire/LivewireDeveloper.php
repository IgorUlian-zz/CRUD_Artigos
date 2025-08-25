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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Developer::query();

        if ($this->search) {
            $searchTerm = strtolower($this->search);

            $query->where(function ($q) use ($searchTerm) {
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
        $this->seniority = 'Jr';
        $this->tags = '';
    }

    public function store()
    {
        $validationRules = [
            'seniority' => 'required',
            'tags' => 'required',
        ];

        if ($this->developer_id) {
            $developer = Developer::find($this->developer_id);
            $userIdToIgnore = $developer->user ? $developer->user->id : null;
            $validationRules['email'] = ['required', 'email', Rule::unique('users')->ignore($userIdToIgnore)];
        } else {
            $validationRules['email'] = ['required', 'email', Rule::unique('users')];
            $validationRules['password'] = 'required|min:8|confirmed';
        }

        $this->validate($validationRules);

        $developerData = [
            'seniority' => $this->seniority,
            'tags' => is_array($this->tags) ? $this->tags : array_map('trim', explode(',', $this->tags)),
        ];

        if ($this->developer_id) {
            $developer = Developer::findOrFail($this->developer_id);
            $developer->update($developerData);

            if ($developer->user) {
                $developer->user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                ]);
            }
            session()->flash('message', 'Desenvolvedor atualizado com sucesso.');

        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            $user->developer()->create($developerData);

            session()->flash('message', 'Desenvolvedor e conta de utilizador criados com sucesso.');
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $developer = Developer::with('user')->findOrFail($id);

        $this->developer_id = $id;
        $this->seniority = $developer->seniority;

        $this->email = $developer->user->email;
        $this->name = $developer->user->name;
        $this->tags = is_array($developer->tags) ? implode(', ', $developer->tags) : '';
        $this->password = '';
        $this->password_confirmation = '';

        $this->openModal();
    }

    public function delete($id)
    {
        $developer = Developer::with('user')->find($id);

        if ($developer) {
            if ($developer->user) {
                $developer->user->delete();
            } else {
                $developer->delete();
            }
            session()->flash('message', 'Desenvolvedor e conta de utilizador deletados com sucesso.');
        }
    }
}
