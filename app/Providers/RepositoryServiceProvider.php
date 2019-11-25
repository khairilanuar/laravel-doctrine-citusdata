<?php

namespace App\Providers;

use App\Contracts\Repositories\UserRepository;
use App\Entities\User;
use App\Repositories\UserRepositoryDoctrine;
use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepository::class, function($app) {
            return new UserRepositoryDoctrine(
                $app['em'],
                $app['em']->getClassMetaData(User::class)
            );
        });
    }
}
