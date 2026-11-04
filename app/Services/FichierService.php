<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FichierService
{
    public function __construct()
    {
        // S'assurer que le dossier private existe
        if (!Storage::disk('local')->exists('')) {
            Storage::disk('local')->makeDirectory('');
        }
    }

    /**
     * Valide et enregistre un fichier
     */
    public function enregistrer(UploadedFile $file, string $type, string $disk = 'local'): array
    {
        $config = $this->getConfig($type);

        $this->valider($file, $config);

        $nomOriginal = $file->getClientOriginalName();
        $nomAleatoire = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $chemin = $file->storeAs('', $nomAleatoire, $disk);

        return [
            'chemin' => $chemin,
            'nom_original' => $nomOriginal,
            'mime' => $file->getMimeType(),
            'taille' => $file->getSize(),
        ];
    }

    /**
     * Remplace un fichier existant
     */
    public function remplacer(string $ancienChemin, UploadedFile $nouveauFichier, string $type): array
    {
        $this->supprimer($ancienChemin);
        return $this->enregistrer($nouveauFichier, $type);
    }

    /**
     * Supprime un fichier du disque
     */
    public function supprimer(string $chemin): void
    {
        if (Storage::disk('local')->exists($chemin)) {
            Storage::disk('local')->delete($chemin);
        }
    }

    /**
     * Valide un fichier selon le type
     */
    protected function valider(UploadedFile $file, array $config): void
    {
        // Vérifier l'extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $config['extensions'])) {
            throw new \InvalidArgumentException("Le fichier doit être de type : " . implode(', ', $config['extensions']));
        }

        // Vérifier le MIME type réel
        $mime = $file->getMimeType();
        if (!in_array($mime, $config['mime_types'])) {
            throw new \InvalidArgumentException("Le type MIME du fichier n'est pas autorisé.");
        }

        // Vérifier la taille
        if ($file->getSize() > $config['max_size']) {
            $maxMo = round($config['max_size'] / 1024 / 1024, 0);
            throw new \InvalidArgumentException("Le fichier doit faire moins de {$maxMo} Mo.");
        }
    }

    /**
     * Récupère la configuration pour un type de fichier
     */
    protected function getConfig(string $type): array
    {
        return match ($type) {
            'session_document', 'deliberation' => [
                'extensions' => config('conseil.pdf'),
                'mime_types' => config('conseil.mime_types.pdf'),
                'max_size' => config('conseil.session_document_max'),
            ],
            'pai', 'budget', 'administration' => [
                'extensions' => config('conseil.pdf'),
                'mime_types' => config('conseil.mime_types.pdf'),
                'max_size' => config('conseil.pai_max'),
            ],
            'photo' => [
                'extensions' => config('conseil.image'),
                'mime_types' => config('conseil.mime_types.image'),
                'max_size' => config('conseil.photo_max'),
            ],
            default => throw new \InvalidArgumentException("Type de fichier inconnu : {$type}"),
        };
    }

    /**
     * Récupère le chemin complet d'un fichier
     */
    public function cheminComplet(string $chemin): string
    {
        return Storage::disk('local')->path($chemin);
    }
}
