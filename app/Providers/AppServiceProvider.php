<?php

namespace App\Providers;

use App\Repositories\Contract\RoleRepositoryInterface;
use App\Repositories\SQL\RoleRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(RoleRepositoryInterface::class,RoleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
