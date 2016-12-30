<?php

namespace MathieuTu\LaravelAdminPackage\Http;

class Kernel extends \Illuminate\Foundation\Http\Kernel
{
    /**
     * Get the route dispatcher callback.
     *
     * @return \Closure
     */
    protected function dispatchToRouter()
    {
        // Reconstruct the kernel and reset the class' router to use our new
        // extended router which got instantiated and bound into the IoC after
        // the default router got set up and bound. This might look kinda odd,
        // but poses no direct consequences.
        parent::__construct($this->app, $this->app->make('router'));

        // Continue as normal
        return parent::dispatchToRouter();
    }
}
