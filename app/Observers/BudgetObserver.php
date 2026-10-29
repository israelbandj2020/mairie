<?php

namespace App\Observers;

use App\Models\Budget;
use App\Services\FichierService;

class BudgetObserver
{
    public function __construct(
        protected FichierService $fichierService
    ) {}

    public function deleted(Budget $budget): void
    {
        $this->fichierService->supprimer($budget->chemin);
    }
}
