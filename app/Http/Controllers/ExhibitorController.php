<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Event;
use App\Models\Meeting;
use App\Models\Visitor;
use App\Models\User;

class ExhibitorController extends Controller
{
    public function eventsIndex()
    {
        $events = Event::whereIn('custid',  \Auth::user()->getRoleNames())->get();
        $meetings = Meeting::where('approved', null)->where('exhibitor_id', \Auth::user()->id)->where('requested', 'visitor')->get();
        $visitors = Visitor::where('approved', true)->whereDoesntHave('meetings', function ($meetingQuery) {
            $meetingQuery->where('exhibitor_id', \Auth::user()->id);
        })->get();

        return view('exhibitor.events.index', compact('events', 'meetings', 'visitors'));
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

    public function meetingRequest(Request $request)
    {
        foreach ($request->visitors as $visitor) {
            do {
                $custid = createCustomid();
            } while (Meeting::where('custid', $custid)->first() <> null);

            $inscription = Visitor::find($visitor);
            $meeting = new Meeting([
                'custid' => $custid,
                'event_id' => $inscription->event->id,
                'visitor_id' => $inscription->id,
                'exhibitor_id' => \Auth::user()->id,
                'approved' => null,
                'requested' => 'exhibitor'
            ]);
            $meeting->save();

        }

        return redirect()->back()->with('successrequest', 'Reunión solicitada');
    }

    public function inviteIndex()
    {
        return view('exhibitor.invite');
    }

    public function inviteSend(Request $request)
    {
        $custid = createCustomid();
        $ext = $request->excel->getClientOriginalExtension();

        $request->excel->storeAs('/', 'excels/'.$custid.'.'.$ext, 'public_uploads');
        $collection = fastexcel()->import(public_path().'/excels/'.$custid.'.'.$ext);

        unlink(public_path().'/excels/'.$custid.'.'.$ext);
        
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
}
