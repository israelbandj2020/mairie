<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Services\FichierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function __construct(
        protected FichierService $fichierService
    ) {}

    public function index()
    {
        $budgets = Budget::orderBy('annee', 'desc')->get();
        return view('budgets.index', compact('budgets'));
    }

    public function create()
    {
        return view('budgets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'annee' => 'required|integer|min:2020|max:2100',
            'type' => 'required|in:annuel,supplementaire',
            'montant' => 'required|numeric|min:0',
            'fichier' => 'required|file|max:10240',
        ]);

        $infos = $this->fichierService->enregistrer($validated['fichier'], 'budget');

        Budget::create([
            'annee' => $validated['annee'],
            'type' => $validated['type'],
            'montant' => $validated['montant'],
            'chemin' => $infos['chemin'],
            'nom_original' => $infos['nom_original'],
            'mime' => $infos['mime'],
            'taille' => $infos['taille'],
            'cree_par' => Auth::id(),
        ]);

        return redirect()->route('budgets.index')
            ->with('succes', 'Budget ajouté avec succès.');
    }

    public function show(Budget $budget)
    {
        return view('budgets.show', compact('budget'));
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budgets.index')
            ->with('succes', 'Budget supprimé avec succès.');
    }
}
