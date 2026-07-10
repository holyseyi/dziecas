<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Core\CsrfMiddleware;
use Models\Category;

class CategoryController extends Controller
{
    public function index(): void { $this->admin(); $this->view('admin.categories.index', ['title' => 'Categories', 'categories' => (new Category())->all('sort_order ASC')]); }
    public function store(): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->back(); return; } (new Category())->create(['name' => trim($this->input('name')), 'slug' => slugify(trim($this->input('name'))), 'color' => trim($this->input('color', '#3B82F6')), 'sort_order' => (int)($this->input('sort_order', 0))]); $this->json(['success' => true]); }
    public function update(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Category())->update((int)$id, ['name' => trim($this->input('name')), 'slug' => slugify(trim($this->input('name'))), 'color' => trim($this->input('color', '#3B82F6')), 'sort_order' => (int)($this->input('sort_order', 0))]); $this->json(['success' => true]); }
    public function destroy(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Category())->delete((int)$id); $this->json(['success' => true]); }
}
