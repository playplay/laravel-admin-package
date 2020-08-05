<?php

namespace LaravelAdminPackage\App\Http\Middleware;

use App\Providers\AuthServiceProvider;
use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CheckIfPolicyIsRegistered
{
    public static $controllersExceptions = [
        'Closure',
        'LoginController',
        'LogoutController',
        'RegisterController',
        'ForgotPasswordController',
    ];
    protected $policies = [];

    public function __construct(Application $app)
    {
        $this->policies = (new AuthServiceProvider($app))->getPolicies();
    }

    public static function addControllersExceptions($controllerExceptions)
    {
        $controllerExceptions = is_array($controllerExceptions) ? $controllerExceptions : func_get_args();

        self::$controllersExceptions = array_merge(self::$controllersExceptions, $controllerExceptions);
    }

    public function handle(Request $request, Closure $next)
    {
        $modelClassName = $this->getModelClassName($request);

        if ($modelClassName) {
            $this->showMessageIfPolicyIsNotRegistered($modelClassName);
        }

        return $next($request);
    }

    protected function getModelClassName(Request $request): string
    {
        $controllerClassName = $this->getControllerClassName($request);

        if ($this->isInControllersExceptions($controllerClassName)) {
            return false;
        }

        return explode('Controller', $controllerClassName)[0];
    }

    protected function getControllerClassName(Request $request): string
    {
        return class_basename($request->route()->getActionName());
    }

    protected function isInControllersExceptions(string $controllerClassName): bool
    {
        return collect(self::$controllersExceptions)->contains(function ($exception) use ($controllerClassName) {
            return str_contains($controllerClassName, $exception);
        });
    }

    protected function showMessageIfPolicyIsNotRegistered($modelClassName)
    {
        if (!$this->isTherePolicyWhoseNameContains($modelClassName)) {
            dump("Attention, {$modelClassName}Policy n'a pas été ajoutée à " . \App\Providers\AuthServiceProvider::class . "::\$policies : problèmes à prévoir pour les permissions..!");
        }
    }

    protected function isTherePolicyWhoseNameContains(string $needle): bool
    {
        return collect($this->policies)->contains(function ($policy) use ($needle) {
            return str_contains($policy, $needle . 'Policy');
        });
    }
}
