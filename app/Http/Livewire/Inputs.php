<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithFileUploads};
use App\Models\Input;
use Carbon\Carbon;
use Storage;
use Str;

class Inputs extends Component
{
    use WithFileUploads;
    public $event, $inputs, $input, $type, $name, $label, $subtitle, $options, $input_id, $optionsDisabled = false, $new = false;
    public $listeners = ['create', 'destroy', 'changeNew', 'refresh' => '$refresh'];

    protected $rules = [
        'input.type' => 'required',
        'input.name' => 'required',
        'input.label' => 'required',
        'input.options' => 'required',
    ];

    public function mount(Input $input)
    {
        $this->input = $input;
    }

    public function render()
    {
        $this->inputs = Input::has('events')->get();

        return view('livewire.input.input');
    }

    public function create($type, $label, $options, $subtitle, $input_id)
    {
        if (!$input_id) {
            $input = new Input([
                'type' => $type,
                'name' => Str::slug($label, '-'),
                'label' => $label,
                'options' => $options ? implode('*', $options) : $subtitle,
            ]);
            $input->save();

            $input_id = $input->id;
        }

        $this->event->inputs()->attach($input_id);

        $this->emit('alert', ['title' => '¡Uno más!', 'text' => 'El campo ha sido dado de alta', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function destroy($id)
    {
        $this->event->inputs()->detach($id);

        $this->emit('alert', ['title' => '¡Adiós!', 'text' => 'El correo ha sido eliminado', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function changeNew()
    {
        if ($this->new) {
            $this->new = false;
        } else {
            $this->new = true;
        }
    }

    public function changeType()
    {
        if ($this->type == 'text') {
            $this->optionsDisabled = true;
        }
    }
}
