<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use App\Models\{Talk, Track, Visitor, Group};
use Auth;

class Tracks extends Component
{
    public $talk, $link;
    public $listeners = ['barScanner', 'changeTrack', 'loadTrack'];

    protected $rules = [
        'talk' => '',
        'link' => ''
    ];

    public function render()
    {
        if (Auth::user()->hasRole('organizer')) {
            $talks = Talk::all();
        } else if (Auth::user()->hasRole('exhibitor')) {
            $talks = Talk::where('exhibitor_id', Auth::user()->id)->get();
        }

        return view('livewire.qrnav', compact('talks'));
    }

    public function changeTrack()
    {
        if ($this->talk == null) {
            if (Auth::user()->hasRole('organizer')) {
                $talk = Talk::first();
            } else if (Auth::user()->hasRole('exhibitor')) {
                $talk = Talk::where('exhibitor_id', Auth::user()->id)->first();
            }

            Session::put('talk', $talk->title);
            Session::put('talk_id', $talk->id);
        } else {
            $talk = Talk::find($this->talk);
            Session::put('talk', $talk->title);
            Session::put('talk_id', $talk->id);
        }
    }

    public function barScanner()
    {
        $visitor = Visitor::where('custid', substr($this->link, -6))->first();

        if (!empty($visitor)) {
            $check = Track::where('visitor_id', $visitor->id)->where('talk_id', Session::get('talk_id'))->where('extra', null)->first();

            if (empty($check)) {
                $track = new Track([
                    'visitor_id' => $visitor->id,
                    'talk_id' => Session::get('talk_id'),
                ]);
                $track->save();

                $group = Group::where('title', Session::get('talk'))->first();

                $visitor->groups()->attach($group->id);
            }
            $this->link = null;
            $this->emit('alert', ['title' => '¡Aceptado!', 'text' => 'El ingreso ha sido registrado correctamente', 'type' => 'success']);
        } else {
            $this->link = null;
            $this->emit('alert', ['title' => '¡No encontrado!', 'text' => 'No se ha encontrado el asistente', 'type' => 'error']);
        }
    }
}
