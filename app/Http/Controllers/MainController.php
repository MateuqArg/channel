<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\{Event, User, Visitor, Meeting};
use App\Jobs\{CheckForms};
use Carbon\Carbon;
use Auth;

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

    public function eventsForm($custid)
    {
        $event = Event::where('custid', $custid)->first();
        
        $date = Carbon::create($event->date);
        if ($date->lessThan(Carbon::now())) {
            $event = 'Este evento ya ha cerrado sus inscripciones';
        }

        $exhibitors = User::role('exhibitor')->role($custid)->get();

        $user = Auth::user();

        return view('main.form', compact('event', 'user', 'exhibitors'));
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

        if (!\Auth::user()) {
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
        $user->password = \Hash::make($request->password);
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
        CheckForms::dispatch()->onConnection('database');
        Artisan::call('queue:work database --queue=default');
    }
}
