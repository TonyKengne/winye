<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Cursus;
use App\Models\Departement;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    /**
     * Dashboard étudiant
     */
    public function utilisateurDashboard()
{
    $utilisateur = Utilisateur::find(Session::get('compte_utilisateur_id'));

    if (!$utilisateur) {
        return redirect()->route('login');
    }

    $needsFiliere = is_null($utilisateur->filiere_id);

    return view('etudiant.dashboard', compact('needsFiliere'));
}


    /**
     * Dashboard enseignant
     */
    public function enseignantDashboard()
    {
        return view('enseignant.dashboard');
    }

    /**
     * Dashboard administrateur / secrétaire
     */
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }
}
