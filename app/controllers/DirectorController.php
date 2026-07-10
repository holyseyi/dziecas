<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Models\Director;
use Models\Movie;
use Models\Series;

class DirectorController extends Controller
{
    public function show(string $slug): void
    {
        $director = (new Director())->findBy('slug', $slug);
        if (!$director) {
            $this->view('errors.404', ['title' => 'Not Found']);
            http_response_code(404);
            return;
        }

        $movies = (new Movie())->where('director_id', (int)$director['id'])->where('status', 'published')->all('published_at DESC', 20);
        $seriesList = (new Series())->where('director_id', (int)$director['id'])->where('status', 'published')->all('published_at DESC', 20);

        $this->view('directors.show', [
            'title' => $director['name'] . ' - MovieHub',
            'director' => $director,
            'movies' => $movies,
            'series' => $seriesList
        ]);
    }
}
