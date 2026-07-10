<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Models\Movie;
use Models\Series;
use Models\Genre;
use Models\Actor;
use Models\Director;
use Models\Country;
use Models\Language;

class SearchController extends Controller
{
    public function index(): void
    {
        $q = trim($this->input('q', ''));
        $type = $this->input('type', 'all');
        $genre = $this->input('genre');
        $actor = $this->input('actor');
        $director = $this->input('director');
        $country = $this->input('country');
        $year = $this->input('year');
        $language = $this->input('language');

        $results = ['movies' => [], 'series' => [], 'genres' => [], 'actors' => [], 'directors' => []];

        if (strlen($q) >= 2) {
            $db = \Core\Database::getInstance();
            $likeQuery = "%{$q}%";
            $results['movies'] = $db->fetchAll(
                "SELECT * FROM movies WHERE status = 'published' AND (title LIKE :q OR original_title LIKE :q) LIMIT 20",
                ['q' => $likeQuery]
            );
            $results['series'] = $db->fetchAll(
                "SELECT * FROM series WHERE status = 'published' AND (title LIKE :q OR original_title LIKE :q) LIMIT 20",
                ['q' => $likeQuery]
            );
        }

        if ($type === 'all' || $type === 'genre') {
            $db = \Core\Database::getInstance();
            $results['genres'] = $db->fetchAll(
                "SELECT * FROM genres WHERE status = 'active' AND name LIKE :q LIMIT 10",
                ['q' => $likeQuery ?? "%{$q}%"]
            );
        }
        if ($type === 'all' || $type === 'actor') {
            $db = \Core\Database::getInstance();
            $results['actors'] = $db->fetchAll(
                "SELECT * FROM actors WHERE status = 'active' AND name LIKE :q LIMIT 10",
                ['q' => $likeQuery ?? "%{$q}%"]
            );
        }
        if ($type === 'all' || $type === 'director') {
            $db = \Core\Database::getInstance();
            $results['directors'] = $db->fetchAll(
                "SELECT * FROM directors WHERE status = 'active' AND name LIKE :q LIMIT 10",
                ['q' => $likeQuery ?? "%{$q}%"]
            );
        }

        $this->view('search.index', [
            'title' => 'Search: ' . e($q),
            'query' => $q,
            'results' => $results
        ]);
    }

    public function suggestions(): void
    {
        $this->json([]);
    }
}
