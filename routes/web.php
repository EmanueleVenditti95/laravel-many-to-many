<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
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
    return view('welcome');
});

 Route::middleware(['auth','verified'])->group(function() {
    Route::get('/admin/projects',[ProjectController::class, 'index'])->name('projects.index');
    Route::get('/admin/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::get('/admin/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::post('/admin/projects',[ProjectController::class, 'store'])->name('projects.store');
    Route::get('/admin/projects/{project}/edit',[ProjectController::class,'edit'])->name('projects.edit');
    Route::put('/admin/projects/{project}',[ProjectController::class,'update'])->name('projects.update');
    Route::delete('/admin/projects/{project}',[ProjectController::class,'destroy'])->name('projects.destroy');
 });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
