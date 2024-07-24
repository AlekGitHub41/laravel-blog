<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class RunApplication extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        ini_set('memory_limit', '-1');
        $directory  = public_path('storage\uploads');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
