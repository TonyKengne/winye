<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EtudiantDashboardController extends Controller
{
    public function index()
{
    $utilisateur = auth()->user()->utilisateur; // ou Session::get selon ton implémentation

    // Vérifier si filiere_id est renseignée
    $needsFiliere = is_null($utilisateur->filiere_id);

    return view('etudiant.dashboard', compact('needsFiliere'));
}

}
