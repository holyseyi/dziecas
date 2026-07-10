<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Middleware\CsrfMiddleware;
use Models\User;
use Models\Bookmark;

class AuthController extends Controller
{
    public function registerForm(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/profile');
            return;
        }
        $this->view('auth.register', ['title' => 'Register - MovieHub']);
    }

    public function register(): void
    {
        if ($this->isAuthenticated()) {
            $this->json(['error' => 'Already authenticated'], 400);
            return;
        }

        if (!CsrfMiddleware::check()) {
            $this->back();
            $this->withError('form', 'Invalid CSRF token');
            return;
        }

        $username = trim($this->input('username', ''));
        $email = trim($this->input('email', ''));
        $password = $this->input('password', '');
        $confirmPassword = $this->input('password_confirmation', '');

        $userModel = new User();

        if (strlen($username) < 3) {
            $this->back();
            $this->withError('username', 'Username must be at least 3 characters');
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->back();
            $this->withError('email', 'Invalid email address');
            return;
        }

        if ($userModel->findBy('email', $email)) {
            $this->back();
            $this->withError('email', 'Email already registered');
            return;
        }

        if ($userModel->findBy('username', $username)) {
            $this->back();
            $this->withError('username', 'Username already taken');
            return;
        }

        if (strlen($password) < 6) {
            $this->back();
            $this->withError('password', 'Password must be at least 6 characters');
            return;
        }

        if ($password !== $confirmPassword) {
            $this->back();
            $this->withError('password', 'Passwords do not match');
            return;
        }

        $userModel->create([
            'username' => $username,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role_id' => 2,
            'status' => 'active'
        ]);

        $this->withSuccess('Registration successful. Please login.');
        $this->redirect('/login');
    }

    public function loginForm(): void
    {
        if ($this->isAuthenticated()) {
            if ($this->isAdmin()) {
                $this->redirect('/admin');
            }
            $this->redirect('/');
            return;
        }
        $this->view('auth.login', ['title' => 'Login - MovieHub']);
    }

    public function login(): void
    {
        if ($this->isAuthenticated()) {
            $this->json(['error' => 'Already authenticated'], 400);
            return;
        }

        if (!CsrfMiddleware::check()) {
            $this->back();
            $this->withError('form', 'Invalid CSRF token');
            return;
        }

        $email = trim($this->input('email', ''));
        $password = $this->input('password', '');

        if (empty($email) || empty($password)) {
            $this->back();
            $this->withError('form', 'Email and password are required');
            return;
        }

        $userModel = new User();
        $user = $userModel->findBy('email', $email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $this->back();
            $this->withError('form', 'Invalid email or password');
            return;
        }

        if ($user['status'] !== 'active') {
            $this->back();
            $this->withError('form', 'Your account has been disabled');
            return;
        }

        unset($user['password_hash']);
        $user['role'] = ($user['role_id'] ?? 2) == 1 ? 'admin' : 'user';
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['user'] = $user;

        $userModel->update((int)$user['id'], [
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => get_client_ip()
        ]);

        if ($user['role'] === 'admin' || ($user['role_id'] ?? 2) === 1) {
            $this->redirect('/admin');
        } else {
            $this->redirect('/');
        }
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/');
    }

    public function forgotForm(): void
    {
        $this->view('auth.forgot', ['title' => 'Forgot Password - MovieHub']);
    }

    public function forgot(): void
    {
        if (!CsrfMiddleware::check()) {
            $this->back();
            return;
        }

        $email = trim($this->input('email', ''));
        $this->withSuccess('If an account exists, a password reset link has been sent.');
        $this->redirect('/login');
    }

    public function resetForm(): void
    {
        $this->view('auth.reset', ['title' => 'Reset Password - MovieHub']);
    }

    public function reset(): void
    {
        if (!CsrfMiddleware::check()) {
            $this->back();
            return;
        }

        $email = trim($this->input('email', ''));
        $password = $this->input('password', '');
        $confirmPassword = $this->input('password_confirmation', '');

        if (strlen($password) < 6) {
            $this->back();
            $this->withError('password', 'Password must be at least 6 characters');
            return;
        }

        if ($password !== $confirmPassword) {
            $this->back();
            $this->withError('password', 'Passwords do not match');
            return;
        }

        $userModel = new User();
        $user = $userModel->findBy('email', $email);

        if ($user) {
            $userModel->update((int)$user['id'], [
                'password_hash' => password_hash($password, PASSWORD_DEFAULT)
            ]);
        }

        $this->withSuccess('Password reset successful. Please login.');
        $this->redirect('/login');
    }

    public function profile(): void
    {
        $this->auth();

        $userId = (int)$_SESSION['user_id'];
        $userModel = new User();
        $user = $userModel->find($userId);

        $bookmarks = (new Bookmark())->fetchAll(
            "SELECT * FROM bookmarks WHERE user_id = :uid ORDER BY created_at DESC",
            ['uid' => $userId]
        );

        $this->view('auth.profile', [
            'title' => 'My Profile - MovieHub',
            'user' => $user,
            'bookmarks' => $bookmarks
        ]);
    }

    public function updateProfile(): void
    {
        $this->auth();
        if (!CsrfMiddleware::check()) {
            $this->json(['error' => 'CSRF token mismatch'], 419);
            return;
        }

        $userId = (int)$_SESSION['user_id'];
        $userModel = new User();

        $userModel->update($userId, [
            'username' => trim($this->input('username', '')),
            'bio' => trim($this->input('bio', '')),
            'country' => trim($this->input('country', '')),
            'language' => trim($this->input('language', 'en'))
        ]);

        $this->withSuccess('Profile updated successfully');
        $this->redirect('/profile');
    }

    public function uploadAvatar(): void
    {
        $this->auth();

        if (empty($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            $this->back();
            $this->withError('avatar', 'Please select a file to upload');
            return;
        }

        $file = $_FILES['avatar'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (!in_array($file['type'], $allowedTypes)) {
            $this->back();
            $this->withError('avatar', 'Invalid file type');
            return;
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            $this->back();
            $this->withError('avatar', 'File size must be under 5MB');
            return;
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'avatar_' . (int)$_SESSION['user_id'] . '_' . time() . '.' . $ext;
        $uploadPath = STORAGE_PATH . 'uploads/avatars/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $this->back();
            $this->withError('avatar', 'Failed to upload file');
            return;
        }

        $userModel = new User();
        $userModel->update((int)$_SESSION['user_id'], ['avatar' => $filename]);

        $this->withSuccess('Avatar updated successfully');
        $this->redirect('/profile');
    }

    public function bookmarks(): void
    {
        $this->auth();

        $bookmarks = (new Bookmark())->fetchAll(
            "SELECT b.*, m.title as movie_title, m.poster as movie_poster, m.slug as movie_slug FROM bookmarks b LEFT JOIN movies m ON b.item_type = 'movie' AND b.item_id = m.id WHERE b.user_id = :uid ORDER BY b.created_at DESC",
            ['uid' => (int)$_SESSION['user_id']]
        );

        $this->view('auth.bookmarks', [
            'title' => 'My Bookmarks - MovieHub',
            'bookmarks' => $bookmarks
        ]);
    }

    public function history(): void
    {
        $this->auth();

        $history = (new WatchHistory())->fetchAll(
            "SELECT * FROM watch_history WHERE user_id = :uid ORDER BY watched_at DESC",
            ['uid' => (int)$_SESSION['user_id']]
        );

        $this->view('auth.history', [
            'title' => 'Watch History - MovieHub',
            'history' => $history
        ]);
    }

    public function ratings(): void
    {
        $this->auth();

        $ratings = (new Rating())->fetchAll(
            "SELECT * FROM ratings WHERE user_id = :uid ORDER BY created_at DESC",
            ['uid' => (int)$_SESSION['user_id']]
        );

        $this->view('auth.ratings', [
            'title' => 'My Ratings - MovieHub',
            'ratings' => $ratings
        ]);
    }
}
