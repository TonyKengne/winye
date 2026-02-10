<?php

namespace App\Http\Controllers\enseignant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Matiere;
use App\Models\Notification;
use App\Models\Document;
use App\Models\Sujet;
use App\Models\Consultation;
use App\Models\Filliere;
use App\Models\Setting;


class EnseignantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function dashboard()
    {
        $compte = Auth::user();
        $user = $compte->utilisateur;

        // ✅ Statistiques adaptées à votre structure de base de données
        $stats = [
            // Nombre total de documents de l'enseignant
            'documents' => Document::where('enseignant_id', $compte->id)->count(),
            
            // Nombre de corrigés (sujets avec corrige_disponible = true)
            'corriges' => Sujet::where('corrige_disponible', true)
                               ->whereHas('documents', function($query) use ($compte) {
                                   $query->where('enseignant_id', $compte->id);
                               })
                               ->count(),
            
            // Nombre de matières uniques dans lesquelles l'enseignant a uploadé des documents
            'matieres' => Sujet::whereHas('documents', function($query) use ($compte) {
                                   $query->where('enseignant_id', $compte->id);
                               })
                               ->distinct('matiere_id')
                               ->count('matiere_id'),
            
            // Total des consultations (utilise la colonne 'consultation' dans la table document)
            'vues' => Document::where('enseignant_id', $compte->id)->sum('consultation'),
        ];

        // ✅ Documents récents avec leurs relations via sujet
        $recentDocuments = Document::where('enseignant_id', $compte->id)
            ->with(['sujet.matiere', 'sujet.filiere'])
            ->orderBy('date_upload', 'desc')
            ->take(5)
            ->get()
            ->map(function($doc) {
                // Créer des relations virtuelles pour que la vue fonctionne
                $doc->matiere = $doc->sujet ? $doc->sujet->matiere : null;
                $doc->filiere = $doc->sujet ? $doc->sujet->filiere : null;
                $doc->vues = $doc->consultation; // Mapper consultation vers vues
                return $doc;
            });

        return view('enseignant.dashboard', compact('user', 'stats', 'recentDocuments'));
    }

    public function showDocument($id)
    {
        $compte = Auth::user();
        
        // ✅ Vérifier que le document appartient bien à l'enseignant
        $document = Document::with(['sujet.matiere', 'sujet.filiere'])
            ->where('enseignant_id', $compte->id)
            ->findOrFail($id);

        // Mapper les relations pour la vue
        $document->matiere = $document->sujet ? $document->sujet->matiere : null;
        $document->filiere = $document->sujet ? $document->sujet->filiere : null;
        $document->vues = $document->consultation;

        return view('enseignant.document_show', compact('document'));
    }

    public function upload()
    {
        $matieres = Matiere::all();
        $filieres = \App\Models\FilLiere::all();
        $sujets = Sujet::all();
        
        return view('enseignant.upload', compact('matieres', 'filieres', 'sujets'));
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
            'est_corrige' => 'nullable|boolean',
        ]);

        $compte = Auth::user();

        // 1️⃣ Stocker le fichier
        $path = $request->file('document')->store('documents', 'public');
        
        // Déterminer le type de fichier
        $extension = strtoupper($request->file('document')->getClientOriginalExtension());

        // 2️⃣ Créer le sujet
        $sujet = Sujet::create([
            'nom' => $request->titre,
            'description' => $request->description ?? null,
            'annee' => $request->annee,
            'semestre' => $request->semestre,
            'type_examen' => $request->type_examen,
            'duree' => $request->duree,
            'coefficient' => $request->coefficient,
            'matiere_id' => $request->matiere_id,
            'filliere_id' => $request->filliere_id,
            'corrige_disponible' => $request->has('est_corrige') ? true : false,
            'qrcode' => null,
        ]);

        // 3️⃣ Créer le document lié au sujet
        $document = Document::create([
            'titre' => $request->titre,
            'enseignant_id' => $compte->id,
            'sujet_id' => $sujet->id,
            'chemin_fichier' => $path,
            'type' => $extension,
            'valide' => 0,
            'consultation' => 0,
            'date_upload' => now(),
            'description' => $request->description,
        ]);

        // 4️⃣ Notification admin
        Notification::create([
            'titre' => 'Nouvelle épreuve en attente',
            'message' => 'Le document "' . $document->titre . '" a été déposé par ' . $compte->email . ' et attend validation.',
            'role_id' => 4,
            'is_lu' => false,
            'created_at' => now(),
        ]);

        return back()->with('success', '✅ Sujet et document enregistrés, en attente de validation.');
    }

    public function mesDocuments()
    {
        $compte = Auth::user();

        $documents = Document::where('enseignant_id', $compte->id)
            ->with(['sujet.matiere', 'sujet.filiere'])
            ->orderBy('date_upload', 'desc')
            ->get()
            ->map(function($doc) {
                $doc->matiere = $doc->sujet ? $doc->sujet->matiere : null;
                $doc->filiere = $doc->sujet ? $doc->sujet->filiere : null;
                $doc->vues = $doc->consultation;
                return $doc;
            });

        return view('enseignant.documents', compact('documents'));
    }

    public function mesMatieres()
    {
        try {
            $enseignantId = auth()->id();
            
            // Récupérer toutes les filières pour les filtres et les formulaires
            $filieres = Filliere::orderBy('nom')->get();
            
            // Récupérer les matières avec leurs relations et compter les documents/sujets
            $matieres = Matiere::with(['filiere', 'documents', 'sujets'])
            ->withCount([
                'documents' => function($query) use ($enseignantId) {
                    $query->where('enseignant_id', $enseignantId);
                },
                'sujets' => function($query) use ($enseignantId) {
                    $query->whereHas('documents', function($q) use ($enseignantId) {
                        $q->where('enseignant_id', $enseignantId);
                    });
                }
            ])
            ->whereHas('documents', function($query) use ($enseignantId) {
                $query->where('enseignant_id', $enseignantId);
            })
            ->orderBy('nom')
            ->get();        
            
            return view('enseignant.matieres', compact('matieres', 'filieres'));
            
        } catch (Exception $e) {
            Log::error('Erreur lors du chargement des matières: ' . $e->getMessage());
            
            return redirect()->route('enseignant.dashboard')
                ->with('error', 'Impossible de charger les matières.');
        }
    }

    /**
     * Enregistrer une nouvelle matière
     */
    public function storeMatieres(Request $request)
    {
        try {
            // Validation
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'code' => 'nullable|string|max:20|unique:matiere,code',
                'filliere_id' => 'required|exists:filliere,id',
                'coefficient' => 'required|numeric|min:0.5|max:10',
                'description' => 'nullable|string|max:1000',
            ], [
                'nom.required' => 'Le nom de la matière est obligatoire.',
                'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
                'code.unique' => 'Ce code matière existe déjà.',
                'filliere_id.required' => 'Veuillez sélectionner une filière.',
                'filliere_id.exists' => 'La filière sélectionnée n\'existe pas.',
                'coefficient.required' => 'Le coefficient est obligatoire.',
                'coefficient.numeric' => 'Le coefficient doit être un nombre.',
                'coefficient.min' => 'Le coefficient minimum est 0.5.',
                'coefficient.max' => 'Le coefficient maximum est 10.',
            ]);

            DB::beginTransaction();

            // Créer la matière
            $matiere = Matiere::create([
                'nom' => $validated['nom'],
                'code' => $validated['code'] ?? null,
                'filliere_id' => $validated['filliere_id'],
                'coefficient' => $validated['coefficient'],
                'description' => $validated['description'] ?? null,
            ]);

            DB::commit();

            return redirect()->route('enseignant.matieres')
                ->with('success', 'Matière créée avec succès !');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Veuillez corriger les erreurs dans le formulaire.');

        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur lors de la création de la matière: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de la matière.');
        }
    }

    /**
     * Mettre à jour une matière
     */
    public function updateMatieres(Request $request, $id)
    {
        try {
            $matiere = Matiere::findOrFail($id);

            // Validation
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'code' => 'nullable|string|max:20|unique:matiere,code,' . $id,
                'filliere_id' => 'required|exists:filliere,id',
                'coefficient' => 'required|numeric|min:0.5|max:10',
                'description' => 'nullable|string|max:1000',
            ], [
                'nom.required' => 'Le nom de la matière est obligatoire.',
                'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
                'code.unique' => 'Ce code matière existe déjà.',
                'filliere_id.required' => 'Veuillez sélectionner une filière.',
                'filliere_id.exists' => 'La filière sélectionnée n\'existe pas.',
                'coefficient.required' => 'Le coefficient est obligatoire.',
                'coefficient.numeric' => 'Le coefficient doit être un nombre.',
                'coefficient.min' => 'Le coefficient minimum est 0.5.',
                'coefficient.max' => 'Le coefficient maximum est 10.',
            ]);

            DB::beginTransaction();

            // Mettre à jour la matière
            $matiere->update([
                'nom' => $validated['nom'],
                'code' => $validated['code'] ?? null,
                'filliere_id' => $validated['filliere_id'],
                'coefficient' => $validated['coefficient'],
                'description' => $validated['description'] ?? null,
            ]);

            DB::commit();

            return redirect()->route('enseignant.matieres')
                ->with('success', 'Matière modifiée avec succès !');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            
            return redirect()->route('enseignant.matieres')
                ->with('error', 'Matière non trouvée.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Veuillez corriger les erreurs dans le formulaire.');

        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur lors de la modification de la matière: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la modification.');
        }
    }

    /**
     * Supprimer une matière
     */
    public function destroyMatieres($id)
    {
        try {
            $matiere = Matiere::findOrFail($id);

            // Vérifier si la matière a des documents associés
            if ($matiere->documents()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Impossible de supprimer cette matière car elle possède des documents associés.');
            }

            // Vérifier si la matière a des sujets associés
            if ($matiere->sujets()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Impossible de supprimer cette matière car elle possède des sujets associés.');
            }

            DB::beginTransaction();

            $matiere->delete();

            DB::commit();

            return redirect()->route('enseignant.matieres')
                ->with('success', 'Matière supprimée avec succès !');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            
            return redirect()->route('enseignant.matieres')
                ->with('error', 'Matière non trouvée.');

        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur lors de la suppression de la matière: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }


    public function statistiques()
    {
        try {
            $enseignantId = auth()->id();
            
            // Statistiques générales
            $totalDocuments = Document::where('enseignant_id', $enseignantId)->count();
            $documentsValides = Document::where('enseignant_id', $enseignantId)
                ->where('valide', 1)
                ->count();
            $documentsEnAttente = Document::where('enseignant_id', $enseignantId)
                ->where('valide', 0)
                ->count();
            $documentsRejetes = Document::where('enseignant_id', $enseignantId)
                ->where('valide', -1)
                ->count();
            
            // Nombre de matières
            $totalMatieres = Matiere::whereHas('documents', function($query) use ($enseignantId) {
                $query->where('enseignant_id', $enseignantId);
            })->count();
            
            // Tendance des documents (comparaison avec le mois dernier)
            $documentsThisMonth = Document::where('enseignant_id', $enseignantId)
                ->whereMonth('date_upload', now()->month)
                ->whereYear('date_upload', now()->year)
                ->count();
                
            $documentsLastMonth = Document::where('enseignant_id', $enseignantId)
                ->whereMonth('date_upload', now()->subMonth()->month)
                ->whereYear('date_upload', now()->subMonth()->year)
                ->count();
                
            $documentsTrend = $documentsLastMonth > 0 
                ? round((($documentsThisMonth - $documentsLastMonth) / $documentsLastMonth) * 100)
                : 0;
            
            // Top matières (les 5 matières avec le plus de documents)
            $topMatieres = Matiere::withCount(['documents' => function($query) use ($enseignantId) {
                    $query->where('enseignant_id', $enseignantId);
                }])
                ->with('filiere')
                ->having('documents_count', '>', 0)
                ->orderBy('documents_count', 'desc')
                ->take(5)
                ->get();
                
            $maxDocuments = $topMatieres->max('documents_count') ?? 1;
            
            // Documents par mois (6 derniers mois)
            $monthLabels = [];
            $monthData = [];
            
            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $monthLabels[] = $date->locale('fr')->isoFormat('MMM YYYY');
                
                $count = Document::where('enseignant_id', $enseignantId)
                    ->whereMonth('date_upload', $date->month)
                    ->whereYear('date_upload', $date->year)
                    ->count();
                    
                $monthData[] = $count;
            }
            
            // Activités récentes (10 derniers documents)
            $recentActivities = Document::with(['sujet.matiere', 'sujet.filiere'])
            ->where('enseignant_id', $enseignantId)
            ->orderBy('date_upload', 'desc')
            ->take(10)
            ->get()
            ->map(function($doc) {
                $doc->type = $doc->valide === 1 ? 'validate' : ($doc->valide === 0 ? 'upload' : 'reject');
                return $doc;
            });        
            
            return view('enseignant.statistiques', compact(
                'totalDocuments',
                'documentsValides',
                'documentsEnAttente',
                'documentsRejetes',
                'totalMatieres',
                'documentsTrend',
                'topMatieres',
                'maxDocuments',
                'monthLabels',
                'monthData',
                'recentActivities'
            ));
            
        } catch (Exception $e) {
            Log::error('Erreur lors du chargement des statistiques: ' . $e->getMessage());
            
            return redirect()->route('enseignant.dashboard')
                ->with('error', 'Impossible de charger les statistiques.');
        }
    }


    public function parametres()
    {
        $compte = Auth::user(); // CompteUtilisateur
        $utilisateur = $compte->utilisateur; // relation hasOne
    
        return view('enseignant.parametres', compact('compte', 'utilisateur'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:compte_utilisateurs,email,' . Auth::id(),
            'telephone' => 'nullable|string|max:20',
        ]);

        $compte = Auth::user();
        $utilisateur = $compte->utilisateur;

        // Mettre à jour le compte
        $compte->email = $request->email;
        $compte->save();

        // Mettre à jour l'utilisateur
        $utilisateur->nom = $request->nom;
        $utilisateur->prenom = $request->prenom;
        $utilisateur->telephone = $request->telephone;
        $utilisateur->save();

        return back()->with('success', 'Profil mis à jour avec succès!');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048'
        ]);

        $compte = Auth::user();
        $utilisateur = $compte->utilisateur;

        // Supprimer l'ancienne photo si elle existe
        if ($utilisateur->photo_profil && \Storage::disk('public')->exists($utilisateur->photo_profil)) {
            \Storage::disk('public')->delete($utilisateur->photo_profil);
        }

        $path = $request->file('photo')->store('profiles', 'public');

        $utilisateur->photo_profil = $path;
        $utilisateur->save();

        return back()->with('success', 'Photo mise à jour avec succès !');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $compte = Auth::user();

        if (!Hash::check($request->current_password, $compte->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect']);
        }

        $compte->password = Hash::make($request->new_password);
        $compte->save();

        return back()->with('success', 'Mot de passe mis à jour avec succès !');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'language' => 'required|in:fr,en',
            'theme' => 'required|in:light,dark',
        ]);

        Setting::updateOrCreate(['key' => 'language'], ['value' => $request->language]);
        Setting::updateOrCreate(['key' => 'theme'], ['value' => $request->theme]);

        return back()->with('success', 'Préférences mises à jour !');
    }
 

}