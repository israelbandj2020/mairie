<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ParametresController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('parametres.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $user->update($validated);

        return redirect()->route('parametres.edit')
            ->with('succes', 'Informations mises à jour avec succès.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('parametres.edit')
            ->with('succes', 'Mot de passe modifié avec succès.');
    }
}
