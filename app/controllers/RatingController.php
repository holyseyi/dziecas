<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Middleware\CsrfMiddleware;
use Models\Rating;

class RatingController extends Controller
{
    public function submit(string $type, string $id): void
    {
        if (!$this->isAuthenticated()) {
            $this->json(['error' => 'Please login to rate'], 401);
            return;
        }

        if (!CsrfMiddleware::check()) {
            $this->json(['error' => 'CSRF token mismatch'], 419);
            return;
        }

        $rating = (int)($this->input('rating', 0));
        $userId = (int)$_SESSION['user_id'];

        if ($rating < 1 || $rating > 5) {
            $this->json(['error' => 'Invalid rating'], 400);
            return;
        }

        $ratingModel = new Rating();
        $existing = $ratingModel->fetch(
            "SELECT * FROM ratings WHERE item_type = :type AND item_id = :iid AND user_id = :uid",
            ['type' => $type, 'iid' => (int)$id, 'uid' => $userId]
        );

        if ($existing) {
            $ratingModel->update((int)$existing['id'], ['rating' => $rating]);
        } else {
            $ratingModel->create([
                'item_type' => $type,
                'item_id' => (int)$id,
                'user_id' => $userId,
                'rating' => $rating,
                'ip_address' => get_client_ip(),
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
            ]);
        }

        $this->json(['success' => true, 'rating' => $rating]);
    }
}
