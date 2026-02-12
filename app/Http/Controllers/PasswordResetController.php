<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompteUtilisateur;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    /**
     * Affiche le formulaire de récupération
     */
    public function showRecoverForm()
    {
        // Vue pour entrer email, nom, prénom, matricule
        return view('auth.password_recover');
    }

    public function showResetForm($id)
    {
        // Vue pour entrer le nouveau mot de passe
        return view('auth.password_reset', ['user_id' => $id]);
    }


    /**
     * Vérifie les informations saisies par l'utilisateur
     */
    public function verify(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'nom'       => 'required|string',
            'prenom'    => 'required|string',
            'matricule' => 'nullable|string',
        ]);
    
        // Chercher le compte par email
        $compte = CompteUtilisateur::where('email', $request->email)->first();
    
        if ($compte && $compte->utilisateur) {
            $utilisateur = $compte->utilisateur;
    
            // Vérifier nom, prénom, matricule
            if (
                $utilisateur->nom === $request->nom &&
                $utilisateur->prenom === $request->prenom &&
                (!$request->matricule || $utilisateur->matricule === $request->matricule)
            ) {
                return redirect()->route('password.reset.form', ['id' => $compte->id])
                    ->with('success', 'Utilisateur trouvé, vous pouvez réinitialiser votre mot de passe.');
            }
        }
    
        return back()->withErrors(['email' => 'Aucun utilisateur correspondant trouvé.']);
    }
    

    /**
     * Réinitialise le mot de passe
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'user_id'  => 'required|integer',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $compte = CompteUtilisateur::findOrFail($request->user_id);
        $compte->password = Hash::make($request->password);
        $compte->save();

        return redirect()->route('login')
            ->with('success', 'Mot de passe changé avec succès. Vous pouvez vous connecter.');
    }
}
