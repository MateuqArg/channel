<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\Event;
use App\Models\Visitor;

class Events extends Component
{
    public $event, $events, $search, $inscription = [], $title, $date, $approve;
    public $listeners = ['destroy', 'selected', 'refresh' => '$refresh'];

    protected $rules = [
        'event.title' => 'required',
        'event.date' => 'required',
        'event.inscription' => 'array',
        'event.approve' => '',
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        $this->events = Event::where('id', 'like', '%'.$this->search.'%')
        ->orWhere('title', 'like', '%'.$this->search.'%')->get();
        $visitors = Visitor::where('approved', null)->get();

        return view('livewire.event.event');
    }

    public function create()
    {
        // dd($this);
        $this->validate([
            'title' => 'required',
            'date' => 'required',
            'inscription' => 'required',
        ]);

        if ($this->approve) {
            $this->approve = false;
        }

        do {
            $custid = createCustomid();
        } while (Event::where('custid', $custid)->first() <> null);

        if ($this->approve == null) {
            $approve = false;
        } else {
            $approve = true;
        }

        $event = new Event([
            'custid' => $custid,
            'title' => $this->title,
            'date' => $this->date,
            'inscription' => implode("*", $this->inscription),
            'approve' => $approve
        ]);
        $event->save();

        Role::create(['name' => $custid]);

        $this->emit('alert', ['title' => '¡Uno más!', 'text' => 'El evento ha sido dado de alta', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function update($id)
    {
        $event = Event::find($id);

        if (null !== $this->event->title) {
            $event->title = $this->event->title;
        }
        if (null !== $this->event->date) {
            $event->date = $this->event->date;
        }
        if (null !== $this->event->approve) {
            $event->approve = $this->event->approve;
        }
        if (null !== $this->event->inscription) {
            $event->inscription = implode('*', $this->event->inscription);
            $this->event->inscription = [];
        }
        $event->update();

        $this->emit('alert', ['title' => '¡Arreglado!', 'text' => 'El evento ha sido modificado correctamente', 'type' => 'success']);
    }

    public function destroy($id)
    {
        Event::destroy($id);

        $this->emit('alert', ['title' => '¡Adiós!', 'text' => 'El evento ha sido eliminado', 'type' => 'success']);
    }

    public function selected($id)
    {
        $event = Event::find($id);

        $this->event->title = $event->title;
        $this->event->date = $event->date;
        $this->event->title = $event->title;

        $this->event->inscription = [];
        foreach(explode('*', $event->inscription) as $key => $data)
        {
            $this->event->inscription = array_merge($this->event->inscription, [$data]);
        }
        $this->event->approve = $event->approve;
    }
}
