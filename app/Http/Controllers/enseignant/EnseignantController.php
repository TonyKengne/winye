<?php

namespace App\Http\Controllers\enseignant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Matiere;
use App\Models\CompteUtilisateur;
use App\Models\Utilisateur;
use App\Models\Notification;
use App\Models\Document;
use App\Models\Sujet;
use App\Models\Consultation;
use App\Models\Filliere;
use App\Models\Setting;



class EnseignantController extends Controller
{
        
    public function dashboard()
    {
        // Récupérer l'ID de l'enseignant depuis la session
        $enseignantId = Session::get('compte_utilisateur_id');

        if (!$enseignantId) {
            abort(403); // accès interdit si non connecté
        }

        // Requête de base sur les documents de l'enseignant
        $documentsQuery = Document::where('auteur_id', $enseignantId);

        // STATISTIQUES
        $stats = [
            // Nombre total de documents
            'documents' => (clone $documentsQuery)->count(),

            // Nombre de corrigés proposés
            'corriges' => (clone $documentsQuery)
                ->whereHas('corrige')
                ->count(),

            // Nombre de matières pour lesquelles l'enseignant a des documents
            'matieres' => Matiere::whereHas('documents', function ($q) use ($enseignantId) {
                $q->where('auteur_id', $enseignantId);
            })->count(),

            // Nombre total de vues sur tous les documents
            'vues' => (clone $documentsQuery)->sum('nb_vues'),
        ];

        // DOCUMENTS RECENTS (avec relations correctes)
        $recentDocuments = $documentsQuery->with([
                'sujet.matiere',   // récupérer la matière du sujet
                'sujet.filieres',  // récupérer les filières du sujet
                'corrige'          // récupérer le corrigé si existant
            ])
            ->latest()
            ->take(5)
            ->get();

        // Retourne la vue avec les stats et les documents récents
        return view('enseignant.dashboard', compact('stats', 'recentDocuments'));
    }



    public function showDocument($id)
    {
        $compte = Auth::user();
        
        // Vérifier que le document appartient bien à l'enseignant
        $document = Document::with(['sujet.matiere', 'sujet.filiere'])
            ->where('enseignant_id', $compte->id)
            ->findOrFail($id);

        // Mapper les relations pour la vue
        $document->matiere = $document->sujet ? $document->sujet->matiere : null;
        $document->filiere = $document->sujet ? $document->sujet->filiere : null;
        $document->vues = $document->consultation;

        return view('enseignant.document_show', compact('document'));
    }

    public function upload()
    {
        $matieres = Matiere::all();
        $filieres = \App\Models\FilLiere::all();
        $sujets = Sujet::all();
        
        return view('enseignant.upload', compact('matieres', 'filieres', 'sujets'));
    }

    public function statistiques()
{
    try {
        $enseignantId = Session::get('compte_utilisateur_id');

        if (!$enseignantId) {
            abort(403);
        }

        // =========================
        // STATISTIQUES GENERALES
        // =========================

        $documentsQuery = Document::where('auteur_id', $enseignantId);

        $totalDocuments      = (clone $documentsQuery)->count();
        $documentsValides    = (clone $documentsQuery)->where('valide', 1)->count();
        $documentsEnAttente  = (clone $documentsQuery)->where('valide', 0)->count();

        // Si tu n’utilises plus -1 pour rejeté, on met 0
        $documentsRejetes = 0;

        $totalMatieres = Matiere::whereHas('documents', function ($q) use ($enseignantId) {
            $q->where('auteur_id', $enseignantId);
        })->count();

        // =========================
        // TENDANCE MENSUELLE
        // =========================

        $now = now();

        $documentsThisMonth = Document::where('auteur_id', $enseignantId)
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $lastMonthDate = $now->copy()->subMonth();

        $documentsLastMonth = Document::where('auteur_id', $enseignantId)
            ->whereMonth('created_at', $lastMonthDate->month)
            ->whereYear('created_at', $lastMonthDate->year)
            ->count();

        $documentsTrend = $documentsLastMonth > 0
            ? round((($documentsThisMonth - $documentsLastMonth) / $documentsLastMonth) * 100)
            : 0;

        // =========================
        // TOP MATIERES
        // =========================

        $topMatieres = Matiere::withCount([
                'documents as documents_count' => function ($q) use ($enseignantId) {
                    $q->where('auteur_id', $enseignantId);
                }
            ])
            ->having('documents_count', '>', 0)
            ->orderByDesc('documents_count')
            ->take(5)
            ->get();

        $maxDocuments = $topMatieres->max('documents_count') ?? 1;

        // =========================
        // DOCUMENTS PAR MOIS (6 derniers)
        // =========================

        $monthLabels = [];
        $monthData   = [];

        for ($i = 5; $i >= 0; $i--) {

            $date = now()->subMonths($i);

            $monthLabels[] = $date->locale('fr')->isoFormat('MMM YYYY');

            $count = Document::where('auteur_id', $enseignantId)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();

            $monthData[] = $count;
        }

        // =========================
        // ACTIVITES RECENTES
        // =========================

        $recentActivities = Document::with([
                'sujet.matiere',
                'sujet.filieres'
            ])
            ->where('auteur_id', $enseignantId)
            ->latest('created_at')
            ->take(10)
            ->get()
            ->map(function ($doc) {

                // Type pour icône timeline
                $doc->type = $doc->valide == 1 ? 'validate' : 'upload';

                // Titre = titre du sujet ou nom du fichier
                $doc->titre = $doc->sujet->titre ?? $doc->nom;

                // Matière
                $doc->matiere = $doc->sujet->matiere ?? null;

                // 1ère filière seulement
                $doc->filiere = $doc->sujet->filieres->first() ?? null;

                return $doc;
            });

        return view('enseignant.statistiques', compact(
            'totalDocuments',
            'documentsValides',
            'documentsEnAttente',
            'documentsRejetes',
            'totalMatieres',
            'documentsTrend',
            'topMatieres',
            'maxDocuments',
            'monthLabels',
            'monthData',
            'recentActivities'
        ));

    } catch (\Exception $e) {

        \Log::error('Erreur statistiques enseignant : ' . $e->getMessage());

        return redirect()
            ->route('enseignant.dashboard')
            ->with('error', 'Impossible de charger les statistiques.');
    }
}

    public function parametres()
{
    $compte = CompteUtilisateur::with('utilisateur')
        ->findOrFail(session('compte_utilisateur_id'));

    $utilisateur = $compte->utilisateur;

    return view('enseignant.parametres', compact('compte', 'utilisateur'));
}



    public function updateProfile(Request $request)
{
    if (!session()->has('compte_utilisateur_id')) {
        return redirect()->route('login')
            ->with('error', 'Session expirée.');
    }

    $compteId = session('compte_utilisateur_id');

    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:compte_utilisateurs,email,' . $compteId,
        'telephone' => 'nullable|string|max:20',
    ]);

    $compte = CompteUtilisateur::findOrFail($compteId);

    $utilisateur = Utilisateur::where(
        'compte_utilisateur_id',
        $compteId
    )->firstOrFail();

    // Mise à jour email
    $compte->update([
        'email' => $request->email
    ]);

    // Mise à jour infos personnelles
    $utilisateur->update([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'telephone' => $request->telephone
    ]);

    // Mise à jour session si nécessaire
    Session::put('nom_utilisateur', $request->nom);
    Session::put('prenom_utilisateur', $request->prenom);

    return back()->with('success', 'Profil mis à jour avec succès !');
}
 public function updatePhoto(Request $request)
{
    if (!session()->has('compte_utilisateur_id')) {
        return redirect()->route('login');
    }

    $request->validate([
        'photo' => 'required|image|max:2048'
    ]);

    $compteId = session('compte_utilisateur_id');

    $utilisateur = Utilisateur::where(
        'compte_utilisateur_id',
        $compteId
    )->firstOrFail();

    // Supprimer ancienne photo
    if ($utilisateur->photo_profil && 
        Storage::disk('public')->exists($utilisateur->photo_profil)) {

        Storage::disk('public')->delete($utilisateur->photo_profil);
    }

    $path = $request->file('photo')->store('profiles', 'public');

    $utilisateur->update([
        'photo_profil' => $path
    ]);

    Session::put('photo_profil', $path);

    return back()->with('success', 'Photo mise à jour avec succès !');
}
public function updatePassword(Request $request)
{
    if (!session()->has('compte_utilisateur_id')) {
        return redirect()->route('login');
    }

    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    $compte = CompteUtilisateur::findOrFail(
        session('compte_utilisateur_id')
    );

    if (!Hash::check($request->current_password, $compte->password)) {
        return back()->with('error', 'Mot de passe actuel incorrect.');
    }

    $compte->update([
        'password' => Hash::make($request->new_password)
    ]);

    // Optionnel : forcer reconnexion
    Session::flush();

    return redirect()->route('login')
        ->with('success', 'Mot de passe modifié. Veuillez vous reconnecter.');
}
public function updateSettings(Request $request)
{
    if (!session()->has('compte_utilisateur_id')) {
        return redirect()->route('login');
    }

    $request->validate([
        'language' => 'required|in:fr,en',
        'theme' => 'required|in:light,dark',
    ]);

    $compteId = session('compte_utilisateur_id');

    Setting::updateOrCreate(
        [
            'compte_utilisateur_id' => $compteId,
            'key' => 'language'
        ],
        [
            'value' => $request->language
        ]
    );

    Setting::updateOrCreate(
        [
            'compte_utilisateur_id' => $compteId,
            'key' => 'theme'
        ],
        [
            'value' => $request->theme
        ]
    );

    return back()->with('success', 'Préférences mises à jour !');
}

}