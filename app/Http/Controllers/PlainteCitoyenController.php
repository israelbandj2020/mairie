<?php

namespace App\Http\Controllers;

use App\Models\Plainte;
use App\Services\FichierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlainteCitoyenController extends Controller
{
    protected $fichierService;

    public function __construct(FichierService $fichierService)
    {
        $this->fichierService = $fichierService;
    }

    public function create()
    {
        return view('plaintes-citoyens.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_plainte' => 'required|in:executif,agent_mairie,conseiller,autres',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:5120',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $infos = $this->fichierService->enregistrer($validated['photo'], 'photo', 'public');
            $photoPath = $infos['chemin'];
        }

        Plainte::create([
            'type_plainte' => $validated['type_plainte'],
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'telephone' => $validated['telephone'],
            'description' => $validated['description'],
            'photo' => $photoPath,
            'statut_validation' => 'en_attente',
            'cree_par' => Auth::check() ? Auth::id() : null,
        ]);

        return redirect()->route('plaintes-citoyens.create')
            ->with('succes', 'Votre plainte a été soumise avec succès. Elle sera examinée par l\'administration.');
    }
}
