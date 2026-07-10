<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Middleware\CsrfMiddleware;
use Models\Bookmark;
use Models\Movie;
use Models\Series;
use Models\Episode;

class BookmarkController extends Controller
{
    public function toggle(string $id): void
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
            return;
        }

        $type = $this->input('type', 'movie');
        $userId = (int)$_SESSION['user_id'];
        $model = new Bookmark();

        $existing = $model->fetch(
            "SELECT * FROM bookmarks WHERE user_id = :uid AND item_type = :type AND item_id = :iid",
            ['uid' => $userId, 'type' => $type, 'iid' => (int)$id]
        );

        if ($existing) {
            $model->delete((int)$existing['id']);
            $this->json(['bookmarked' => false]);
        } else {
            $model->create(['user_id' => $userId, 'item_type' => $type, 'item_id' => (int)$id]);
            $this->json(['bookmarked' => true]);
        }
    }
}
