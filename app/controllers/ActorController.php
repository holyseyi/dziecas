<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Models\Actor;
use Models\Movie;
use Models\Series;

class ActorController extends Controller
{
    public function show(string $slug): void
    {
        $actor = (new Actor())->findBy('slug', $slug);
        if (!$actor) {
            $this->view('errors.404', ['title' => 'Not Found']);
            http_response_code(404);
            return;
        }

        $movies = (new Movie())->fetchAll(
            "SELECT m.* FROM movies m JOIN actor_movies am ON m.id = am.movie_id WHERE am.actor_id = :aid AND m.status = 'published' LIMIT 20",
            ['aid' => $actor['id']]
        );

        $seriesList = (new Series())->fetchAll(
            "SELECT s.* FROM series s JOIN actor_movies am ON s.id = am.series_id WHERE am.actor_id = :aid AND s.status = 'published' LIMIT 20",
            ['aid' => $actor['id']]
        );

        $this->view('actors.show', [
            'title' => $actor['name'] . ' - MovieHub',
            'actor' => $actor,
            'movies' => $movies,
            'series' => $seriesList
        ]);
    }
}
