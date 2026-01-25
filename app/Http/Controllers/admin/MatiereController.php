<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campus;
use App\Models\Cursus;
use App\Models\Departement;
use App\Models\Niveau;
use App\Models\Filiere;
use App\Models\Matiere;

class MatiereController extends Controller
{
    /**
     * INDEX : liste des matières
     */
   public function index(Request $request)
{
    $campusId      = $request->campus;
    $cursusId      = $request->cursus;
    $departementId = $request->departement;
    $niveauId      = $request->niveau;
    $filiereId     = $request->filiere;

    $matieres = Matiere::with(['niveau', 'filieres.departement.cursus.campus'])
        ->when($niveauId, fn ($q) =>
            $q->where('niveau_id', $niveauId)
        )
        ->when($filiereId, fn ($q) =>
            $q->whereHas('filieres', fn ($qq) =>
                $qq->where('filieres.id', $filiereId)
            )
        )
        ->when($departementId, fn ($q) =>
            $q->whereHas('filieres', fn ($qq) =>
                $qq->where('departement_id', $departementId)
            )
        )
        ->when($cursusId, fn ($q) =>
            $q->whereHas('filieres.departement', fn ($qq) =>
                $qq->where('cursus_id', $cursusId)
            )
        )
        ->when($campusId, fn ($q) =>
            $q->whereHas('filieres.departement.cursus', fn ($qq) =>
                $qq->where('campus_id', $campusId)
            )
        )
        ->latest()
        ->get();

    return view('admin.matiere.index', [
        'matieres'      => $matieres,
        'campuses'      => Campus::orderBy('nom')->get(),
        'cursusList'    => Cursus::orderBy('nom')->get(),
        'departements'  => Departement::orderBy('nom')->get(),
        'niveaux'       => Niveau::orderBy('nom')->get(),
        'filieres'      => Filiere::orderBy('nom')->get(),

        'campusId'      => $campusId,
        'cursusId'      => $cursusId,
        'departementId' => $departementId,
        'niveauId'      => $niveauId,
        'filiereId'     => $filiereId,
    ]);
}

    /**
     * CREATE : formulaire
     */
    public function create()
    {
        return view('admin.matiere.create', [
            'niveaux'  => Niveau::all(),
            'filieres' => Filiere::all(),
            'campuses' => Campus::all(),
            'cursuses' => Cursus::all(),
            'departements' => Departement::all(),
        ]);
    }

    /**
     * STORE : enregistrement
     */
   public function store(Request $request)
{
    // Validation
    $data = $request->validate([
        'code'           => 'required|string|max:20',
        'nom'            => 'required|string|max:255',
        'semestre'       => 'required|string|max:10',
        'mode'           => 'required|in:filiere,niveau',
        'niveau_id'      => 'nullable|exists:niveaux,id',
        'filiere_id'     => 'nullable|exists:filieres,id',
        'campus_id'      => 'required|exists:campuses,id',
        'cursus_id'      => 'required|exists:cursuses,id',
        'departement_id' => 'required|exists:departements,id',
    ]);

    // Déterminer les filières et le niveau
    if ($data['mode'] === 'filiere') {
        // Mode filière unique
        if (!$data['filiere_id']) {
            return back()->withErrors(['filiere_id' => 'Veuillez sélectionner une filière'])->withInput();
        }

        $filiere = Filiere::find($data['filiere_id']);

        if (!$filiere || !$filiere->niveau_id) {
            return back()->withErrors(['filiere_id' => 'La filière sélectionnée n’a pas de niveau associé'])->withInput();
        }

        $filieres = [$filiere->id];
        $niveauId = $filiere->niveau_id;

    } else {
        // Mode niveau
        if (!$data['niveau_id']) {
            return back()->withErrors(['niveau_id' => 'Veuillez sélectionner un niveau'])->withInput();
        }

        $filieres = Filiere::where('niveau_id', $data['niveau_id'])
                            ->where('departement_id', $data['departement_id'])
                            ->pluck('id')
                            ->toArray();

        $niveauId = $data['niveau_id'];

        if (empty($filieres)) {
            return back()->withErrors(['niveau_id' => 'Aucune filière trouvée pour ce niveau et département'])->withInput();
        }
    }

    // Créer la matière
    $matiere = Matiere::create([
        'code'      => $data['code'],
        'nom'       => $data['nom'],
        'semestre'  => $data['semestre'],
        'niveau_id' => $niveauId,
    ]);

    // Assigner les filières
    $matiere->filieres()->sync($filieres);

    return redirect()->route('admin.matiere.index')
                     ->with('success', 'Matière ajoutée avec succès');
}


}
