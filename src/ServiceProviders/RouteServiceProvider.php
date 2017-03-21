<?php

namespace LaravelAdminPackage\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use LaravelAdminPackage\App\Http\Middleware\CheckIfPolicyIsRegistered;
use LaravelAdminPackage\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /** @var  Router $router */
    private $router;
    private $domain;
    private $path;
    private $namePrefix = 'admin';
    private $middlewares = ['web'];

    public function boot()
    {
        $this->router = app('router');
        $this->path = config('admin.path');
        $this->domain = config('admin.subdomain') ?
            config('admin.subdomain') . '.' . config('app.domain') :
            config('app.domain');

        $this->checkPoliciesInController();
        $this->mapRoutes();
    }

    protected function checkPoliciesInController()
    {
        $middlewareName = 'checkPoliciesInController';
        $this->router->middleware($middlewareName, CheckIfPolicyIsRegistered::class);
        if (config('app.debug')) {
            $this->middlewares[] = $middlewareName;
        }
    }

    protected function mapRoutes()
    {
        $this->router->group([
            'middleware' => $this->middlewares,
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
                'middleware' => ['auth', 'admin'],
            ], function (Router $router) {
                require base_path('routes/admin.php');
            });
        }
    }
}
