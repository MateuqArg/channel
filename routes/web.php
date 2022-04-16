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

// Route::get('/', function () {
//     return view('main.home');
// })->name('home');

Route::name('visitor.')->prefix('visitor')->group(function () {
    Route::prefix('events')->group(function () {
        Route::get('/', [MainController::class, 'events'])->name('index');
        Route::get('/{custid}', [MainController::class, 'eventsVisitor'])->name('inscription');
        Route::get('/{custid}/store', [MainController::class, 'visitorStore'])->name('inscription.store');
    });
});

Route::name('organizer.')->prefix('organizer')->middleware(['role:organizer'], ['auth'])->group(function () {
    Route::name('events.')->prefix('events')->group(function () {
        Route::get('/', [OrganizerController::class, 'eventsIndex'])->name('index');
        Route::get('/{id}', [OrganizerController::class, 'eventsShow'])->name('show');
        Route::post('/create', [OrganizerController::class, 'eventsCreate'])->name('create');
    });

    Route::name('visitor.')->prefix('visitor')->group(function () {
        Route::get('/{custid}', [OrganizerController::class, 'visitorScan'])->name('scan');
        Route::get('/print/{custid}', [OrganizerController::class, 'visitorPrint'])->name('print');
        Route::get('/track/{custid}', [OrganizerController::class, 'visitorTrack'])->name('track');
        Route::get('/accept/{id}', [OrganizerController::class, 'visitorAccept'])->name('accept');
        Route::get('/reject/{id}', [OrganizerController::class, 'visitorReject'])->name('reject');
    });

    Route::name('exhibitor.')->prefix('exhibitor')->group(function () {
        Route::get('/', [OrganizerController::class, 'exhibitors'])->name('index');
        Route::get('/create', [OrganizerController::class, 'exhibitorsCreate'])->name('create');
    });

    Route::name('talk.')->prefix('talk')->group(function () {
        Route::get('/', [OrganizerController::class, 'talks'])->name('index');
        Route::get('/create', [OrganizerController::class, 'talksCreate'])->name('create');
    });

    Route::get('/admins', [OrganizerController::class, 'admins'])->name('admins');

    Route::name('visitors.')->prefix('visitors')->group(function () {
        Route::get('/', [OrganizerController::class, 'visitors'])->name('index');
        Route::get('/edit', [OrganizerController::class, 'visitorsEdit'])->name('edit');
    });
});

Route::name('exhibitor.')->prefix('exhibitor')->middleware(['role:exhibitor'], ['auth'])->group(function () {
    Route::name('events.')->prefix('events')->group(function () {
        Route::get('/', [ExhibitorController::class, 'eventsIndex'])->name('index');
        Route::get('/download', [ExhibitorController::class, 'eventsDownload'])->name('download');
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

    Route::get('/talks', [ExhibitorController::class, 'talks'])->name('talks');
    Route::get('/visitors', [ExhibitorController::class, 'visitors'])->name('visitors');
});

require __DIR__.'/auth.php';
