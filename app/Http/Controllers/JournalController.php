<?php

namespace App\Http\Controllers;

use App\Models\JournalActivite;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $activites = JournalActivite::with('utilisateur')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('journal.index', compact('activites'));
    }
}
