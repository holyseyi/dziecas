<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Middleware\CsrfMiddleware;
use Models\Movie;
use Helpers\UploadHelper;

class MovieController extends Controller
{
    public function index(): void
    {
        $this->admin();
        $page = (int)($this->input('page', 1));
        $perPage = 20;
        $search = trim($this->input('search', ''));

        $where = '1=1';
        $params = [];
        if ($search) {
            $where .= " AND title LIKE :search";
            $params['search'] = "%{$search}%";
        }

        $results = (new Movie())->paginate($page, $perPage, 'published_at DESC', $where, $params);

        $this->view('admin.movies.index', [
            'title' => 'Movies - Admin',
            'movies' => $results['items'],
            'pagination' => $results,
            'search' => $search
        ]);
    }

    public function create(): void
    {
        $this->admin();
        $this->view('admin.movies.create', [
            'title' => 'Add Movie - Admin',
            'categories' => (new \Models\Category())->where('status', 'active'),
            'countries' => (new \Models\Country())->where('status', 'active'),
            'languages' => (new \Models\Language())->where('status', 'active'),
            'directors' => (new \Models\Director())->where('status', 'active'),
            'genres' => (new \Models\Genre())->where('status', 'active'),
            'actors' => (new \Models\Actor())->where('status', 'active')
        ]);
    }

    public function store(): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) {
            $this->back();
            return;
        }

        $poster = UploadHelper::upload($_FILES['poster'] ?? null, 'posters');
        $banner = UploadHelper::upload($_FILES['banner'] ?? null, 'banners');

        $movieModel = new Movie();
        $data = [
            'title' => trim($this->input('title')),
            'original_title' => trim($this->input('original_title', '')),
            'slug' => trim($this->input('slug')),
            'description' => trim($this->input('description')),
            'short_description' => truncate(strip_tags($this->input('description')), 200),
            'poster' => $poster,
            'banner' => $banner,
            'trailer_url' => trim($this->input('trailer_url', '')),
            'duration' => (int)$this->input('duration', 0),
            'release_date' => $this->input('release_date'),
            'imdb_rating' => (float)$this->input('imdb_rating', 0),
            'type' => $this->input('type', 'movie'),
            'category_id' => $this->input('category_id'),
            'country_id' => $this->input('country_id'),
            'language_id' => $this->input('language_id'),
            'director_id' => $this->input('director_id'),
            'status' => $this->input('status', 'draft'),
            'published_at' => $this->input('published_at', date('Y-m-d H:i:s')),
            'featured' => $this->input('featured', 0),
            'trending' => $this->input('trending', 0),
            'editor_pick' => $this->input('editor_pick', 0),
            'quality' => $this->input('quality', 'HD'),
            'seo_title' => trim($this->input('seo_title', '')),
            'seo_description' => trim($this->input('seo_description', '')),
            'seo_keywords' => trim($this->input('seo_keywords', '')),
            'created_by' => $_SESSION['user_id']
        ];

        $movieId = $movieModel->create($data);

        $genreIds = $this->input('genres', []);
        $actorIds = $this->input('actors', []);

        $db = \Core\Database::getInstance();
        foreach ($genreIds as $gid) {
            $db->query("INSERT INTO movie_genres (movie_id, genre_id) VALUES (:mid, :gid)", ['mid' => $movieId, 'gid' => $gid]);
        }
        foreach ($actorIds as $index => $aid) {
            $db->query("INSERT INTO actor_movies (movie_id, actor_id, cast_order) VALUES (:mid, :aid, :idx)", ['mid' => $movieId, 'aid' => $aid, 'idx' => $index]);
        }

        $this->withSuccess('Movie created successfully');
        $this->redirect('/admin/movies');
    }

    public function edit(string $id): void
    {
        $this->admin();
        $movie = (new Movie())->find((int)$id);

        if (!$movie) {
            $this->redirect('/admin/movies');
            return;
        }

        $this->view('admin.movies.edit', [
            'title' => 'Edit Movie - Admin',
            'movie' => $movie,
            'categories' => (new \Models\Category())->where('status', 'active'),
            'countries' => (new \Models\Country())->where('status', 'active'),
            'languages' => (new \Models\Language())->where('status', 'active'),
            'directors' => (new \Models\Director())->where('status', 'active'),
            'genres' => (new \Models\Genre())->where('status', 'active'),
            'actors' => (new \Models\Actor())->where('status', 'active'),
            'selected_genres' => (new \Models\Genre())->fetchAll("SELECT genre_id FROM movie_genres WHERE movie_id = :id", ['id' => $id]),
            'selected_actors' => (new \Models\Actor())->fetchAll("SELECT actor_id FROM actor_movies WHERE movie_id = :id", ['id' => $id])
        ]);
    }

    public function update(string $id): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) {
            $this->back();
            return;
        }

        $movieModel = new Movie();
        $poster = UploadHelper::upload($_FILES['poster'] ?? null, 'posters');
        $banner = UploadHelper::upload($_FILES['banner'] ?? null, 'banners');

        $data = [
            'title' => trim($this->input('title')),
            'original_title' => trim($this->input('original_title', '')),
            'slug' => trim($this->input('slug')),
            'description' => trim($this->input('description')),
            'short_description' => truncate(strip_tags($this->input('description')), 200),
            'trailer_url' => trim($this->input('trailer_url', '')),
            'duration' => (int)$this->input('duration', 0),
            'release_date' => $this->input('release_date'),
            'imdb_rating' => (float)$this->input('imdb_rating', 0),
            'type' => $this->input('type', 'movie'),
            'category_id' => $this->input('category_id'),
            'country_id' => $this->input('country_id'),
            'language_id' => $this->input('language_id'),
            'director_id' => $this->input('director_id'),
            'status' => $this->input('status', 'draft'),
            'featured' => $this->input('featured', 0),
            'trending' => $this->input('trending', 0),
            'editor_pick' => $this->input('editor_pick', 0),
            'quality' => $this->input('quality', 'HD'),
            'seo_title' => trim($this->input('seo_title', '')),
            'seo_description' => trim($this->input('seo_description', '')),
            'seo_keywords' => trim($this->input('seo_keywords', '')),
            'updated_by' => $_SESSION['user_id']
        ];

        if ($poster) $data['poster'] = $poster;
        if ($banner) $data['banner'] = $banner;

        $movieModel->update((int)$id, $data);
        $this->withSuccess('Movie updated successfully');
        $this->redirect('/admin/movies');
    }

    public function destroy(string $id): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) {
            $this->json(['error' => 'CSRF token mismatch'], 419);
            return;
        }
        (new Movie())->delete((int)$id);
        $this->json(['success' => true]);
    }
}
