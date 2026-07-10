<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Core\CsrfMiddleware;
use Models\Comment;
use Models\Movie;
use Models\Series;

class CommentController extends Controller
{
    public function submit(string $type, string $id): void
    {
        if (!CsrfMiddleware::check()) {
            $this->json(['error' => 'CSRF token mismatch'], 419);
            return;
        }

        $content = trim($this->input('content', ''));
        $parentId = (int)($this->input('parent_id', 0));
        $userId = $this->isAuthenticated() ? (int)$_SESSION['user_id'] : null;
        $authorName = trim($this->input('author_name', $_SESSION['user']['username'] ?? 'Guest'));
        $authorEmail = trim($this->input('author_email', ''));

        if (empty($content)) {
            $this->json(['error' => 'Comment cannot be empty'], 400);
            return;
        }

        if (!$userId && (empty($authorName) || empty($authorEmail))) {
            $this->json(['error' => 'Name and email are required'], 400);
            return;
        }

        $commentModel = new Comment();
        $commentModel->create([
            'item_type' => $type,
            'item_id' => (int)$id,
            'user_id' => $userId,
            'parent_id' => $parentId,
            'author_name' => $authorName,
            'author_email' => $authorEmail,
            'content' => $content,
            'status' => 'published',
            'ip_address' => get_client_ip(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
        ]);

        $this->json(['success' => true]);
    }
}
