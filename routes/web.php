<?php

use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\BesoinController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliberationController;
use App\Http\Controllers\FichierController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\PaiController;
use App\Http\Controllers\ParametresController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'compte.valide'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/fichiers/{type}/{id}', [FichierController::class, 'voir'])->name('fichiers.voir');

    Route::resource('sessions', SessionController::class);
    Route::post('/sessions/{session}/documents', [SessionController::class, 'ajouterDocument'])->name('sessions.ajouter-document');
    Route::delete('/sessions/{session}/documents/{document}', [SessionController::class, 'supprimerDocument'])->name('sessions.supprimer-document');

    Route::resource('pai', PaiController::class)->parameters(['pai' => 'planPai']);
    Route::resource('budgets', BudgetController::class);
    Route::resource('besoins', BesoinController::class)->parameters(['besoins' => 'besoin']);
    Route::resource('deliberations', DeliberationController::class);

    Route::get('/administration', [AdministrationController::class, 'index'])->name('administration.index');
    Route::post('/administration/documents', [AdministrationController::class, 'storeDocument'])->name('administration.documents.store');
    Route::delete('/administration/documents/{document}', [AdministrationController::class, 'destroyDocument'])->name('administration.documents.destroy');
    Route::post('/administration/membres', [AdministrationController::class, 'storeMembre'])->name('administration.membres.store');
    Route::delete('/administration/membres/{membre}', [AdministrationController::class, 'destroyMembre'])->name('administration.membres.destroy');

    Route::middleware('admin')->group(function () {
        Route::get('/comptes', [CompteController::class, 'index'])->name('comptes.index');
        Route::post('/comptes/{user}/valider', [CompteController::class, 'valider'])->name('comptes.valider');
        Route::post('/comptes/{user}/suspendre', [CompteController::class, 'suspendre'])->name('comptes.suspendre');
        Route::post('/comptes/{user}/reactiver', [CompteController::class, 'reactiver'])->name('comptes.reactiver');
        Route::delete('/comptes/{user}', [CompteController::class, 'destroy'])->name('comptes.destroy');

        Route::resource('users', UserController::class);

        Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
    });

    Route::get('/parametres', [ParametresController::class, 'edit'])->name('parametres.edit');
    Route::patch('/parametres', [ParametresController::class, 'update'])->name('parametres.update');
    Route::post('/parametres/password', [ParametresController::class, 'updatePassword'])->name('parametres.password');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
