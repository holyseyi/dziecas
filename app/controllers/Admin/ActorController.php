<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Core\CsrfMiddleware;
use Models\Actor;

class ActorController extends Controller
{
    public function index(): void { $this->admin(); $this->view('admin.actors.index', ['title' => 'Actors', 'actors' => (new Actor())->all('name ASC')]); }
    public function store(): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->back(); return; } (new Actor())->create(['name' => trim($this->input('name')), 'slug' => slugify(trim($this->input('name'))), 'biography' => trim($this->input('biography', ''))]); $this->json(['success' => true]); }
    public function update(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Actor())->update((int)$id, ['name' => trim($this->input('name')), 'slug' => slugify(trim($this->input('name'))), 'biography' => trim($this->input('biography', ''))]); $this->json(['success' => true]); }
    public function destroy(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Actor())->delete((int)$id); $this->json(['success' => true]); }
}
