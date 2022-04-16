<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\User;
use Auth;

class Exhibitors extends Component
{
    public $role = [], $search;

    public $listeners = ['cleanData'];

    public function render()
    {
        $events = Event::get()->all();
        $this->exhibitors = User::where('id', 'like', '%'.$this->search.'%')
        ->whereHas('roles', function($q){
            $q->where('name', 'exhibitor');
            // $q->where('name', 'like', '%'.$this->search.'%');
        })->get();
        $roles = \Spatie\Permission\Models\Role::all();
        $user = Auth::user();

        return view('livewire.exhibitor.exhibitor', compact('events', 'roles', 'user'));
    }

    public function update($id)
    {
        $exhibitor = User::find($id);
        $user = Auth::user();

        foreach ($this->role as $role) {
            if ($user->hasRole($role)) {
                $user->removeRole($role);
            } else {
                $user->assignRole($role);
            }
        }

        $this->emit('alert', 'Expositor modificado correctamente');
        $this->emit('cleanData');
    }

    public function cleanData()
    {
        $this->reset(['role']);
    }
}
