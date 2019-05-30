<?php

namespace App\Providers;

use App\Http\Controllers\Auth\Services\GoogleController;
use App\Http\Controllers\Auth\Services\GoogleUser;
use App\Http\Controllers\Auth\Services\ContractLogin;
use App\Http\Controllers\Auth\Services\ContractUser;
use App\Http\Controllers\Auth\UserRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->app->bind( ContractUser::class, GoogleUser::class );
        $this->app->bind( ContractLogin::class, GoogleController::class );
    }
}
