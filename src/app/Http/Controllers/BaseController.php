<?php

namespace LaravelAdminPackage\App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as LaravelController;
use LaravelAdminPackage\App\Http\Middleware\CheckIfPolicyIsRegistered;
use LaravelAdminPackage\App\Models\BaseModel;

abstract class BaseController extends LaravelController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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

    protected function resourceMethodsWithoutModels()
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

    protected function alertUpdateSuccess(BaseModel $model, $title = null, $body = null)
    {
        $title = $title !== null ? (is_callable($title) ? $title($model) : $title) : 'C\'est tout bon !';
        $body = $body !== null
            ? (is_callable($body) ? $body($model) : $body)
            : '<strong>' . $model->getTitle() . '</strong> a été modifié(e) avec succés.';

        return $this->alertSuccess($title, $body);
    }

    protected function alertSuccess($title, $body)
    {
        return alert()->success($body, $title)->html()->confirmButton()->autoclose(7000);
    }

    protected function alertStoreSuccess(BaseModel $model, $title = null, $body = null)
    {
        $title = $title !== null ? (is_callable($title) ? $title($model) : $title) : 'C\'est tout bon !';
        $body = $body !== null
            ? (is_callable($body) ? $body($model) : $body)
            : '<strong>' . $model->getTitle() . '</strong> a été créé(e) avec succés.';

        return $this->alertSuccess($title, $body);
    }

    protected function disableWarningMessageForPolicy()
    {
        CheckIfPolicyIsRegistered::addControllersExceptions(class_basename($this));
    }

}
