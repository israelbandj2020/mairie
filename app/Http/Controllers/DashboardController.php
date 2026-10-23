<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $comptesEnAttente = 0;

        if ($user->estAdmin()) {
            $comptesEnAttente = \App\Models\User::where('statut', 'en_attente')->count();
        }

        return view('dashboard', [
            'user' => $user,
            'comptesEnAttente' => $comptesEnAttente,
        ]);
    }
}
