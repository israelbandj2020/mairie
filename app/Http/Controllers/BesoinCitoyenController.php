<?php

namespace App\Http\Controllers;

use App\Models\Besoin;
use App\Models\Canton;
use App\Services\FichierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BesoinCitoyenController extends Controller
{
    public function __construct(
        protected FichierService $fichierService
    ) {}

    public function create()
    {
        $cantons = Canton::all();
        return view('besoins-citoyens.create', compact('cantons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'canton_id' => 'required|exists:cantons,id',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:5120',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $infos = $this->fichierService->enregistrer($validated['photo'], 'photo', 'public');
            $photoPath = $infos['chemin'];
        }

        Besoin::create([
            'canton_id' => $validated['canton_id'],
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'telephone' => $validated['telephone'],
            'photo' => $photoPath,
            'statut_validation' => 'en_attente',
            'priorite' => 'moyenne',
            'statut' => 'en_cours',
            'cree_par' => Auth::check() ? Auth::id() : null,
        ]);

        return redirect()->route('besoins-citoyens.create')
            ->with('succes', 'Votre besoin a été soumis avec succès. Il sera examiné par l\'administration.');
    }
}
