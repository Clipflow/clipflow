<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('groups', App\Http\Controllers\GroupController::class)
    ->middleware('auth');

Route::get('/groups/{group}/members', [App\Http\Controllers\GroupMembersController::class, 'index'])
    ->name('groups.members')
    ->middleware('auth');

Route::post('/groups/{group}/members', [App\Http\Controllers\GroupMembersController::class, 'store'])
    ->name('groups.members.store')
    ->middleware('auth');

Route::delete('/groups/{group}/members/{groupMember}', [App\Http\Controllers\GroupMembersController::class, 'destroy'])
    ->name('groups.members.destroy')
    ->middleware('auth');

require __DIR__.'/auth.php';
