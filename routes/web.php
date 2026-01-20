<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\InscriptionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\admin\CampusController;
use App\Http\Controllers\admin\CursusController;

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


//route pour la validation des inscriptions
Route::get('/admin/inscriptions', [InscriptionController::class, 'index'])->name('admin.inscriptions');
Route::post('/admin/inscriptions/{id}/valider', [InscriptionController::class, 'valider'])->name('admin.inscriptions.valider');
Route::post('/inscriptions/{id}/desactiver',[InscriptionController::class, 'desactiver'])->name('admin.inscriptions.desactiver');
//route pour la gestion des notifications
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::get('/admin/notifications', [NotificationController::class, 'adminIndex'])->name('admin.notifications.index');
Route::post('/admin/notifications/send', [NotificationController::class, 'send'])->name('admin.notifications.send');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
//route pour la gestion des profil utilisateur
Route::put('/profil/informations', [ProfilController::class, 'updateInformations'])->name('profil.update.informations');
Route::put('/profil/complementaires', [ProfilController::class, 'updateComplementaires'])->name('profil.update.complementaires');
Route::put('/profil/mot-de-passe', [ProfilController::class, 'updatePassword'])->name('profil.update.password');
Route::post('/profil/photo', [ProfilController::class, 'updatePhoto'])->name('profil.update.photo');
//routes pour la gestion de l'architecture: campus
Route::get('/campus', [CampusController::class, 'index'])->name('admin.campus.index');
Route::get('/campus/create', [CampusController::class, 'create'])->name('admin.campus.create');
Route::post('/campus', [CampusController::class, 'store'])->name('admin.campus.store');
Route::get('/campus/{campus}/edit', [CampusController::class, 'edit'])->name('admin.campus.edit');
Route::put('/campus/{campus}', [CampusController::class, 'update'])->name('admin.campus.update');
Route::delete('/campus/{campus}', [CampusController::class, 'destroy'])->name('admin.campus.destroy');
// Cursus
Route::get('/cursus', [CursusController::class, 'index'])->name('admin.cursus.index');
Route::get('/cursus/create', [CursusController::class, 'create'])->name('admin.cursus.create');
Route::post('/cursus', [CursusController::class, 'store'])->name('admin.cursus.store');
