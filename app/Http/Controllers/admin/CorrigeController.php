<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Cursus;
use App\Models\Departement;
use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\Corrige;
use App\Models\Sujet;
use Illuminate\Http\Request;

class CorrigeController extends Controller
{

public function create()
{
    //  Campus
    $campuses = Campus::orderBy('nom')->get();

    //  Cursus
    $cursuses = Cursus::select('id', 'nom', 'campus_id')
        ->orderBy('nom')
        ->get();

    // Départements
    $departements = Departement::select('id', 'nom', 'cursus_id')
        ->orderBy('nom')
        ->get();

    //  Filières
    $filieres = Filiere::select('id', 'nom', 'departement_id')
        ->orderBy('nom')
        ->get();

    // Matières (avec filières pour le JS)
    $matieres = Matiere::with('filieres:id')
        ->select('id', 'nom')
        ->orderBy('nom')
        ->get();

    // Sujets VALIDÉS uniquement
    $sujets = Sujet::with('matiere:id,nom')
        ->where('statut', 'valide')
        ->select(
            'id',
            'matiere_id',
            'titre',
            'semestre',
            'annee_academique'
        )
        ->orderBy('annee_academique', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.corrige.create', compact(
        'campuses',
        'cursuses',
        'departements',
        'filieres',
        'matieres',
        'sujets'
    ));
}

public function store(Request $request)
{
    $request->validate([
        'sujet_id' => 'required|exists:sujets,id',
        'fichier'  => 'required|file|mimes:pdf|max:5120',
    ]);

    // éviter plusieurs corrigés pour un même sujet
    if (Corrige::where('sujet_id', $request->sujet_id)->exists()) {
        return back()->withErrors([
            'sujet_id' => 'Ce sujet possède déjà un corrigé.'
        ])->withInput();
    }

    $path = $request->file('fichier')->store('corriges', 'public');

    Corrige::create([
        'sujet_id' => $request->sujet_id,
        'fichier'  => $path,
        'statut'   => 'en_attente',
    ]);

    return redirect()
        ->route('admin.sujet.index')
        ->with('success', 'Corrigé ajouté avec succès.');
}
    /**
     * Affichage du corrigé (PDF)
     */
    public function show(Corrige $corrige)
    {
        $corrige->load('sujet.matiere');

        return view('admin.corrige.show', compact('corrige'));
    }
}
