<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Inscription;
use Carbon\Carbon;

class OrganizerController extends Controller
{
    public function eventsIndex()
    {
        $events = Event::get()->all();
        $inscriptions = Inscription::get()->all();

        return view('organizer.events.index', compact('events', 'inscriptions'));
    }

    public function eventsCreate(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required',
            'inscription' => 'required',
        ]);

        if ($request->approve == 'on') {
            $approve = true;
        } else {
            $approve = false;
        }

        do {
            $custid = strtolower(Str::random(6));
        } while (Event::where('custid', $custid)->first() <> null);

        $event = new Event([
            'custid' => $custid,
            'title' => $request->title,
            'date' => $request->date,
            'inscription' => implode("*", $request->inscription),
            'approve' => $approve
        ]);
 
        $event->save();

        return redirect()->back()->with('success', 'Evento dado de alta correctamente');
    }
}
