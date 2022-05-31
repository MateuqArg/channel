<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination, WithFileUploads};
use App\Models\User;
use Storage;

class Users extends Component
{
    use WithPagination; use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $search, $file, $user;
    public $readyToLoad = false;
    public $cant = '10', $downtype = 'all';

    public $listeners = ['destroy', 'selected', 'refresh' => '$refresh'];

    protected $rules = [
        'user.name' => 'required',
        'user.email' => 'required',
        'user.role' => 'array',
        'file' => ''
    ];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        if ($this->readyToLoad) {
            $users = User::paginate($this->cant);
        } else {
            $users = [];
        }

        $roles = \Spatie\Permission\Models\Role::all();

        return view('livewire.users.users', compact('users', 'roles'));
    }

    public function update($id)
    {
        $this->validate([
            'user.name' => 'required',
            'user.email' => 'required',
            'user.role' => 'required',
            'file' => '',
        ]);


        $user = User::find($id);
        if (null !== $this->user->name) {
            $user->name = $this->user->name;
        }
        if (null !== $this->user->email) {
            $user->email = $this->user->email;
        }
        if (null !== $this->file) {
            $avatar = Storage::disk('public_uploads')->put('/', $this->file);
            $user->avatar = basename($avatar);
        }
        if (null !== $this->user->role) {
            $user->syncRoles($this->user->role);
        }

        $user->update();

        $this->emit('alert', ['title' => '¡Arreglado!', 'text' => 'El usuario ha sido modificado correctamente', 'type' => 'success']);
    }

    public function destroy($id)
    {
        User::destroy($id);

        $this->emit('alert', ['title' => '¡Adiós!', 'text' => 'El usuario ha sido eliminado', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function loadUsers()
    {
        $this->readyToLoad = true;
    }

    public function selected($id)
    {
        $user = User::find($id);

        $this->user->name = $user->name;
        $this->user->email = $user->email;
        $this->user->role = $user->getRoleNames();
    }
}
