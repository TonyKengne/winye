<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sujet;
use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\Corrige; // <-- important pour utiliser Corrige::STATUT_VALIDE

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Query de base : sujets validés uniquement + corrigés validés
        $query = Sujet::with([
            'matiere.filieres',
            'matiere.niveau',
            'corriges' => function($q) {
                $q->where('statut', Corrige::STATUT_VALIDE);
            }
        ])->where('statut', 'valide');

        // Filtres dynamiques
        if ($request->filled('annee')) {
            $query->where('annee_academique', $request->annee);
        }

        if ($request->filled('semestre')) {
            $query->where('semestre', $request->semestre);
        }

        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtre par filière (via la table pivot filiere_matiere)
        if ($request->filled('filiere_id')) {
            $query->whereHas('matiere.filieres', function($q) use ($request) {
                $q->where('filieres.id', $request->filiere_id);
            });
        }

        // Tri par date de création (plus récent en premier)
        $query->orderBy('created_at', 'desc');

        // Pagination
        $sujets = $query->paginate(12);

        // Données pour les filtres
        $filieres = Filiere::with('niveau', 'departement')->orderBy('nom')->get();
        $matieres = Matiere::with('niveau')->orderBy('nom')->get();

        // Années disponibles (distinctes)
        $annees_disponibles = Sujet::where('statut', 'valide')
            ->distinct()
            ->pluck('annee_academique')
            ->sort()
            ->values();

        // Statistiques
        $stats = [
            'total_sujets' => Sujet::where('statut', 'valide')->count(),
            'total_filieres' => Filiere::count(),
            'total_matieres' => Matiere::count(),
            'annees_count' => $annees_disponibles->count(),
        ];

        return view('home', compact(
            'sujets',
            'filieres',
            'matieres',
            'annees_disponibles',
            'stats'
        ));
    }
}
