<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Talk;
use App\Models\Event;
use App\Models\User;

class Talks extends Component
{
    public $search, $cretalk, $talk, $event, $talks;
    public $listeners = ['destroy', 'selected', 'refresh' => '$refresh', 'cleanData'];

    protected $rules = [
        'talk.event' => 'required',
        'talk.exhibitor' => 'required',
        'talk.title' => 'required',
        'cretalk.event' => 'required',
        'cretalk.exhibitor' => 'required',
        'cretalk.title' => 'required'
    ];

    public function mount(Talk $talk)
    {
        $this->talk = $talk;
        $this->cretalk = $talk;
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
        do {
            $custid = createCustomid();
        } while (Talk::where('custid', $custid)->first() <> null);

        if ($this->cretalk->event == null) {
            $event = Event::get()->first();
            $this->cretalk->event = $event->id;
        }

        if ($this->cretalk->exhibitor == null) {
            $exhibitor = User::whereHas('roles', function($q){$q->where('name', 'exhibitor');})->first();
            $this->cretalk->exhibitor = $exhibitor->id;
        }

        $talk = new Talk([
            'custid' => $custid,
            'event_id' => $this->cretalk->event,
            'exhibitor_id' => $this->cretalk->exhibitor,
            'title' => $this->cretalk->title
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

    public function download()
    {
        $all = Talk::all();

        foreach ($all as $single) {
            $data[] = array(
                'ID' => $single->id,
                'ID público' => $single->custid,
                'Evento' => $single->event->title,
                'Expositor' => $single->exhibitor->name,
                'Titulo' => $single->title,
            ); 
        }

        $export = (new FastExcel($data))->download('charlas.xlsx');

        $file_name = "charlas.xlsx";

        $export->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', true);
        $export->headers->set('Content-Disposition', 'attachment; ' .
            'filename="' . rawurldecode($file_name) . '"; ' .
            'filename*=UTF-8\'\'' . rawurldecode($file_name), true);
        $export->headers->set('Cache-Control', 'max-age=0', true);
        $export->headers->set('Pragma', 'public', true);

        $this->emit('alert', ['title' => '¡Descargado!', 'text' => 'El archivo ha sido descargado', 'type' => 'success']);
        return $export;
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
