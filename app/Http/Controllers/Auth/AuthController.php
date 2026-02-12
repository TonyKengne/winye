<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Utilisateur;
use App\Models\CompteUtilisateur;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Afficher le formulaire d'inscription
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
 * Traiter l'inscription d'un utilisateur
 */
public function register(RegisterRequest $request)
{
    // Création du compte utilisateur
    $compte = CompteUtilisateur::create([
        'email'         => $request->email,
        'password'      => Hash::make($request->password),
        'statut'        => 'inactif',
        'role_id'       => $request->role === 'etudiant' ? 1 : 2,
        'date_creation' => now(),
    ]);

    // Création du profil utilisateur
    $utilisateur = Utilisateur::create([
        'compte_utilisateur_id' => $compte->id,
        'nom'       => $request->nom,
        'prenom'    => $request->prenom,
        'matricule' => $request->role === 'enseignant'
            ? $request->matricule
            : null,
    ]);

    $rolesANotifier = [3, 4]; // 3 = Secrétaire, 4 = Administrateur

    foreach ($rolesANotifier as $roleId) {
        Notification::create([
            'titre' => 'Nouvelle demande d’inscription',
            'message' => 
                'Nouvelle inscription en attente : ' .
                $utilisateur->prenom . ' ' . $utilisateur->nom .
                ' (' . $compte->email . ')',
            'destinataire_role_id' => $roleId,
            'lu' => false,
            'date_envoi' => now(),
        ]);
    }

    return redirect()
        ->back()
        ->with(
            'success',
            'Inscription réussie. Votre compte sera activé après validation.'
        );
}

   /**
 * Traiter la connexion
 */
   public function login(Request $request)
{
    // Validation
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    // Chercher le compte avec relation utilisateur
    $compte = CompteUtilisateur::with('utilisateur')
        ->where('email', $request->email)
        ->first();

    if (!$compte || !Hash::check($request->password, $compte->password)) {
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Email ou mot de passe incorrect.');
    }

    // Vérifier statut du compte
    if ($compte->statut !== 'actif') {
        return back()->with('error', 'Votre compte n’est pas encore activé.');
    }

    // Vérifier qu'un profil utilisateur existe
    if (!$compte->utilisateur) {
        Session::flush();
        return back()->with('error', 'Profil utilisateur introuvable. Contactez l’administrateur.');
    }

    $utilisateur = $compte->utilisateur;

    // Stocker les informations essentielles dans la session
    Session::put([
        'compte_utilisateur_id' => $compte->id,
        'role_id'               => $compte->role_id,
        'nom_utilisateur'       => $utilisateur->nom,
        'prenom_utilisateur'    => $utilisateur->prenom,
        'photo_profil'          => $utilisateur->photo_profil,
        'email_utilisateur'     => $compte->email,
        'filiere_id'            => $utilisateur->filiere_id,
    ]);

    // Redirection selon rôle
    switch ($compte->role_id) {
        case 1: // Étudiant
            if (is_null($utilisateur->filiere_id)) {
                // Filère non définie → rediriger vers onboarding
                return redirect()->route('inscription.filiere')
                                 ->with('info', 'Veuillez compléter votre inscription pour accéder au dashboard.');
            }
            return redirect()->route('utilisateur.dashboard')
                             ->with('success', 'Connexion réussie ! Bienvenue sur Winye.');

        case 2: // Enseignant
            return redirect()->route('enseignant.dashboard')
                             ->with('success', 'Connexion réussie ! Bienvenue sur Winye.');

        case 3: // Secrétaire
        case 4: // Administrateur
            return redirect()->route('admin.dashboard')
                             ->with('success', 'Connexion réussie ! Bienvenue sur Winye.');

        default:
            Session::flush();
            return redirect()->route('login')
                             ->with('error', 'Rôle non reconnu.');
    }
}

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Session::forget(['utilisateur_id', 'role_id']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Déconnexion réussie.');
    }
}
