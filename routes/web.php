<?php

use App\Http\Controllers\TaskController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/tasks/', [TaskController::class, 'index'])->name('task_index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('task_create');
Route::post('/tasks/store', [TaskController::class, 'store'])->name('task_store');

Route::middleware(['CheckTaskOwner'])->group(function () {
    Route::get('/tasks/edit/{id}', [TaskController::class, 'edit'])->name('task_edit');
    Route::post('/tasks/update/{id}', [TaskController::class, 'update'])->name('task_update');
    Route::get('/tasks/delete/{id}', [TaskController::class, 'destroy'])->name('task_delete');
});
