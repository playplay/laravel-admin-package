<?php

namespace LaravelAdminPackage\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class InstallationServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishPackageFiles();
        $this->publishesTemplateFiles();
        $this->loadViewsAndConfig();
    }

    private function publishPackageFiles()
    {
        // publish config file
        $this->publishes([$this->packagePath('/config') => config_path()], 'config');

        // publish examples file
        $this->publishes([$this->packagePath('/examples', true) => base_path()], 'examples');

        // publish lang files
        $this->publishes([$this->packagePath('/resources/lang') => resource_path('lang/')], 'lang');

        // publish views
        $this->publishes([$this->packagePath('/resources/views') => resource_path('views/admin/')], 'views');

        // publish admin assets
        $this->publishes([$this->packagePath('/public') => public_path('admin')], 'public');
    }

    private function publishesTemplateFiles($group = 'template')
    {
        $this->publishes([
            base_path('vendor/almasaeed2010/adminlte/dist/js')  => public_path('admin/vendor/adminlte/js'),
            base_path('vendor/almasaeed2010/adminlte/dist/css') => public_path('admin/vendor/adminlte/css'),
        ], $group);

        $this->publishes([
            base_path('vendor/almasaeed2010/adminlte/bootstrap/') => public_path('admin/vendor/bootstrap/'),
        ], $group);

        $this->publishes([
            $this->packagePath('/public/vendor/swal/') => public_path('admin/vendor/swal'),
        ], $group);

        $this->publishes([
            base_path('vendor/fortawesome/font-awesome/css')   => public_path('admin/vendor/fa/css'),
            base_path('vendor/fortawesome/font-awesome/fonts') => public_path('admin/vendor/fa/fonts'),
        ], $group);

        $this->publishes([
            base_path('vendor/almasaeed2010/adminlte/plugins/') => public_path('admin/vendor/plugins/'),
        ], $group);
    }

    private function loadViewsAndConfig()
    {
        // - first the published views (in case they have any changes)
        $this->loadViewsFrom(resource_path('views/admin'), 'admin');

        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom($this->packagePath('/resources/views'), 'admin');

        // use the vendor configuration file as fallback
        $this->mergeConfigFrom($this->packagePath('/config/admin.php'), 'admin');
    }

    private function packagePath($path = '', $root = false)
    {
        return __DIR__ . '/../' . ($root ? '../' : '') . trim($path, '/');
    }
}
