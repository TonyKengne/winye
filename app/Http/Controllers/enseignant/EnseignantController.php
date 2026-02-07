<?php

namespace App\Http\Controllers\enseignant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Matiere;
 use App\Models\Notification;
 use App\Models\Document;

class EnseignantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    public function dashboard()
    {
        $compte = Auth::user(); // modèle CompteUtilisateur
        $user = $compte->utilisateur; // modèle Utilisateur
       // $user = Auth::user();

        $stats = [
            'documents' => \App\Models\Document::count(),
            'corriges'  => \App\Models\Sujet::count(), // ou la table qui stocke les corrigés
            'matieres'  => \App\Models\Matiere::count(),
            'vues' => \App\Models\Consultation::count(), // ou une logique pour compter les vues
        ];

        $recentDocuments = collect([]);
        $recentDocuments = \App\Models\Document::with('matiere') 
            ->orderBy('date_upload', 'desc') 
            ->take(5) // les 5 plus récents 
            ->get();

        return view('enseignant.dashboard', compact('user', 'stats', 'recentDocuments'));
    }

    public function showDocument($id)
    {
        $document = Document::with('matiere')->findOrFail($id);

        return view('enseignant.document_show', compact('document'));
    }
    public function upload()
    {
     $matieres = \App\Models\Matiere::all(); $filieres = \App\Models\FilLiere::all(); // ✅ variable au pluriel 
     $sujets = \App\Models\Sujet::all(); return view('enseignant.upload', compact('matieres', 'filieres', 'sujets')); // ✅ cohérence 
    }


    public function storeDocument(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'annee' => 'required|string',
            'semestre' => 'required|string',
            'type_examen' => 'required|string',
            'duree' => 'nullable|string',
            'coefficient' => 'nullable|numeric',
            'matiere_id' => 'required|exists:matiere,id',
            'filliere_id' => 'required|exists:filliere,id',
            'document' => 'required|file|max:5120|mimes:pdf,doc,docx,ppt,pptx,jpg,png',
        ]);

        // 1️⃣ Stocker le fichier
        $path = $request->file('document')->store('documents', 'public');
        $compte = Auth::user();

        // 2️⃣ Créer le sujet
        $sujet = \App\Models\Sujet::create([
            'nom' => $request->titre,
            'description' => $request->description ?? null,
            'annee' => $request->annee,
            'semestre' => $request->semestre,
            'type_examen' => $request->type_examen,
            'duree' => $request->duree,
            'coefficient' => $request->coefficient,
            'matiere_id' => $request->matiere_id,
            'filliere_id' => $request->filliere_id,
            'corrige_disponible' => false,
            'qrcode' => null, // tu peux générer un QR code plus tard
        ]);

        // 3️⃣ Créer le document lié au sujet
        $document = Document::create([
            'titre' => $request->titre,
            'enseignant_id' => $compte->id,
            'sujet_id' => $sujet->id, // relation avec le sujet
            'chemin_fichier' => $path,
            'valide' => 0,
            'date_upload' => now(),
        ]);

        // 4️⃣ Notification admin
        Notification::create([
            'titre' => 'Nouvelle épreuve en attente',
            'message' => 'Le document "' . $document->titre . '" a été déposé par ' . $compte->email . ' et attend validation.',
            'role_id' => 4,
            'lu' => false,
            'date_envoi' => now(),
        ]);

        return back()->with('success', '✅ Sujet et document enregistrés, en attente de validation.');
    }


    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048'
        ]);

        $user = Auth::user();

        $path = $request->file('photo')->store('photos', 'public');

        $user->photo = $path;
        $user->save();

        return back()->with('success', 'Photo mise à jour avec succès !');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Mot de passe mis à jour !');
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $user->language = $request->language;
        $user->theme = $request->theme;
        $user->save();

        return back()->with('success', 'Préférences mises à jour !');
    }

    public function mesDocuments()
    {
        $compte = Auth::user();
        $enseignant = $compte->utilisateur;

        $documents = Document::where('enseignant_id', Auth::id())
        ->with(['matiere','filiere'])
        ->get();


        return view('enseignant.documents', compact('documents'));
    }

    public function mesMatieres()
    {
        return view('enseignant.matieres');
    }

    public function statistiques()
    {
        return view('enseignant.statistiques');
    }

    public function parametres()
    {
        $user = Auth::user(); return view('enseignant.parametres', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès!');
    }
}
