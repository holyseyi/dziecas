<?php

declare(strict_types=1);

namespace Controllers\Api;

use Core\Controller;
use Models\Category;

class CategoryController extends Controller
{
    public function index(): void
    {
        $this->json(['success' => true, 'data' => (new Category())->where('status', 'active')->all('sort_order ASC')]);
    }
}
