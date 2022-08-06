<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\{Event, User, Visitor, Meeting, Response, Input};
use App\Jobs\{CheckForms, SendQR};
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Auth;
use Image;
use Storage;
use Sheets;
use Str;
use Hash;

class MainController extends Controller
{
    public function __construct()
    {
    }

    public function events()
    {
        $events = Event::get()->all();

        return view('main.index', compact('events'));
    }

    public function eventForm($custid)
    {
        $event = Event::where('custid', $custid)->first();

        $date = Carbon::create($event->date);
        if ($date->lessThan(Carbon::now())) {
            $event = 'Este evento ya ha cerrado sus inscripciones';
        }

        return view('main.form', compact('event'));
    }

    public function eventFormStore(Request $request, $custid)
    {
        unset($request['_token']);

        foreach ($request->all() as $key => $value) {
           $request->session()->put("form.data.$key", $value);
        }

        return redirect()->route('events.survey.get', [$custid]);
    }

    public function eventSurveyForm($custid)
    {
        $event = Event::where('custid', $custid)->first();
        
        $date = Carbon::create($event->date);
        if ($date->lessThan(Carbon::now())) {
            $event = 'Este evento ya ha cerrado sus inscripciones';
        }

        $inputs = $event->inputs;
// dd(Str::slug($inputs[10]->label, '-'));
        return view('main.survey', compact('event', 'inputs'));
    }

    public function eventSurveyFormStore(Request $request, $custid)
    {
        unset($request['_token']);

        foreach ($request->all() as $key => $value) {
           $request->session()->put("form.survey.$key", $value);
        }

// dd($request->session()->get('form.survey'));

        return redirect()->route('events.meeting.get', [$custid]);
    }

    public function eventMeetingForm($custid)
    {
        $event = Event::where('custid', $custid)->first();
        
        $date = Carbon::create($event->date);
        if ($date->lessThan(Carbon::now())) {
            $event = 'Este evento ya ha cerrado sus inscripciones';
        }

        $exhibitors = User::role('exhibitor')->role($custid)->get();

        return view('main.meeting', compact('event', 'exhibitors'));
    }

    public function eventMeetingFormStore(Request $request, $custid)
    {
        unset($request['_token']);

        $event = Event::where('custid', $custid)->first();

        $approved = false;
        if ($event->approve == 0) {
            $approved = true;
        }

        $request->session()->put("form.meeting", $request->all()['meeting']);

        $data = $request->session()->get('form.data');
        $survey = $request->session()->get('form.survey');
        $meetings = $request->session()->get('form.meeting');

        do {
            $userid = createCustomid();;
        } while (Visitor::where('custid', $userid)->first() <> null);

        $visitor = new Visitor([
            'custid' => $userid,
            'event_id' => $event->id,
            'approved' => $approved,
            'present' => null,
            'vip' => 0,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'company' => $data['company'],
            'charge' => $data['charge'],
            'state' => $data['state'],
            'city' => $data['city'],
        ]);
        $visitor->save();

        foreach ($survey as $key => $value) {
            if (is_array($value)) {
                $value = implode('*', $value);
            }
            $response = new Response([
                'input_id' => $key,
                'visitor_id' => $visitor->id,
                'value' => $value,
            ]);
            $response->save();
        }

        foreach($meetings as $meeting) {
            do {
                $custid = createCustomid();
            } while (Meeting::where('custid', $custid)->first() <> null);

            $exhibitor = User::find($meeting)->first();

            if (!empty($exhibitor)) {
                $meeting = new Meeting([
                    'custid' => $custid,
                    'event_id' => $event->id,
                    'visitor_id' => $visitor->id,
                    'exhibitor' => $exhibitor->id,
                    'approved' => null,
                    'requested' => 'visitor'
                ]);
                $meeting->save();
            }
        }

        SendQR::dispatch($visitor->id)->onConnection('database');
        Artisan::call('queue:work database --queue=default');

        return redirect()->back()->with('success', 'Inscripción realizada correctamente');
    }

    public function eventsVisitor(Request $request, $custid)
    {
        $event = Event::where('custid', $custid)->first();
        $data = explode("*", $event->inscription);

        $exhibitors = User::role('exhibitor')->role($custid)->get();

        $user = Auth::user();

        return view('main.inscription', compact('event', 'data', 'exhibitors', 'user'));
    }

    public function visitorStore(Request $request, $custid)
    {
        $event = Event::where('custid', $custid)->first();

        do {
            $inscid = createCustomid();;
        } while (Visitor::where('custid', $inscid)->first() <> null);
        $data = $request->all();
        unset($data['_token']);
        $data['event_id'] = $event->id;
        $data['custid'] = $inscid;

        if ($event->approve = false) {
            $data['approved'] = true;
        }

        if (!Auth::user()) {
            do {
                $userid = createCustomid();
            } while (User::where('custid', $userid)->first() <> null);

            $user = new User([
                'custid' => $userid,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('visitor');

            event(new Registered($user));

            Auth::login($user);

            $data['visitor_id'] = $user->id;
        } else {
            $user = Auth::user();
            $data['visitor_id'] = $user->id;
        }

        $visitor = new Visitor;
        $visitor->fill($data);
        $visitor->save();

        if ($request->meeting == 'on') {
            foreach ($request->exhibitors as $exhibitor) {
                do {
                    $inscid = createCustomid();
                } while (Meeting::where('custid', $inscid)->first() <> null);
                $meeting = new Meeting([
                    'custid' => $custid,
                    'event_id' => $event->id,
                    'visitor_id' => $user->id,
                    'exhibitor_id' => $exhibitor,
                    'approved' => null,
                    'requested' => 'visitor'
                ]);
                $meeting->save();
            }
        }

        return redirect()->back()->with('success', 'Inscripción enviada correctamente')->with('disabled');
    }

    public function profile()
    {
        return view('main.profile');
    }

    public function inviteEnable(Request $request, $token, $type)
    {
        $request->session()->put('token', $token);
        $request->session()->put('type', $type);

        $user = User::where('password', $token)->first();

        return view('main.invite', compact('user', 'type'));
    }

    public function inviteStore(Request $request)
    {
        $token = $request->session()->get('token');
        $type = $request->session()->get('type');

        $user = User::where('password', $token)->first();
        $user->password = Hash::make($request->password);
        $user->update();

        if ($type = 'organizer') {
            $user->assignRole('organizer');
        } else if ($type = 'exhibitor') {
            $user->assignRole('exhibitor');
        }

        Auth::loginUsingId($user->id, true);
        if ($type = 'organizer') {
            return redirect()->route('organizer.events.index');
        } else {
            return redirect()->route('exhibitor.visitors.index');
        }
    }

    public function meetingAccept(Request $request, $id)
    {
        $meeting = Meeting::find($id);
        $meeting->approved = true;
        $meeting->update();

        return view('main.meetaccept');
    }

    public function updateForms()
    {
        $forms = cachedForms('all');

        $passed = [];
        foreach ($forms as $key => $list) {
            foreach ($list as $form) {
                $check = Visitor::where('name', $form['Nombre completo'])
                ->where('email', $form['Direccion de email'])->first();

                if ($check == null) {
                    do {
                        $custid = createCustomid();
                    } while (Visitor::where('custid', $custid)->first() <> null);

                    $event = Event::where('title', $key)->first();
                    $approved = false;

                    if ($event->approve == 0) {
                        $approved = true;
                    }

                    $key = array_search('Provincia/Estado/Región', array_keys($form->toArray()), true) + 1;
                    if ($key !== false) {
                        $responses = array_slice($form->toArray(), $key, null, true);
                        unset($responses['Pido reunirme con...']);
                    }
dd($responses);
                    $visitor = new Visitor([
                        'custid' => $custid,
                        'event_id' => $event->id,
                        'approved' => $approved,
                        'present' => null,
                        'vip' => 0,
                        'name' => $form['Nombre completo'],
                        'email' => $form['Direccion de email'],
                        'phone' => $form['Telefono'],
                        'company' => $form['Empresa'],
                        'charge' => $form['Cargo'],
                        'state' => $form['Provincia/Estado/Región'],
                        'city' => $form['Localidad'],
                    ]);
                    $visitor->save();

                    foreach ($responses as $key => $value) {
                        $input = Input::where('label', $key)->first();

                        $response = new Response([
                            'input_id' => $input->id,
                            'visitor_id' => $visitor->id,
                            'value' => $value
                        ]);
                        $response->save();
                    }

                    if (!in_array($form['Nombre completo'], $passed)) {
                        if ($event->approve == 0) {
                            $file = QrCode::format('png')->size(305)->generate('https://www.channeltalks.net/organizer/visitor/'.$visitor->custid);
                            $file_name = Str::random(32).'.'.'png';
                            $qr_file = Storage::disk('public_uploads')->put($file_name, $file);
                            $file = Storage::disk('public_uploads')->get($file_name);

                            $bg = '../public_html/uploads/'.$event->qrfile;

                            $img = Image::make($bg);

                            $img->text($form['Nombre completo'], 350, 200, function($font) {
                                $font->file('../public_html/Montserrat.ttf');
                                $font->align('center');
                                $font->color('#000');
                                $font->size(36);
                            });

                            $img->insert($file, 'bottom', 350, 186);

                            $file_name = Str::random(32).'.'.'png';

                            $img->save('../public_html/uploads/'.$file_name);
                            // Storage::disk('public_uploads')->delete($file_name);

                            $authorization = ['Authorization' => 'eyJpdiI6Ik9UUXdOVFkyT1RZek5qSTNNVGs0T0E9PSIsInZhbHVlIjoiMEwwVjFjeTVyZ3ZnWlE1U204REtkQk0vZCtSbW4rdGZ1WXg3Uzk2Z2dLST0iLCJtYWMiOiI0MzM2M2NlNDE3YjMyY2ZhNjNlZTIxNGFmMDQwOTQyNjVhMzA3ZGNlMDQzZGQ5NDNlZWY0OTIxNWNhZjI4MmUzIn0='];

                            $client = new Client();
                            $client = $client->request('POST', 'https://api.esmsv.com/v1/listscontacts/create', [
                            'headers' => $authorization,
                            'form_params' => [
                                'name' => 'Asistencia aprobada: '.$form['Nombre completo'].rand(),
                            ]]);
                            $list_id = json_decode($client->getBody(), true)['data']['id'];

                            $client = new Client();
                            $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/getall', [
                            'headers' => $authorization,
                            'form_params' => [
                                'email' => $form['Direccion de email'],
                            ]]);

                            $contacts_ids = [];
                            if (!empty(json_decode($client->getBody(), true)['data']['data'])) {
                                $contacts_ids[] = json_decode($client->getBody(), true)['data']['data'][0]['id'];
                            } else {
                                $client = new Client();
                                $client = $client->request('POST', 'https://api.esmsv.com/v1/contacts/create', [
                                'headers' => $authorization,
                                'form_params' => [
                                    'email' => $form['Direccion de email'],
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

                            // $client = new Client();
                            // $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/create', [
                            // 'headers' => $authorization,
                            // 'form_params' => [
                            //     'name' => 'Registro aprobado: '.$form['Nombre completo'],
                            //     'subject' => '¡Has sido registrado exitosamente!',
                            //     'content' => '<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody><tr><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%; padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center"><div style="font-size: 12px;font-style: normal;font-weight: 400;"><img src="https://channeltalks.net/uploads/'.$file_name.'" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: 0;height: auto;line-height: 100%;margin: undefined;float: none;width: auto;max-width: 600px;" alt="" border="0" width="auto" class="center fullwidth"></div></td></tr></tbody></table>',
                            //     'fromAlias' => 'Channel Talks',
                            //     'fromEmail' => 'channeltalks@mediaware.news',
                            //     'replyEmail' => 'channeltalks@mediaware.news',
                            //     'mailListsIds' => [$list_id],
                            // ]]);
                            // $id = json_decode($client->getBody(), true)['data']['id'];

                            // $client = new Client();
                            // $client = $client->request('POST', 'https://api.esmsv.com/v1/campaign/send', [
                            // 'headers' => $authorization,
                            // 'form_params' => [
                            //     'id' => $id,
                            //     'sendNow' => 1
                            // ]]);
                        }

                        if (!empty($form['Pido reunirme con...'])) {
                            $meetings = explode(', ', $form['Pido reunirme con...']);

                            foreach($meetings as $meeting) {
                                do {
                                    $custid = createCustomid();
                                } while (Meeting::where('custid', $custid)->first() <> null);

                                $exhibitor = User::where('name', $meeting)->first();

                                if (!empty($exhibitor)) {
                                    $meeting = new Meeting([
                                        'custid' => $custid,
                                        'event_id' => Cache::get('currentEvent'),
                                        'visitor_id' => $visitor->id,
                                        'exhibitor' => $exhibitor->id,
                                        'approved' => null,
                                        'requested' => 'visitor'
                                    ]);
                                    $meeting->save();
                                }
                            }
                        }

                        $passed[] = $form['Nombre completo'];
                    }
                }
            }
        }

        cachedForms('all');        

        // CheckForms::dispatch()->onConnection('database');
        // Artisan::call('queue:work database --queue=default');
    }
}
