<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\User;
use Auth;

class Exhibitors extends Component
{
    public $user, $exhibitor, $exhibitors, $search;
    public $listeners = ['destroy', 'selected', 'refresh' => '$refresh'];

    protected $rules = [
        'exhibitor.role' => 'array',
        'user.id' => 'array',
    ];

    public function mount(User $exhibitor)
    {
        $this->exhibitor = $exhibitor;
    }

    public function render()
    {
        $events = Event::get()->all();
        $users = User::whereDoesntHave('roles', function($q){
            $q->where('name', 'exhibitor');
        })->get();
        $this->exhibitors = User::where('id', 'like', '%'.$this->search.'%')
        ->whereHas('roles', function($q){
            $q->where('name', 'exhibitor');
        })->get();
        $roles = \Spatie\Permission\Models\Role::all();
        $user = Auth::user();

        return view('livewire.exhibitor.exhibitor', compact('users', 'events', 'roles', 'user'));
    }

    public function create()
    {
        foreach($this->user['id'] as $id) {
            $exhibitor = User::find($id);

            $exhibitor->assignRole('exhibitor');
        }

        $this->emit('alert', ['title' => '¡Uno más!', 'text' => 'El expositor ha sido dado de alta', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function destroy($id)
    {
        $exhibitor = User::find($id);

        $exhibitor->removeRole('exhibitor');

        $this->emit('alert', ['title' => '¡Adiós!', 'text' => 'El expositor ha sido eliminado', 'type' => 'success']);
    }

    public function update($id)
    {
        $exhibitor = User::find($id);

        $this->exhibitor->role = array_merge($this->exhibitor->role, ['exhibitor']);

        $exhibitor->syncRoles($this->exhibitor->role);

        $this->emit('alert', ['id' => $id, 'title' => '¡Arreglado!', 'text' => 'El expositor ha sido modificado', 'type' => 'success']);
    }

    public function selected($id)
    {
        $exhibitor = User::find($id);

        $this->exhibitor->role = [];
        foreach($exhibitor->getRoleNames() as $data)
        {
            if(strlen($data) == 6) {
                $this->exhibitor->role = array_merge($this->exhibitor->role, [$data]);
            }
        }
        $this->exhibitor->role = array_merge($this->exhibitor->role, ['organizer']);
        $this->exhibitor->role = array_merge($this->exhibitor->role, ['exhibitor']);
    }
}
