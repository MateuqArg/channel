<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination};
use App\Models\{Group, Visitor, Email, Talk};
use Rap2hpoutre\FastExcel\FastExcel;
use GuzzleHttp\Client;
use Sheets;

class Groupall extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $email, $visitor, $search, $gid, $receiver;
    public $readyToLoad = false;
    public $cant = '10';
    public $listeners = ['addVisitors'];

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
        $this->spread = '1KZXp18tUAQvlpHsI9n8QIH24osjQuECQ0hso7fjZ-Nw';
        $this->currentEvent = 'Respuestas de formulario 1';
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

        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        foreach ($forms as $form) {
            $names[$form['id']] = $form['Nombre completo'];
        }

        $input = preg_quote($this->search, '~');

        $ids = [];
        foreach (preg_grep('~' . $input . '~', $names) as $key => $result) {
            $ids[] = $key;
        }

        $visitors = Visitor::whereHas('tracks', function($q) use($ids){
            $q->whereIn('talk_id', $ids);
        })->orWhere('id', $ids)->paginate($this->cant);

        return view('livewire.groups.all', compact('forms', 'visitors'));
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

        // $group = new Event([
        //     'custid' => $custid,
        //     'title' => $this->title,
        //     'date' => $this->date,
        //     'inscription' => implode("*", $this->inscription),
        //     'approve' => $approve
        // ]);
        // $event->save();
    }

    public function sendEmail($data)
    {
        dd($data);
        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        // $visitors = Visitor::where('custid',)->get();
        if (strtolower($this->email->receiver) == 'todos') {
            $talks = Talk::where('exhibitor_id', \Auth::user()->id)->get();
            $ids = [];
            foreach ($talks as $talk) {
                $ids[] = $talk->id;
            }

            $visitors = Visitor::whereHas('tracks', function($q) use($ids){
                $q->whereIn('talk_id', $ids);
            });
        }

        $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

        $client = new Client();
        $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
        'headers' => $authorization,
        'form_params' => [
            'name' => 'Email de: '.\Auth::user()->name.' - '. $this->email->subject,
        ]]);
        $list_id = json_decode($client->getBody(), true)['data']['id'];

        foreach ($visitors as $visitor) {
            $client = new Client();
            $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
            'headers' => $authorization,
            'form_params' => [
                'email' => $forms[$visitor->form_id]['Direccion de email'],
            ]]);
            $contacts_ids[] = json_decode($client->getBody(), true)['data']['data'][0]['id'];
        }

        $client = new Client();
        $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/suscribe', [
        'headers' => $authorization,
        'form_params' => [
            'listId' => $list_id,
            'contactsIds' => $contacts_ids
        ]]);

        $client = new Client();
        $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/create', [
        'headers' => $authorization,
        'form_params' => [
            'name' => 'Email de: '.\Auth::user()->name.' - '. $this->email->subject,
            'subject' => $this->email->subject,
            'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://mediaware.org/channeltalks/imagenes/header.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"><p style="max-width: 600px; font-size: 20px">'.$this->email->content.'</p></div></td></tr></tbody></table>',
            'fromAlias' => \Auth::user()->name,
            'fromEmail' => 'channeltalks@mediaware.news',
            'replyEmail' => 'channeltalks@mediaware.news',
            'mailListsIds' => [$list_id],
        ]]);
        $id = json_decode($client->getBody(), true)['data']['id'];

        $client = new Client();
        $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/send', [
        'headers' => $authorization,
        'form_params' => [
            'id' => $id,
            'sendNow' => 1
        ]]);

        $this->emit('alert', ['title' => '¡Enviado!', 'text' => 'El correo ha sido enviado correctamente', 'type' => 'success']);
    }

    public function download()
    {
        $talks = Talk::where('exhibitor_id', \Auth::user()->id)->get();

        $ids = [];
        foreach ($talks as $talk) {
            $ids[] = $talk->id;
        }

        $all = Visitor::whereHas('tracks', function($q) use($ids){
            $q->whereIn('talk_id', $ids);
        })->get();

        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $header = $sheets->pull(0);
        $forms = Sheets::collection($header, $sheets);

        foreach ($all as $single) {
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

    public function selected($data)
    {
        $this->receiver = $data;        
    }
}
