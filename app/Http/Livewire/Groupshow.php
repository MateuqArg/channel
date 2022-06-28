<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination, WithFileUploads};
use Illuminate\Support\Facades\Cache;
use App\Models\{Group, Visitor, Email, Talk};
use App\Jobs\SendEmail;
use Rap2hpoutre\FastExcel\FastExcel;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Storage;
use Sheets;

class Groupshow extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $email, $visitor, $search, $gid, $visitor_id, $name, $subject, $content, $date, $drawprices, $drawcant;
    public $readyToLoad = false;
    public $cant = '10';
    public $listeners = ['addVisitors', 'draw'];

    protected $rules = [
        'email.receiver' => 'required',
        'email.subject' => 'required',
        'email.content' => 'required',
        'visitor' => 'array'
    ];

    public function mount(Email $email)
    {
        $this->email = $email;
    }

    public function __construct()
    {
        $this->spread = Cache::get('spread');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $talks = Talk::where('exhibitor_id', \Auth::user()->id)->get();
        $ids = [];
        foreach ($talks as $talk) {
            $ids[] = $talk->id;
        }

        $allvisitors = Visitor::whereHas('tracks', function($q) use($ids){
            $q->whereIn('talk_id', $ids);
        })->get();

        $forms = Cache::get('forms');

        foreach ($forms as $form) {
            $names[$form['id']] = strtolower($form['Nombre completo']);
        }

        $group = Group::find($this->gid);
        $input = preg_quote(strtolower($this->search), '~');
        $ids = [];
        if ($input <> null) {
            foreach (preg_grep('~' . $input . '~', $names) as $key => $result) {
                $ids[] = $key;
            }

            $visitors = Visitor::whereHas('groups', function($q) use($group){
                $q->where('title', $group->title);
            })->where('id', $ids)->paginate($this->cant);
        } else {
            $visitors = Visitor::whereHas('groups', function($q) use($group){
                $q->where('title', $group->title);
            })->paginate($this->cant);
        }
        return view('livewire.groups.show', compact('group', 'forms', 'visitors', 'allvisitors'));
    }

    public function loadVisitors()
    {
        $this->readyToLoad = true;
    }

    public function addVisitors($data)
    {
        $group = Group::find($this->gid);

        foreach ($data as $visitor_id) {
            $visitor = Visitor::find($visitor_id);
            // dd($visitor->groups);
            if (!$visitor->groups->contains($group)) {
                $visitor->groups()->attach($group->id);
            }
        }
    }

    public function sendEmail($group, $objective)
    {
        $this->validate([
            'subject' => 'required',
            'date' => 'required',
            'content' => 'required',
        ]);

        if (strtolower($objective) == 'all') {
            $visitors = Visitor::whereHas('groups', function($q) use($group){
                $q->where('title', $group);
            })->get();
        } else {
            $visitors = Visitor::where('id', $objective)->get();
        }

        $ids = [];
        foreach ($visitors as $visitor) {
            $ids[] = $visitor->id;
        }

        $file = Storage::disk('public_uploads')->put('/', $this->content);

        $talk = Talk::where('title', $group)->first();

        $email = new Email([
            'name' => 'Email de: '.\Auth::user()->name.' - '. $this->subject,
            'subject' => $this->subject,
            'content' => basename($file),
            'date' => $this->date,
            'event_id' => $talk->event_id,
            'objective' => implode("*", $ids),
        ]);
        $email->save();

        $date = Carbon::create($this->date);
        // SendEmail::dispatch($email->id)->onConnection('database')->delay($date);

        $this->emit('alert', ['title' => '¡Uno más!', 'text' => 'El correo ha sido enviado correctamente', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function download()
    {
        $group = Group::find($this->gid);
        $title = $group->title;

        $forms = Cache::get('forms');

        foreach ($group->visitors as $single) {
            $data[] = array(
                'ID' => $single->id,
                'ID público' => $single->custid,
                'Nombre' => $forms[$single->form_id]['Nombre completo'],
                'Correo' => $forms[$single->form_id]['Direccion de email'],
                'Teléfono' => $forms[$single->form_id]['Telefono'],
                'Empresa' => $forms[$single->form_id]['Empresa'],
                'Cargo' => $forms[$single->form_id]['Cargo'],
                'Provincia' => $forms[$single->form_id]['Provincia'],
                'Ciudad' => $forms[$single->form_id]['Localidad'],
                '¿Presente?' => $single->present,
            );
        }
        $export = (new FastExcel($data))->download($title.'.xlsx');

        $file_name = $title.'.xlsx';

        $export->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', true);
        $export->headers->set('Content-Disposition', 'attachment; ' .
            'filename="' . rawurldecode($file_name) . '"; ' .
            'filename*=UTF-8\'\'' . rawurldecode($file_name), true);
        $export->headers->set('Cache-Control', 'max-age=0', true);
        $export->headers->set('Pragma', 'public', true);

        $this->emit('alert', ['title' => '¡Descargado!', 'text' => 'El archivo ha sido descargado', 'type' => 'success']);
        return $export;
    }

    public function draw()
    {
        $group = Group::find($this->gid);
        $forms = Cache::get('forms');
        $count = $visitors = Visitor::whereHas('groups', function($q) use($group){
                $q->where('title', $group->title);
            })->get()->count();
        $visitors = $visitors = Visitor::whereHas('groups', function($q) use($group){
                $q->where('title', $group->title);
            })->get();

        $nums = [];
        for ($i=0; $i < $this->drawcant; $i++) { 
           do {
            $price = random_int(1, $count);
            } while (in_array($price, $nums));

            $nums[] = $price;
            $prices[] = $forms[$visitors[$price-1]->form_id]['Nombre completo'];
        }

        $this->drawprices = $prices;
    }
}
