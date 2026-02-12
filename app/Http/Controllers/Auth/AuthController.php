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
        // Validation des champs
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Récupération du compte avec le profil utilisateur
        $compte = CompteUtilisateur::with('utilisateur')
            ->where('email', $request->email)
            ->first();

        // Vérification email / mot de passe
        if (!$compte || !Hash::check($request->password, $compte->password)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email ou mot de passe incorrect.');
        }

        // Vérification du statut du compte
        if ($compte->statut !== 'actif') {
            return back()
                ->with('error', 'Votre compte n’est pas encore activé.');
        }

        // Vérifier que le profil existe
        if (!$compte->utilisateur) {
            Session::flush();
            return back()
                ->with('error', 'Profil utilisateur introuvable. Contactez l’administrateur.');
        }

        

        // Mise en session (données essentielles)
        Session::put('compte_utilisateur_id', $compte->id);
        Session::put('role_id', $compte->role_id);
        Session::put('nom_utilisateur', $compte->utilisateur->nom);
        Session::put('prenom_utilisateur', $compte->utilisateur->prenom);
        Session::put('photo_profil', $compte->utilisateur->photo_profil);
        Session::put('email_utilisateur', $compte->email);

        // Redirection selon le rôle
        switch ($compte->role_id) {
            case 1: // Étudiant
                $route = 'utilisateur.dashboard';
                break;

            case 2: // Enseignant
                $route = 'enseignant.dashboard';
                break;

            case 3: // Secrétaire
            case 4: // Administrateur
                $route = 'admin.dashboard';
                break;

            default:
                Session::flush();
                return redirect()
                    ->route('login')
                    ->with('error', 'Rôle non reconnu.');
        }

        return redirect()
            ->route($route)
            ->with('success', 'Connexion réussie ! Bienvenue sur Winye.');
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
