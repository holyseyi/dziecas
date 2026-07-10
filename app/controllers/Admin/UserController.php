<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Middleware\CsrfMiddleware;
use Models\User;

class UserController extends Controller
{
    public function index(): void
    {
        $this->admin();
        $page = (int)($this->input('page', 1));
        $results = (new User())->paginate($page, 20, 'created_at DESC');

        $this->view('admin.users.index', [
            'title' => 'Users - Admin',
            'users' => $results['items'],
            'pagination' => $results
        ]);
    }

    public function update(string $id): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); }

        $status = $this->input('status', 'active');
        $role = $this->input('role', 'user');

        (new User())->update((int)$id, [
            'status' => $status,
            'role_id' => $role === 'admin' ? 1 : 2
        ]);

        $this->json(['success' => true]);
    }

    public function destroy(string $id): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) { $this->json(['error' => 'CSRF'], 419); }
        (new User())->delete((int)$id);
        $this->json(['success' => true]);
    }
}
