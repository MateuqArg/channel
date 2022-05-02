<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Event;
use App\Models\Meeting;
use App\Models\Visitor;
use App\Models\User;
use GuzzleHttp\Client;
use Sheets;

class ExhibitorController extends Controller
{
    public function __construct()
    {
        $this->currentEvent = 1;
    }

    // public function eventsIndex()
    // {
    //     $events = Event::whereIn('custid',  \Auth::user()->getRoleNames())->get();
    //     $meetings = Meeting::where('approved', null)->where('exhibitor', \Auth::user()->name)->where('requested', 'visitor')->get();
    //     $visitors = Visitor::where('approved', true)->whereDoesntHave('meetings', function ($meetingQuery) {
    //         $meetingQuery->where('exhibitor', \Auth::user()->name);
    //     })->get();
    //     $sheets = Sheets::spreadsheet("1hhh76KaFDoJeVE8AC-oTXpIm7WgsESImaY1raUQo4nw")->sheet(strval($this->currentEvent))->get();
    //     $forms = Sheets::collection($sheets->pull(0), $sheets);

    //     return view('exhibitor.events.index', compact('events', 'meetings', 'visitors', 'forms'));
    // }

    public function visitors()
    {
        $meetings = Meeting::where('approved', null)->where('exhibitor', \Auth::user()->name)->where('requested', 'visitor')->get();
        $sheets = Sheets::spreadsheet("1hhh76KaFDoJeVE8AC-oTXpIm7WgsESImaY1raUQo4nw")->sheet(strval($this->currentEvent))->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        return view('exhibitor.visitors', compact('meetings', 'forms'));
    }

    public function meetingAccept(Request $request, $id)
    {
        $meeting = Meeting::find($id);
        $meeting->approved = true;
        $meeting->update();

        return redirect()->back()->with('success', 'Reunión aceptada correctamente');
    }

    public function meetingReject(Request $request, $id)
    {
        $meeting = Meeting::find($id);
        $meeting->approved = false;
        $meeting->update();

        return redirect()->back()->with('success', 'Reunión rechazada correctamente');
    }

    public function inviteIndex()
    {
        return view('exhibitor.invite');
    }

    public function inviteSend(Request $request)
    {
        if ($request->excel) {
            $custid = createCustomid();
            $ext = $request->excel->getClientOriginalExtension();

            $request->excel->storeAs('/', 'excels/'.$custid.'.'.$ext, 'public_uploads');
            $collection = fastexcel()->import(public_path().'/excels/'.$custid.'.'.$ext);

            unlink(public_path().'/excels/'.$custid.'.'.$ext);
        }
        
        dd($collection);

        // return redirect()->back()->with('successrequest', 'Reunión solicitada');
    }

    public function visitorsDownload(Request $request)
    {
        // $visitors = 

        $request->excel->storeAs('/', 'excels/'.$custid.'.'.$ext, 'public_uploads');
        $collection = fastexcel()->import(public_path().'/excels/'.$custid.'.'.$ext);

        unlink(public_path().'/excels/'.$custid.'.'.$ext);
        
        dd($collection);

        // return redirect()->back()->with('successrequest', 'Reunión solicitada');
    }

    public function staffIndex()
    {
        return view('exhibitor.staff');
    }

    public function staffSend(Request $request)
    {
        $check =  User::where('email', $request->email)->first();

        if (empty($check)) {
            $event = Event::find($this->currentEvent);
            $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

            $client = new Client();
            $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/getAll', [
            'headers' => $authorization,
            'form_params' => [
                'filter' => 'Expositor nuevo: '.$request->name,
            ]]);
            $check = json_decode($client->getBody(), true)['data']['data'];

            if (!isset($check[0])) {
                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
                'headers' => $authorization,
                'form_params' => [
                    'name' => 'Expositor nuevo: '.$request->name,
                ]]);
                $list_id = json_decode($client->getBody(), true)['data']['id'];

                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
                'headers' => $authorization,
                'form_params' => [
                    'email' => $request->email,
                ]]);

                if (isset(json_decode($client->getBody(), true)['data']['data'][0]['id'])) {
                    $contacts_ids[] = json_decode($client->getBody(), true)['data']['data'][0]['id'];
                } else {
                    $client = new Client();
                    $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/create', [
                    'headers' => $authorization,
                    'form_params' => [
                        'email' => $request->email,
                    ]]);
                    $contacts_ids[] = json_decode($client->getBody(), true)['data']['id'];
                }

                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/suscribe', [
                'headers' => $authorization,
                'form_params' => [
                    'listId' => $list_id,
                    'contactsIds' => $contacts_ids
                ]]);

                $token = sha1(rand());

                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/create', [
                'headers' => $authorization,
                'form_params' => [
                    'name' => 'Expositor nuevo: '.$request->name,
                    'subject' => 'Has sido invitado a ser expositor del evento '.$event->title,
                    'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://mediaware.org/channeltalks/imagenes/header.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"><p style="max-width: 600px; font-size: 20px">Hola '.$request->name.' has sido invitado a ser expositor del evento '.$event->title.' para confirmar su cuenta ingresa al siguiente link <a href="'.route('staff.enable', ['token' => $token, 'type' => 'exhibitor']).'">AQUI</a>.</p></div></td></tr></tbody></table>',
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

                do {
                    $custid = createCustomid();
                } while (User::where('custid', $custid)->first() <> null);

                $user = new User([
                    'custid' => $custid,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $token
                ]);
                $user->save();
            }

            return redirect()->back()->with('success', 'Expositor invitado correctamente');
        }

        return redirect()->back()->with('success', 'Este expositor ya existe');
    }
}
