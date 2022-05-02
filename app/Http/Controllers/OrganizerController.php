<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Event;
use App\Models\Visitor;
use App\Models\User;
use App\Models\Talk;
use App\Models\Track;
use App\Models\Meeting;
use App\Models\Email;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Sheets;
use Image;
use Storage;
use Printing;
use Auth;

class OrganizerController extends Controller
{
    public function __construct()
    {
        $this->currentEvent = 1;
    }

    public function eventsIndex(Request $request)
    {
        $visitors = Visitor::where('approved', null)->get();

        $sheets = Sheets::spreadsheet("1hhh76KaFDoJeVE8AC-oTXpIm7WgsESImaY1raUQo4nw")->sheet(strval($this->currentEvent))->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        return view('organizer.events.index', compact('visitors', 'forms'));
    }

    public function visitorAccept(Request $request, $id)
    {
        $visitor = Visitor::find($id);
        // $visitor->approved = true;
        // $visitor->update();

        $sheets = Sheets::spreadsheet("1hhh76KaFDoJeVE8AC-oTXpIm7WgsESImaY1raUQo4nw")->sheet(strval($this->currentEvent))->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        $file = QrCode::format('png')->size(305)->generate(route('organizer.visitor.track', ['custid' => $visitor->custid]));
        $qr_file = 'qr.png';
        Storage::disk('public_uploads')->put($qr_file, $file);
        $file = Storage::disk('public_uploads')->get($qr_file);

        $bg = Storage::disk('public')->get('/images/registro.jpg');

        $file_name = time().'.'.'png';

        $img = Image::make($bg);

        $img->text($forms[$visitor->form_id]['Nombre completo'], 350, 200, function($font) {
            $font->file(public_path("Montserrat.ttf"));
            $font->align('center');
            $font->color('#000');
            $font->size(36);
        });

        $img->insert($file, 'bottom', 350, 186);

        $img->save(public_path('uploads/'.$file_name));
        Storage::disk('public_uploads')->delete($qr_file);

        $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

        $client = new Client();
        $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
        'headers' => $authorization,
        'form_params' => [
            'name' => 'Asistencia aprobada: '.$forms[$visitor->form_id]['Nombre completo'],
        ]]);
        $list_id = json_decode($client->getBody(), true)['data']['id'];

        $client = new Client();
        $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
        'headers' => $authorization,
        'form_params' => [
            'email' => $forms[$visitor->form_id]['Direccion de email'],
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
            'name' => 'Registro aprobado: '.$forms[$visitor->form_id]['Nombre completo'],
            'subject' => '¡Has sido registrado exitosamente!',
            'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="'.public_path('uploads/'.$file_name).'" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"></div></td></tr></tbody></table>',
            'fromAlias' => 'Channel Talks',
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

        return redirect()->back()->with('successvisitors', 'Inscripción aceptada correctamente');
    }

    public function visitorReject(Request $request, $id)
    {
        $visitor = Visitor::find($id);
        $visitor->approved = false;
        $visitor->update();

        return redirect()->back()->with('successvisitors', 'Inscripción rechazada correctamente');
    }

    public function visitorScan(Request $request, $custid)
    {
        $visitor = Visitor::where('custid', $custid)->first();

        $entrys = Track::where('visitor_id', $visitor->id)->where('extra', 'enter')->first();

        if (empty($entrys)) {
            $track = new Track([
                'visitor_id' => $visitor->id,
                'talk_id' => null,
                'extra' => 'enter'
            ]);
            $track->save();
        }

        $sheets = Sheets::spreadsheet("1hhh76KaFDoJeVE8AC-oTXpIm7WgsESImaY1raUQo4nw")->sheet(strval($this->currentEvent))->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        // // Código para imprimir la etiqueta

        //  $printers = Printing::printers();

        // // $printJob = Printing::newPrintTask()
        // //     ->printer($printerId)
        // //     ->file($img->response("png"))
        // //     ->send();

        // // $printJob->id();

        // // Printing::newPrintTask()
        // //     ->printer('PRINTERID')
        // //     ->file(public_path('uploads/'.$file_name))
        // //     ->send();

        // // Storage::disk('public_uploads')->delete($file_name);

        // Código para mandar mail al expositor con el que tenga reunión

        if ($visitor->present <> 1) {
            $meetings = Meeting::where('visitor_id', $visitor->id)->where('approved', true)->where('event_id', $this->currentEvent)->get();

            if (!empty($meetings)) {
                $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/getAll', [
                'headers' => $authorization,
                'form_params' => [
                    'filter' => 'Reunión con '.$forms[$visitor->form_id]['Nombre completo'],
                ]]);
                $check = json_decode($client->getBody(), true)['data']['data'];

                if (!isset($check[0])) {
                    $client = new Client();
                    $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
                    'headers' => $authorization,
                    'form_params' => [
                        'name' => 'Reunión con '.$forms[$visitor->form_id]['Nombre completo'],
                    ]]);
                    $list_id = json_decode($client->getBody(), true)['data']['id'];

                    foreach ($meetings as $meeting) {
                        $exhibitor = User::where('name', $meeting->exhibitor)->first();
                        $client = new Client();
                        $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
                        'headers' => $authorization,
                        'form_params' => [
                            'email' => $exhibitor->email,
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
                        'name' => 'Reunión con '.$forms[$visitor->form_id]['Nombre completo'],
                        'subject' => 'El invitado '.$forms[$visitor->form_id]['Nombre completo'].' ha ingresado al evento',
                        'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://mediaware.org/channeltalks/imagenes/header.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"><p style="max-width: 600px; font-size: 20px">El invitado '.$forms[$visitor->form_id]['Nombre completo'].' ha ingresado al evento, sugerimos contactarse para coordinar la reunión al email: '.$forms[$visitor->form_id]['Direccion de email'].'.</p></div></td></tr></tbody></table>',
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

        $visitor->present = true;
        $visitor->update();

        return view('organizer.visitor.scan', compact('visitor', 'forms'));
    }

    public function visitorPrint(Request $request, $custid)
    {
        $visitor = Visitor::where('custid', $custid)->first();

        $sheets = Sheets::spreadsheet("1hhh76KaFDoJeVE8AC-oTXpIm7WgsESImaY1raUQo4nw")->sheet(strval($this->currentEvent))->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        // Código para generar la etiqueta

        $file = QrCode::format('png')->size(300)->generate(route('organizer.visitor.track', ['custid' => $visitor->custid]));
        $qr_file = 'qr.png';
        Storage::disk('public_uploads')->put($qr_file, $file);
        $file = Storage::disk('public_uploads')->get($qr_file);

        $file_name = time().'.'.'png';

        $img = Image::canvas(600, 800, '#fff');

        $img->insert($file, 'top', 300, 60);

        // dd(explode(' ', $forms[$visitor->form_id]['Nombre completo'], 2)[0]);

        $img->text(ucwords(strtolower(explode(' ', $forms[$visitor->form_id]['Nombre completo'], 2)[0])), 300, 480, function($font) {
            $font->file(public_path("Gotham.ttf"));
            $font->align('center');
            $font->color('#000');
            $font->size(90);
        });

        $img->text(ucwords(strtolower(explode(' ', $forms[$visitor->form_id]['Nombre completo'], 2)[1])), 300, 570, function($font) {
            $font->file(public_path("Gotham.ttf"));
            $font->align('center');
            $font->color('#000');
            $font->size(90);
        });

        $img->text(ucwords(strtolower($forms[$visitor->form_id]['Cargo'])), 300, 680, function($font) {
            $font->file(public_path("Gotham.ttf"));
            $font->align('center');
            $font->color('#000');
            $font->size(45);
        });

        $img->text(ucwords(strtolower($forms[$visitor->form_id]['Empresa'])), 300, 760, function($font) {
            $font->file(public_path("Gotham.ttf"));
            $font->align('center');
            $font->color('#000');
            $font->size(60);
        });

        $img->save(public_path('uploads/'.$file_name));
        Storage::disk('public_uploads')->delete($qr_file);
        return $img->response("png");

        // return redirect()->back();
    }

    public function visitorTrack(Request $request, $custid)
    {
        $visitor = Visitor::where('custid', $custid)->first();
        $entrys = Track::where('visitor_id', $visitor->id)->where('extra', 'enter')->first();

        if (!empty($entrys)) {

            $talks = Talk::where('event_id', $visitor->event_id)->get();

            $sheets = Sheets::spreadsheet("1hhh76KaFDoJeVE8AC-oTXpIm7WgsESImaY1raUQo4nw")->sheet(strval($this->currentEvent))->get();
            $header = $sheets->pull(0);
            $forms = Sheets::collection($header, $sheets);

            return view('organizer.visitor.track', compact('visitor', 'talks', 'forms'));
        }
    }

    public function trackStore(Request $request, $id)
    {
        $check = Track::where('visitor_id', $id)->where('talk_id', $request->talk)->first();

        if (empty($check)) {
            $track = new Track([
                'visitor_id' => $id,
                'talk_id' => $request->talk,
            ]);
            $track->save();
        }

        return redirect()->back()->with('alert');
    }

    public function exhibitors()
    {
        return view('organizer.events.exhibitors');
    }

    public function exhibitorsCreate(Request $request)
    {
        $events = $request->events;
        $users = $request->users;

        $users = User::whereIn('id', $users)->get();

        if ($events) {
            $events = Event::whereIn('id', $events)->get();

            foreach ($events as $event) {
                $roles[] = $event->custid;
            }
        }

        $roles[] = 'exhibitor';

        foreach ($users as $user) {
            $user->assignRole($roles);
        }

        return redirect()->back()->with('success', 'Expositor dado de alta correctamente');
    }

    public function talks()
    {
        return view('organizer.events.talks');
    }

    public function visitors()
    {
        return view('organizer.events.visitors');
    }

    public function staffIndex()
    {
        return view('organizer.staff');
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
                'filter' => 'Organizador nuevo: '.$request->name,
            ]]);
            $check = json_decode($client->getBody(), true)['data']['data'];

            if (!isset($check[0])) {
                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
                'headers' => $authorization,
                'form_params' => [
                    'name' => 'Organizador nuevo: '.$request->name,
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
                    'name' => 'Organizador nuevo: '.$request->name,
                    'subject' => 'Has sido invitado a ser organizador del evento '.$event->title,
                    'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://mediaware.org/channeltalks/imagenes/header.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"><p style="max-width: 600px; font-size: 20px">Hola '.$request->name.' has sido invitado a ser organizador del evento '.$event->title.' para confirmar su cuenta ingresa al siguiente link <a href="'.route('staff.enable', ['token' => $token, 'type' => 'organizer']).'">AQUI</a>.</p></div></td></tr></tbody></table>',
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

            return redirect()->back()->with('success', 'Organizador invitado correctamente');
        }

        return redirect()->back()->with('success', 'Este organizador ya existe');
    }
}
