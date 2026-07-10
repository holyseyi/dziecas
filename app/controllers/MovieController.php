<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Models\Movie;
use Models\Category;
use Models\Genre;
use Models\Country;
use Models\Director;
use Models\Actor;
use Models\Rating;
use Models\Comment;
use Models\Bookmark;
use Models\DownloadLink;
use Models\StreamingLink;
use Models\Screenshot;

class MovieController extends Controller
{
    public function index(): void
    {
        $page = (int)($this->input('page', 1));
        $perPage = PER_PAGE;
        $sort = $this->input('sort', 'latest');
        $genre = $this->input('genre');
        $country = $this->input('country');
        $year = $this->input('year');
        $category = $this->input('category');

        $movieModel = new Movie();
        $where = "status = 'published'";
        $params = [];

        if ($genre) {
            $where .= " AND id IN (SELECT movie_id FROM movie_genres WHERE genre_id = (SELECT id FROM genres WHERE slug = :genre))";
            $params['genre'] = $genre;
        }
        if ($country) {
            $where .= " AND country_id = (SELECT id FROM countries WHERE slug = :country)";
            $params['country'] = $country;
        }
        if ($year) {
            $where .= " AND strftime('%Y', release_date) = :year";
            $params['year'] = (string)$year;
        }
        if ($category) {
            $where .= " AND category_id = (SELECT id FROM categories WHERE slug = :category)";
            $params['category'] = $category;
        }

        $orderBy = match ($sort) {
            'popular' => 'view_count DESC',
            'trending' => 'user_rating DESC',
            'title' => 'title ASC',
            default => 'published_at DESC'
        };

        $results = $movieModel->paginate($page, $perPage, $orderBy, $where, $params);

        $this->configPageTitle('All Movies');
        $this->view('movies.index', [
            'title' => 'All Movies',
            'movies' => $results['items'],
            'pagination' => $results
        ]);
    }

    public function show(string $slug): void
    {
        $movieModel = new Movie();
        $movie = $movieModel->findBy('slug', $slug);

        if (!$movie || ($movie['status'] !== 'published' && !$this->isAdmin())) {
            $this->view('errors.404', ['title' => 'Not Found']);
            http_response_code(404);
            return;
        }

        $movieModel->query("UPDATE movies SET view_count = view_count + 1 WHERE id = :id", ['id' => $movie['id']]);

        $categoryModel = new Category();
        $movie['category'] = $movie['category_id'] ? $categoryModel->find((int)$movie['category_id']) : null;

        $countryModel = new Country();
        $movie['country'] = $movie['country_id'] ? $countryModel->find((int)$movie['country_id']) : null;

        $languageModel = new Language();
        $movie['language'] = $movie['language_id'] ? $languageModel->find((int)$movie['language_id']) : null;

        $directorModel = new Director();
        $movie['director'] = $movie['director_id'] ? $directorModel->find((int)$movie['director_id']) : null;

        $genreModel = new Genre();
        $genres = $genreModel->where('status', 'active');
        $movie['genres'] = $genreModel->fetchAll(
            "SELECT g.* FROM genres g JOIN movie_genres mg ON g.id = mg.genre_id WHERE mg.movie_id = :id",
            ['id' => $movie['id']]
        );

        $actorModel = new Actor();
        $movie['actors'] = $actorModel->fetchAll(
            "SELECT a.*, am.role, am.character_name FROM actors a JOIN actor_movies am ON a.id = am.actor_id WHERE am.movie_id = :id ORDER BY am.cast_order ASC",
            ['id' => $movie['id']]
        );

        $downloadModel = new DownloadLink();
        $movie['download_links'] = $downloadModel->where('movie_id', (int)$movie['id']);

        $streamingModel = new StreamingLink();
        $movie['streaming_links'] = $streamingModel->where('movie_id', (int)$movie['id']);

        $screenshotModel = new Screenshot();
        $movie['screenshots'] = $screenshotModel->where('movie_id', (int)$movie['id']);

        $ratingModel = new Rating();
        $movie['ratings'] = $ratingModel->where('item_type', 'movie')->where('item_id', (int)$movie['id']);

        $userRating = 0;
        if ($this->isAuthenticated()) {
            $userRating = $ratingModel->where('item_type', 'movie')->where('item_id', (int)$movie['id'])->findBy('user_id', (int)$_SESSION['user_id']);
            $userRating = $userRating ? (int)$userRating['rating'] : 0;
        }

        $commentModel = new Comment();
        $relatedMovies = $movieModel->fetchAll(
            "SELECT * FROM movies WHERE status = 'published' AND id != :id AND category_id = :cat_id ORDER BY RANDOM() LIMIT 6",
            ['id' => $movie['id'], 'cat_id' => $movie['category_id']]
        );

        $isBookmarked = false;
        if ($this->isAuthenticated()) {
            $bookmarkModel = new Bookmark();
            $isBookmarked = $bookmarkModel->findBy('user_id', (int)$_SESSION['user_id']) && $bookmarkModel->where('user_id', (int)$_SESSION['user_id'])->where('item_type', 'movie')->where('item_id', (int)$movie['id']) ? true : false;
        }

        $this->view('movies.show', [
            'title' => $movie['title'] . ' - MovieHub',
            'movie' => $movie,
            'userRating' => $userRating,
            'relatedMovies' => $relatedMovies,
            'isBookmarked' => $isBookmarked,
            'seo_title' => $movie['seo_title'] ?: $movie['title'],
            'seo_description' => $movie['seo_description'] ?: truncate(strip_tags($movie['description']), 160),
            'seo_keywords' => $movie['seo_keywords']
        ]);
    }
}
