<?php

namespace App\Http\Controllers\Etudiant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sujet;
use App\Models\Corrige;
use App\Models\Favori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Notification;

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

// INDEX NOTIFICATIONS

public function notificationsIndex()
{
    $utilisateurId = session('compte_utilisateur_id');

    $notifications = Notification::where('compte_utilisateur_id', $utilisateurId)
        ->latest()
        ->get();

    return view('etudiant.notifications.index', compact('notifications'));
}


// MARQUER COMME LU

public function markAsRead(Notification $notification)
{
    $utilisateurId = session('compte_utilisateur_id');

    if ($notification->utilisateur_id == $utilisateurId) {
        $notification->update([
            'is_lu' => true
        ]);
    }

    return back()->with('success', 'Notification marquée comme lue.');
}


// FORMULAIRE CONTACT ADMIN

public function createNotification()
{
    return view('etudiant.notifications.create');
}


// ENVOYER MESSAGE ADMIN

public function storeNotification(Request $request)
{
    $request->validate([
        'titre' => 'required',
        'message' => 'required'
    ]);

    Notification::create([
        'utilisateur_id' => session('compte_utilisateur_id'),
        'titre' => $request->titre,
        'message' => $request->message,
        'is_lu' => false,
        'type' => 'info' // si tu as un champ type
    ]);

    return redirect()->route('etudiant.notifications.index')
        ->with('success', 'Message envoyé à l’administrateur.');
}

public function favorisIndex()
{
    $userId = session('compte_utilisateur_id'); // ton id en session

    $sujets = Sujet::join('favoris', function ($join) {
            $join->on('favoris.favorisable_id', '=', 'sujets.id')
                 ->where('favoris.favorisable_type', '=', \App\Models\Sujet::class);
        })
        ->where('favoris.utilisateur_id', $userId)
        ->with(['matiere', 'corrige'])
        ->orderByDesc('favoris.created_at')
        ->select('sujets.*')
        ->get();

    return view('etudiant.favoris.index', compact('sujets'));
}



public function toggleFavori(Request $request)
{
    $userId = session('compte_utilisateur_id');
    $sujetId = $request->sujet_id;

    $exists = \DB::table('favoris')
        ->where('compte_utilisateur_id', $userId)
        ->where('sujet_id', $sujetId)
        ->exists();

    if ($exists) {
        \DB::table('favoris')
            ->where('compte_utilisateur_id', $userId)
            ->where('sujet_id', $sujetId)
            ->delete();

        return response()->json(['removed' => true]);
    }

    return response()->json(['removed' => false]);
}




}
