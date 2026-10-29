<?php

namespace App\Http\Controllers;

use App\Models\Besoin;
use App\Models\Canton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BesoinController extends Controller
{
    public function index()
    {
        $besoins = Besoin::with('canton')->orderBy('created_at', 'desc')->paginate(20);
        return view('besoins.index', compact('besoins'));
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

        Besoin::create([
            ...$validated,
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
            'canton_id' => 'required|exists:cantons,id',
            'description' => 'required|string',
            'priorite' => 'required|in:haute,moyenne,basse',
            'statut' => 'required|in:en_cours,traite,rejete',
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
}
