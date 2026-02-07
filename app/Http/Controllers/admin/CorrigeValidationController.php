<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CorrigeValidationController extends Controller
{
      public function index()
    {
        $sujets = Sujet::whereHas('corrige')->with('corrige')->get();
        return view('admin.corrige.index', compact('sujets'));
    }

    public function updateStatut(Request $request, Corrige $corrige)
    {
        $request->validate([
            'statut'  => 'required|in:valide,refuse',
            'message' => 'nullable|string|max:255',
        ]);

        // Mise à jour corrigé
        $corrige->update([
            'statut'    => $request->statut,
            'is_public' => $request->statut === 'valide',
        ]);

        // Audit
        AuditCorrige::create([
            'corrige_id'  => $corrige->id,
            'valideur_id' => session('compte_utilisateur_id'),
            'statut'      => $request->statut,
            'message'     => $request->message,
        ]);

        // Notification à l’auteur du sujet
        $auteurId = $corrige->sujet->compte_utilisateur_id;

        Notification::create([
            'titre' => 'Validation du corrigé',
            'message' => $request->statut === 'valide'
                ? "Votre corrigé du sujet « {$corrige->sujet->titre} » a été validé."
                : "Votre corrigé du sujet « {$corrige->sujet->titre} » a été refusé.",
            'type' => 'corrige',
            'compte_utilisateur_id' => $auteurId,
            'role_id' => null, // envoi à une seule personne
            'is_lu' => false,
        ]);

        return back()->with('success', 'Statut du corrigé mis à jour.');
    }

}
