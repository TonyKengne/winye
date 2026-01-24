<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Cursus;
use App\Models\Departement;
use App\Models\Filiere;
use App\Models\Niveau;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    public function index(Request $request)
    {
        $campusId = $request->campus;
        $cursusId = $request->cursus;

        $campuses = Campus::orderBy('nom')->get();
        $cursusList = Cursus::when($campusId, fn($q) => $q->where('campus_id', $campusId))->orderBy('nom')->get();
        $departements = Departement::when($cursusId, function($q) use ($cursusId) {
        $q->where('cursus_id', $cursusId);})->orderBy('nom')->get();
        $filieres = Filiere::with('departement.cursus.campus')
            ->when($campusId, fn($q) => $q->whereHas('departement.cursus', fn($q2) => $q2->where('campus_id', $campusId)))
            ->when($cursusId, fn($q) => $q->whereHas('departement', fn($q2) => $q2->where('cursus_id', $cursusId)))
            ->orderBy('nom')
            ->get();

        $colors = ['soft-violet', 'soft-blue', 'soft-green', 'soft-orange', 'soft-teal'];

        return view('admin.filiere.index', compact('filieres', 'campuses', 'cursusList','departements', 'campusId', 'cursusId', 'colors'));
    }

  public function create()
{
    return view('admin.filiere.create', [
        'campus' => Campus::orderBy('nom')->get(),
        'niveaux' => Niveau::orderBy('nom')->get(),
    ]);
}

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'departement_id' => 'required|exists:departements,id',
        ]);

        Filiere::create($request->all());

        return redirect()->route('admin.filiere.index')
                         ->with('success', 'Filière ajoutée avec succès.');
    }

    public function destroy(Filiere $filiere)
    {
        $filiere->delete();
        return redirect()->route('admin.filiere.index')
                         ->with('success', 'Filière supprimée avec succès.');
    }
}
