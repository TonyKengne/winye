<?php

namespace App\Http\Controllers\Etudiant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Cursus;
use App\Models\Departement;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Session;

class InscriptionFiliereController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PAGE PRINCIPALE
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $utilisateur = Utilisateur::find(Session::get('compte_utilisateur_id'));

        if (!$utilisateur) {
            return redirect()->route('login');
        }

        $needsFiliere = is_null($utilisateur->filiere_id);

        // Récupération des sélections en session
        $selectedCampus       = session('selectedCampus');
        $selectedCursus       = session('selectedCursus');
        $selectedDepartement  = session('selectedDepartement');
        $selectedNiveau       = session('selectedNiveau');
        $selectedFiliere      = session('selectedFiliere');

        // Données
        $campuses      = Campus::all();
        $cursusList    = collect();
        $departements  = collect();
        $niveaux       = collect();
        $filieres      = collect();

        if ($selectedCampus) {
            $cursusList = Cursus::where('campus_id', $selectedCampus)->get();
        }

        if ($selectedCursus) {
            $departements = Departement::where('cursus_id', $selectedCursus)->get();
        }

        if ($selectedDepartement) {
            $niveaux = Niveau::all();
        }

        if ($selectedNiveau) {
            $filieres = Filiere::where('niveau_id', $selectedNiveau)
                                ->where('departement_id', $selectedDepartement)
                                ->get();
        }

        // Calcul progression
        $steps = [
            $selectedCampus,
            $selectedCursus,
            $selectedDepartement,
            $selectedNiveau,
            $selectedFiliere
        ];

        $completedSteps = collect($steps)->filter()->count();
        $progress = ($completedSteps / 5) * 100;

        return view('etudiant.onboarding.filiere', compact(
            'needsFiliere',
            'campuses',
            'cursusList',
            'departements',
            'niveaux',
            'filieres',
            'selectedCampus',
            'selectedCursus',
            'selectedDepartement',
            'selectedNiveau',
            'selectedFiliere',
            'progress'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SÉLECTION CAMPUS
    |--------------------------------------------------------------------------
    */
    public function selectCampus($id)
    {
        session([
            'selectedCampus'      => $id,
            'selectedCursus'      => null,
            'selectedDepartement' => null,
            'selectedNiveau'      => null,
            'selectedFiliere'     => null,
        ]);

        return redirect()->route('inscription.filiere');
    }

    /*
    |--------------------------------------------------------------------------
    | SÉLECTION CURSUS
    |--------------------------------------------------------------------------
    */
    public function selectCursus($id)
    {
        session([
            'selectedCursus'      => $id,
            'selectedDepartement' => null,
            'selectedNiveau'      => null,
            'selectedFiliere'     => null,
        ]);

        return redirect()->route('inscription.filiere');
    }

    /*
    |--------------------------------------------------------------------------
    | SÉLECTION DÉPARTEMENT
    |--------------------------------------------------------------------------
    */
    public function selectDepartement($id)
    {
        session([
            'selectedDepartement' => $id,
            'selectedNiveau'      => null,
            'selectedFiliere'     => null,
        ]);

        return redirect()->route('inscription.filiere');
    }

    /*
    |--------------------------------------------------------------------------
    | SÉLECTION NIVEAU
    |--------------------------------------------------------------------------
    */
    public function selectNiveau($id)
    {
        session([
            'selectedNiveau'  => $id,
            'selectedFiliere' => null,
        ]);

        return redirect()->route('inscription.filiere');
    }

    /*
    |--------------------------------------------------------------------------
    | ENREGISTREMENT FINAL
    |--------------------------------------------------------------------------
    */
    public function save(Request $request)
    {
        $request->validate([
            'filiere_id' => 'required|exists:filieres,id'
        ]);

        $utilisateur = Utilisateur::find(Session::get('compte_utilisateur_id'));

        if (!$utilisateur) {
            return redirect()->route('login');
        }

        $utilisateur->filiere_id = $request->filiere_id;
        $utilisateur->save();

        // Nettoyage session
        session()->forget([
            'selectedCampus',
            'selectedCursus',
            'selectedDepartement',
            'selectedNiveau',
            'selectedFiliere'
        ]);

        return redirect()->route('utilisateur.dashboard')
                         ->with('success', 'Filière enregistrée avec succès !');
    }
}
