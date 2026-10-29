<?php

namespace Tests\Feature;

use App\Services\FichierService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FichierServiceTest extends TestCase
{
    public function test_service_validates_pdf_file()
    {
        Storage::fake('local');
        $service = new FichierService();

        $file = UploadedFile::fake()->create('document.pdf', 1000, 'application/pdf');

        $result = $service->enregistrer($file, 'session_document');

        $this->assertArrayHasKey('chemin', $result);
        $this->assertArrayHasKey('nom_original', $result);
        $this->assertArrayHasKey('mime', $result);
        $this->assertArrayHasKey('taille', $result);

        Storage::disk('local')->assertExists($result['chemin']);
    }

    public function test_service_rejects_invalid_extension()
    {
        Storage::fake('local');
        $service = new FichierService();

        $file = UploadedFile::fake()->create('document.exe', 1000, 'application/x-msdownload');

        $this->expectException(\Exception::class);
        $service->enregistrer($file, 'session_document');
    }
}
