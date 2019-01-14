<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{

    //protected $API_URL = 'http://localhost:3000/api/1.0/';
    protected $API_URL = 'http://api.amolca.com/';
    //protected $API_URL = 'https://amolca-backend.herokuapp.com/api/1.0/';

    public function boot()
    {
        Blade::directive('COPMoney', function ($money) {
            return "<?php echo '$' . number_format($money, 0, ',', '.'); ?>";
        });

        Schema::defaultStringLength(191);
    }

    public function register()
    {
        $this->app->singleton('GuzzleHttp\Client', function() {
            return $this->client = $client = new Client([
                        'base_uri' => $this->API_URL
                    ]);
        });
    }

    protected function mapApiRoutes(){
        Route::group([
            'middleware' => ['api', 'auth:api'],
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }
}
