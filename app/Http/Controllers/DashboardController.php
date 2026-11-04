<?php

namespace App\Http\Controllers;

use App\Models\SessionTravail;
use App\Models\Deliberation;
use App\Models\PlanPai;
use App\Models\Budget;
use App\Models\Besoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->estAdmin();

        $anneeCourante = date('Y');

        $stats = [
            'sessions' => SessionTravail::count(),
            'sessions_annee' => SessionTravail::whereYear('date', $anneeCourante)->count(),
            'sessions_terminees' => SessionTravail::where('statut', 'terminee')->count(),
            'deliberations' => Deliberation::count(),
            'pai' => PlanPai::count(),
            'budgets' => Budget::count(),
            'besoins' => Besoin::count(),
            'besoins_traites' => Besoin::where('statut', 'traite')->count(),
        ];

        $comptesEnAttente = 0;
        if ($isAdmin) {
            $comptesEnAttente = \App\Models\User::where('statut', 'en_attente')->count();
        }

        $prochaineSession = SessionTravail::where('statut', 'planifiee')
            ->where('date', '>=', now())
            ->orderBy('date')
            ->first();

        $derniereSession = SessionTravail::where('statut', 'terminee')
            ->orderBy('date', 'desc')
            ->first();

        return view('dashboard', [
            'user' => $user,
            'isAdmin' => $isAdmin,
            'comptesEnAttente' => $comptesEnAttente,
            'stats' => $stats,
            'prochaineSession' => $prochaineSession,
            'derniereSession' => $derniereSession,
            'anneeCourante' => $anneeCourante,
        ]);
    }
}
