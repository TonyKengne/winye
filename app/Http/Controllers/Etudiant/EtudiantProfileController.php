<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Utilisateur;

class EtudiantProfileController extends Controller
{
    // Afficher le profil
    public function index()
    {
        $utilisateur = Utilisateur::find(session('compte_utilisateur_id'));

        return view('etudiant.profile.index', compact('utilisateur'));
    }

    // Mettre à jour la photo de profil
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        $utilisateur = Utilisateur::find(session('compte_utilisateur_id'));

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos_profil', 'public');
            $utilisateur->photo_profil = $path;
            $utilisateur->save();
        }

        return back()->with('success', 'Photo de profil mise à jour avec succès !');
    }

    // Mettre à jour les informations personnelles
    public function updateInformations(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'telephone' => 'nullable|string|max:20',
        ]);

        $utilisateur = Utilisateur::find(session('compte_utilisateur_id'));

        $utilisateur->update($request->only('nom', 'prenom', 'date_naissance', 'telephone'));

        return back()->with('success', 'Informations personnelles mises à jour !');
    }

    // Mettre à jour le mot de passe
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_actuel' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $utilisateur = Utilisateur::find(session('compte_utilisateur_id'));

        if (!Hash::check($request->password_actuel, $utilisateur->password)) {
            return back()->withErrors(['password_actuel' => 'Le mot de passe actuel est incorrect.']);
        }

        $utilisateur->password = Hash::make($request->password);
        $utilisateur->save();

        return back()->with('success', 'Mot de passe mis à jour avec succès !');
    }
}
