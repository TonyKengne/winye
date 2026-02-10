<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\InscriptionController;
use App\Http\Controllers\admin\DocumentController;   
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\admin\CampusController;
use App\Http\Controllers\admin\CursusController;
use App\Http\Controllers\admin\DepartementController;
use App\Http\Controllers\admin\FiliereController;
use App\Http\Controllers\Admin\MatiereController;
use App\Http\Controllers\Admin\SujetController;
use App\Http\Controllers\Admin\CorrigeController;
use App\Http\Controllers\Admin\SujetValidationController;
use App\Http\Controllers\Admin\CorrigeValidationController;
use App\Models\Cursus;
use App\Models\Departement;
use App\Http\Controllers\enseignant\EnseignantController;

Route::get('/', function () {
    return view('welcome');
});

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


//route pour la validation des inscriptions
Route::get('/admin/inscriptions', [InscriptionController::class, 'index'])->name('admin.inscriptions');
Route::post('/admin/inscriptions/{id}/valider', [InscriptionController::class, 'valider'])->name('admin.inscriptions.valider');
Route::post('/inscriptions/{id}/desactiver',[InscriptionController::class, 'desactiver'])->name('admin.inscriptions.desactiver');
// =======================
// 🔹 Notifications
// =====================
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
Route::delete('/cursus/{cursus}', [CursusController::class, 'destroy'])->name('admin.cursus.destroy');

// departement
Route::prefix('admin')->name('admin.')->group(function () {
 Route::resource('departement', DepartementController::class)->except(['show']);
Route::get('campus/{campus}/cursus', function ($campusId) {return Cursus::where('campus_id', $campusId)->select('id', 'nom')->orderBy('nom')->get(); });
   });
//filiere

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('filiere', FiliereController::class)->except(['show']);
    // AJAX : récupérer les départements d’un cursus
    Route::get('cursus/{cursus}/departements', function ($cursusId) {
        return Departement::where('cursus_id', $cursusId)->select('id', 'nom')->orderBy('nom')->get(); });

});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('matiere', MatiereController::class)->only(['index', 'create', 'store','destroy']);
});
Route::prefix('admin')->name('admin.')->group(function () {

    Route::resource('sujet', SujetController::class)->only(['index', 'create', 'store', 'destroy', 'show']);
    Route::get('sujets/validation', [SujetValidationController::class, 'index'])->name('sujet.validation');
    Route::post('sujets/{sujet}/statut', [SujetValidationController::class, 'updateStatut'])->name('sujet.statut');
});
Route::get('/admin/corriges/create',[CorrigeController::class, 'create'])->name('admin.corrige.create');
Route::post('/admin/corriges',[CorrigeController::class, 'store'])->name('admin.corrige.store');
Route::get('/admin/corriges/{corrige}', [CorrigeController::class, 'show'])->name('admin.corrige.show');
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('corriges', [CorrigeValidationController::class, 'index'])->name('corrige.index');
    Route::post('corriges/{corrige}/statut', [CorrigeValidationController::class, 'updateStatut'])->name('corrige.updateStatut');
});

  
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

