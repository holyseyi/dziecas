<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Middleware\CsrfMiddleware;
use Models\Director;

class DirectorController extends Controller
{
    public function index(): void { $this->admin(); $this->view('admin.directors.index', ['title' => 'Directors', 'directors' => (new Director())->all('name ASC')]); }
    public function store(): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->back(); return; } (new Director())->create(['name' => trim($this->input('name')), 'slug' => slugify(trim($this->input('name'))), 'biography' => trim($this->input('biography', ''))]); $this->json(['success' => true]); }
    public function update(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Director())->update((int)$id, ['name' => trim($this->input('name')), 'slug' => slugify(trim($this->input('name'))), 'biography' => trim($this->input('biography', ''))]); $this->json(['success' => true]); }
    public function destroy(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Director())->delete((int)$id); $this->json(['success' => true]); }
}
