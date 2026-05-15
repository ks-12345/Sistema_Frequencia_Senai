<?php

namespace App\Providers;

use App\Models\Justificativa;
use App\Models\SolicitacaoSaida;
use App\Policies\JustificativaPolicy;
use App\Policies\SolicitacaoSaidaPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::policy(SolicitacaoSaida::class, SolicitacaoSaidaPolicy::class);
        Gate::policy(Justificativa::class, JustificativaPolicy::class);
    }
}
