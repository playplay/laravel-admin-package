<?php

namespace LaravelAdminPackage\App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as LaravelController;
use LaravelAdminPackage\App\Models\BaseModel;

abstract class BaseController extends LaravelController
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

    protected function ajaxDelete(BaseModel $model)
    {
        if ($model->delete()) {
            return new JsonResponse(['success' => true]);
        }

        abort(500, 'Not deleted!');
    }

    protected function alertSuccess(BaseModel $model, $title = null, $body = null)
    {
        $title = $title !== null ? (is_callable($title) ? $title($model) : $title) : 'C\'est tout bon !';
        $body = $body !== null
            ? (is_callable($body) ? $body($model) : $body)
            : '<strong>' . $model->getTitle() . '</strong> a été modifié avec succés.';

        return alert()->success($body, $title)
            ->html()->confirmButton()->autoclose(7000);
    }

}
