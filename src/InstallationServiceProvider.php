<?php

namespace LaravelAdminPackage;

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

    private function publishesTemplate($group = 'template')
    {
        $this->publishes([
            base_path('vendor/almasaeed2010/adminlte/dist/js')  => public_path('vendor/adminlte/js'),
            base_path('vendor/almasaeed2010/adminlte/dist/css') => public_path('vendor/adminlte/css'),
        ], $group);

        $this->publishes([
            base_path('vendor/almasaeed2010/adminlte/bootstrap/') => public_path('vendor/bootstrap/'),
        ], $group);

        $this->publishes([
            __DIR__ . '/public/vendor/swal/' => public_path('vendor/swal'),
        ], $group);

        $this->publishes([
            base_path('vendor/fortawesome/font-awesome/css')   => public_path('vendor/fa/css'),
            base_path('vendor/fortawesome/font-awesome/fonts') => public_path('vendor/fa/fonts'),
        ], $group);

        $this->publishes([
            base_path('vendor/almasaeed2010/adminlte/plugins/') => public_path('vendor/plugins/'),
        ], $group);
    }

    /**
     * @param $configPath
     */
    private function loadViewsAndConfig($configPath)
    {
        // - first the published views (in case they have any changes)
        $this->loadViewsFrom(resource_path('views/admin'), 'admin');

        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'admin');

        // use the vendor configuration file as fallback
        $this->mergeConfigFrom($configPath . '/admin.php', 'admin');
    }

    /**
     * Define the routes for the application.
     *
     *
     * @param \Illuminate\Routing\Router | \LaravelAdminPackage\Routing\Router $router
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
                    'namespace' => 'LaravelAdminPackage\App\Http\Controllers',
                ], function (Router $router) {
                    $router->auth();
                });
            }
            if (file_exists(base_path('routes/admin.php'))) {
                $router->group([
                    'namespace'  => 'App\Http\Controllers\Admin',
                    'middleware' => 'auth',
                ], function (Router $router) {
                    require base_path('routes/admin.php');
                });
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
            return new Routing\Router($app['events'], $app);
        });
    }
}
