<?php

declare(strict_types=1);

namespace Controllers\Api;

use Core\Controller;
use Models\Genre;

class GenreController extends Controller
{
    public function index(): void
    {
        $this->json(['success' => true, 'data' => (new Genre())->all('sort_order ASC')]);
    }
}
