<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;

class Profiles extends Component
{
    public function render()
    {
        $this->user = Auth::user();

        return view('livewire.profile');
    }

    public function update()
    {
        
    }
}
