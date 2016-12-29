<?php

namespace MathieuTu\LaravelAdminPackage;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class LaravelAdminPackageServiceProvider extends ServiceProvider
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
        // LOAD THE VIEWS
        // - first the published views (in case they have any changes)
        $this->loadViewsFrom(resource_path('views/admin'), 'admin');
        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom(realpath(__DIR__ . '/resources/views'), 'admin');

        // use the vendor configuration file as fallback
        $this->mergeConfigFrom(
            __DIR__ . '/config/admin.php', 'admin'
        );

        $this->setupRoutes($router);

        // PUBLISH FILES
        // publish config file
        $this->publishes([__DIR__ . '/config' => config_path()], 'config');
        // publish route file
        $this->publishes([__DIR__ . '/routes' => app_path('routes/')], 'config');
        // publish views
        $this->publishes([__DIR__ . '/resources/views' => resource_path('views/admin/')], 'views');
        // publish public AdminLTE assets
        $this->publishes([base_path('vendor/almasaeed2010/adminlte/dist') => public_path('vendor/adminlte')], 'adminlte');
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $domain = config('admin.subdomain') ?
            config('admin.subdomain') . '.' . config('app.domain') :
            config('app.domain');


        $router->group([
            'middleware' => 'web',
            'domain'     => $domain,
            'prefix'     => config('admin.path'),
            'as'         => 'admin.',
        ], function (Router $router) {
            $router->group([
                'as'        => 'auth.',
                'namespace' => 'MathieuTu\LaravelAdminPackage\app\Http\Controllers',
            ], function (Router $router) {
                $router->auth();
            });
            require app_path('routes/admin.php');
        });

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {

    }
}
