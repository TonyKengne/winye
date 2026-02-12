<?php

namespace App\Http\Controllers\Etudiant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sujet;
use App\Models\Corrige;
use App\Models\Favori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EtudiantController extends Controller
{
    // Voir un sujet
    public function voirSujet(Sujet $sujet)
    {
        $sujet->load('matiere', 'corrige');
        return view('etudiant.sujets.show', compact('sujet'));
    }

    // Voir un corrigé
    public function voirCorrige(Corrige $corrige)
    {
        return view('etudiant.corriges.show', compact('corrige'));
    }

    // Ajouter un favori
 public function ajouterFavori(Sujet $sujet)
{
    // Récupère l'ID de l'utilisateur connecté depuis la session
    $userId = session('compte_utilisateur_id');

    // Vérifie si le sujet est déjà dans les favoris de l'utilisateur
    $favoriExistant = Favori::where([
        'favorisable_id'   => $sujet->id,
        'favorisable_type' => Sujet::class,
        'utilisateur_id'   => $userId,
    ])->first();

    if (!$favoriExistant) {
        // Crée le favori seulement s'il n'existe pas
        Favori::create([
            'favorisable_id'   => $sujet->id,
            'favorisable_type' => Sujet::class,
            'utilisateur_id'   => $userId,
        ]);

        // Message flash
        session()->flash('success', 'Sujet ajouté aux favoris !');
    } else {
        session()->flash('info', 'Ce sujet est déjà dans vos favoris.');
    }

    return back();
}


}
