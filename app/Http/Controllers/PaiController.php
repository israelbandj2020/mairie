<?php

namespace App\Http\Controllers;

use App\Models\PlanPai;
use App\Services\FichierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiController extends Controller
{
    public function __construct(
        protected FichierService $fichierService
    ) {}

    public function index()
    {
        $plans = PlanPai::orderBy('annee', 'desc')->get();
        return view('pai.index', compact('plans'));
    }

    public function create()
    {
        return view('pai.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'annee' => 'required|integer|min:2020|max:2100',
            'fichier' => 'required|file|max:10240',
        ]);

        $infos = $this->fichierService->enregistrer($validated['fichier'], 'pai');

        PlanPai::create([
            'annee' => $validated['annee'],
            'chemin' => $infos['chemin'],
            'nom_original' => $infos['nom_original'],
            'mime' => $infos['mime'],
            'taille' => $infos['taille'],
            'cree_par' => Auth::id(),
        ]);

        return redirect()->route('pai.index')
            ->with('succes', 'Plan PAI ajouté avec succès.');
    }

    public function show(PlanPai $planPai)
    {
        return view('pai.show', compact('planPai'));
    }

    public function destroy(PlanPai $planPai)
    {
        $planPai->delete();
        return redirect()->route('pai.index')
            ->with('succes', 'Plan PAI supprimé avec succès.');
    }
}
