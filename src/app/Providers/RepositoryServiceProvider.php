<?php

namespace App\Providers;

use App\Repositories\{V1\Contracts\AbstractFormRepository, V1\FormRepository};
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
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
