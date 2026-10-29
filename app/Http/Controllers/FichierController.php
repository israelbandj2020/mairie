<?php

namespace App\Http\Controllers;

use App\Models\SessionDocument;
use App\Models\Deliberation;
use App\Models\PlanPai;
use App\Models\Budget;
use App\Models\DocumentAdministration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FichierController extends Controller
{
    public function voir(string $type, int $id, Request $request)
    {
        $model = $this->getModel($type, $id);
        $telecharger = $request->query('telecharger') === '1';

        if (!$model || !Storage::disk('local')->exists($model->chemin)) {
            abort(404);
        }

        $file = Storage::disk('local')->get($model->chemin);

        $headers = [
            'Content-Type' => $model->mime,
            'X-Content-Type-Options' => 'nosniff',
        ];

        if ($telecharger) {
            $headers['Content-Disposition'] = 'attachment; filename="' . $model->nom_original . '"';
        } else {
            $headers['Content-Disposition'] = 'inline; filename="' . $model->nom_original . '"';
        }

        return response($file, 200, $headers);
    }

    protected function getModel(string $type, int $id)
    {
        return match ($type) {
            'session-document' => SessionDocument::findOrFail($id),
            'deliberation' => Deliberation::findOrFail($id),
            'pai' => PlanPai::findOrFail($id),
            'budget' => Budget::findOrFail($id),
            'administration' => DocumentAdministration::findOrFail($id),
            default => null,
        };
    }
}
