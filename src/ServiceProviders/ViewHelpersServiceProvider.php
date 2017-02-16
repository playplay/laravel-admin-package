<?php

namespace LaravelAdminPackage\ServiceProviders;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class ViewHelpersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(base_path('vendor/watson/bootstrap-form/src/config/config.php'), 'bootstrap_form');
        $this->publishes([
            base_path('vendor/watson/bootstrap-form/src/config/config.php') => config_path('bootstrap_form.php'),
        ], 'template');
    }

    public function register()
    {
        $this->registerCollective();
        $this->registerForm();
        $this->registerShow();
    }

    private function registerCollective()
    {
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        AliasLoader::getInstance()->alias('Html', \Collective\Html\HtmlFacade::class);
        AliasLoader::getInstance()->alias('Form', \Collective\Html\FormFacade::class);
    }

    private function registerForm()
    {
        $this->app->singleton('admin_form', function ($app) {
            return new \LaravelAdminPackage\Html\Form($app['html'], $app['form'], $app['config']);
        });
        AliasLoader::getInstance()->alias('AdminShow', \LaravelAdminPackage\Facades\Show::class);
    }

    private function registerShow()
    {
        $this->app->singleton('admin_show', function ($app) {
            return new \LaravelAdminPackage\Html\Show($app['html'], $app['form']);
        });
        AliasLoader::getInstance()->alias('AdminForm', \LaravelAdminPackage\Facades\Form::class);
    }
}
