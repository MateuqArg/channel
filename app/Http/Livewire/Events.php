<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\Event;
use App\Models\Visitor;

class Events extends Component
{
    public $event, $selected = [], $search, $inscription = [], $title, $date, $approve;
    public $listeners = ['destroy', 'selected'];

    protected $rules = [
        'event.title' => 'required',
        'event.date' => 'required',
        'event.approve' => '',
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        $events = Event::get()->all();
        $visitors = Visitor::where('approved', null)->get();

        return view('livewire.event.event', compact('events', 'visitors'));
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

        $event = new Event([
            'custid' => $custid,
            'title' => $this->title,
            'date' => $this->date,
            'inscription' => implode("*", $this->inscription),
            'approve' => $this->approve
        ]);
        $event->save();

        Role::create(['name' => $custid]);

        $this->emit('alert', ['title' => '¡Uno más!', 'text' => 'El evento ha sido dado de alta', 'type' => 'success']);
    }

    public function update($id)
    {
        // $this->validate();
        $event = Event::find($id);

        $this->event->save();
        // if (isset($this->title)) {
        //     $event->title = $this->title;
        // }
        // if (isset($this->date)) {
        //     $event->date = $this->date;
        // }
        // if (isset($this->approve)) {
        //     $event->approve = $this->approve;
        // }
        // if (isset($this->inscription)) {
        //     $insc = explode('*', $event->inscription);
        //     // foreach ($this->inscription as $data) {
        //     //     if (in_array($data, $insc) {
                    
        //     //     } else {
        //     //         $user->assignRole($role);
        //     //     }
        //     // }
        // }
        // $event->update();

        $this->emit('alert', ['title' => '¡Arreglado!', 'text' => 'El evento ha sido modificado correctamente', 'type' => 'success']);
    }

    public function destroy($id)
    {
        Event::destroy($id);

        $this->emit('alert', ['title' => '¡Adiós!', 'text' => 'El evento ha sido eliminado', 'type' => 'success']);
    }

    public function cleanData()
    {
        $this->reset(['company', 'charge', 'country', 'state', 'city', 'vip']);
    }

    public function selected($id)
    {
        $event = Event::find($id);

        $this->event->title = $event->title;
        $this->event->date = $event->date;
        $this->event->title = $event->title;
        // foreach(explode('*', $event->inscription) as $data)
        // {
        //     if ('') {
        //         // code...
        //     }
        // }
        $this->event->approve = $event->approve;
    }
}
