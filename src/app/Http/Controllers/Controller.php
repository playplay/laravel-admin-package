<?php

namespace LaravelAdminPackage\App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function authorizeResource($model, $parameter = null, array $options = [], $request = null)
    {
        $parameter = $parameter ?: strtolower(class_basename($model));

        $middleware = [];

        foreach ($this->resourceAbilityMap() as $method => $ability) {
            $modelName = in_array($method, $this->methodsWithoutParameters()) ? $model : $parameter;

            $middleware["can:{$ability},{$modelName}"][] = $method;
        }

        foreach ($middleware as $middlewareName => $methods) {
            $this->middleware($middlewareName, $options)->only($methods);
        }
    }

    protected function resourceAbilityMap()
    {
        return [
            'index'      => 'list',
            'datatables' => 'list',
            'show'       => 'view',
            'create'     => 'create',
            'store'      => 'create',
            'edit'       => 'update',
            'update'     => 'update',
            'destroy'    => 'delete',
        ];
    }

    protected function methodsWithoutParameters()
    {
        return ['index', 'datatables', 'create', 'store'];
    }

    protected function action($method, $parameters = [])
    {
        return action('\\' . static::class . '@' . $method, $parameters);
    }

    protected function ajaxDelete(Model $model)
    {
        if ($model->delete()) {
            return new JsonResponse(['success' => true]);
        }

        abort(500, 'Not deleted!');
    }


}
