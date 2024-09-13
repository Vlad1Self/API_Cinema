<?php

namespace App\Providers;

use App\Contracts\Author\AuthorContract;
use App\Contracts\Genre\GenreContract;
use App\Contracts\Movie\MovieContract;
use App\Contracts\Payment\PaymentContract;
use App\Contracts\PaymentMethod\PaymentMethodContract;
use App\Contracts\Ticket\TicketContract;
use App\Models\Ticket;
use App\Repository\Author\AuthorRepository;
use App\Repository\Genre\GenreRepository;
use App\Repository\Movie\MovieRepository;
use App\Repository\Payment\PaymentRepository;
use App\Repository\PaymentMethod\PaymentMethodRepository;
use App\Repository\Ticket\TicketRepository;
use App\Services\AuthorService;
use App\Services\Events\PaymentFailure;
use App\Services\Events\PaymentSuccess;
use App\Services\GenreService;
use App\Services\Listeners\ChangePaymentStatus;
use App\Services\MovieService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        $this->app->bind(PaymentContract::class, PaymentRepository::class);
        $this->app->bind(PaymentMethodContract::class, PaymentMethodRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'Ticket' => Ticket::class,
        ]);

        Event::listen(
            PaymentSuccess::class,
            ChangePaymentStatus::class,
        );

        Event::listen(
            PaymentFailure::class,
            ChangePaymentStatus::class,
        );
    }
}
