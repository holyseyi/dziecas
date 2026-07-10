<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Core\CsrfMiddleware;
use Models\Genre;

class GenreController extends Controller
{
    public function index(): void { $this->admin(); $this->view('admin.genres.index', ['title' => 'Genres', 'genres' => (new Genre())->where('status', 'active')->all('sort_order ASC')]); }
    public function store(): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->back(); return; } (new Genre())->create(['name' => trim($this->input('name')), 'slug' => slugify(trim($this->input('name'))), 'description' => trim($this->input('description', ''))]); $this->json(['success' => true]); }
    public function update(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Genre())->update((int)$id, ['name' => trim($this->input('name')), 'slug' => slugify(trim($this->input('name'))), 'description' => trim($this->input('description', ''))]); $this->json(['success' => true]); }
    public function destroy(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Genre())->delete((int)$id); $this->json(['success' => true]); }
}
