<?php

namespace heshanh\GoFax;

use heshanh\GoFax;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {

        // Setup the soap client
        $this->app->singleton(GoFax\SoapClient::class, function () {
            return (new GoFax\SoapClient())
                ->setToken(config('services.bronto.soapToken'))
                ->setListId(config('services.bronto.listId'));
        });
    }
}
