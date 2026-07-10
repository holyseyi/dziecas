<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Core\CsrfMiddleware;
use Models\Country;

class CountryController extends Controller
{
    public function index(): void { $this->admin(); $this->view('admin.countries.index', ['title' => 'Countries', 'countries' => (new Country())->all('name ASC')]); }
    public function store(): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->back(); return; } (new Country())->create(['name' => trim($this->input('name')), 'slug' => slugify(trim($this->input('name'))), 'code' => strtoupper(trim($this->input('code', ''))), 'continent' => trim($this->input('continent', ''))]); $this->json(['success' => true]); }
    public function update(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Country())->update((int)$id, ['name' => trim($this->input('name')), 'slug' => slugify(trim($this->input('name'))), 'code' => strtoupper(trim($this->input('code', ''))), 'continent' => trim($this->input('continent', ''))]); $this->json(['success' => true]); }
    public function destroy(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Country())->delete((int)$id); $this->json(['success' => true]); }
}
