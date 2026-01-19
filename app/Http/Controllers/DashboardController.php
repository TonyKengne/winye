<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard étudiant
     */
    public function utilisateurDashboard()
    {
        return view('utilisateur.dashboard');
    }

    /**
     * Dashboard enseignant
     */
    public function enseignantDashboard()
    {
        return view('enseignant.dashboard');
    }

    /**
     * Dashboard administrateur / secrétaire
     */
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }
}
