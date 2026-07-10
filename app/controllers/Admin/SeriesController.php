<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Middleware\CsrfMiddleware;
use Models\Series;
use Helpers\UploadHelper;

class SeriesController extends Controller
{
    public function index(): void
    {
        $this->admin();
        $page = (int)($this->input('page', 1));
        $search = trim($this->input('search', ''));

        $where = '1=1';
        $params = [];
        if ($search) {
            $where .= " AND title LIKE :search";
            $params['search'] = "%{$search}%";
        }

        $results = (new Series())->paginate($page, 20, 'published_at DESC', $where, $params);

        $this->view('admin.series.index', [
            'title' => 'Series - Admin',
            'series' => $results['items'],
            'pagination' => $results,
            'search' => $search
        ]);
    }

    public function store(): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) { $this->back(); return; }

        $poster = UploadHelper::upload($_FILES['poster'] ?? null, 'posters');
        $banner = UploadHelper::upload($_FILES['banner'] ?? null, 'banners');

        $id = (new Series())->create([
            'title' => trim($this->input('title')),
            'slug' => trim($this->input('slug')),
            'description' => trim($this->input('description')),
            'poster' => $poster,
            'banner' => $banner,
            'status' => $this->input('status', 'draft'),
            'category_id' => $this->input('category_id'),
            'country_id' => $this->input('country_id'),
            'director_id' => $this->input('director_id'),
            'created_by' => $_SESSION['user_id']
        ]);

        $this->withSuccess('Series created successfully');
        $this->redirect('/admin/series');
    }

    public function update(string $id): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) { $this->back(); return; }

        $poster = UploadHelper::upload($_FILES['poster'] ?? null, 'posters');
        $banner = UploadHelper::upload($_FILES['banner'] ?? null, 'banners');

        $data = [
            'title' => trim($this->input('title')),
            'slug' => trim($this->input('slug')),
            'description' => trim($this->input('description')),
            'status' => $this->input('status', 'draft'),
            'featured' => $this->input('featured', 0),
            'trending' => $this->input('trending', 0),
            'updated_by' => $_SESSION['user_id']
        ];
        if ($poster) $data['poster'] = $poster;
        if ($banner) $data['banner'] = $banner;

        (new Series())->update((int)$id, $data);
        $this->withSuccess('Series updated successfully');
        $this->redirect('/admin/series');
    }

    public function episodes(string $id): void
    {
        $this->admin();
        $series = (new Series())->find((int)$id);
        $episodes = (new \Models\Episode())->where('series_id', (int)$id);

        $this->view('admin.series.episodes', [
            'title' => 'Episodes - Admin',
            'series' => $series,
            'episodes' => $episodes
        ]);
    }

    public function storeEpisode(string $id): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) { $this->back(); return; }

        (new \Models\Episode())->create([
            'series_id' => (int)$id,
            'season' => (int)$this->input('season'),
            'episode_number' => (int)$this->input('episode_number'),
            'title' => trim($this->input('title', '')),
            'description' => trim($this->input('description', '')),
            'duration' => (int)$this->input('duration', 0),
            'status' => $this->input('status', 'published'),
            'published_at' => $this->input('published_at')
        ]);

        $this->withSuccess('Episode added');
        $this->redirect('/admin/series/' . $id . '/episodes');
    }

    public function updateEpisode(string $id): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) { $this->back(); return; }

        (new \Models\Episode())->update((int)$id, [
            'title' => trim($this->input('title', '')),
            'description' => trim($this->input('description', '')),
            'duration' => (int)$this->input('duration', 0),
            'status' => $this->input('status', 'published'),
            'published_at' => $this->input('published_at')
        ]);

        $this->withSuccess('Episode updated');
        $this->back();
    }

    public function destroyEpisode(string $id): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) { die('CSRF mismatch'); }

        $db = \Core\Database::getInstance();
        $db->query("DELETE FROM episodes WHERE id = :id", ['id' => (int)$id]);
        $this->json(['success' => true]);
    }

    public function destroy(string $id): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); }

        $db = \Core\Database::getInstance();
        $db->query("DELETE FROM movie_genres WHERE movie_id = :id", ['id' => (int)$id]);
        $db->query("DELETE FROM actor_movies WHERE movie_id = :id", ['id' => (int)$id]);
        (new Series())->delete((int)$id);
        $this->json(['success' => true]);
    }
}
