<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\{Group, Visitor, Talk};
use Sheets;

class Groups extends Component
{
    public $cregroup, $visitors;
    public $listeners = ['selected'];

    protected $rules = [
        'cregroup.title' => 'required',
        'cregroup.visitor' => 'array',
    ];

    public function mount(Group $group)
    {
        $this->group = $group;
        // $this->group->visitor = [];
    }

    public function __construct()
    {
        $this->spread = '1KZXp18tUAQvlpHsI9n8QIH24osjQuECQ0hso7fjZ-Nw';
        $this->currentEvent = 'Respuestas de formulario 1';
    }

    public function render()
    {

        $groups = Group::where('exhibitor_id', \Auth::user()->id)->get();

        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        return view('livewire.groups.group', compact('groups', 'forms'));
    }

    public function create()
    {
        $group = new Group([
            'title' => $this->group->title,
            'exhibitor_id' => \Auth::user()->id
        ]);
        $group->save();
    }

    public function destroy($id)
    {
        Visitor::find($id);

        $visitor->groups()->attach($group->id);

        $this->emit('alert', ['title' => '¡Adiós!', 'text' => 'La charla ha sido eliminada', 'type' => 'success']);
    }
}
