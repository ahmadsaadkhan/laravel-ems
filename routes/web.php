<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('user.login');
})->name('event.login');
Route::get('/events/{slug}', [App\Http\Controllers\UserEventController::class, 'ValidateEvent'])->name('user.validate-event');
Route::post('/event-login', [App\Http\Controllers\UserEventController::class, 'login'])->name('user.login');
Route::get('/backup-streams/{slug}', [App\Http\Controllers\UserEventController::class, 'BackUpStreams'])->name('backup.streams');

Route::get('/admin', function () {
    return view('auth.login');
});
Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
  ]);

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/events', [App\Http\Controllers\EventController::class, 'index'])->name('admin.events');
    Route::get('/event', [App\Http\Controllers\EventController::class, 'create'])->name('event.create');
    Route::post('/event', [App\Http\Controllers\EventController::class, 'store'])->name('event.store');
    Route::get('/event/{id}', [App\Http\Controllers\EventController::class, 'edit'])->name('event.edit');
    Route::delete('/event-delete/{id}', [App\Http\Controllers\EventController::class, 'destroy'])->name('event.delete');
    Route::get('/user-list', [App\Http\Controllers\EventController::class, 'userList'])->name('admin.userlist');
    Route::get('/event-user-list/{id}', [App\Http\Controllers\EventController::class, 'EventUserList'])->name('event.userlist');
    Route::get('/user-list-export', [App\Http\Controllers\EventController::class, 'userListExport'])->name('userlist.export');
    Route::get('/event-user-list-export/{id}', [App\Http\Controllers\EventController::class, 'EventUserListExport'])->name('event.userlist.export');
    Route::post('/add-logo', [App\Http\Controllers\EventController::class, 'saveLogo'])->name('add.logo');
});
