<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sujet;
use App\Models\User;
use App\Models\AuditSujet;
use App\Models\Notification;
use Illuminate\Http\Request;

class SujetValidationController extends Controller
{
    // Liste des sujets avec leur statut et auteur
    public function index()
    {
        $sujets = Sujet::with(['matiere', 'audits.auteur', 'audits.valideur'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.sujet.validation', compact('sujets'));
    }

    // Changer le statut d'un sujet et enregistrer dans l'audit
   public function updateStatut(Request $request, $id)
{
    $request->validate([
        'statut' => 'required|in:valide,refuse',
        'message' => 'nullable|string|max:255',
    ]);

    // Récupérer le sujet
    $sujet = Sujet::findOrFail($id);

    // Créer ou mettre à jour l'entrée d'audit
    $audit = AuditSujet::updateOrCreate(
        ['sujet_id' => $sujet->id],
        [
            'valideur_id' => session('compte_utilisateur_id'), // ID du compte connecté
            'statut'      => $request->statut,
            'message'     => $request->message ?? null,
        ]
    );

    // Mettre à jour le statut principal du sujet
    $sujet->statut = $request->statut;
    $sujet->save();

    // Récupérer l'auteur via l'audit
    $auteur = $sujet->audits()->first()?->auteur_id; // Relation AuditSujet->auteur
    if ($auteur) {
        $notificationMessage = $request->statut === 'valide'
            ? "Votre sujet '{$sujet->titre}' a été validé."
            : "Votre sujet '{$sujet->titre}' a été refusé.";

        // Créer la notification pour **une seule personne** (l'auteur)
        Notification::create([
            'compte_utilisateur_id' => $auteur, // l'auteur
            'titre' => "Statut du sujet modifié",
            'message' => $notificationMessage,
            'type' => 'info',
            'is_lu' => false,
            'date_lecture' => null,
        ]);
    }

    return redirect()->back()->with('success', "Le sujet a été {$request->statut} et l'auteur a été notifié.");
}

}
