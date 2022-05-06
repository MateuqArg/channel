<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\{Group, Visitor, Talk};
use Sheets;

class Groups extends Component
{
    public $cregroup, $group;
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
        $talks = Talk::where('exhibitor_id', \Auth::user()->id)->get();
        $ids = [];
        foreach ($talks as $talk) {
            $ids[] = $talk->id;
        }

        $visitors = Visitor::whereHas('tracks', function($q) use($ids){
            $q->whereIn('talk_id', $ids);
        })->get();

        $groups = Group::where('exhibitor_id', \Auth::user()->id)->get();

        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        return view('livewire.groups.group', compact('groups', 'visitors', 'forms'));
    }

    public function create()
    {
        $group = new Group([
            'title' => $this->group->title,
            'exhibitor_id' => \Auth::user()->id
        ]);
        $group->save();
    }
}
