<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Log\Logger as Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->header('Authorization')) {
                $key = explode(' ', $request->header('Authorization'));

                if ($key[0] !== 'Bearer') {
                    return null;
                }
                
                if (!empty($key[1])) {
                    return User::where('api_token', $key[1])->first();
                }
            }

            return null;
        });
    }
}
