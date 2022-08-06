<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithFileUploads};
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Event;
use App\Models\Visitor;
use App\Models\Email;
use App\Jobs\SendEmail;
use Carbon\Carbon;
use Storage;

class Events extends Component
{
    use WithFileUploads;
    public $event, $show = false, $detail, $emails, $events, $search, $spread, $title, $date, $approve, $tresdias, $registro, $undia, $hoy, $gracias;
    public $listeners = ['destroy', 'show', 'getBack', 'selected', 'refresh' => '$refresh'];

    protected $rules = [
        'event.title' => 'required',
        'event.date' => 'required',
        'event.spread' => 'required',
        'event.approve' => '',
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        // SendEmail::dispatch()->onConnection('database')->delay(Carbon::parse('2022-07-25'));
        $this->events = Event::where('id', 'like', '%'.$this->search.'%')
        ->orWhere('title', 'like', '%'.$this->search.'%')->get();
        $visitors = Visitor::where('approved', null)->get();

        return view('livewire.event.event');
    }

    public function create()
    {
        $this->validate([
            'title' => 'required',
            'date' => 'required',
            'qrfile' => 'required',
            'approve' => 'required'
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

        $qrfile = Storage::disk('public_uploads')->put('/', $this->registro);

        $event = new Event([
            'custid' => $custid,
            'title' => $this->title,
            'date' => $this->date,
            'qrfile' => basename($qrfile),
            'approve' => $approve
        ]);
        $event->save();

        $event->inputs()->attach([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]);

        Role::create(['name' => $custid]);

        $date = Carbon::create($this->date);

        $tresdias = Storage::disk('public_uploads')->put('/', $this->tresdias);

        $email = new Email([
            'event_id' => $event->id,
            'name' => 'Recordatorio 3 días',
            'subject' => 'Solo faltan 3 días para el evento',
            'content' => basename($tresdias),
            'date' => $date->subDays(3),
            'objective' => 'all'
        ]);
        $email->save();
        SendEmail::dispatch($email->id)->onConnection('database')->delay(Carbon::parse('2022-07-25'));

        $undia = Storage::disk('public_uploads')->put('/', $this->undia);

        $email = new Email([
            'event_id' => $event->id,
            'name' => 'Recordatorio 1 día',
            'subject' => 'Solo falta 1 día para el evento',
            'content' => basename($undia),
            'date' => $date->subDays(1),
            'objective' => 'all'
        ]);
        $email->save();
        SendEmail::dispatch($email->id)->onConnection('database')->delay(Carbon::parse('2022-07-25'));

        $hoy = Storage::disk('public_uploads')->put('/', $this->hoy);

        $email = new Email([
            'event_id' => $event->id,
            'name' => 'Recordatorio hoy',
            'subject' => 'El evento está por comenzar',
            'content' => basename($hoy),
            'date' => $this->date,
            'objective' => 'all'
        ]);
        $email->save();
        SendEmail::dispatch($email->id)->onConnection('database')->delay(Carbon::parse('2022-07-25'));

        $gracias = Storage::disk('public_uploads')->put('/', $this->gracias);

        $email = new Email([
            'event_id' => $event->id,
            'name' => 'Gracias',
            'subject' => '¡Gracias por asistir al evento!',
            'content' => basename($hoy),
            'date' => $date->addDay(),
            'objective' => 'all'
        ]);
        $email->save();
        SendEmail::dispatch($email->id)->onConnection('database')->delay(Carbon::parse('2022-07-25'));

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
        if (null !== $this->event->spread) {
            $event->spread = $this->event->spread;
        }
        if (null !== $this->event->approve) {
            $event->approve = $this->event->approve;
        }
        // if (null !== $this->event->inscription) {
        //     $event->inscription = implode('*', $this->event->inscription);
        //     $this->event->inscription = [];
        // }
        $event->update();

        $this->emit('alert', ['title' => '¡Arreglado!', 'text' => 'El evento ha sido modificado correctamente', 'type' => 'success']);
    }

    public function destroy($id)
    {
        Event::destroy($id);

        $this->emit('alert', ['title' => '¡Adiós!', 'text' => 'El evento ha sido eliminado', 'type' => 'success']);
    }

    public function download()
    {
        $all = Event::all();

        foreach ($all as $single) {
            $data[] = array(
                'ID' => $single->id,
                'ID público' => $single->custid,
                'Nombre' => $single->title,
                'Fecha' => $single->date,
                '¿Hace falta aprobar las inscripciones?' => $single->approve
            ); 
        }

        $export = (new FastExcel($data))->download('eventos.xlsx');

        $file_name = "eventos.xlsx";

        $export->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', true);
        $export->headers->set('Content-Disposition', 'attachment; ' .
            'filename="' . rawurldecode($file_name) . '"; ' .
            'filename*=UTF-8\'\'' . rawurldecode($file_name), true);
        $export->headers->set('Cache-Control', 'max-age=0', true);
        $export->headers->set('Pragma', 'public', true);

        $this->emit('alert', ['title' => '¡Descargado!', 'text' => 'El archivo ha sido descargado', 'type' => 'success']);
        return $export;
    }

    public function show($id)
    {
        $this->show = true;
        $this->detail = Event::find($id);


        // $this->event->title = $event->title;
        // $this->event->date = $event->date;
        // $this->event->title = $event->title;

        // // $this->event->inscription = [];
        // // foreach(explode('*', $event->inscription) as $key => $data)
        // // {
        // //     $this->event->inscription = array_merge($this->event->inscription, [$data]);
        // // }
        // $this->event->approve = $event->approve;
        // $this->emails = Email::where('id', '1')->get();
    }

    public function getBack()
    {
        $this->show = false;
        $this->detail = null;
    }

    public function selected($id)
    {
        $event = Event::find($id);

        $this->event->title = $event->title;
        $this->event->date = $event->date;
        $this->event->title = $event->title;

        // $this->event->inscription = [];
        // foreach(explode('*', $event->inscription) as $key => $data)
        // {
        //     $this->event->inscription = array_merge($this->event->inscription, [$data]);
        // }
        $this->event->approve = $event->approve;
    }
}
