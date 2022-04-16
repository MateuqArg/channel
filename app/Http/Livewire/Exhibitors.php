<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\User;

class Exhibitors extends Component
{
    public function render()
    {
        $events = Event::get()->all();
        $exhibitors = User::whereHas('roles', function($q){
            $q->where('name', 'exhibitor');
        })->get();

        return view('livewire.exhibitor.exhibitor', compact('events', 'exhibitors'));
    }
}
