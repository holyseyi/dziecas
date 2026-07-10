<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Models\AuditLog;

class LogController extends Controller
{
    public function index(): void
    {
        $this->admin();
        $page = (int)($this->input('page', 1));
        $results = (new AuditLog())->paginate($page, 50, 'created_at DESC');

        $this->view('admin.logs.index', [
            'title' => 'Audit Logs - Admin',
            'logs' => $results['items'],
            'pagination' => $results
        ]);
    }
}
