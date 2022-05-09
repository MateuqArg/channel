<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Event;
use App\Models\User;
use Auth;

class Exhibitors extends Component
{
    public $user, $exhibitor, $exhibitors, $search;
    public $listeners = ['destroy', 'selected', 'refresh' => '$refresh'];

    protected $rules = [
        'exhibitor.role' => 'array',
        'user.id' => 'array',
    ];

    public function mount(User $exhibitor)
    {
        $this->exhibitor = $exhibitor;
    }

    public function render()
    {
        $events = Event::get()->all();
        $users = User::whereDoesntHave('roles', function($q){
            $q->where('name', 'exhibitor');
        })->get();
        $this->exhibitors = User::where('id', 'like', '%'.$this->search.'%')
        ->whereHas('roles', function($q){
            $q->where('name', 'exhibitor');
        })->get();
        $roles = \Spatie\Permission\Models\Role::all();
        $user = Auth::user();

        return view('livewire.exhibitor.exhibitor', compact('users', 'events', 'roles', 'user'));
    }

    public function create()
    {
        foreach($this->user['id'] as $id) {
            $exhibitor = User::find($id);

            $exhibitor->assignRole('exhibitor');
        }

        $this->emit('alert', ['title' => '¡Uno más!', 'text' => 'El expositor ha sido dado de alta', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function update($id)
    {
        $exhibitor = User::find($id);

        $this->exhibitor->role = array_merge($this->exhibitor->role, ['exhibitor']);
        $this->exhibitor->role = array_merge($this->exhibitor->role, ['organizer']);

        $exhibitor->syncRoles($this->exhibitor->role);

        $this->emit('alert', ['id' => $id, 'title' => '¡Arreglado!', 'text' => 'El expositor ha sido modificado', 'type' => 'success']);
    }

    public function destroy($id)
    {
        $exhibitor = User::find($id);

        $exhibitor->removeRole('exhibitor');

        $this->emit('alert', ['title' => '¡Adiós!', 'text' => 'El expositor ha sido eliminado', 'type' => 'success']);
    }

    public function download()
    {
        $all = User::role('exhibitor')->get();

        foreach ($all as $single) {
            $data[] = array(
                'ID' => $single->id,
                'ID público' => $single->custid,
                'Nombre' => $single->name,
                'Email' => $single->email,
                'Teléfono' => $single->phone,
            ); 
        }

        $export = (new FastExcel($data))->download('expositores.xlsx');

        $file_name = "expositores.xlsx";

        $export->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', true);
        $export->headers->set('Content-Disposition', 'attachment; ' .
            'filename="' . rawurldecode($file_name) . '"; ' .
            'filename*=UTF-8\'\'' . rawurldecode($file_name), true);
        $export->headers->set('Cache-Control', 'max-age=0', true);
        $export->headers->set('Pragma', 'public', true);

        $this->emit('alert', ['title' => '¡Descargado!', 'text' => 'El archivo ha sido descargado', 'type' => 'success']);
        return $export;
    }

    public function selected($id)
    {
        $exhibitor = User::where('id', $id)->get()->first();

        $this->exhibitor->role = [];
        foreach($exhibitor->getRoleNames() as $data)
        {
            if(strlen($data) == 6) {
                $this->exhibitor->role = array_merge($this->exhibitor->role, [$data]);
            }
        }
        $this->exhibitor->role = array_merge($this->exhibitor->role, ['organizer']);
        $this->exhibitor->role = array_merge($this->exhibitor->role, ['exhibitor']);
    }
}
