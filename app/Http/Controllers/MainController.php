<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Visitor;
use App\Models\Meeting;
use Auth;

class MainController extends Controller
{
    public function events()
    {
        $events = Event::get()->all();

        return view('main.index', compact('events'));
    }

    public function eventsVisitor(Request $request, $custid)
    {
        $event = Event::where('custid', $custid)->first();
        $data = explode("*", $event->inscription);

        $exhibitors = User::role('exhibitor')->role($custid)->get();

        $user = \Auth::user();

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
}
