<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Campus;
use App\Models\Cursus;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    /**
     * Liste des départements + filtres
     */
    public function index(Request $request)
    {
        $campusId = $request->campus;
        $cursusId = $request->cursus;

        $campuses = Campus::orderBy('nom')->get();

        $cursus = $campusId
            ? Cursus::where('campus_id', $campusId)->orderBy('nom')->get()
            : Cursus::orderBy('nom')->get();

        $departements = Departement::with('cursus.campus')
            ->when($cursusId, function ($q) use ($cursusId) {
                $q->where('cursus_id', $cursusId);
            })
            ->when($campusId, function ($q) use ($campusId) {
                $q->whereHas('cursus', function ($sub) use ($campusId) {
                    $sub->where('campus_id', $campusId);
                });
            })
            ->orderBy('nom')
            ->get();

        return view('admin.departement.index', compact(
            'departements',
            'campuses',
            'cursus',
            'campusId',
            'cursusId'
        ));
    }

    /**
     * Formulaire création
     */
    public function create()
    {
        $campuses = Campus::orderBy('nom')->get();
        return view('admin.departement.create', compact('campuses'));
    }

    /**
     * Enregistrement
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'cursus_id' => 'required|exists:cursuses,id',
        ]);

        Departement::create([
            'nom' => $request->nom,
            'cursus_id' => $request->cursus_id,
        ]);

        return redirect()
            ->route('admin.departement.index')
            ->with('success', 'Département ajouté avec succès');
    }
    // delete
    public function destroy(Departement $departement)
{
    $departement->delete();

    return redirect()
        ->route('admin.departement.index')
        ->with('success', 'Département supprimé avec succès.');
}
}
