<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Cursus;
use Illuminate\Http\Request;

class CursusController extends Controller
{
    /**
     * Liste des cursus
     */
    public function index(Request $request)
    {
        $campusId = $request->campus;

        $campuses = Campus::orderBy('nom')->get();

        $cursus = Cursus::with('campus')
            ->when($campusId, function ($query) use ($campusId) {
                $query->where('campus_id', $campusId);
            })
            ->orderBy('nom')->get();
            $colors = [
                'soft-violet',
                'soft-blue',
                'soft-green',
                'soft-orange',
                'soft-teal'
            ];

        return view('admin.cursus.index', compact(
            'cursus',
            'campuses',
            'campusId',
            'colors'
        ));
    }

    /**
     * Formulaire d'ajout
     */
    public function create()
    {
        $campuses = Campus::orderBy('nom')->get();

        return view('admin.cursus.create', compact('campuses'));
    }

    /**
     * Enregistrement
     */
    public function store(Request $request)
    {
        $request->validate([
            'campus_id' => 'required|exists:campuses,id',
            'nom'       => 'required|string|max:255',
        ]);

        Cursus::create([
            'nom'       => $request->nom,
            'campus_id' => $request->campus_id,
        ]);

        return redirect()
            ->route('admin.cursus.index')
            ->with('success', 'Cursus ajouté avec succès.');
    }
    //delete cursus 
    public function destroy($id)
{
    $cursus = Cursus::with('departements')->findOrFail($id);

    // Vérifie si le cursus contient des départements
    if ($cursus->departements->isNotEmpty()) {
        return redirect()->route('admin.cursus.index')
                         ->with('error', 'Vous devez supprimer les départements avant de supprimer ce cursus.');
    }

    // Supprime le cursus
    $cursus->delete();

    return redirect()->route('admin.cursus.index')
                     ->with('success', 'Cursus supprimé avec succès.');
}

}
