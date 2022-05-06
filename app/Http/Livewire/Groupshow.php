<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination};
use App\Models\{Group, Visitor, Email};
use GuzzleHttp\Client;
use Sheets;

class Groupshow extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $email, $search, $gid;
    public $readyToLoad = false;
    public $cant = '10';

    protected $rules = [
        'email.receiver' => 'required',
        'email.subject' => 'required',
        'email.content' => 'required',
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
        $group = Group::find($this->gid);
        $visitors = Visitor::whereHas('groups', function($q) use($group){
            $q->where('title', $group->title);
        })->paginate($this->cant);

        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        return view('livewire.groups.show', compact('group', 'forms', 'visitors'));
    }

    public function loadVisitors()
    {
        $this->readyToLoad = true;
    }

    public function sendEmail($group)
    {
        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        // $visitors = Visitor::where('custid',)->get();
        if (strtolower($this->email->receiver) == 'todos') {
            $visitors = Visitor::whereHas('groups', function($q) use($group){
                $q->where('title', $group);
            })->get();
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
}
