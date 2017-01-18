<?php

namespace LaravelAdminPackage;

use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use LaravelAdminPackage\Html\Form;
use LaravelAdminPackage\Html\Show;

class ViewHelpersServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->mergeConfigFrom(base_path('vendor/watson/bootstrap-form/src/config/config.php'), 'bootstrap_form');
        $this->publishes([
            base_path('vendor/watson/bootstrap-form/src/config/config.php') => config_path('bootstrap_form.php')
        ], 'template');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCollective();

        $this->registerForm();

        $this->registerShow();
    }

    private function registerCollective()
    {
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        AliasLoader::getInstance()->alias('Html', HtmlFacade::class);
        AliasLoader::getInstance()->alias('Form', FormFacade::class);
    }

    private function registerForm()
    {
        $this->app->singleton('admin_form', function ($app) {
            return new Form($app['html'], $app['form'], $app['config']);
        });
        AliasLoader::getInstance()->alias('AdminShow', Facades\Show::class);
    }

    private function registerShow()
    {
        $this->app->singleton('admin_show', function ($app) {
            return new Show($app['html'], $app['form']);
        });
        AliasLoader::getInstance()->alias('AdminForm', Facades\Form::class);
    }
}
