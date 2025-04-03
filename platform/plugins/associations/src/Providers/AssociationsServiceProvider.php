<?php

namespace Botble\Associations\Providers;

use Illuminate\Support\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;

class AssociationsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    protected function loadRoutes()
    {
        if (!$this->app->routesAreCached()) {
            require base_path('platform/plugins/associations/routes/web.php');

        }
    }
    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'plugins.associations');
    }

    public function boot()
    {
        $this->loadRoutes();
        $this->loadViews();
    }
}
