<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Middleware\CsrfMiddleware;

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

        if (!CsrfMiddleware::check()) {
            $this->view('admin.auth.login', [
                'title' => 'Admin Login',
                'error' => 'Invalid CSRF token'
            ]);
            return;
        }

        $email = trim($this->input('email', ''));
        $password = $this->input('password', '');

        if (empty($email) || empty($password)) {
            $this->view('admin.auth.login', [
                'title' => 'Admin Login',
                'error' => 'Email and password are required'
            ]);
            return;
        }

        $userModel = new \Models\User();
        $user = $userModel->findBy('email', $email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $this->view('admin.auth.login', [
                'title' => 'Admin Login',
                'error' => 'Invalid credentials'
            ]);
            return;
        }

        if ($user['status'] !== 'active') {
            $this->view('admin.auth.login', [
                'title' => 'Admin Login',
                'error' => 'Your account has been disabled'
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

        $this->withSuccess('Login successful');
        $this->view('admin.auth.login', [
            'title' => 'Admin Login',
            'redirect' => '/admin'
        ]);
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/admin/login');
    }
}
