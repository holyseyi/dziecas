<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Models\User;
use Models\Movie;
use Models\Series;
use Models\Comment;
use Models\AuditLog;

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->admin();

        $movieModel = new Movie();
        $seriesModel = new Series();
        $commentModel = new Comment();
        $userModel = new User();

        $stats = [
            'movies' => $movieModel->count("status = 'published'"),
            'series' => $seriesModel->count("status = 'published'"),
            'users' => $userModel->count(),
            'comments' => $commentModel->count("status = 'published'"),
            'pending_comments' => $commentModel->count("status = 'pending'"),
            'total_views' => $movieModel->fetchColumn("SELECT SUM(view_count) FROM movies") ?: 0,
            'recent_comments' => $commentModel->all('created_at DESC', 5),
            'recent_users' => $userModel->all('created_at DESC', 5),
            'recent_audit' => (new AuditLog())->all('created_at DESC', 10)
        ];

        $this->view('admin.dashboard', [
            'title' => 'Dashboard - MovieHub Admin',
            'stats' => $stats
        ]);
    }
}
