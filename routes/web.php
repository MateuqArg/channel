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

Route::prefix('events')->group(function () {
    Route::get('/{custid}', [MainController::class, 'eventsVisitor'])->name('visitor');
    Route::get('/{custid}/store', [MainController::class, 'visitorStore'])->name('store.visitor');
});

// Route::group(['name' => 'student.', 'prefix' => 'student', 'middleware' => ['role:student'], ['auth']], function () {
Route::name('organizer.')->prefix('organizer')->middleware(['role:organizer'], ['auth'])->group(function () {
    Route::name('events.')->prefix('events')->group(function () {
        Route::get('/', [OrganizerController::class, 'eventsIndex'])->name('index');
        Route::get('/{id}', [OrganizerController::class, 'eventsShow'])->name('show');
        Route::post('/create', [OrganizerController::class, 'eventsCreate'])->name('create');
    });

    Route::name('visitor.')->prefix('visitor')->group(function () {
        Route::get('/accept/{id}', [OrganizerController::class, 'visitorAccept'])->name('accept');
        Route::get('/reject/{id}', [OrganizerController::class, 'visitorReject'])->name('reject');
    });

    Route::get('/exhibitors', [OrganizerController::class, 'exhibitors'])->name('exhibitors');
    Route::get('/talks', [OrganizerController::class, 'talks'])->name('talks');
    Route::get('/admins', [OrganizerController::class, 'admins'])->name('admins');
    Route::get('/visitors', [OrganizerController::class, 'visitors'])->name('visitors');
});

Route::name('exhibitor.')->prefix('exhibitor')->middleware(['role:exhibitor'], ['auth'])->group(function () {
    Route::name('events.')->prefix('events')->group(function () {
        Route::get('/', [ExhibitorController::class, 'eventsIndex'])->name('index');
        Route::get('/download', [ExhibitorController::class, 'eventsDownload'])->name('download');
    });
    
    Route::name('invite.')->prefix('invite')->group(function () {
        Route::get('/', [ExhibitorController::class, 'inviteIndex'])->name('index');
        Route::get('/send', [ExhibitorController::class, 'inviteSend'])->name('send');
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
