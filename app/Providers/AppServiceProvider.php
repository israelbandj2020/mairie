<?php

namespace App\Providers;

use App\Models\Budget;
use App\Models\Deliberation;
use App\Models\DocumentAdministration;
use App\Models\PlanPai;
use App\Models\SessionDocument;
use App\Observers\BudgetObserver;
use App\Observers\DeliberationObserver;
use App\Observers\DocumentAdministrationObserver;
use App\Observers\PlanPaiObserver;
use App\Observers\SessionDocumentObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }
        \Carbon\Carbon::setLocale('fr');

        Gate::define('gerer', function ($user) {
            return $user->estAdmin();
        });

        SessionDocument::observe(SessionDocumentObserver::class);
        Deliberation::observe(DeliberationObserver::class);
        PlanPai::observe(PlanPaiObserver::class);
        Budget::observe(BudgetObserver::class);
        DocumentAdministration::observe(DocumentAdministrationObserver::class);
    }
}
