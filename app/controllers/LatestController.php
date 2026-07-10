<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Models\Movie;
use Models\Series;

class LatestController extends Controller
{
    public function index(): void
    {
        $page = (int)($this->input('page', 1));
        $perPage = PER_PAGE;

        $movies = (new Movie())->paginate($page, $perPage, 'published_at DESC', "status = 'published'");
        $seriesList = (new Series())->paginate($page, $perPage, 'published_at DESC', "status = 'published'");

        $this->view('latest.index', [
            'title' => 'Latest Uploads - MovieHub',
            'movies' => $movies['items'],
            'series' => $seriesList['items'],
            'pagination' => $movies
        ]);
    }
}
