<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\{Talk, Track, Visitor, Group};

class Tracks extends Component
{
    public $talk, $link, $currentEvent = 'Respuestas de formulario 1';
    public $listeners = ['barScanner', 'changeTrack', 'loadTrack'];

    protected $rules = [
        'talk' => '',
        'link' => ''
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

        // dd(substr($this->link, -6));
    }

    // public function loadTrack()
    // {
    //     $this->talk = Session::get('talk_id');
    //     // $this->talk->id = Session::get('talk_id');
    //     dd($this->talk);
    // }

    public function barScanner()
    {
        $visitor = Visitor::where('custid', substr($this->link, -6))->first();
        if (!empty($visitor)) {
            $check = Track::where('visitor_id', $visitor->id)->where('talk_id', Session::get('talk_id'))->first();

            // if (empty($check)) {
                $track = new Track([
                    'visitor_id' => $visitor->id,
                    'talk_id' => Session::get('talk_id'),
                ]);
                $track->save();

                $group = Group::where('title', Session::get('talk'))->first();
                // dd($group->id);
                $visitor->groups()->attach($group->id);
            // }
            $this->link = null;
            $this->emit('alert', ['title' => '¡Aceptado!', 'text' => 'El ingreso ha sido registrado correctamente', 'type' => 'success']);
        } else {
            $this->link = null;
            $this->emit('alert', ['title' => '¡No encontrado!', 'text' => 'No se ha encontrado el asistente', 'type' => 'error']);
        }
    }
}
