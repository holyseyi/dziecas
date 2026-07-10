<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Middleware\CsrfMiddleware;
use Models\Comment;

class CommentController extends Controller
{
    public function index(): void
    {
        $this->admin();
        $page = (int)($this->input('page', 1));
        $status = $this->input('status', 'all');

        $where = '1=1';
        $params = [];
        if ($status !== 'all') {
            $where .= " AND status = :status";
            $params['status'] = $status;
        }

        $results = (new Comment())->paginate($page, 20, 'created_at DESC', $where, $params);

        $this->view('admin.comments.index', [
            'title' => 'Comments - Admin',
            'comments' => $results['items'],
            'pagination' => $results,
            'status' => $status
        ]);
    }

    public function destroy(string $id): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); }
        (new Comment())->delete((int)$id);
        $this->json(['success' => true]);
    }
}
