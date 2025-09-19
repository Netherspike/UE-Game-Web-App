<?php

namespace App\Providers;

use App\Models\Character;
use App\Policies\AccountPolicy;
use App\Policies\CharacterPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PolicyServiceProvider extends ServiceProvider
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
        Gate::define('access_character', [CharacterPolicy::class, 'access']);
        Gate::define('access_account', [AccountPolicy::class, 'access']);
    }
}
