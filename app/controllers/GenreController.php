<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Core\Database;
use Models\Genre;
use Models\Movie;
use Models\Series;

class GenreController extends Controller
{
    public function show(string $slug): void
    {
        $genre = (new Genre())->findBy('slug', $slug);

        if (!$genre) {
            $this->view('errors.404', ['title' => 'Not Found']);
            http_response_code(404);
            return;
        }

        $db = Database::getInstance();
        $movies = $db->fetchAll(
            "SELECT m.* FROM movies m JOIN movie_genres mg ON m.id = mg.movie_id WHERE mg.genre_id = :gid AND m.status = 'published' ORDER BY m.published_at DESC LIMIT 20",
            ['gid' => $genre['id']]
        );

        $seriesList = $db->fetchAll(
            "SELECT s.* FROM series s JOIN movie_genres mg ON s.id = mg.series_id WHERE mg.genre_id = :gid AND s.status = 'published' ORDER BY s.published_at DESC LIMIT 20",
            ['gid' => $genre['id']]
        );

        $this->view('genres.show', [
            'title' => $genre['name'] . ' - MovieHub',
            'genre' => $genre,
            'movies' => $movies,
            'series' => $seriesList
        ]);
    }
}
