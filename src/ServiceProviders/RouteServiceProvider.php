<?php

namespace LaravelAdminPackage\ServiceProviders;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LaravelAdminPackage\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    private $router;
    private $domain;
    private $path;
    private $namePrefix = 'admin';
    private $middleware = 'web';

    public function __construct(Application $app)
    {
        $this->router = $app->make('router');
        $this->path = config('admin.path');
        $this->domain = config('admin.subdomain') ?
            config('admin.subdomain') . '.' . config('app.domain') :
            config('app.domain');

        parent::__construct($app);
    }

    public function boot()
    {
        $this->router->group([
            'middleware' => $this->middleware,
            'domain'     => $this->domain,
            'prefix'     => $this->path,
            'as'         => $this->namePrefix . '.',
        ], function () {
            $this->mapAuthRoutes();
            $this->mapAdminRoutes();
        });
    }

    protected function mapAuthRoutes()
    {
        if (config('admin.use_default_auth')) {
            $this->router->group([
                'as'        => 'auth.',
                'namespace' => 'LaravelAdminPackage\App\Http\Controllers',
            ], function (Router $router) {
                $router->auth();
            });
        }
    }

    protected function mapAdminRoutes()
    {
        if (file_exists(base_path('routes/admin.php'))) {
            $this->router->group([
                'namespace'  => 'App\Http\Controllers\Admin',
                'middleware' => 'auth',
            ], function (Router $router) {
                require base_path('routes/admin.php');
            });
        }
    }
}
