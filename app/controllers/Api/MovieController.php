<?php

declare(strict_types=1);

namespace Controllers\Api;

use Core\Controller;
use Core\Database;
use Models\Movie;

class MovieController extends Controller
{
    public function index(): void
    {
        $db = Database::getInstance();
        $page = (int)($this->input('page', 1));
        $perPage = (int)($this->input('limit', 20));

        $results = (new Movie())->paginate($page, $perPage, 'published_at DESC', "status = 'published'");
        $this->json([
            'success' => true,
            'data' => $results['items'],
            'pagination' => [
                'page' => $results['page'],
                'per_page' => $results['per_page'],
                'total' => $results['total'],
                'total_pages' => $results['total_pages']
            ]
        ]);
    }

    public function latest(): void
    {
        $results = (new Movie())->paginate(1, 20, 'published_at DESC', "status = 'published'");
        $this->json(['success' => true, 'data' => $results['items']]);
    }

    public function trending(): void
    {
        $results = (new Movie())->paginate(1, 20, 'user_rating DESC', "status = 'published' AND trending = 1");
        $this->json(['success' => true, 'data' => $results['items']]);
    }

    public function search(): void
    {
        $q = trim($this->input('q', ''));
        if (strlen($q) < 2) {
            $this->json(['success' => true, 'data' => []]);
            return;
        }

        $db = Database::getInstance();
        $movies = $db->fetchAll(
            "SELECT * FROM movies WHERE status = 'published' AND (title LIKE :q OR original_title LIKE :q) LIMIT 20",
            ['q' => "%{$q}%"]
        );
        $this->json(['success' => true, 'data' => $movies]);
    }

    public function show(string $slug): void
    {
        $movie = (new Movie())->findBy('slug', $slug);
        if (!$movie) {
            $this->json(['error' => 'Not Found'], 404);
            return;
        }
        $this->json(['success' => true, 'data' => $movie]);
    }
}
