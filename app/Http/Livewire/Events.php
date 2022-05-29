<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Event;
use App\Models\Visitor;
use App\Models\Email;
use App\Jobs\SendEmail;
use Carbon\Carbon;

class Events extends Component
{
    public $event, $show = false, $detail, $emails, $events, $search, $inscription = [], $title, $date, $approve;
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
            'spread' => 'required'
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
            'spread' => $this->spread,
            // 'inscription' => implode("*", $this->inscription),
            'approve' => $approve
        ]);
        $event->save();

        Role::create(['name' => $custid]);

        $date = Carbon::create($this->date);

        $email = new Email([
            'name' => 'Recordatorio 3 días',
            'subject' => 'Solo faltan 3 días para el evento',
            'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://mediaware.org/channeltalks/imagenes/3dias.jpg" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"></div></td></tr></tbody></table>',
            'date' => $date->subDays(3),
            'objective' => 'all'
        ]);
        $email->save();
        SendEmail::dispatch($email->id)->onConnection('database')->delay(Carbon::parse('2022-07-25'));

        $email = new Email([
            'name' => 'Recordatorio 1 día',
            'subject' => 'Solo falta 1 día para el evento',
            'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://mediaware.org/channeltalks/imagenes/1dia.jpg" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"></div></td></tr></tbody></table>',
            'date' => $date->subDays(1),
            'objective' => 'all'
        ]);
        $email->save();
        SendEmail::dispatch($email->id)->onConnection('database')->delay(Carbon::parse('2022-07-25'));

        $email = new Email([
            'name' => 'Recordatorio hoy',
            'subject' => 'El evento está por comenzar',
            'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://mediaware.org/channeltalks/imagenes/hoy.jpg" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"></div></td></tr></tbody></table>',
            'date' => $this->date,
            'objective' => 'all'
        ]);
        $email->save();
        SendEmail::dispatch($email->id)->onConnection('database')->delay(Carbon::parse('2022-07-25'));

        $email = new Email([
            'name' => 'Gracias',
            'subject' => '¡Gracias por asistir al evento!',
            'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://mediaware.org/channeltalks/imagenes/gracias.jpg" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"></div></td></tr></tbody></table>',
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
