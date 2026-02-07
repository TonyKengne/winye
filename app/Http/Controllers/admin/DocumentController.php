<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    public function show($id)
    {
        $doc = Document::with(['matiere', 'filiere', 'enseignant'])->findOrFail($id);

        return view('admin.documents.show', compact('doc'));
    }

    /**
     * Afficher les documents en attente de validation
     */
    public function index()
    {
        $documentsEnAttente = Document::where('valide', 0)->get();
        $documentsValides = Document::where('valide', 1)->get();

        return view('admin.documents.index', compact('documentsEnAttente', 'documentsValides'));
    }

    /**
     * Valider un document
     */
       public function valider($id)
    {
        $doc = Document::findOrFail($id);
        $doc->valide = 1;
        $doc->save();

        return back()->with('success', 'Document validé avec succès.');
    }

    /**
     * Rejeter un document
     */
 

    public function rejeter($id)
    {
        $doc = Document::findOrFail($id);
        $doc->valide = -1;
        $doc->save();

        return back()->with('error', 'Document rejeté.');
    }

}
