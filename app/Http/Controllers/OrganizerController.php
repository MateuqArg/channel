<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\{Event, Visitor, User, Talk, Track, Meeting, Email, Group};
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
        $this->middleware('auth');
        $this->spread = '1qCqKCFDEskSdIHq0p7lWwZupleeRG5nBI7on7_uwqmE';
        $this->currentEvent = 'Respuestas de formulario 1';
    }

    public function eventsIndex(Request $request)
    {
        $visitors = Visitor::where('approved', null)->get();

        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        return view('organizer.events.index', compact('visitors', 'forms'));
    }

    public function visitorAccept(Request $request, $id)
    {
        $visitor = Visitor::find($id);
        // $visitor->approved = true;
        // $visitor->update();

        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        $file = QrCode::format('png')->size(305)->generate(route('organizer.visitor.track', ['custid' => $visitor->custid]));
        $qr_file = $file_name = time().'.'.'png';
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

        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
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

            if ($meetings->isNotEmpty()) {
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
                        'name' => 'Reunión con '.$forms[$visitor->form_id]['Nombre completo'].rand(),
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
                }
            }

            $meetings = Meeting::where('visitor_id', $visitor->id)->where('approved', true)->where('event_id', $this->currentEvent)->get();

            if ($visitor->vip == 1) {
                $organizers = User::role('organizer')->get();
                
                $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

                $client = new Client();
                $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/getAll', [
                'headers' => $authorization,
                'form_params' => [
                    'filter' => 'Ingreso VIP: '.$forms[$visitor->form_id]['Nombre completo'],
                ]]);
                $check = json_decode($client->getBody(), true)['data']['data'];

                if (!isset($check[0])) {
                    $client = new Client();
                    $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
                    'headers' => $authorization,
                    'form_params' => [
                        'name' => 'Ingreso VIP: '.$forms[$visitor->form_id]['Nombre completo'].rand(),
                    ]]);
                    $list_id = json_decode($client->getBody(), true)['data']['id'];

                    foreach ($organizers as $user) {
                        $client = new Client();
                        $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
                        'headers' => $authorization,
                        'form_params' => [
                            'email' => $user->email,
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
                        'name' => 'Ingreso VIP: '.$forms[$visitor->form_id]['Nombre completo'],
                        'subject' => 'El invitado '.$forms[$visitor->form_id]['Nombre completo'].' ha ingresado al evento',
                        'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://mediaware.org/channeltalks/imagenes/header.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"><p style="max-width: 600px; font-size: 20px">El invitado VIP '.$forms[$visitor->form_id]['Nombre completo'].' ha ingresado al evento.</p></div></td></tr></tbody></table>',
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
                }
            }
        }

        $visitor->present = true;
        $visitor->update();

        // return \Response::download(public_path('/images/1.png'));
        return view('organizer.visitor.scan', compact('visitor', 'forms'));
    }

    public function visitorPrint(Request $request, $custid)
    {
        $visitor = Visitor::where('custid', $custid)->first();

        $sheets = Sheets::spreadsheet($this->spread)->sheet($this->currentEvent)->get();
        $forms = Sheets::collection($sheets->pull(0), $sheets);

        // Código para generar la etiqueta

        $file = QrCode::format('png')->size(300)->generate(route('organizer.visitor.track', ['custid' => $visitor->custid]));
        $qr_file = 'qr.png';
        Storage::disk('public_uploads')->put($qr_file, $file);
        $file = Storage::disk('public_uploads')->get($qr_file);

        $file_name = time().'.'.'png';

        $width = 600;
        $height = 850;
        $center_x = $width / 2;
        // $center_y = $height / 2;
        $max_len = 14;
        $font_size = 76;
        $font_height = 35;

        $text = ucwords(strtolower(explode(' ', $forms[$visitor->form_id]['Nombre completo'], 2)[0]));
        if (isset(explode(' ', $forms[$visitor->form_id]['Nombre completo'], 2)[1])) {
            $text = $text .' '. ucwords(strtolower(explode(' ', $forms[$visitor->form_id]['Nombre completo'], 2)[1]));
        }
        
        $lines = explode("\n", wordwrap($text, $max_len));
        $y = 450 - ((count($lines) - 1) * $font_height);
        $img = Image::canvas($width, 800, '#fff');
        $img->insert($file, 'top', 300, 10);

        foreach ($lines as $line)
        {
            $img->text($line, $center_x, $y, function($font) use ($font_size){
                $font->file(public_path("Gotham.ttf"));
                $font->size($font_size);
                $font->color('#000');
                $font->align('center');
            });

            $y += $font_height * 2;
        }

        $max_len = 23;
        $font_size = 45;
        $font_height = 30;

        $text = ucwords(strtolower($forms[$visitor->form_id]['Cargo']));

        $lines = explode("\n", wordwrap($text, $max_len));
        $y2 = $y - ((count($lines) - 1) * $font_height);

        foreach ($lines as $line)
        {
            $img->text($line, $center_x, $y, function($font) use ($font_size){
                $font->file(public_path("Gotham.ttf"));
                $font->size($font_size);
                $font->color('#000');
                $font->align('center');
            });

            $y += $font_height * 2;
        }

        $y = $y + 20;

        $max_len = 18;
        $font_size = 60;
        $font_height = 30;

        $text = ucwords(strtolower($forms[$visitor->form_id]['Empresa']));

        $lines = explode("\n", wordwrap($text, $max_len));
        $y2 = $y - ((count($lines) - 1) * $font_height);

        foreach ($lines as $line)
        {
            $img->text($line, $center_x, $y, function($font) use ($font_size){
                $font->file(public_path("Gotham.ttf"));
                $font->size($font_size);
                $font->color('#000');
                $font->align('center');
            });

            $y += $font_height * 2;
        }

        $img->save(public_path('uploads/'.$file_name));
        Storage::disk('public_uploads')->delete($qr_file);
        return \Response::download(public_path('uploads/'.$file_name));
        // return $img->response("png");
    }

    public function visitorTrack(Request $request, $custid)
    {
        $visitor = Visitor::where('custid', $custid)->first();
        $entrys = Track::where('visitor_id', $visitor->id)->where('extra', 'enter')->first();

        if (!empty($entrys)) {
            $check = Track::where('visitor_id', $visitor->id)->where('talk_id', Session::get('talk_id'))->first();
            // dd($check);
            if (empty($check)) {
                $track = new Track([
                    'visitor_id' => $visitor->id,
                    'talk_id' => Session::get('talk_id'),
                ]);
                $track->save();
// dd(Session::get('talk'));
                $group = Group::where('title', Session::get('talk'))->first();
                $visitor->groups()->attach($group->id);
            }
        }

        return redirect()->back()->with('alert');
    }

    public function exhibitors()
    {
        return view('organizer.events.exhibitors');
    }

    public function exhibitorsCreate(Request $request)
    {
        $check =  User::where('email', $request->email)->first();

        if (empty($check)) {
            $event = Event::find(substr($this->currentEvent, strrpos($this->currentEvent, ' ') + 1));

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
                    'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://mediaware.org/channeltalks/imagenes/header.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"><p style="max-width: 600px; font-size: 20px">Hola '.$request->name.' has sido invitado a ser expositor del evento '.$event->title.' para confirmar su cuenta ingresa al siguiente link <a href="'.route('exhibitor.enable', ['token' => $token]).'">AQUI</a>.</p></div></td></tr></tbody></table>',
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

                $user->assignRole('exhibitor');
            }

            return redirect()->back()->with('success', 'Expositor invitado correctamente');
        }

        return redirect()->back()->with('success', 'Este expositor ya existe');
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

    public function simulateIndex()
    {
        return view('organizer.simulate');
    }

    public function simulate(Request $request)
    {
        $request->session()->flush();
        Session::put('simulate', Auth::user()->id);
        Auth::loginUsingId($request->userid, true);
        // dd(Session::get('talk_id'));
        return redirect()->route('exhibitor.visitors');
    }

    // public function staffSend(Request $request)
    // {
    //     $check =  User::where('email', $request->email)->first();

    //     if (empty($check)) {
    //         $event = Event::find(substr($this->currentEvent, strrpos($this->currentEvent, ' ') + 1));

    //         $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

    //         $client = new Client();
    //         $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/getAll', [
    //         'headers' => $authorization,
    //         'form_params' => [
    //             'filter' => $request->type.' nuevo: '.$request->name,
    //         ]]);
    //         $check = json_decode($client->getBody(), true)['data']['data'];

    //         if (!isset($check[0])) {
    //             $client = new Client();
    //             $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
    //             'headers' => $authorization,
    //             'form_params' => [
    //                 'name' => $request->type.' nuevo: '.$request->name,
    //             ]]);
    //             $list_id = json_decode($client->getBody(), true)['data']['id'];

    //             $client = new Client();
    //             $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
    //             'headers' => $authorization,
    //             'form_params' => [
    //                 'email' => $request->email,
    //             ]]);

    //             if (isset(json_decode($client->getBody(), true)['data']['data'][0]['id'])) {
    //                 $contacts_ids[] = json_decode($client->getBody(), true)['data']['data'][0]['id'];
    //             } else {
    //                 $client = new Client();
    //                 $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/create', [
    //                 'headers' => $authorization,
    //                 'form_params' => [
    //                     'email' => $request->email,
    //                 ]]);
    //                 $contacts_ids[] = json_decode($client->getBody(), true)['data']['id'];
    //             }

    //             $client = new Client();
    //             $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/suscribe', [
    //             'headers' => $authorization,
    //             'form_params' => [
    //                 'listId' => $list_id,
    //                 'contactsIds' => $contacts_ids
    //             ]]);

    //             $token = sha1(rand());

    //             $client = new Client();
    //             $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/create', [
    //             'headers' => $authorization,
    //             'form_params' => [
    //                 'name' => $request->type.' nuevo: '.$request->name,
    //                 'subject' => 'Has sido invitado a ser '.$request->type.' del evento '.$event->title,
    //                 'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://mediaware.org/channeltalks/imagenes/header.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"><p style="max-width: 600px; font-size: 20px">Hola '.$request->name.' has sido invitado a ser .'$request->type'. del evento '.$event->title.' para confirmar su cuenta ingresa al siguiente link <a href="'.route('staff.enable', ['token' => $token, 'type' => $request->type]).'">AQUI</a>.</p></div></td></tr></tbody></table>',
    //                 'fromAlias' => 'Channel Talks',
    //                 'fromEmail' => 'channeltalks@mediaware.news',
    //                 'replyEmail' => 'channeltalks@mediaware.news',
    //                 'mailListsIds' => [$list_id],
    //             ]]);
    //             $id = json_decode($client->getBody(), true)['data']['id'];

    //             $client = new Client();
    //             $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/send', [
    //             'headers' => $authorization,
    //             'form_params' => [
    //                 'id' => $id,
    //                 'sendNow' => 1
    //             ]]);

    //             do {
    //                 $custid = createCustomid();
    //             } while (User::where('custid', $custid)->first() <> null);

    //             $user = new User([
    //                 'custid' => $custid,
    //                 'name' => $request->name,
    //                 'email' => $request->email,
    //                 'password' => $token
    //             ]);
    //             $user->save();

    //             if ($request->staff) {
    //                 $user->assignRole('staff');
    //             }
    //         }

    //         return redirect()->back()->with('success', 'Organizador invitado correctamente');
    //     }

    //     return redirect()->back()->with('success', 'Este organizador ya existe');
    // }
}
