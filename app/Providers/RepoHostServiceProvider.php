<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\RepoHost;
use App\GithubRepoHost;

class RepoHostServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\RepoHost', function () {
            $service = env('REPOHOSTSERVICE', 'github');

            switch($service) {
                case 'github':
                default:
                    $rh = new GithubRepoHost();
            }

            return $rh;
        });
    }
}
