<?php

namespace App\Http\Controllers;

use App\Models\DocumentAdministration;
use App\Models\MembreBureau;
use App\Models\User;
use App\Services\FichierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministrationController extends Controller
{
    public function __construct(
        protected FichierService $fichierService
    ) {}

    public function index()
    {
        $documents = DocumentAdministration::orderBy('created_at', 'desc')->get();
        $membres = MembreBureau::orderBy('ordre')->get();
        return view('administration.index', compact('documents', 'membres'));
    }

    public function storeDocument(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'fichier' => 'required|file|max:10240',
        ]);

        $infos = $this->fichierService->enregistrer($validated['fichier'], 'administration');

        DocumentAdministration::create([
            'titre' => $validated['titre'],
            'chemin' => $infos['chemin'],
            'nom_original' => $infos['nom_original'],
            'mime' => $infos['mime'],
            'taille' => $infos['taille'],
            'cree_par' => Auth::id(),
        ]);

        return redirect()->route('administration.index')
            ->with('succes', 'Document ajouté avec succès.');
    }

    public function destroyDocument(DocumentAdministration $document)
    {
        $document->delete();
        return redirect()->route('administration.index')
            ->with('succes', 'Document supprimé avec succès.');
    }

    public function storeMembre(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        $user = User::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => strtolower($validated['prenom'] . '.' . $validated['nom'] . '@mairie.tg'),
            'password' => bcrypt('password'),
            'role' => 'conseiller',
            'statut' => 'valide',
        ]);

        $maxOrdre = MembreBureau::max('ordre') ?? 0;

        MembreBureau::create([
            'user_id' => $user->id,
            'role' => $validated['role'],
            'ordre' => $maxOrdre + 1,
        ]);

        return redirect()->route('administration.index')
            ->with('succes', 'Membre ajouté avec succès.');
    }

    public function destroyMembre(MembreBureau $membre)
    {
        $membre->delete();
        return redirect()->route('administration.index')
            ->with('succes', 'Membre supprimé avec succès.');
    }
}
