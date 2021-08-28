<?php

namespace App\Providers;

use App\Repository\Business\KidClassRepository;
use App\Repository\Business\KidRepository;
use App\Repository\Business\UserRepository;
use App\Repository\Contract\KidClassInterface;
use App\Repository\Contract\KidInterface;
use App\Repository\Contract\UserInterface;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(KidInterface::class,KidRepository::class);
        $this->app->bind(KidClassInterface::class,KidClassRepository::class);
        $this->app->bind(UserInterface::class,UserRepository::class);
    }
}
