<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Talk;
use App\Models\Event;
use App\Models\User;

class Talks extends Component
{
    public $event, $new_talk, $exhibitor, $title, $talks;

    public $listeners = ['destroy'];

    public function render()
    {
        $this->events = Event::get()->all();
        $this->talks = Talk::get()->all();
        $this->exhibitors = User::whereHas('roles', function($q){
            $q->where('name', 'exhibitor');
        })->get();

        return view('livewire.talk.talk');
    }

    public function create()
    {
        dd($this);
        if ($this->new_talk == 'on') {
            do {
                $custid = createCustomid();
            } while (Talk::where('custid', $custid)->first() <> null);

            $talk = new Talk([
                'custid' => $custid,
                'event_id' => $this->event,
                'exhibitor_id' => $this->exhibitor,
                'title' => $this->title
            ]);
            $talk->save();
        } else {
            foreach ($this->talks as $talk) {
                $talk = Talk::find($talk);
                
                $talk->exhibitor_id = $this->exhibitor;
                $talk->update();
            }
        }
    }

    public function update($id)
    {
        $talk = Talk::find($id);

        if (isset($this->event)) {
            $talk->event = $this->event;
        }
        if (isset($this->exhibitor)) {
            $talk->exhibitor = $this->exhibitor;    
        }
        if (isset($this->title)) {
            $talk->title = $this->title;
        }
        $talk->update();

        $this->emit('alert', 'Asistente modificado correctamente');
    }

    public function destroy($id)
    {
        Talk::destroy($id);
    }
}
