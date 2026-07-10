<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Middleware\CsrfMiddleware;
use Models\Advertisement;

class AdController extends Controller
{
    public function index(): void { $this->admin(); $this->view('admin.ads.index', ['title' => 'Advertisements', 'ads' => (new Advertisement())->all('created_at DESC')]); }
    public function store(): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Advertisement())->create(['name' => trim($this->input('name')), 'position' => trim($this->input('position')), 'code' => trim($this->input('code')), 'status' => $this->input('status', 'active')]); $this->json(['success' => true]); }
    public function update(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Advertisement())->update((int)$id, ['name' => trim($this->input('name')), 'position' => trim($this->input('position')), 'code' => trim($this->input('code')), 'status' => $this->input('status', 'active')]); $this->json(['success' => true]); }
    public function destroy(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Advertisement())->delete((int)$id); $this->json(['success' => true]); }
}
