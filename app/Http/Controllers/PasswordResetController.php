<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompteUtilisateur;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    // Formulaire de récupération
    public function showRecoverForm()
    {
        return view('auth.password_recover');
    }

    // Vérification des informations
    public function verifyUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'matricule' => 'nullable|string',
        ]);

        $query = CompteUtilisateur::where('email', $request->email)
            ->whereHas('utilisateur', function($q) use ($request) {
                $q->where('nom', $request->nom)
                  ->where('prenom', $request->prenom);

                if ($request->filled('matricule')) {
                    $q->where('matricule', $request->matricule);
                }
            });

        $user = $query->first();

        if (!$user) {
            return back()->withErrors(['error' => 'Les informations fournies ne correspondent à aucun utilisateur.']);
        }

        return view('auth.password_reset', compact('user'));
    }

    // Réinitialisation du mot de passe
    public function resetPassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = CompteUtilisateur::findOrFail($request->user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Mot de passe changé avec succès. Vous pouvez vous connecter.');
    }
}
