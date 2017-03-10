<?php

namespace LaravelAdminPackage\ServiceProviders;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class ViewHelpersServiceProvider extends ServiceProvider
{
    public function boot(ViewFactory $viewFactory)
    {
        $this->mergeConfigFrom(base_path('vendor/watson/bootstrap-form/src/config/config.php'), 'bootstrap_form');
        $this->publishes([
            base_path('vendor/watson/bootstrap-form/src/config/config.php') => config_path('bootstrap_form.php'),
        ], 'template');

        $this->addViewComposers($viewFactory);
    }

    private function addViewComposers(ViewFactory $factory)
    {
        $factory->composer(['admin::partials.datatables'], function (View $view) {
            $columns = collect($view->getData()['columns'])
                ->map(function ($attribute, $key) {
                    if (is_string($key) && is_array($attribute)) {
                        $parameters = $attribute;
                        $attribute = $key;
                    }

                    return array_merge(['data' => $attribute, 'name' => $attribute], ($parameters ?? []));
                })->values();

            $config = $view->getData()['config'];
            if (isset($config['has_actions']) && $config['has_actions']) {
                $columns = $columns->merge([[
                    'data'       => 'actions',
                    'name'       => 'actions',
                    'searchable' => false,
                    'orderable'  => false,
                ]]);
            }

            return $view->with([
                'columnsNames' => $columns->pluck('data'),
                'columnsJson' => $columns->toJson(),
            ]);
        });
    }

    public function register()
    {
        $this->registerCollective();
        $this->registerForm();
        $this->registerShow();
    }

    private function registerCollective()
    {
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        AliasLoader::getInstance()->alias('Html', \Collective\Html\HtmlFacade::class);
        AliasLoader::getInstance()->alias('Form', \Collective\Html\FormFacade::class);
    }

    private function registerForm()
    {
        $this->app->singleton('admin_form', function ($app) {
            return new \LaravelAdminPackage\Html\Form($app['html'], $app['form'], $app['config']);
        });
        AliasLoader::getInstance()->alias('AdminShow', \LaravelAdminPackage\Facades\Show::class);
    }

    private function registerShow()
    {
        $this->app->singleton('admin_show', function ($app) {
            return new \LaravelAdminPackage\Html\Show($app['html'], $app['form'], app(Gate::class));
        });
        AliasLoader::getInstance()->alias('AdminForm', \LaravelAdminPackage\Facades\Form::class);
    }
}
