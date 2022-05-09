<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination};
use App\Models\{Visitor, Meeting, User, Talk};
use Rap2hpoutre\FastExcel\FastExcel;
use GuzzleHttp\Client;
use Sheets;
use Auth;

class Exhvisitors extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search, $company, $charge, $country, $state, $city, $vip;
    public $readyToLoad = false;
    public $cant = '10';

    public $listeners = ['meet'];

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
        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $header = $sheets->pull(0);
        $this->forms = Sheets::collection($header, $sheets);

        if ($this->readyToLoad) {
            $visitors = Visitor::where('custid', 'like', '%'.$this->search.'%')->orderBy('event_id')->paginate($this->cant);
        } else {
            $visitors = [];
        }

        return view('livewire.exhvisitor.visitor', compact('visitors'));
    }

    public function loadVisitors()
    {
        $this->readyToLoad = true;
    }

    public function update($id)
    {
        $visitor = Visitor::find($id);

        if ($this->vip == true) {
            $visitor->vip = true;
        } else {
            $visitor->vip = false;
        }
        $visitor->update();

        $this->emit('alert', 'Asistente modificado correctamente');
        $this->emit('cleanData');
    }

    public function meet($id)
    {
        do {
            $custid = createCustomid();
        } while (Meeting::where('custid', $custid)->first() <> null);

        $check = Meeting::where('event_id', $this->currentEvent)->where('visitor_id', $id)->where('exhibitor', Auth::user()->name)->first();

        if(empty($check)) {
            $visitor = Visitor::find($id);

            $meeting = new Meeting([
                'custid' => $custid,
                'event_id' => $this->currentEvent,
                'visitor_id' => $visitor->id,
                'exhibitor' => Auth::user()->name,
                'approved' => null,
                'requested' => 'exhibitor'
            ]);
            $meeting->save();

            $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

            $client = new Client();
            $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/getAll', [
            'headers' => $authorization,
            'form_params' => [
                'filter' => 'Reunión con '.Auth::user()->name,
            ]]);
            $check = json_decode($client->getBody(), true)['data']['data'];

            if (!isset($check[0])) {
                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
                'headers' => $authorization,
                'form_params' => [
                    'name' => 'Reunión con '.Auth::user()->name,
                ]]);
                $list_id = json_decode($client->getBody(), true)['data']['id'];

                $exhibitor = User::where('name', $meeting->exhibitor)->first();
                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
                'headers' => $authorization,
                'form_params' => [
                    'email' => $this->forms[$visitor->form_id]['Direccion de email'],
                ]]);
                $contacts_ids[] = json_decode($client->getBody(), true)['data']['data'][0]['id'];

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
                    'name' => 'Reunión con '.Auth::user()->name,
                    'subject' => 'El expositor '.Auth::user()->name.' ha solicitado una reunión con usted',
                    'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://mediaware.org/channeltalks/imagenes/header.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"><p style="max-width: 600px; font-size: 20px">El expositor '.Auth::user()->name.' ha solicitado una reunión con usted. Puede confirmar esta reunión <a href="'.route('meeting.accept', ['id' => $meeting->id]).'">AQUÍ</a></p></div></td></tr></tbody></table>',
                    'fromAlias' => 'Channel Talks',
                    'fromEmail' => 'channeltalks@mediaware.news',
                    'replyEmail' => 'channeltalks@mediaware.news',
                    'mailListsIds' => [1],
                ]]);
                $id = json_decode($client->getBody(), true)['data']['id'];

                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/send', [
                'headers' => $authorization,
                'form_params' => [
                    'id' => $id,
                    'sendNow' => 1
                ]]);
            }
        }
    }

    public function download()
    {
        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $header = $sheets->pull(0);
        $forms = Sheets::collection($header, $sheets);
        $all = Visitor::all();

        foreach ($all as $single) {
            $data[] = array(
                'ID' => $single->id,
                'ID público' => $single->custid,
                'Nombre' => $forms[$single->form_id]['Nombre completo'],
                'Empresa' => $forms[$single->form_id]['Empresa'],
                'Cargo' => $forms[$single->form_id]['Cargo'],
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

    public function cleanData()
    {
        $this->reset(['company', 'charge', 'country', 'state', 'city', 'vip']);
    }
}
