<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Talk;

class Tracks extends Component
{
    public $talk, $currentEvent = 'Respuestas de formulario 1';
    // public $listeners = ['selectd'];

    protected $rules = [
        'talk' => '',
    ];

    public function render()
    {
        $talks = Talk::where('event_id', substr($this->currentEvent, strrpos($this->currentEvent, ' ') + 1))->get();

        return view('livewire.qrnav', compact('talks'));
    }

    public function changeTrack()
    {
        if ($this->talk == null) {
            $talk = Talk::first();
            Session::put('talk', $talk->title);
            Session::put('talk_id', $talk->id);
        } else {
            $talk = Talk::find($this->talk);
            Session::put('talk', $talk->title);
            Session::put('talk_id', $talk->id);
        }
    }

    // public function selectd()
    // {
    //     $this->talk = Session::get('talk_id');
    // }
}
