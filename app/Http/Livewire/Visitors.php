<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Visitor;
use Sheets;

class Visitors extends Component
{
    public $search, $visitors, $company, $charge, $country, $state, $city, $vip;

    public $listeners = ['destroy'];

    public function render()
    {
        $currentEvent = 1;

        $sheets = Sheets::spreadsheet("1hhh76KaFDoJeVE8AC-oTXpIm7WgsESImaY1raUQo4nw")->sheet(strval($currentEvent))->get();
        $header = $sheets->pull(0);
        $this->forms = Sheets::collection($header, $sheets);

        $this->visitors = Visitor::where('custid', 'like', '%'.$this->search.'%')
        ->get();

        if ($this->search == null) {
            foreach ($this->forms as $form) {

                $check = Visitor::where('form_id', $form['id'])->first();
                if ($check == null) {
                    do {
                        $custid = createCustomid();
                    } while (Visitor::where('custid', $custid)->first() <> null);

                    $visitor = new Visitor([
                        'custid' => $custid,
                        'event_id' => $currentEvent,
                        'form_id' => $form['id'],
                        'approved' => null,
                        'present' => null,
                        'vip' => 0
                    ]);
                    $visitor->save();
                }
            }
        }

        return view('livewire.visitor.visitor');
    }

    public function update($id)
    {
        $visitor = Visitor::find($id);

        if ($this->vip == "on") {
            $visitor->vip = true;
        } else {
            $visitor->vip = false;
        }

        if (isset($this->company)) {
            $visitor->company = $this->company;
        }
        if (isset($this->charge)) {
            $visitor->charge = $this->charge;    
        }
        if (isset($this->country)) {
            $visitor->country = $this->country;
        }
        if (isset($this->state)) {
            $visitor->state = $this->state;
        }
        if (isset($this->city)) {
            $visitor->city = $this->city;
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
