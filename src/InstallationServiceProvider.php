<?php

namespace MathieuTu\LaravelAdminPackage;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class InstallationServiceProvider extends ServiceProvider
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
        $configPath = __DIR__ . '/config';

        $this->publishFiles($configPath);
        $this->loadViewsAndConfig($configPath);
        $this->setupRoutes($router);
    }

    /**
     * @param $configPath
     */
    private function publishFiles($configPath)
    {
        // publish config file
        $this->publishes([$configPath => config_path()], 'config');

        // publish examples file
        $this->publishes([__DIR__ . '/../examples' => base_path()], 'examples');

        // publish lang files
        $this->publishes([__DIR__ . '/resources/lang' => resource_path('lang/')], 'lang');

        // publish views
        $this->publishes([__DIR__ . '/resources/views' => resource_path('views/admin/')], 'views');

        // publish public AdminLTE and Bootstrap assets
        $this->publishesTemplate();

        // publish admin assets
        $this->publishes([__DIR__ . '/public' => public_path('admin')], 'public');
    }

    private function publishesTemplate()
    {
        $this->publishes([
            base_path('vendor/almasaeed2010/adminlte/dist/js')  => public_path('vendor/adminlte/js'),
            base_path('vendor/almasaeed2010/adminlte/dist/css') => public_path('vendor/adminlte/css'),
        ], 'template');

        $this->publishes([
            base_path('vendor/almasaeed2010/adminlte/bootstrap/js')  => public_path('vendor/bootstrap/js'),
            base_path('vendor/almasaeed2010/adminlte/bootstrap/css') => public_path('vendor/bootstrap/css'),
        ], 'template');

        $this->publishes([
            base_path(__DIR__ . '/public/vendor/swal/') => public_path('vendor/swal'),
        ], 'template');

        $this->publishes([
            base_path('vendor/almasaeed2010/adminlte/plugins/') => public_path('vendor/plugins/'),
        ], 'template');
    }

    /**
     * @param $configPath
     */
    private function loadViewsAndConfig($configPath)
    {
        // - first the published views (in case they have any changes)
        $this->loadViewsFrom(resource_path('views/admin'), 'admin');

        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom(realpath(__DIR__ . '/resources/views'), 'admin');

        // use the vendor configuration file as fallback
        $this->mergeConfigFrom($configPath . '/admin.php', 'admin');
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    private function setupRoutes(Router $router)
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
            if (config('admin.use_default_auth')) {
                $router->group([
                    'as'        => 'auth.',
                    'namespace' => 'MathieuTu\LaravelAdminPackage\app\Http\Controllers',
                ], function (Router $router) {
                    $router->auth();
                });
            }
            if (file_exists(base_path('routes/admin.php'))) {
                require base_path('routes/admin.php');
            }
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('router', function ($app) {
            return new \MathieuTu\LaravelAdminPackage\Routing\Router($app['events'], $app);
        });
    }
}
