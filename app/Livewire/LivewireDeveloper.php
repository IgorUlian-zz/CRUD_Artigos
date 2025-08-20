<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Developer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LivewireDeveloper extends Component
{
use WithPagination;

    public $name, $email, $senority, $tags;
    public $password, $password_confirmation;
    public $id_developer;
    public $isOpen = false;
    public $showForm = false;

    public function render()
    {
        return view('livewire.developer.livewire-developer', [
            'showForm' => $this->showForm,
            'developers' => Developer::paginate(5)
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
        $this->senority = '';
        $this->tags = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->developer_id = '';
    }

    public function store()
    {
        $validationRules = [
            'name' => 'required',
            'email' => 'required|email|unique:developers,email,' . $this->developer_id . '|unique:users,email',
            'senority' => 'required',
            'tags' => 'required'
        ];

        if (!$this->developer_id) {
            $validationRules['password'] = 'required|min:8|confirmed';
        }

        $this->validate($validationRules);

        Developer::updateOrCreate(['id' => $this->developer_id], [
            'name' => $this->name,
            'email' => $this->email,
            'senority' => $this->senority,
            'tags' => explode(',', $this->tags)
        ]);

        if (!$this->developer_id) {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
        }

        session()->flash('message',
            $this->developer_id ? 'Desenvolvedor atualizado com sucesso.' : 'Desenvolvedor e conta de usuário criados com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $developer = Developer::findOrFail($id);
        $this->developer_id = $id;
        $this->name = $developer->name;
        $this->email = $developer->email;
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
            session()->flash('message', 'Desenvolvedor e conta de usuário deletados com sucesso.');
        }
    }
}
