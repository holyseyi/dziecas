<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Core\Database;
use Models\Country;
use Models\Movie;
use Models\Series;

class CountryController extends Controller
{
    public function show(string $slug): void
    {
        $country = (new Country())->findBy('slug', $slug);

        if (!$country) {
            $this->view('errors.404', ['title' => 'Not Found']);
            http_response_code(404);
            return;
        }

        $db = Database::getInstance();
        $movies = $db->fetchAll(
            "SELECT * FROM movies WHERE country_id = :cid AND status = 'published' ORDER BY published_at DESC LIMIT 20",
            ['cid' => $country['id']]
        );
        $seriesList = $db->fetchAll(
            "SELECT * FROM series WHERE country_id = :cid AND status = 'published' ORDER BY published_at DESC LIMIT 20",
            ['cid' => $country['id']]
        );

        $this->view('countries.show', [
            'title' => $country['name'] . ' Movies - MovieHub',
            'country' => $country,
            'movies' => $movies,
            'series' => $seriesList
        ]);
    }
}
