<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\CompteUtilisateur;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    /**
     * Liste des notifications de l'utilisateur connecté
     */
    public function index()
    {
        $compteId = Session::get('compte_utilisateur_id');

        $notifications = Notification::where(function ($q) use ($compteId) {
                $q->where('compte_utilisateur_id', $compteId)
                  ->orWhere('role_id', Session::get('role_id'));
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications.index', compact('notifications'));
    }
    

    /**
     * Envoi d'une notification (admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'message' => 'required|string',
            'role_id' => 'nullable|integer',
            'compte_utilisateur_id' => 'nullable|integer',
        ]);

        Notification::create([
            'titre' => $request->titre,
            'message' => $request->message,
            'type' => 'info',
            'role_id' => $request->role_id,
            'compte_utilisateur_id' => $request->compte_utilisateur_id,
            'is_lu' => false,
        ]);

        return back()->with('success', 'Notification envoyée avec succès.');
    }
        public function contactAdmin()
    {
        return view('notifications.contact-admin');
    }


    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->update([
            'is_lu' => true,
            'date_lecture' => now(),
        ]);

        return back();
    }

     /**
     * Interface admin : voir & envoyer des notifications
     */
   public function adminIndex()
    {
        // Récupérer toutes les notifications destinées à l’admin
        $notifications = Notification::where('destinataire_role_id', 4)
            ->orderBy('date_envoi', 'desc')
            ->get();

        // Récupérer les documents en attente et validés
        $documentsEnAttente = Document::where('valide', 0)->get();
        $documentsValides   = Document::where('valide', 1)->get();

        return view('notifications.index', compact('notifications', 'documentsEnAttente', 'documentsValides'));
    }


    /**
     * Envoi d'une notification (ADMIN)
     */
    public function send(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'message' => 'required|string',
            'cible' => 'required|in:role,utilisateur',
            'role_id' => 'nullable|required_if:cible,role',
            'compte_utilisateur_id' => 'nullable|required_if:cible,utilisateur',
        ]);

        Notification::create([
            'titre' => $request->titre,
            'message' => $request->message,
            'type' => 'info',
            'role_id' => $request->cible === 'role' ? $request->role_id : null,
            'compte_utilisateur_id' => $request->cible === 'utilisateur'
                ? $request->compte_utilisateur_id
                : null,
            'is_lu' => false,
        ]);

        return back()->with('success', 'Notification envoyée avec succès.');
    }
}
