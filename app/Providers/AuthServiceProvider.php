<?php

namespace App\Providers;

use App\Models\Property;
use App\Models\PropertyPreference;
use App\Policies\PropertyPolicy;
use App\Policies\PropertyPreferencePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Property::class => PropertyPolicy::class,
        PropertyPreference::class => PropertyPreferencePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
