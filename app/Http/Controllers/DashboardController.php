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
    $utilisateur = Utilisateur::with('filiere')->find(Session::get('compte_utilisateur_id'));

    if (!$utilisateur) {
        return redirect()->route('login');
    }

    $needsFiliere = is_null($utilisateur->filiere_id);

    if ($needsFiliere) {
        return view('etudiant.dashboard', compact('needsFiliere'));
    }

    // Charger les matières de la filière avec leurs sujets et le corrigé associé valide et public
    $matieres = $utilisateur->filiere
        ->matieres()
        ->with(['sujets' => function ($query) {
            $query->where('statut', 'valide')
                  ->with(['corrige' => function ($q) {
                      $q->where('statut', 'valide')
                        ->where('is_public', true);
                  }]);
        }])
        ->get();

    return view('etudiant.dashboard', compact('utilisateur', 'needsFiliere', 'matieres'));
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
