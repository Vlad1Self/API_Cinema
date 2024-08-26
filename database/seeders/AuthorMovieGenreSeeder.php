<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorMovieGenreSeeder extends Seeder
{
    public function run()
    {
        $authors = Author::all();
        $genres = Genre::all();
        $movies = Movie::all();

        foreach ($movies as $movie) {
            if ($movie->authors()->count() == 0) {
                $randomAuthors = $authors->random(rand(1, 3));
                $movie->authors()->attach($randomAuthors->pluck('id')->toArray());
            }

            if ($movie->genres()->count() == 0) {
                $randomGenres = $genres->random(rand(1, 3));
                $movie->genres()->attach($randomGenres->pluck('id')->toArray());
            }
        }
    }
}
