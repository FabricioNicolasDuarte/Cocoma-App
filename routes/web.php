<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PageController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para los proyectos (CRUD)
    Route::resource('projects', ProjectController::class);

    // Ruta para generar el informe PDF de un proyecto específico
    Route::get('/projects/{project}/report', [ProjectController::class, 'generateReport'])->name('projects.report');

    // Rutas para las páginas estáticas
    Route::get('/sobre-cocoma', [PageController::class, 'about'])->name('pages.about');
    Route::get('/developers', [PageController::class, 'developers'])->name('pages.developers');
    Route::get('/compare', [PageController::class, 'compare'])->name('pages.compare');
});



require __DIR__.'/auth.php';

