<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Core\Database;
use Models\Genre;
use Models\Category;
use Models\Movie;
use Models\Series;

class CategoryController extends Controller
{
    public function show(string $slug): void
    {
        $category = (new Category())->findBy('slug', $slug);

        if (!$category) {
            $this->view('errors.404', ['title' => 'Not Found']);
            http_response_code(404);
            return;
        }

        $db = Database::getInstance();
        $movies = $db->fetchAll(
            "SELECT * FROM movies WHERE category_id = :cid AND status = 'published' ORDER BY published_at DESC LIMIT 12",
            ['cid' => $category['id']]
        );
        $seriesList = $db->fetchAll(
            "SELECT * FROM series WHERE category_id = :cid AND status = 'published' ORDER BY published_at DESC LIMIT 8",
            ['cid' => $category['id']]
        );

        $this->view('categories.show', [
            'title' => $category['name'] . ' - MovieHub',
            'category' => $category,
            'movies' => $movies,
            'series' => $seriesList
        ]);
    }

    public function anime(): void
    {
        $genre = (new Genre())->findBy('slug', 'animation');
        if ($genre) {
            $this->show($genre['slug']);
        } else {
            $this->view('pages.category', ['title' => 'Anime', 'items' => [], 'type' => 'movie']);
        }
    }

    public function kdramas(): void
    {
        $db = Database::getInstance();
        $movies = $db->fetchAll(
            "SELECT m.* FROM movies m JOIN countries c ON m.country_id = c.id WHERE m.status = 'published' AND c.slug = 'south-korea' ORDER BY m.published_at DESC LIMIT 24"
        );
        $this->view('pages.category', ['title' => 'K-Dramas', 'items' => $movies, 'type' => 'movie']);
    }

    public function nollywood(): void
    {
        $db = Database::getInstance();
        $movies = $db->fetchAll(
            "SELECT m.* FROM movies m JOIN countries c ON m.country_id = c.id WHERE m.status = 'published' AND c.slug = 'nigeria' ORDER BY m.published_at DESC LIMIT 24"
        );
        $this->view('pages.category', ['title' => 'Nollywood Movies', 'items' => $movies, 'type' => 'movie']);
    }

    public function hollywood(): void
    {
        $db = Database::getInstance();
        $movies = $db->fetchAll(
            "SELECT m.* FROM movies m JOIN countries c ON m.country_id = c.id WHERE m.status = 'published' AND c.slug = 'usa' ORDER BY m.published_at DESC LIMIT 24"
        );
        $this->view('pages.category', ['title' => 'Hollywood Movies', 'items' => $movies, 'type' => 'movie']);
    }

    public function bollywood(): void
    {
        $db = Database::getInstance();
        $movies = $db->fetchAll(
            "SELECT m.* FROM movies m JOIN countries c ON m.country_id = c.id WHERE m.status = 'published' AND c.slug = 'india' ORDER BY m.published_at DESC LIMIT 24"
        );
        $this->view('pages.category', ['title' => 'Bollywood Movies', 'items' => $movies, 'type' => 'movie']);
    }

    public function tvShows(): void
    {
        $series = (new Series())->where('status', 'published')->all('published_at DESC', 24);
        $this->view('pages.category', ['title' => 'TV Shows', 'items' => $series, 'type' => 'series']);
    }

    public function documentaries(): void
    {
        $db = Database::getInstance();
        $movies = $db->fetchAll(
            "SELECT m.* FROM movies m JOIN movie_genres mg ON m.id = mg.movie_id JOIN genres g ON mg.genre_id = g.id WHERE m.status = 'published' AND g.slug = 'documentary' ORDER BY m.published_at DESC LIMIT 24"
        );
        $this->view('pages.category', ['title' => 'Documentaries', 'items' => $movies, 'type' => 'movie']);
    }

    public function musicVideos(): void
    {
        $db = Database::getInstance();
        $movies = $db->fetchAll(
            "SELECT * FROM movies WHERE status = 'published' AND type = 'music-video' ORDER BY published_at DESC LIMIT 24"
        );
        $this->view('pages.category', ['title' => 'Music Videos', 'items' => $movies, 'type' => 'movie']);
    }
}
