<?php

namespace App\Providers;

use App\Repositories\Contracts\AbstractFormRepository;
use App\Repositories\FormRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AbstractFormRepository::class,
            FormRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
