<?php

namespace LaravelAdminPackage\Routing;

class ResourceRegistrar extends \Illuminate\Routing\ResourceRegistrar
{
    /**
     * The verbs used in the resource URIs.
     *
     * @var array
     */
    protected static $verbs = [
        'create'     => 'create',
        'edit'       => 'edit',
        'datatables' => 'datatables',
    ];

    /**
     * The default actions for a resourceful controller.
     *
     * @var array
     */
    protected $resourceDefaults = ['index', 'create', 'datatables', 'store', 'show', 'edit', 'update', 'destroy'];

    /**
     * Add the datatables method for a resourceful route.
     *
     * @param  string $name
     * @param  string $base
     * @param  string $controller
     * @param  array  $options
     *
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceDatatables($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name) . '/' . static::$verbs['datatables'];

        $action = $this->getResourceAction($name, $controller, 'datatables', $options);

        return $this->router->get($uri, $action);
    }

}
