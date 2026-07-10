<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Core\Database;

class YearController extends Controller
{
    public function show(string $year): void
    {
        $db = Database::getInstance();
        $movies = $db->fetchAll(
            "SELECT * FROM movies WHERE status = 'published' AND strftime('%Y', release_date) = :y ORDER BY published_at DESC LIMIT 20",
            ['y' => $year]
        );
        $seriesList = $db->fetchAll(
            "SELECT * FROM series WHERE status = 'published' AND strftime('%Y', release_date) = :y ORDER BY published_at DESC LIMIT 20",
            ['y' => $year]
        );

        $this->view('years.show', [
            'title' => 'Movies from ' . $year,
            'year' => $year,
            'movies' => $movies,
            'series' => $seriesList
        ]);
    }
}
