<?php

namespace App\Providers;

use App\Contracts\AuthorContract;
use App\Contracts\GenreContract;
use App\Contracts\MovieContract;
use App\Services\AuthorService;
use App\Services\GenreService;
use App\Services\MovieService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthorContract::class, AuthorService::class);
        $this->app->bind(GenreContract::class, GenreService::class);
        $this->app->bind(MovieContract::class, MovieService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
