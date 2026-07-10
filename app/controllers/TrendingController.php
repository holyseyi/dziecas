<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Models\Movie;
use Models\Series;

class TrendingController extends Controller
{
    public function index(): void
    {
        $page = (int)($this->input('page', 1));
        $perPage = PER_PAGE;

        $movies = (new Movie())->paginate($page, $perPage, 'user_rating DESC', "status = 'published' AND trending = 1");
        $seriesList = (new Series())->paginate($page, $perPage, 'user_rating DESC', "status = 'published' AND trending = 1");

        $this->view('trending.index', [
            'title' => 'Trending - MovieHub',
            'movies' => $movies['items'],
            'series' => $seriesList['items'],
            'pagination' => $movies
        ]);
    }
}
