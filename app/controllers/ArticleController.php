<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;

class ArticleController extends Controller
{
    public function index(): void {
        $this->view('articles.index', ['title' => 'Articles', 'articles' => []]);
    }
    public function show(string $slug): void {
        $this->view('articles.show', ['title' => 'Article', 'article' => []]);
    }
}
