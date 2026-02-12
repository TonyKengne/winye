<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Cursus;
use App\Models\Departement;
use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\Corrige;
use App\Models\Sujet;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CorrigeController extends Controller
{
    /**
     * Formulaire d'ajout d'un corrigé
     */
    public function create()
    {
        $enseignantId = session('compte_utilisateur_id');

        // Données pour filtres
        $campuses = Campus::orderBy('nom')->get();
        $cursuses = Cursus::select('id', 'nom', 'campus_id')->orderBy('nom')->get();
        $departements = Departement::select('id', 'nom', 'cursus_id')->orderBy('nom')->get();
        $filieres = Filiere::select('id', 'nom', 'departement_id')->orderBy('nom')->get();
        $matieres = Matiere::with('filieres:id')->select('id', 'nom')->orderBy('nom')->get();

        // Sujets VALIDÉS et appartenant à l'enseignant
        $sujets = Sujet::with('matiere:id,nom')
            ->whereHas('audits', function ($q) use ($enseignantId) {
                $q->where('auteur_id', $enseignantId);
            })
            ->where('statut', 'valide')
            ->select('id', 'matiere_id', 'titre', 'semestre', 'annee_academique')
            ->orderBy('annee_academique', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('enseignant.corrige.create', compact(
            'campuses',
            'cursuses',
            'departements',
            'filieres',
            'matieres',
            'sujets'
        ));
    }

    /**
     * Stockage du corrigé
     */
    public function store(Request $request)
    {
        $request->validate([
            'sujet_id' => 'required|exists:sujets,id',
            'fichier'  => 'required|file|mimes:pdf|max:5120', // max 5 Mo
        ]);

        // Vérifie qu'un corrigé n'existe pas déjà pour ce sujet
        if (Corrige::where('sujet_id', $request->sujet_id)->exists()) {
            return back()->withErrors([
                'sujet_id' => 'Ce sujet possède déjà un corrigé.'
            ])->withInput();
        }

        DB::beginTransaction();
        try {
            // Stockage du fichier
            $path = $request->file('fichier')->store('corriges', 'public');

            // Création du corrigé
            $corrige = Corrige::create([
                'sujet_id'  => $request->sujet_id,
                'titre'     => 'Corrigé - ' . now()->format('Y'),
                'fichier'   => $path,
                'statut'    => 'en_attente',
                'is_public' => false,
            ]);

            // Création du document associé
            Document::create([
                'corrige_id' => $corrige->id,
                'auteur_id' => session('compte_utilisateur_id'),
                'nom'        => $request->file('fichier')->getClientOriginalName(),
                'fichier'    => $path,
                'type'       => 'corrige'
            ]);

            DB::commit();

            return redirect()
                ->route('enseignant.sujet.index')
                ->with('success', 'Corrigé ajouté avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l’ajout du corrigé : ' . $e->getMessage());
        }
    }

    /**
     * Visualisation d'un corrigé
     */
    public function show(Corrige $corrige)
    {
        $enseignantId = session('compte_utilisateur_id');

        // Vérifie que l'enseignant a accès à ce corrigé
        $corrige->load('sujet.matiere');
        if (!$corrige->sujet->audits->where('auteur_id', $enseignantId)->count()) {
            abort(403, 'Accès refusé');
        }

        return view('enseignant.corrige.show', compact('corrige'));
    }
}
