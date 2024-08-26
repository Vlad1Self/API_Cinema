<?php

namespace App\Providers;

use App\Contracts\Author\AuthorContract;
use App\Contracts\Genre\GenreContract;
use App\Contracts\Movie\MovieContract;
use App\Contracts\Ticket\TicketContract;
use App\Repository\Author\AuthorRepository;
use App\Repository\Genre\GenreRepository;
use App\Repository\Movie\MovieRepository;
use App\Repository\Ticket\TicketRepository;
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
        $this->app->bind(AuthorContract::class, AuthorRepository::class);
        $this->app->bind(GenreContract::class, GenreRepository::class);
        $this->app->bind(MovieContract::class, MovieRepository::class);
        $this->app->bind(TicketContract::class, TicketRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
