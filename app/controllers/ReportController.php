<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Middleware\CsrfMiddleware;
use Models\Comment;
use Models\Movie;
use Models\Series;

class ReportController extends Controller
{
    public function submit(): void
    {
        if (!CsrfMiddleware::check()) {
            $this->json(['error' => 'CSRF token mismatch'], 419);
            return;
        }

        $id = (int)($this->input('id', 0));
        $type = $this->input('type', 'movie');
        $reason = trim($this->input('reason', ''));

        if (!$id || empty($reason)) {
            $this->back();
            $this->withError('reason', 'Please provide a reason');
            return;
        }

        $this->withSuccess('Report submitted. Thank you!');
        $this->back();
    }
}
