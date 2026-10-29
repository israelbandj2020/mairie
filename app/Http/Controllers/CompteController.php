<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CompteController extends Controller
{
    public function index()
    {
        $comptes = User::orderBy('created_at', 'desc')->paginate(20);
        return view('comptes.index', compact('comptes'));
    }

    public function valider(User $user)
    {
        $user->update([
            'statut' => 'valide',
            'valide_le' => now(),
            'valide_par' => auth()->id(),
        ]);

        return redirect()->route('comptes.index')
            ->with('succes', 'Compte validé avec succès.');
    }

    public function suspendre(User $user)
    {
        $user->update(['statut' => 'suspendu']);

        return redirect()->route('comptes.index')
            ->with('succes', 'Compte suspendu avec succès.');
    }

    public function reactiver(User $user)
    {
        $user->update(['statut' => 'valide']);

        return redirect()->route('comptes.index')
            ->with('succes', 'Compte réactivé avec succès.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('comptes.index')
            ->with('succes', 'Compte supprimé avec succès.');
    }
}
