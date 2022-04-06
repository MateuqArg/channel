<?php

use Illuminate\Support\Facades\Route;

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

// Route::group(['name' => 'student.', 'prefix' => 'student', 'middleware' => ['role:student'], ['auth']], function () {
Route::name('student.')->prefix('student')->middleware(['role:student'], ['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('student.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
