<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\Event;
use App\Models\Visitor;
use Carbon\Carbon;

class OrganizerController extends Controller
{
    public function eventsIndex()
    {
        $events = Event::get()->all();
        $visitors = Visitor::where('approved', null)->get();

        return view('organizer.events.index', compact('events', 'visitors'));
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
            $custid = createCustomid();
        } while (Event::where('custid', $custid)->first() <> null);

        $event = new Event([
            'custid' => $custid,
            'title' => $request->title,
            'date' => $request->date,
            'inscription' => implode("*", $request->inscription),
            'approve' => $approve
        ]);
        $event->save();

        Role::create(['name' => $custid]);

        return redirect()->back()->with('success', 'Evento dado de alta correctamente');
    }

    public function visitorAccept(Request $request, $id)
    {
        $visitor = Visitor::find($id);
        $visitor->approved = true;
        $visitor->update();

        return redirect()->back()->with('successvisitors', 'Inscripción aceptada correctamente');
    }

    public function visitorReject(Request $request, $id)
    {
        $visitor = Visitor::find($id);
        $visitor->approved = false;
        $visitor->update();

        return redirect()->back()->with('successvisitors', 'Inscripción rechazada correctamente');
    }
}
