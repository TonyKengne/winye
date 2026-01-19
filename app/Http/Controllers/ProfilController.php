<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Utilisateur;
use App\Models\CompteUtilisateur;

class ProfilController extends Controller
{
    public function index()
    {
        $utilisateur = Utilisateur::where(
            'compte_utilisateur_id',
            session('compte_utilisateur_id')
        )->firstOrFail();

        return view('profil.index', compact('utilisateur'));
    }

    public function updateInformations(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'date_naissance' => 'nullable|date',
            'telephone' => 'nullable|string',
        ]);

        Utilisateur::where('compte_utilisateur_id', session('compte_utilisateur_id'))
            ->update($request->only([
                'nom',
                'prenom',
                'date_naissance',
                'telephone'
            ]));

        Session::put('nom_utilisateur', $request->nom);
        Session::put('prenom_utilisateur', $request->prenom);

        return back()->with('success', 'Informations personnelles mises à jour.');
    }

    public function updateComplementaires(Request $request)
    {
        $request->validate([
            'matricule' => 'nullable|string',
            'filiere_id' => 'nullable|integer',
            'mode' => 'nullable|string',
        ]);

        Utilisateur::where('compte_utilisateur_id', session('compte_utilisateur_id'))
            ->update($request->only([
                'matricule',
                'filiere_id',
                'mode'
            ]));

        return back()->with('success', 'Informations complémentaires mises à jour.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_actuel' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $compte = CompteUtilisateur::findOrFail(session('compte_utilisateur_id'));

        if (!Hash::check($request->password_actuel, $compte->password)) {
            return back()->with('error', 'Mot de passe actuel incorrect.');
        }

        $compte->update([
            'password' => Hash::make($request->password),
        ]);

        Session::flush();

        return redirect()->route('login')
            ->with('success', 'Mot de passe modifié. Veuillez vous reconnecter.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        $path = $request->file('photo')->store('profiles', 'public');

        Utilisateur::where('compte_utilisateur_id', session('compte_utilisateur_id'))
            ->update(['photo_profil' => $path]);

        Session::put('photo_profil', $path);

        return back()->with('success', 'Photo de profil mise à jour.');
    }
}
