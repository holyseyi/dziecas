<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Core\Database;
use Models\Movie;
use Models\Series;
use Models\Genre;
use Models\FeaturedContent;

class HomeController extends Controller
{
    public function index(): void
    {
        $db = Database::getInstance();

        $trendingMovies = $db->fetchAll("SELECT * FROM movies WHERE status = 'published' AND trending = 1 ORDER BY imdb_rating DESC LIMIT 10");
        $trendingSeries = $db->fetchAll("SELECT * FROM series WHERE status = 'published' AND trending = 1 ORDER BY imdb_rating DESC LIMIT 10");
        $featuredMovies = $db->fetchAll("SELECT * FROM movies WHERE status = 'published' AND featured = 1 ORDER BY published_at DESC LIMIT 8");
        $latestMovies = $db->fetchAll("SELECT * FROM movies WHERE status = 'published' ORDER BY published_at DESC LIMIT 12");
        $recentlyUpdatedSeries = $db->fetchAll("SELECT * FROM series WHERE status = 'published' ORDER BY updated_at DESC LIMIT 8");
        $popularThisWeek = $db->fetchAll("SELECT * FROM movies WHERE status = 'published' ORDER BY view_count DESC LIMIT 10");
        $anime = $db->fetchAll("SELECT m.* FROM movies m JOIN movie_genres mg ON m.id = mg.movie_id JOIN genres g ON mg.genre_id = g.id WHERE m.status = 'published' AND g.slug = 'animation' ORDER BY m.published_at DESC LIMIT 8");

        $featured = (new FeaturedContent())->all('sort_order ASC', 5);
        $heroMovie = !empty($featured) ? (new Movie())->find((int)$featured[0]['item_id']) : ($latestMovies[0] ?? []);
        $heroSeries = !empty($featured) ? (new Series())->find((int)$featured[0]['item_id']) : null;

        $genres = (new Genre())->all('sort_order ASC');
        $activeGenres = array_filter($genres, fn($g) => $g['status'] === 'active');

        $this->view('home.index', [
            'title' => 'MovieHub - Watch Latest Movies & TV Series',
            'trendingMovies' => $trendingMovies,
            'trendingSeries' => $trendingSeries,
            'featuredMovies' => $featuredMovies,
            'latestMovies' => $latestMovies,
            'recentlyUpdatedSeries' => $recentlyUpdatedSeries,
            'popularThisWeek' => $popularThisWeek,
            'heroMovie' => $heroMovie,
            'heroSeries' => $heroSeries,
            'genres' => $genres,
            'featuredContent' => $featured
        ]);
    }
}
