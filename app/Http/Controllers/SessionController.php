<?php

namespace App\Http\Controllers;

use App\Models\SessionTravail;
use App\Models\SessionDocument;
use App\Services\FichierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function __construct(
        protected FichierService $fichierService
    ) {}

    public function index(Request $request)
    {
        $sessions = SessionTravail::orderBy('date', 'desc')->paginate(20);
        return view('sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'lieu' => 'nullable|string|max:255',
            'statut' => 'required|in:planifiee,en_cours,terminee,annulee',
        ]);

        try {
            $numero = SessionTravail::genererNumero($validated['date']);
        } catch (\Exception $e) {
            return back()->withInput()->with('erreur', $e->getMessage());
        }

        $session = SessionTravail::create([
            'numero' => $numero,
            ...$validated,
            'cree_par' => Auth::id(),
        ]);

        return redirect()->route('sessions.show', $session)
            ->with('succes', 'Session créée avec succès.');
    }

    public function show(SessionTravail $session)
    {
        $session->load('documents');
        return view('sessions.show', compact('session'));
    }

    public function edit(SessionTravail $session)
    {
        return view('sessions.edit', compact('session'));
    }

    public function update(Request $request, SessionTravail $session)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'lieu' => 'nullable|string|max:255',
            'statut' => 'required|in:planifiee,en_cours,terminee,annulee',
        ]);

        $session->update($validated);

        return redirect()->route('sessions.show', $session)
            ->with('succes', 'Session modifiée avec succès.');
    }

    public function destroy(SessionTravail $session)
    {
        $session->delete();

        return redirect()->route('sessions.index')
            ->with('succes', 'Session supprimée avec succès.');
    }

    public function ajouterDocument(Request $request, SessionTravail $session)
    {
        $validated = $request->validate([
            'fichier' => 'required|file|max:10240',
            'type' => 'required|in:ordre_du_jour,ordre_du_jour_valide,compte_rendu,decision',
        ]);

        $infos = $this->fichierService->enregistrer($validated['fichier'], 'session_document');

        SessionDocument::create([
            'session_travail_id' => $session->id,
            'chemin' => $infos['chemin'],
            'nom_original' => $infos['nom_original'],
            'mime' => $infos['mime'],
            'taille' => $infos['taille'],
            'type' => $validated['type'],
            'cree_par' => Auth::id(),
        ]);

        return redirect()->route('sessions.show', $session)
            ->with('succes', 'Document ajouté avec succès.');
    }

    public function supprimerDocument(SessionTravail $session, SessionDocument $document)
    {
        if ($document->session_travail_id !== $session->id) {
            abort(404);
        }

        $document->delete();

        return redirect()->route('sessions.show', $session)
            ->with('succes', 'Document supprimé avec succès.');
    }
}
