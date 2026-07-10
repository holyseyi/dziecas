<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;

class BackupController extends Controller
{
    public function index(): void
    {
        $this->admin();
        $this->view('admin.backup.index', ['title' => 'Database Backup - Admin']);
    }

    public function export(): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) { $this->back(); return; }

        $dbPath = __DIR__ . '/../../../database/database.sqlite';
        if (!file_exists($dbPath)) {
            die('Database not found');
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="backup_' . date('Y-m-d_H-i-s') . '.sqlite"');
        header('Content-Length: ' . filesize($dbPath));
        readfile($dbPath);
        exit;
    }

    public function import(): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) { $this->back(); return; }

        if (empty($_FILES['database']) || $_FILES['database']['error'] !== UPLOAD_ERR_OK) {
            $this->withError('database', 'Please select a file');
            $this->redirect('/admin/backup');
            return;
        }

        $tmpFile = $_FILES['database']['tmp_name'];
        $dbPath = __DIR__ . '/../../../database/database.sqlite';
        copy($tmpFile, $dbPath);

        $this->withSuccess('Database restored successfully');
        $this->redirect('/admin/backup');
    }
}
