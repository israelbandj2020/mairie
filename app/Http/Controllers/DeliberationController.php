<?php

namespace App\Http\Controllers;

use App\Models\Deliberation;
use App\Models\SessionTravail;
use App\Services\FichierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliberationController extends Controller
{
    public function __construct(
        protected FichierService $fichierService
    ) {}

    public function index()
    {
        $deliberations = Deliberation::with('session')->orderBy('date', 'desc')->paginate(20);
        return view('deliberations.index', compact('deliberations'));
    }

    public function create()
    {
        $sessions = SessionTravail::orderBy('date', 'desc')->get();
        return view('deliberations.create', compact('sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_enregistrement' => 'required|string|max:50',
            'session_travail_id' => 'required|exists:sessions_travail,id',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'fichier' => 'required|file|max:10240',
        ]);

        $infos = $this->fichierService->enregistrer($validated['fichier'], 'deliberation');

        Deliberation::create([
            'numero_enregistrement' => $validated['numero_enregistrement'],
            'session_travail_id' => $validated['session_travail_id'],
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'chemin' => $infos['chemin'],
            'nom_original' => $infos['nom_original'],
            'mime' => $infos['mime'],
            'taille' => $infos['taille'],
            'cree_par' => Auth::id(),
        ]);

        return redirect()->route('deliberations.index')
            ->with('succes', 'Délibération ajoutée avec succès.');
    }

    public function show(Deliberation $deliberation)
    {
        $deliberation->load('session', 'creePar');
        return view('deliberations.show', compact('deliberation'));
    }

    public function destroy(Deliberation $deliberation)
    {
        $deliberation->delete();
        return redirect()->route('deliberations.index')
            ->with('succes', 'Délibération supprimée avec succès.');
    }
}
