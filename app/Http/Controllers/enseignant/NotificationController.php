<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    /**
     * Liste des notifications de l'enseignant connecté
     */
    public function index(Request $request)
    {
        $compteId = Session::get('compte_utilisateur_id');
        $roleId   = Session::get('role_id');

        if (!$compteId) {
            abort(403, 'Accès refusé.');
        }

        $notifications = Notification::where(function ($q) use ($compteId, $roleId) {
                $q->where('compte_utilisateur_id', $compteId)
                  ->orWhere('role_id', $roleId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('enseignant.notifications.index', compact('notifications'));
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::where('id', $id)
            ->where(function ($q) {
                $q->where('compte_utilisateur_id', Session::get('compte_utilisateur_id'))
                  ->orWhere('role_id', Session::get('role_id'));
            })
            ->firstOrFail();

        $notification->update([
            'is_lu'        => true,
            'date_lecture' => now(),
        ]);

        return back()->with('success', 'Notification marquée comme lue.');
    }

    /**
     * Formulaire d'envoi de message
     */
    public function create(Request $request)
    {
        return view('enseignant.notifications.create');
    }

    /**
     * Enregistrer le message envoyé (Admin ou Secrétaire uniquement)
     */
    public function store(Request $request)
    {
        $compteId = Session::get('compte_utilisateur_id');

        if (!$compteId) {
            abort(403, 'Accès refusé.');
        }

        $request->validate([
            'titre'   => 'required|string|max:255',
            'message' => 'required|string',
            'role_id' => 'required|in:3,4', // 3 = Secrétaire, 4 = Admin
        ]);

        Notification::create([
            'titre'                   => $request->titre,
            'message'                 => $request->message,
            'type'                    => 'info',
            'role_id'                 => $request->role_id,
            'compte_utilisateur_id'   => null,
            'is_lu'                   => false,
        ]);

        return redirect()
            ->route('enseignant.notification')
            ->with('success', 'Message envoyé avec succès.');
    }
}
