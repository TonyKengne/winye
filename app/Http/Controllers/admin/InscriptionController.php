<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompteUtilisateur;

class InscriptionController extends Controller
{
    /**
     * Afficher les demandes d'inscription
     */
    public function index()
    {
        // Nouvelles demandes (inactifs)
        $nouvellesDemandes = CompteUtilisateur::with('role')
            ->where('statut', 'inactif')
            ->get();

        // Inscriptions admises (actifs)
        $inscriptionsAdmise = CompteUtilisateur::with('role')
            ->where('statut', 'actif')
            ->get();

        return view('admin.inscriptions.index', compact(
            'nouvellesDemandes',
            'inscriptionsAdmise'
        ));
    }

    /**
     * Valider une inscription
     */
    public function valider($id)
    {
        $compte = CompteUtilisateur::findOrFail($id);

        $compte->statut = 'actif';
        $compte->save();

        return redirect()->back()
            ->with('success', 'Inscription validée avec succès.');
    }

    /**
     * Désactiver une inscription
     */
    public function desactiver(int $id): RedirectResponse
    {
        $compte = CompteUtilisateur::findOrFail($id);

        $compte->update([
            'statut' => 'inactif',
        ]);

        return back()->with(
            'success',
            'Inscription désactivée avec succès.'
        );
    }
}
