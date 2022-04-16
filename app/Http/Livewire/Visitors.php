<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Visitor;

class Visitors extends Component
{
    public $search, $visitors, $company, $charge, $country, $state, $city, $vip;

    public $listeners = ['destroy'];

    public function render()
    {
        $this->visitors = Visitor::where('approved', 1)->
        whereHas('user', function($q){
            $q->where('name', 'like', '%'.$this->search.'%');
        })
        ->orWhere('custid', 'like', '%'.$this->search.'%')
        ->orWhere('company', 'like', '%'.$this->search.'%')
        ->get();

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

    public function cleanData()
    {
        $this->reset(['company', 'charge', 'country', 'state', 'city', 'vip']);
    }
}
