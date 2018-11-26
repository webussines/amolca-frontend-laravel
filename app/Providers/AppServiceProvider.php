<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    //protected $API_URL = 'http://localhost:3000/api/1.0';
    protected $API_URL = 'https://amolca-backend.herokuapp.com/api/1.0/';

    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton('GuzzleHttp\Client', function() {
            return $this->client = $client = new Client([
                        'base_uri' => $this->API_URL
                    ]);
        });
    }
}
