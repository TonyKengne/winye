<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campus;

class CampusController extends Controller
{
    /**
     * Afficher la liste des campus
     */
    public function index()
    {
        $campus = Campus::orderBy('nom')->get();
        return view('admin.campus.index', compact('campus'));
    }

    /**
     * Afficher le formulaire pour créer un nouveau campus
     */
    public function create()
    {
        return view('admin.campus.create');
    }

    /**
     * Enregistrer un nouveau campus
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:campuses,nom',
            'photo_campus' => 'nullable|image|max:2048', // limite 2MB
        ]);

        $photoPath = null;
        if ($request->hasFile('photo_campus')) {
            $photoPath = $request->file('photo_campus')->store('campus', 'public');
        }

        Campus::create([
            'nom' => $request->nom,
            'photo_campus' => $photoPath,
        ]);

        return redirect()->route('admin.campus.index')
                         ->with('success', 'Campus ajouté avec succès.');
    }

    /**
     * Formulaire pour modifier un campus existant
     */
    public function edit(Campus $campus)
    {
        return view('admin.campus.edit', compact('campus'));
    }

    /**
     * Mettre à jour un campus
     */
    public function update(Request $request, Campus $campus)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:campus,nom,' . $campus->id,
            'photo_campus' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo_campus')) {
            $campus->photo_campus = $request->file('photo_campus')->store('campus', 'public');
        }

        $campus->nom = $request->nom;
        $campus->save();

        return redirect()->route('campus.index')
                         ->with('success', 'Campus mis à jour avec succès.');
    }

    /**
     * Supprimer un campus
     */
    public function destroy(Campus $campus)
    {
        if ($campus->photo_campus) {
            \Storage::disk('public')->delete($campus->photo_campus);
        }

        $campus->delete();

        return redirect()->route('campus.index')
                         ->with('success', 'Campus supprimé avec succès.');
    }
}
