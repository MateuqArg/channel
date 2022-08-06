<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ExhibitorController;
use App\Http\Controllers\MainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('main.home');
})->name('home');

Route::name('events.')->prefix('events')->group(function () {
    Route::get('/{custid}', [MainController::class, 'eventForm'])->name('form.get');
    Route::get('/{custid}/store', [MainController::class, 'eventFormStore'])->name('form.store');
    Route::get('/survey/{custid}', [MainController::class, 'eventSurveyForm'])->name('survey.get');
    Route::get('/survey/{custid}/store', [MainController::class, 'eventSurveyFormStore'])->name('survey.store');
    Route::get('/meeting/{custid}', [MainController::class, 'eventMeetingForm'])->name('meeting.get');
    Route::get('/meeting/{custid}/store', [MainController::class, 'eventMeetingFormStore'])->name('meeting.store');
    // Route::get('/emails/{id}', [OrganizerController::class, 'eventsEmails'])->name('emails');
});

Route::get('/invite/{token}/{type}', [MainController::class, 'inviteEnable'])->name('staff.enable');
Route::post('/invite/store', [MainController::class, 'inviteStore'])->name('staff.store');
Route::get('/invite/{token}', [MainController::class, 'exhibitorEnable'])->name('exhibitor.enable');
// Route::post('/invite/store', [MainController::class, 'inviteStore'])->name('staff.store');
Route::get('/meeting/accept/{id}', [MainController::class, 'meetingAccept'])->name('meeting.accept');
Route::get('/updateforms', [MainController::class, 'updateForms'])->name('forms');

Route::get('/profile', [MainController::class, 'profile'])->name('profile');

Route::name('organizer.')->prefix('organizer')->middleware(['role:organizer'])->group(function () {
    Route::name('events.')->prefix('events')->group(function () {
        Route::get('/', [OrganizerController::class, 'eventsIndex'])->name('index');
        Route::get('/emails/{id}', [OrganizerController::class, 'eventsEmails'])->name('emails');
        Route::get('/forms/{id}', [OrganizerController::class, 'eventsForms'])->name('forms');
    });

    Route::name('users.')->prefix('users')->group(function () {
        Route::get('/', [OrganizerController::class, 'usersIndex'])->name('index');
    });

    Route::name('visitor.')->prefix('visitor')->group(function () {
        Route::get('/{custid}', [OrganizerController::class, 'visitorScan'])->name('scan');
        Route::get('/print/{custid}', [OrganizerController::class, 'visitorPrint'])->name('print');
        Route::get('/track/{custid}', [OrganizerController::class, 'visitorTrack'])->name('track');
        Route::get('/store/{id}', [OrganizerController::class, 'trackStore'])->name('store');
        Route::get('/accept/{id}', [OrganizerController::class, 'visitorAccept'])->name('accept');
        Route::get('/reject/{id}', [OrganizerController::class, 'visitorReject'])->name('reject');
    });

    Route::name('exhibitor.')->prefix('exhibitor')->group(function () {
        Route::get('/', [OrganizerController::class, 'exhibitors'])->name('index');
        Route::post('/create', [OrganizerController::class, 'exhibitorsCreate'])->name('create');
    });

    Route::name('talk.')->prefix('talk')->group(function () {
        Route::get('/', [OrganizerController::class, 'talks'])->name('index');
    });

    Route::name('staff.')->prefix('staff')->group(function () {
        Route::get('/', [OrganizerController::class, 'staffIndex'])->name('index');
        Route::post('/send', [OrganizerController::class, 'staffSend'])->name('send');
    });

    Route::name('visitors.')->prefix('visitors')->group(function () {
        Route::get('/', [OrganizerController::class, 'visitors'])->name('index');
    });

    Route::name('simulate.')->prefix('simulate')->group(function () {
        Route::get('/', [OrganizerController::class, 'simulateIndex'])->name('index');
        Route::post('/send', [OrganizerController::class, 'simulate'])->name('send');
    });
});

Route::name('exhibitor.')->prefix('exhibitor')->middleware(['role:exhibitor'])->group(function () {
    Route::name('visitors.')->prefix('visitors')->group(function () {
        Route::get('/', [ExhibitorController::class, 'visitors'])->name('index');
    });

    Route::name('visitor.')->prefix('visitor')->group(function () {
        Route::get('/track/{custid}', [ExhibitorController::class, 'visitorTrack'])->name('track');
        Route::get('/store/{id}', [ExhibitorController::class, 'trackStore'])->name('store');
    });

    Route::name('groups.')->prefix('groups')->group(function () {
        Route::get('/', [ExhibitorController::class, 'groups'])->name('index');
        Route::get('/show/{id}', [ExhibitorController::class, 'groupShow'])->name('show');
        Route::get('/all', [ExhibitorController::class, 'groupAll'])->name('all');
    });
    
    Route::name('invite.')->prefix('invite')->group(function () {
        Route::get('/', [ExhibitorController::class, 'inviteIndex'])->name('index');
        Route::post('/send', [ExhibitorController::class, 'inviteSend'])->name('send');
    });

    Route::name('meeting.')->prefix('meeting')->group(function () {
        Route::post('/request', [ExhibitorController::class, 'meetingRequest'])->name('request');
        Route::get('/accept/{id}', [ExhibitorController::class, 'meetingAccept'])->name('accept');
        Route::get('/reject/{id}', [ExhibitorController::class, 'meetingReject'])->name('reject');
    });

    Route::name('staff.')->prefix('staff')->group(function () {
        Route::get('/', [ExhibitorController::class, 'staffIndex'])->name('index');
        Route::post('/send', [ExhibitorController::class, 'staffSend'])->name('send');
    });

    Route::get('/talks', [ExhibitorController::class, 'talks'])->name('talks');
    Route::get('/visitors', [ExhibitorController::class, 'visitors'])->name('visitors');

    Route::name('simulate.')->prefix('simulate')->group(function () {
        Route::get('/send', [ExhibitorController::class, 'simulate'])->name('send');
    });
});

require __DIR__.'/auth.php';
