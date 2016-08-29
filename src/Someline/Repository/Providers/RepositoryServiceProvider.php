<?php
namespace Someline\Repository\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package Someline\Repository\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(base_path('vendor/prettus/l5-repository/src/resources/config/repository.php'), 'repository');

        $this->loadTranslationsFrom(base_path('vendor/prettus/l5-repository/src/resources/lang'), 'repository');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Someline\Repository\Generators\Commands\RepositoryCommand');
        $this->commands('Someline\Repository\Generators\Commands\TransformerCommand');
        $this->commands('Someline\Repository\Generators\Commands\PresenterCommand');
        $this->commands('Someline\Repository\Generators\Commands\EntityCommand');
        $this->commands('Someline\Repository\Generators\Commands\ValidatorCommand');
        $this->commands('Someline\Repository\Generators\Commands\ControllerCommand');
        $this->commands('Someline\Repository\Generators\Commands\BindingsCommand');
        $this->commands('Someline\Repository\Generators\Commands\CriteriaCommand');
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
