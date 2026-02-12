<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Sujet;
use App\Models\Matiere;
use App\Models\Campus;
use App\Models\Cursus;
use App\Models\Departement;
use App\Models\Filiere;
use App\Models\Notification;
use App\Models\CompteUtilisateur;
use App\Models\AuditSujet;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SujetController extends Controller
{
    /* =========================
       INDEX – SUJETS DE L'ENSEIGNANT
    ========================= */
    public function index(Request $request)
{
    $enseignantId = session('compte_utilisateur_id');

    $query = Sujet::with([
        'matiere',
        'matiere.filieres',
        'corrige'
    ])
    ->whereHas('audits', function ($q) use ($enseignantId) {
        $q->where('auteur_id', $enseignantId);
    });

    // ========================
    // FILTRES
    // ========================

    if ($request->filled('matiere')) {
        $query->where('matiere_id', $request->matiere);
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('annee_academique')) {
        $query->where('annee_academique', $request->annee_academique);
    }

    if ($request->filled('semestre')) {
        $query->where('semestre', $request->semestre);
    }

    $sujets = $query->orderBy('created_at', 'desc')->get();

    // ========================
    // DONNÉES POUR FILTRES
    // ========================

    $campuses     = Campus::orderBy('nom')->get();
    $cursuses     = Cursus::orderBy('nom')->get();
    $departements = Departement::orderBy('nom')->get();
    $filieres     = Filiere::orderBy('nom')->get();
    $matieres     = Matiere::with('filieres')->orderBy('nom')->get();

    $anneesAcademiques = $this->getAnneesAcademiques();

    return view('enseignant.sujet.index', compact(
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
       CREATE
    ========================= */
    public function create()
    {
        $anneesAcademiques = $this->getAnneesAcademiques();

        return view('enseignant.sujet.create', [
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
        $anneeCourante = now()->year;

        for ($i = $debut; $i <= $finMax; $i++) {
            if (($i + 1) <= $anneeCourante) {
                $annees[] = $i . '-' . ($i + 1);
            }
        }

        return $annees;
    }

    /* =========================
       STORE
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

        DB::beginTransaction();

        try {

            $path = $request->file('fichier')->store('sujets', 'public');
            $sujet = Sujet::create([
                'matiere_id'       => $request->matiere_id,
                'titre'            => $request->titre,
                'type'             => $request->type,
                'annee_academique' => $request->annee_academique,
                'semestre'         => $request->semestre,
                'fichier'          => $path,
                'statut'           => 'en_attente',
            ]);

            Document::create([
                'sujet_id' => $sujet->id,
                'auteur_id' => session('compte_utilisateur_id'),
                'nom'      => $request->file('fichier')->getClientOriginalName(),
                'fichier'  => $path,
                'type'     => 'sujet'
            ]);

            AuditSujet::create([
                'sujet_id'  => $sujet->id,
                'auteur_id' => session('compte_utilisateur_id'),
                'statut'    => 'en_attente',
            ]);

            // Notification aux admins
            $admins = CompteUtilisateur::whereIn('role_id', [3, 4])->get();

            foreach ($admins as $admin) {
                Notification::create([
                    'compte_utilisateur_id' => $admin->id,
                    'titre' => "Nouveau sujet soumis",
                    'message' => "L'enseignant a soumis le sujet '{$sujet->titre}' pour validation.",
                    'type' => 'info',
                    'role_id' => $admin->role_id,
                    'is_lu' => false,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('enseignant.sujet.index')
                ->with('success', 'Sujet soumis avec succès et en attente de validation.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Erreur lors de l’enregistrement.');
        }
    }

    /* =========================
       SHOW
    ========================= */
    public function show(Sujet $sujet)
    {
        return view('enseignant.sujet.show', compact('sujet'));
    }

    /* =========================
       DESTROY
    ========================= */
    public function destroy(Sujet $sujet)
    {
        $enseignantId = session('compte_utilisateur_id');

        // sécurité : l'enseignant ne peut supprimer que ses sujets
        $isAuteur = $sujet->audits()
            ->where('auteur_id', $enseignantId)
            ->exists();

        if (!$isAuteur) {
            return back()->with('error', 'Action non autorisée.');
        }

        if ($sujet->fichier && Storage::disk('public')->exists($sujet->fichier)) {
            Storage::disk('public')->delete($sujet->fichier);
        }

        $sujet->audits()->delete();
        $sujet->delete();

        return redirect()
            ->route('enseignant.sujet.index')
            ->with('success', 'Sujet supprimé avec succès.');
    }
}
