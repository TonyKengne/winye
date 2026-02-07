<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sujet;
use App\Models\Matiere;
use App\Models\Campus;
use App\Models\Cursus;
use App\Models\Departement;
use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\CompteUtilisateur;
use App\Models\AuditSujet;
use Illuminate\Support\Facades\Storage;


class SujetController extends Controller
{
    /* =========================
       INDEX – LISTE + FILTRES
    ========================= */
   public function index(Request $request)
{
    $query = Sujet::with([
        'matiere',
        'matiere.filieres',
        'matiere.filieres.departement',
        'matiere.filieres.departement.cursus',
        'matiere.filieres.departement.cursus.campus'
    ]);

    if ($request->filled('campus')) {
        $query->whereHas('matiere.filieres.departement.cursus', function ($q) use ($request) {
            $q->where('campus_id', $request->campus);
        });
    }

    if ($request->filled('cursus')) {
        $query->whereHas('matiere.filieres.departement', function ($q) use ($request) {
            $q->where('cursus_id', $request->cursus);
        });
    }

    if ($request->filled('departement')) {
        $query->whereHas('matiere.filieres', function ($q) use ($request) {
            $q->where('departement_id', $request->departement);
        });
    }

    if ($request->filled('filiere')) {
        $query->whereHas('matiere.filieres', function ($q) use ($request) {
            $q->where('filieres.id', $request->filiere);
        });
    }

    if ($request->filled('semestre')) {
        $query->whereHas('matiere', function ($q) use ($request) {
            $q->where('semestre', $request->semestre);
        });
    }

    if ($request->filled('matiere')) {
        $query->where('matiere_id', $request->matiere);
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('annee_academique')) {
        $query->where('annee_academique', $request->annee_academique);
    }

    $sujets = $query->latest()->get();
    $sujets = Sujet::with(['matiere', 'corrige']) ->orderBy('created_at', 'desc')->get();

    $campuses      = Campus::orderBy('nom')->get();
    $cursuses      = Cursus::orderBy('nom')->get();
    $departements  = Departement::orderBy('nom')->get();
    $filieres      = Filiere::orderBy('nom')->get();
    $matieres      = Matiere::orderBy('nom')->get();

    $anneesAcademiques = $this->getAnneesAcademiques();

    return view('admin.sujet.index', compact(
        'sujets',
        'campuses',
        'cursuses',
        'departements',
        'filieres',
        'matieres',
        'anneesAcademiques'
    ));
}



    /* =========================
       CREATE – FORMULAIRE
    ========================= */
    
    public function create()
{
    $matieres = Matiere::orderBy('nom')->get();
    $anneesAcademiques = $this->getAnneesAcademiques();

    return view('admin.sujet.create', [
    'campuses'          => Campus::all(),
    'cursuses'          => Cursus::all(),
    'departements'      => Departement::all(),
    'filieres'          => Filiere::all(),
    'matieres'          => Matiere::with('filieres')->get(),
    'anneesAcademiques' => $anneesAcademiques
]);

}
private function getAnneesAcademiques()
{
    $annees = [];
    $debut = 2021;
    $finMax = 2040;
    $anneeCourante = now()->year; // ex: 2026

    for ($i = $debut; $i <= $finMax; $i++) {
        // ex : 2025-2026
        if (($i + 1) <= $anneeCourante) {
            $annees[] = $i . '-' . ($i + 1);
        }
    }

    return $annees;
}



    /* =========================
       STORE – ENREGISTREMENT
    ========================= */
 public function store(Request $request)
{
    $request->validate([
        'matiere_id'        => 'required|exists:matieres,id',
        'titre'             => 'required|string|max:255',
        'type'              => 'required|in:CC,TD_TP,EXAMEN,RATTRAPAGE',
        'annee_academique'  => 'required|string|max:9',
        'semestre'          => 'required|in:1,2',
        'fichier'           => 'required|file|mimes:pdf|max:5120',
    ]);

    // Upload du fichier
    $path = $request->file('fichier')->store('sujets', 'public');

    // Créer le sujet
    $sujet = Sujet::create([
        'matiere_id'       => $request->matiere_id,
        'titre'            => $request->titre,
        'type'             => $request->type,
        'annee_academique' => $request->annee_academique,
        'semestre'         => $request->semestre,
        'fichier'          => $path,
        'statut'           => 'en_attente',
    ]);

    // Créer l'audit pour suivre l'auteur
    AuditSujet::create([
        'sujet_id'   => $sujet->id,
        'auteur_id'  => session('compte_utilisateur_id'), // ID du compte connecté
        'statut'     => 'en_attente',
    ]);

    // Envoyer une notification aux utilisateurs avec role_id 3 et 4
    $admins = CompteUtilisateur::whereIn('role_id', [3, 4])->get();

    foreach ($admins as $admin) {
        Notification::create([
            'compte_utilisateur_id' => $admin->id,
            'titre' => "Nouveau sujet ajouté",
            'message' => "Un nouveau sujet '{$sujet->titre}' a été soumis et est en attente de validation.",
            'type' => 'info',
            'role_id' => $admin->role_id,
            'is_lu' => false,
        ]);
    }

    return redirect()
        ->route('admin.sujet.index')
        ->with('success', 'Sujet ajouté avec succès et les secrétaires & admins ont été notifiés.');
}



    /* =========================
       SHOW – (OPTIONNEL)
    ========================= */
    public function show(Sujet $sujet)
    {
        return view('admin.sujet.show', compact('sujet'));
    }

    /* =========================
       DELETE
    ========================= */
    public function destroy(Sujet $sujet)
{
    // Supprimer le fichier du sujet
    if ($sujet->fichier && Storage::disk('public')->exists($sujet->fichier)) {
        Storage::disk('public')->delete($sujet->fichier);
    }

    // Supprimer tous les audits liés au sujet
    $sujet->audits()->delete();

    // Supprimer le sujet
    $sujet->delete();

    return redirect()
        ->route('admin.sujet.index')
        ->with('success', 'Sujet et toutes ses données liées ont été supprimés avec succès.');
}

}
