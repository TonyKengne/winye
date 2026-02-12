<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\InscriptionController;
use App\Http\Controllers\admin\DocumentController;   // ✅ import manquant
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\enseignant\EnseignantController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Routes pour la page d'accueil
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// =======================
// 🔹 Authentification
// =======================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// =======================
// 🔹 Dashboards
// =======================
Route::get('/dashboard', [DashboardController::class, 'utilisateurDashboard'])->name('utilisateur.dashboard');
Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

// =======================
// 🔹 Inscriptions (Admin)
// =======================
Route::get('/admin/inscriptions', [InscriptionController::class, 'index'])->name('admin.inscriptions');
Route::post('/admin/inscriptions/{id}/valider', [InscriptionController::class, 'valider'])->name('admin.inscriptions.valider');
Route::post('/admin/inscriptions/{id}/desactiver', [InscriptionController::class, 'desactiver'])->name('admin.inscriptions.desactiver');

// =======================
// 🔹 Notifications
// =======================
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::get('/admin/notifications', [NotificationController::class, 'adminIndex'])->name('admin.notifications.index');
Route::post('/admin/notifications/send', [NotificationController::class, 'send'])->name('admin.notifications.send');
Route::get('/notifications/contact-admin', [NotificationController::class, 'contactAdmin'])->name('notifications.contact.admin');

// =======================
// 🔹 Documents (Admin)
// =======================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/{id}', [DocumentController::class, 'show'])->name('documents.show');
    Route::post('/documents/{id}/valider', [DocumentController::class, 'valider'])->name('documents.valider');
    Route::post('/documents/{id}/rejeter', [DocumentController::class, 'rejeter'])->name('documents.rejeter');
});

// =======================
// 🔹 Profil
// =======================
Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
Route::put('/profil/informations', [ProfilController::class, 'updateInformations'])->name('profil.update.informations');
Route::put('/profil/complementaires', [ProfilController::class, 'updateComplementaires'])->name('profil.update.complementaires');
Route::put('/profil/mot-de-passe', [ProfilController::class, 'updatePassword'])->name('profil.update.password');
Route::post('/profil/photo', [ProfilController::class, 'updatePhoto'])->name('profil.update.photo');

// =======================
// 🔹 Enseignant
// =======================
Route::middleware(['auth'])->prefix('enseignant')->name('enseignant.')->group(function () {
    Route::get('/dashboard', [EnseignantController::class, 'dashboard'])->name('dashboard');
    Route::get('/documents', [EnseignantController::class, 'mesDocuments'])->name('documents');
    Route::get('/upload', [EnseignantController::class, 'upload'])->name('upload');
    Route::post('/upload', [EnseignantController::class, 'storeDocument'])->name('storeDocument');
    Route::get('/documents/{id}', [EnseignantController::class, 'showDocument'])->name('document.show');
    Route::get('/matieres', [EnseignantController::class, 'mesMatieres'])->name('matieres');
    Route::post('/matiere', [EnseignantController::class, 'storeMatieres'])->name('matiere.store');
    Route::put('/matiere/{id}', [EnseignantController::class, 'updateMatieres']) ->name('matiere.update');
    Route::delete('/matiere/{id}', [EnseignantController::class, 'destroyMatieres'])->name('matiere.destroy');
    Route::get('/statistiques', [EnseignantController::class, 'statistiques'])->name('statistiques');
    Route::get('/parametres', [EnseignantController::class, 'parametres'])->name('parametres');

    Route::post('/update-profile', [EnseignantController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-photo', [EnseignantController::class, 'updatePhoto'])->name('updatePhoto');
    Route::post('/update-password', [EnseignantController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/update-settings', [EnseignantController::class, 'updateSettings'])->name('updateSettings');
});
