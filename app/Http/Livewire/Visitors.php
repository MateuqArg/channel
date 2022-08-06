<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination};
use Illuminate\Support\Facades\Cache;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\{Visitor, Meeting, Event};
use Sheets;

class Visitors extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $event, $search, $company, $charge, $country, $state, $city, $vip, $drawprices;
    public $readyToLoad = false;
    public $cant = '10', $downtype = 'all';

    protected $rules = [
        'event' => 'required',
        'drawprices' => 'array',
    ];

    public $listeners = ['destroy', 'draw', 'updatingSearch'];

    public function __construct()
    {
        $this->event = Event::orderBy('id', 'DESC')->first()->id;
    }

    public function render()
    {
        $input = preg_quote(strtolower($this->search), '~');

        if ($this->readyToLoad) {
            $visitors = Visitor::
            where('event_id', $this->event)
            ->when($input, function($query) use ($input) {
                $query->where('custid', 'like', '%'.$input.'%')
                    ->orWhere('name', 'like', '%'.$input.'%')
                    ->orWhere('company', 'like', '%'.$input.'%'); 
            })
            ->orderBy('event_id', 'DESC');

            $presents = $visitors->where('present', 1)->count();
            $vips = $visitors->where('vip', 1)->count();

            $visitors = Visitor::
            where('event_id', $this->event)
            ->when($input, function($query) use ($input) {
                $query->where('custid', 'like', '%'.$input.'%')
                    ->orWhere('name', 'like', '%'.$input.'%')
                    ->orWhere('company', 'like', '%'.$input.'%'); 
            })
            ->orderBy('event_id', 'DESC')->paginate($this->cant);

        } else {
            $visitors = [];
            $presents = '0';
            $vips = '0';
        }

        $events = Event::orderBy('id', 'DESC')->get();
        $approve = Visitor::where('approved', null)->where('event_id', $this->event)->get();

        return view('livewire.visitor.visitor', compact('visitors', 'presents', 'vips', 'events', 'approve'));
    }

    public function loadVisitors()
    {
        $this->readyToLoad = true;
    }

    public function update($id)
    {
        $visitor = Visitor::find($id);

        if ($this->vip == true) {
            $visitor->vip = true;
        } else {
            $visitor->vip = false;
        }
        $visitor->update();

        $this->emit('alert', 'Asistente modificado correctamente');
        $this->emit('cleanData');
    }

    public function destroy($id)
    {
        Visitor::destroy($id);
    }

    public function download()
    {
        if ($this->downtype == 'all') {
            $all = Visitor::where('event_id', $this->event)->get();
        } else if ($this->downtype == 'presents') {
            $all = Visitor::where('event_id', $this->event)->where('present', 1)->get();
        } else if ($this->downtype == 'vips') {
            $all = Visitor::where('event_id', $this->event)->where('vip', 1)->get();
        }

        $event = Event::find($this->event);

        // $data[] = $event->inputs->toArray();

        // $header = array(
        //         'ID' => '',
        //         'ID público' => '',
        //         '¿Aprobado?' => '',
        //         '¿Presente?' => '',
        //         'Evento' => '',
        //         'Nombre' => '',
        //         'Correo' => '',
        //         'Teléfono' => '',
        //         'Empresa' => '',
        //         'Cargo' => '',
        //         'Provincia' => '',
        //         'Ciudad' => '',
        //     );

        // foreach ($event->inputs as $input) {
        //     $header[$input->label] = '';
        // }

        // $data[] = $header;
        foreach ($all as $single) {
            foreach($single->responses as $response) {
                $input = $response->input;
                $responses[$input->label] = $response->value;
            }

            $info = array(
                'ID' => $single->id,
                'ID público' => $single->custid,
                '¿Aprobado?' => $single->approved,
                '¿Presente?' => $single->present,
                'Evento' => $single->event->title,
                'Nombre' => $single->name,
                'Correo' => $single->email,
                'Teléfono' => $single->phone,
                'Empresa' => $single->company,
                'Cargo' => $single->charge,
                'Provincia' => $single->state,
                'Ciudad' => $single->city,
            );

            $data[] = array_merge($info, $responses);
        }
// dd($data);
        $header = ['ID', 'NAME', ];  // this is my custom header

        $export = (new FastExcel(usersGenerator()))->withoutHeaders()->download('asistentes.xlsx');

        $file_name = "asistentes.xlsx";

        $export->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', true);
        $export->headers->set('Content-Disposition', 'attachment; ' .
            'filename="' . rawurldecode($file_name) . '"; ' .
            'filename*=UTF-8\'\'' . rawurldecode($file_name), true);
        $export->headers->set('Cache-Control', 'max-age=0', true);
        $export->headers->set('Pragma', 'public', true);

        $this->emit('alert', ['title' => '¡Descargado!', 'text' => 'El archivo ha sido descargado', 'type' => 'success']);
        return $export;
    }

    public function draw($cant)
    {
        $count = Visitor::all()->count();
        $visitors = Visitor::all();

        $nums = [];
        $prices = [];
        for ($i=0; $i < $cant; $i++) { 
           do {
            $price = random_int(1, $count);
            } while (in_array($price, $nums));
            $nums[] = $price;
            $prices[] = $visitors[$price-1]->name;
        }

        $this->drawprices = $prices;
        
    }

    public function cleanData()
    {
        $this->reset(['company', 'charge', 'country', 'state', 'city', 'vip']);
    }
}
