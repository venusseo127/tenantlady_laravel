<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Factory;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $credentialsPath = config('firebase.credentials.file');
        $credentialsJson = env('FIREBASE_CREDENTIALS_JSON');

        if (!$credentialsPath && !$credentialsJson) {
            return;
        }

        $factory = new Factory;

        if ($credentialsJson) {
            $factory = $factory->withServiceAccount(json_decode(base64_decode($credentialsJson), true));
        } elseif (file_exists($credentialsPath)) {
            $factory = $factory->withServiceAccount($credentialsPath);
        } else {
            return;
        }

        $this->app->singleton('firebase', fn () => $factory->create());
        $this->app->singleton('firebase.auth', fn () => app('firebase')->createAuth());
        $this->app->singleton('firebase.messaging', fn () => app('firebase')->createMessaging());
    }

    public function boot(): void
    {
        //
    }
}
