<?php

namespace App\Http\Controllers;

use App\Models\Plainte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlainteController extends Controller
{
    public function index(Request $request)
    {
        $query = Plainte::query();

        // Filtre par statut de validation
        if ($request->filled('statut_validation')) {
            $query->where('statut_validation', $request->statut_validation);
        }

        // Filtre par type de plainte
        if ($request->filled('type_plainte')) {
            $query->where('type_plainte', $request->type_plainte);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $validSortFields = ['created_at', 'type_plainte'];
        if (in_array($sortBy, $validSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $plaintes = $query->paginate(20);

        return view('plaintes.index', compact('plaintes'));
    }

    public function show(Plainte $plainte)
    {
        $plainte->load('creePar');
        return view('plaintes.show', compact('plainte'));
    }

    public function valider(Plainte $plainte)
    {
        $plainte->update(['statut_validation' => 'valide']);
        return redirect()->route('plaintes.index')
            ->with('succes', 'Plainte validée avec succès.');
    }

    public function rejeter(Plainte $plainte)
    {
        $plainte->update(['statut_validation' => 'rejete']);
        return redirect()->route('plaintes.index')
            ->with('succes', 'Plainte rejetée.');
    }

    public function destroy(Plainte $plainte)
    {
        $plainte->delete();
        return redirect()->route('plaintes.index')
            ->with('succes', 'Plainte supprimée avec succès.');
    }
}
