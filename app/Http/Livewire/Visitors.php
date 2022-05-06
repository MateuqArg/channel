<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination};
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Visitor;
use App\Models\Meeting;
use Sheets;

class Visitors extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search, $company, $charge, $country, $state, $city, $vip;
    public $readyToLoad = false;
    public $cant = '10';

    public $listeners = ['destroy'];

    public function __construct()
    {
        $this->spread = '1KZXp18tUAQvlpHsI9n8QIH24osjQuECQ0hso7fjZ-Nw';
        $this->currentEvent = 'Respuestas de formulario 1';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $header = $sheets->pull(0);
        $this->forms = Sheets::collection($header, $sheets);

        if ($this->readyToLoad) {
            $visitors = Visitor::where('custid', 'like', '%'.$this->search.'%')->orderBy('event_id')->paginate($this->cant);
        } else {
            $visitors = [];
        }

        return view('livewire.visitor.visitor', compact('visitors'));
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
        $export = (new FastExcel(Visitors::all()))->download('asistentes.xlsx');

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

    public function cleanData()
    {
        $this->reset(['company', 'charge', 'country', 'state', 'city', 'vip']);
    }
}
