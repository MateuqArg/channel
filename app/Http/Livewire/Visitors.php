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
        $this->spread = '1qCqKCFDEskSdIHq0p7lWwZupleeRG5nBI7on7_uwqmE';
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

        foreach ($this->forms as $form) {
            $names[$form['id']] = strtolower($form['Nombre completo']);
        }

        foreach ($this->forms as $form) {
            $companies[$form['id']] = strtolower($form['Empresa']);
        }

        if (substr($this->search, 0, 4) == 'http') {
//return redirect()->to('/organizer/visitor/'.substr($this->search, -6));
            $this->search = substr($this->search, -6);
        }

        $input = preg_quote(strtolower($this->search), '~');

        $ids = [];
        foreach (preg_grep('~' . $input . '~', $names) as $key => $result) {
            $ids[] = $key;
        }

        foreach (preg_grep('~' . $input . '~', $companies) as $key => $result) {
            $ids[] = $key;
        }

        if ($this->readyToLoad) {
            $visitors = Visitor::
            where('custid', 'like', '%'.$this->search.'%')
            ->orWhereIn('id', $ids)
            ->orderBy('event_id')->paginate($this->cant);
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
        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $header = $sheets->pull(0);
        $forms = Sheets::collection($header, $sheets);
        $all = Visitor::all();

        foreach ($all as $single) {
            $data[] = array(
                'ID' => $single->id,
                'ID público' => $single->custid,
                'Evento' => $single->event->title,
                'Nombre' => $forms[$single->form_id]['Nombre completo'],
                'Correo' => $forms[$single->form_id]['Direccion de email'],
                'Teléfono' => $forms[$single->form_id]['Telefono'],
                'Empresa' => $forms[$single->form_id]['Empresa'],
                'Cargo' => $forms[$single->form_id]['Cargo'],
                'Provincia' => $forms[$single->form_id]['Provincia'],
                'Ciudad' => $forms[$single->form_id]['Localidad'],
                '¿Aprobado?' => $single->approved,
                '¿Presente?' => $single->present,
            );
        }

        $export = (new FastExcel($data))->download('asistentes.xlsx');

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
