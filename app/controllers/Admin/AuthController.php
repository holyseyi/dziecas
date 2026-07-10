<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;

class AuthController extends Controller
{
    public function loginForm(): void
    {
        if ($this->isAdmin()) {
            $this->redirect('/admin');
            return;
        }
        $this->view('admin.auth.login', ['title' => 'Admin Login']);
    }

    public function login(): void
    {
        if ($this->isAdmin()) {
            $this->redirect('/admin');
            return;
        }

        $email = trim($this->input('email', ''));
        $password = $this->input('password', '');

        $userModel = new \Models\User();
        $user = $userModel->findBy('email', $email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $this->view('admin.auth.login', [
                'title' => 'Admin Login',
                'error' => 'Invalid credentials'
            ]);
            return;
        }

        $role = ($user['role_id'] == 1) ? 'admin' : 'user';
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $role,
            'role_id' => $user['role_id']
        ];

        $userModel->update((int)$user['id'], [
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => get_client_ip()
        ]);

        $this->redirect('/admin');
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/admin/login');
    }
}
