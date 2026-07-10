<?php

declare(strict_types=1);

namespace Controllers\Api;

use Core\Controller;
use Models\Series;

class SeriesController extends Controller
{
    public function index(): void
    {
        $page = (int)($this->input('page', 1));
        $perPage = (int)($this->input('limit', 20));
        $results = (new Series())->paginate($page, $perPage, 'published_at DESC', "status = 'published'");
        $this->json(['success' => true, 'data' => $results['items'], 'pagination' => $results]);
    }
}
