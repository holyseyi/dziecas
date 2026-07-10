<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Core\CsrfMiddleware;
use Models\Announcement;

class AnnouncementController extends Controller
{
    public function index(): void { $this->admin(); $this->view('admin.announcements.index', ['title' => 'Announcements', 'announcements' => (new Announcement())->all('created_at DESC')]); }
    public function store(): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Announcement())->create(['title' => trim($this->input('title')), 'content' => trim($this->input('content')), 'type' => $this->input('type', 'info'), 'position' => $this->input('position', 'top'), 'status' => $this->input('status', 'active'), 'created_by' => $_SESSION['user_id']]); $this->json(['success' => true]); }
    public function update(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Announcement())->update((int)$id, ['title' => trim($this->input('title')), 'content' => trim($this->input('content')), 'type' => $this->input('type', 'info'), 'position' => $this->input('position', 'top'), 'status' => $this->input('status', 'active')]); $this->json(['success' => true]); }
    public function destroy(string $id): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); } (new Announcement())->delete((int)$id); $this->json(['success' => true]); }
}
