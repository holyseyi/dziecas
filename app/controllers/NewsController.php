<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;

class NewsController extends Controller
{
    public function index(): void {
        $this->view('news.index', ['title' => 'Entertainment News', 'news' => []]);
    }
    public function show(string $slug): void {
        $this->view('news.show', ['title' => 'News', 'news' => []]);
    }
}
