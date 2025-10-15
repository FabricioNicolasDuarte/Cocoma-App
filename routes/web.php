<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AIAnalysisController;


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
    Route::resource('projects', ProjectController::class);
    Route::get('/projects/{project}/report', [ProjectController::class, 'generateReport'])->name('projects.report');
    Route::get('/sobre-cocoma', [PageController::class, 'about'])->name('pages.about');
    Route::get('/developers', [PageController::class, 'developers'])->name('pages.developers');
    Route::get('/compare', [PageController::class, 'compare'])->name('pages.compare');
    Route::get('/ia-analyzer', [AIAnalysisController::class, 'index'])->name('ia.analyzer.index');
    Route::post('/ia-analyzer/analyze', [AIAnalysisController::class, 'analyze'])->name('ia.analyzer.analyze');

});



require __DIR__.'/auth.php';

