<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizerController;
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

Route::get('/events/{custid}', [MainController::class, 'eventsInscription'])->name('inscription');
Route::get('/events/{custid}/store', [MainController::class, 'inscriptionStore'])->name('store.inscription');

// Route::group(['name' => 'student.', 'prefix' => 'student', 'middleware' => ['role:student'], ['auth']], function () {
Route::name('organizer.')->prefix('organizer')->middleware(['role:organizer'], ['auth'])->group(function () {
    Route::name('events.')->prefix('events')->group(function () {
        Route::get('/', [OrganizerController::class, 'eventsIndex'])->name('index');
        Route::get('/{id}', [OrganizerController::class, 'eventsShow'])->name('show');
        Route::post('/create', [OrganizerController::class, 'eventsCreate'])->name('create');
    });

    Route::get('/exhibitors', [OrganizerController::class, 'exhibitors'])->name('exhibitors');
    Route::get('/talks', [OrganizerController::class, 'talks'])->name('talks');
    Route::get('/admins', [OrganizerController::class, 'admins'])->name('admins');
    Route::get('/visitors', [OrganizerController::class, 'visitors'])->name('visitors');
});

require __DIR__.'/auth.php';
