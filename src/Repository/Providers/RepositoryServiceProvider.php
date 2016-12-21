<?php
namespace Starter\Repository\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package Starter\Repository\Providers
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
        $this->commands('Starter\Repository\Generators\Commands\RepositoryCommand');
        $this->commands('Starter\Repository\Generators\Commands\TransformerCommand');
        $this->commands('Starter\Repository\Generators\Commands\PresenterCommand');
        $this->commands('Starter\Repository\Generators\Commands\EntityCommand');
        $this->commands('Starter\Repository\Generators\Commands\ValidatorCommand');
        $this->commands('Starter\Repository\Generators\Commands\ControllerCommand');
        $this->commands('Starter\Repository\Generators\Commands\BindingsCommand');
        $this->commands('Starter\Repository\Generators\Commands\CriteriaCommand');
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
