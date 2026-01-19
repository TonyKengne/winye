<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\InscriptionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfilController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/dashboard', [DashboardController::class, 'utilisateurDashboard'])->name('utilisateur.dashboard');
Route::get('/enseignant/dashboard', [DashboardController::class, 'enseignantDashboard'])->name('enseignant.dashboard');
Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');


Route::get('/admin/inscriptions', [InscriptionController::class, 'index'])->name('admin.inscriptions');
Route::post('/admin/inscriptions/{id}/valider', [InscriptionController::class, 'valider'])->name('admin.inscriptions.valider');
Route::post('/inscriptions/{id}/desactiver',[InscriptionController::class, 'desactiver'])->name('admin.inscriptions.desactiver');
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::get('/admin/notifications', [NotificationController::class, 'adminIndex'])->name('admin.notifications.index');
Route::post('/admin/notifications/send', [NotificationController::class, 'send'])->name('admin.notifications.send');
Route::get('/profil', [ProfilController::class, 'index'])
    ->name('profil.index');

Route::put('/profil/informations', [ProfilController::class, 'updateInformations'])
    ->name('profil.update.informations');

Route::put('/profil/complementaires', [ProfilController::class, 'updateComplementaires'])
    ->name('profil.update.complementaires');

Route::put('/profil/mot-de-passe', [ProfilController::class, 'updatePassword'])
    ->name('profil.update.password');

Route::post('/profil/photo', [ProfilController::class, 'updatePhoto'])
    ->name('profil.update.photo');
