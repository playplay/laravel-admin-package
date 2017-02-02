<?php

namespace LaravelAdminPackage\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use LaravelAdminPackage\Routing\Router;

class MainServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->extendsRouter();
        $this->registerRoutes();
        $this->registerViewHelpers();
        $this->registerDatatables();
        $this->registerSwal();
        $this->installPackage();
    }

    private function extendsRouter()
    {
        $this->app->singleton('router', function ($app) {
            return new Router($app['events'], $app);
        });
    }

    private function registerRoutes()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    private function registerViewHelpers()
    {
        $this->app->register(ViewHelpersServiceProvider::class);
    }

    private function registerDatatables()
    {
        $this->app->register(\Yajra\Datatables\DatatablesServiceProvider::class);
    }

    private function registerSwal()
    {
        $this->app->register(\UxWeb\SweetAlert\SweetAlertServiceProvider::class);
    }

    private function installPackage()
    {
        $this->app->register(InstallationServiceProvider::class);
    }
}
