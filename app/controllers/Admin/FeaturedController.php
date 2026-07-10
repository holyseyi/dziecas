<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Middleware\CsrfMiddleware;
use Models\FeaturedContent;

class FeaturedController extends Controller
{
    public function index(): void { $this->admin(); $this->view('admin.featured.index', ['title' => 'Featured Content', 'content' => (new FeaturedContent())->all('sort_order ASC')]); }
    public function store(): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new FeaturedContent())->create(['item_type' => $this->input('item_type'), 'item_id' => (int)$this->input('item_id'), 'section' => $this->input('section'), 'sort_order' => (int)$this->input('sort_order', 0), 'label' => trim($this->input('label', ''))]); $this->json(['success' => true]); }
    public function destroy(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new FeaturedContent())->delete((int)$id); $this->json(['success' => true]); }
}
