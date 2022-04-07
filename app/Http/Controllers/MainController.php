<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Inscription;
use App\Models\Meeting;

class MainController extends Controller
{
    public function eventsInscription(Request $request, $custid)
    {
        $event = Event::where('custid', $custid)->first();
        $data = explode("*", $event->inscription);

        $exhibitors = User::role('exhibitor')->role('e'.$custid)->get();

        return view('main.inscription', compact('event', 'data', 'exhibitors'));
    }

    public function inscriptionStore(Request $request, $custid)
    {
        $event = Event::where('custid', $custid)->first();

        do {
            $inscid = strtolower(Str::random(6));
        } while (Inscription::where('custid', $inscid)->first() <> null);
        $data = $request->all();
        unset($data['_token']);
        $data['event_id'] = $event->id;
        $data['custid'] = $inscid;

        if ($event->approve = true) {
            $data['approved'] = false;
        }

        $inscription = new Inscription;
        $inscription->fill($data);
        $inscription->save();

        $inscription = Inscription::where('custid', $inscid)->first();

        if ($request->meeting == 'on') {
            foreach ($request->exhibitors as $exhibitor) {
                $meeting = new Meeting([
                    'event_id' => $event->id,
                    'inscription_id' => $inscription->id,
                    'exhibitor_id' => $exhibitor,
                    'approved' => false
                ]);
                $meeting->save();
            }
        }

        return redirect()->back()->with('success', 'Inscripción enviada correctamente')->with('disabled');
    }
}
