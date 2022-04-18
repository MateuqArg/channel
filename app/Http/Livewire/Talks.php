<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Talk;
use App\Models\Event;
use App\Models\User;

class Talks extends Component
{
    public $search, $talk, $event, $talks;
    public $listeners = ['destroy', 'selected', 'refresh' => '$refresh', 'cleanData'];

    protected $rules = [
        'talk.event' => 'required',
        'talk.exhibitor' => 'required',
        'talk.title' => 'required'
    ];

    public function mount(Talk $talk)
    {
        $this->talk = $talk;
    }

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
        // dd($this);
        do {
            $custid = createCustomid();
        } while (Talk::where('custid', $custid)->first() <> null);

        $talk = new Talk([
            'custid' => $custid,
            'event_id' => $this->talk->event,
            'exhibitor_id' => $this->talk->exhibitor,
            'title' => $this->talk->title
        ]);
        $talk->save();

        $this->emit('alert', ['title' => '¡Una más!', 'text' => 'La charla ha sido dada de alta', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function update($id)
    {
        $talk = Talk::find($id);

        if (null !== $this->talk->event) {
            $talk->event_id = $this->talk->event;
        }
        if (null !== $this->talk->exhibitor) {
            $talk->exhibitor_id = $this->talk->exhibitor;    
        }
        if (null !== $this->talk->title) {
            $talk->title = $this->talk->title;
        }

        $talk->update();

        $this->emit('alert', ['title' => '¡Arreglado!', 'text' => 'La charla ha sido modificada correctamente', 'type' => 'success']);
    }

    public function destroy($id)
    {
        Talk::destroy($id);

        $this->emit('alert', ['title' => '¡Adiós!', 'text' => 'La charla ha sido eliminada', 'type' => 'success']);
    }

    public function selected($id)
    {
        $talk = Talk::find($id);

        $this->talk->event = $talk->event->id;
        $this->talk->exhibitor = $talk->exhibitor->id;
        $this->talk->title = $talk->title;
    }

    public function cleanData()
    {
        $this->talk->event = null;
        $this->talk->exhibitor = null;
        $this->talk->title = null;
    }
}
