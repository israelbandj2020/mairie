<?php

namespace App\Http\Controllers;

use App\Models\Besoin;
use App\Models\Canton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BesoinController extends Controller
{
    public function index(Request $request)
    {
        $query = Besoin::with('canton');

        // Filtre par statut de validation (pour les admins)
        if ($request->filled('statut_validation')) {
            $query->where('statut_validation', $request->statut_validation);
        } else {
            // Par défaut, ne montrer que les besoins validés pour les non-admins
            if (!Auth::user()->estAdmin()) {
                $query->valides();
            }
        }

        // Filtre par canton
        if ($request->filled('canton_id')) {
            $query->where('canton_id', $request->canton_id);
        }

        // Filtre par priorité
        if ($request->filled('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $validSortFields = ['created_at', 'priorite', 'statut', 'canton_id'];
        if (in_array($sortBy, $validSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $besoins = $query->paginate(20);
        $cantons = Canton::all();

        return view('besoins.index', compact('besoins', 'cantons'));
    }

    public function create()
    {
        $cantons = Canton::all();
        return view('besoins.create', compact('cantons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'canton_id' => 'required|exists:cantons,id',
            'description' => 'required|string',
            'priorite' => 'required|in:haute,moyenne,basse',
        ]);

        // Si l'utilisateur est admin, le besoin est validé automatiquement
        $statutValidation = Auth::user()->estAdmin() ? 'valide' : 'en_attente';

        Besoin::create([
            ...$validated,
            'statut_validation' => $statutValidation,
            'statut' => 'en_cours',
            'cree_par' => Auth::id(),
        ]);

        return redirect()->route('besoins.index')
            ->with('succes', 'Besoin ajouté avec succès.');
    }

    public function show(Besoin $besoin)
    {
        $besoin->load('canton', 'creePar');
        return view('besoins.show', compact('besoin'));
    }

    public function edit(Besoin $besoin)
    {
        $cantons = Canton::all();
        return view('besoins.edit', compact('besoin', 'cantons'));
    }

    public function update(Request $request, Besoin $besoin)
    {
        $validated = $request->validate([
            'canton_id' => 'sometimes|required|exists:cantons,id',
            'description' => 'sometimes|required|string',
            'priorite' => 'sometimes|required|in:haute,moyenne,basse',
            'statut' => 'sometimes|required|in:en_cours,traite,rejete',
        ]);

        $besoin->update($validated);

        return redirect()->route('besoins.show', $besoin)
            ->with('succes', 'Besoin modifié avec succès.');
    }

    public function destroy(Besoin $besoin)
    {
        $besoin->delete();
        return redirect()->route('besoins.index')
            ->with('succes', 'Besoin supprimé avec succès.');
    }

    public function valider(Besoin $besoin)
    {
        $besoin->update(['statut_validation' => 'valide']);
        return redirect()->route('besoins.index')
            ->with('succes', 'Besoin validé avec succès.');
    }

    public function rejeter(Besoin $besoin)
    {
        $besoin->update(['statut_validation' => 'rejete']);
        return redirect()->route('besoins.index')
            ->with('succes', 'Besoin rejeté.');
    }
}
