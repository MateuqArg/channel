<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use App\Models\{Group, Visitor, Talk};
use Sheets;

class Groups extends Component
{
    public $cregroup, $title, $visitors;
    public $listeners = ['selected'];

    // protected $rules = [
    //     'cregroup.title' => 'required',
    //     'cregroup.visitor' => 'array',
    // ];

    public function mount(Group $group)
    {
        $this->group = $group;
        // $this->group->visitor = [];
    }

    public function __construct()
    {
        $this->spread = Cache::get('spread');
    }

    public function render()
    {

        $groups = Group::where('exhibitor_id', \Auth::user()->id)->get();

        $forms = Cache::get('forms');

        return view('livewire.groups.group', compact('groups', 'forms'));
    }

    public function create()
    {
        // dd($this->title);
        do {
            $custid = createCustomid();
        } while (Talk::where('custid', $custid)->first() <> null);

        $talk = new Talk([
            'custid' => $custid,
            'event_id' => Cache::get('currentEvent'),
            'exhibitor_id' => \Auth::user()->id,
            'title' => $this->title
        ]);
        $talk->save();

        $group = new Group([
            'title' => $this->title,
            'exhibitor_id' => \Auth::user()->id
        ]);
        $group->save();

        $this->emit('alert', ['title' => '¡Agregado!', 'text' => 'El grupo ha sido dado de alta', 'type' => 'success']);
    }

    public function destroy($id)
    {
        Visitor::find($id);

        $visitor->groups()->attach($group->id);

        $this->emit('alert', ['title' => '¡Adiós!', 'text' => 'La charla ha sido eliminada', 'type' => 'success']);
    }
}
