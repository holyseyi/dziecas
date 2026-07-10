<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers/functions.php';

$router = new \Core\Router();

$router->get('/storage/{path}', 'MediaController@serve');

$router->get('/', 'HomeController@index');
$router->get('/movies', 'MovieController@index');
$router->get('/movie/{slug}', 'MovieController@show');
$router->get('/series', 'SeriesController@index');
$router->get('/series/{slug}', 'SeriesController@show');
$router->get('/series/{seriesSlug}/season/{season}', 'SeriesController@season');
$router->get('/series/{seriesSlug}/season/{season}/episode/{episode}', 'SeriesController@watch');
$router->get('/anime', 'CategoryController@anime');
$router->get('/kdramas', 'CategoryController@kdramas');
$router->get('/nollywood', 'CategoryController@nollywood');
$router->get('/hollywood', 'CategoryController@hollywood');
$router->get('/bollywood', 'CategoryController@bollywood');
$router->get('/tv-shows', 'CategoryController@tvShows');
$router->get('/documentaries', 'CategoryController@documentaries');
$router->get('/music-videos', 'CategoryController@musicVideos');
$router->get('/trending', 'TrendingController@index');
$router->get('/latest', 'LatestController@index');
$router->get('/popular', 'PopularController@index');
$router->get('/genre/{slug}', 'GenreController@show');
$router->get('/category/{slug}', 'CategoryController@show');
$router->get('/country/{slug}', 'CountryController@show');
$router->get('/year/{year}', 'YearController@show');
$router->get('/search', 'SearchController@index');
$router->get('/search/suggestions', 'SearchController@suggestions');
$router->get('/actor/{slug}', 'ActorController@show');
$router->get('/director/{slug}', 'DirectorController@show');
$router->get('/articles', 'ArticleController@index');
$router->get('/article/{slug}', 'ArticleController@show');
$router->get('/news', 'NewsController@index');
$router->get('/news/{slug}', 'NewsController@show');
$router->get('/contact', 'PageController@contact');
$router->get('/dmca', 'PageController@dmca');
$router->get('/privacy', 'PageController@privacy');
$router->get('/terms', 'PageController@terms');
$router->post('/report-broken-link', 'ReportController@submit');

$router->get('/bookmark/{id}', 'BookmarkController@toggle');
$router->post('/rate/{type}/{id}', 'RatingController@submit');
$router->post('/comment/{type}/{id}', 'CommentController@submit');

$router->get('/register', 'AuthController@registerForm');
$router->post('/register', 'AuthController@register');
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->get('/forgot-password', 'AuthController@forgotForm');
$router->post('/forgot-password', 'AuthController@forgot');
$router->get('/reset-password', 'AuthController@resetForm');
$router->post('/reset-password', 'AuthController@reset');
$router->get('/profile', 'AuthController@profile');
$router->post('/profile/update', 'AuthController@updateProfile');
$router->post('/profile/avatar', 'AuthController@uploadAvatar');
$router->get('/profile/bookmarks', 'AuthController@bookmarks');
$router->get('/profile/history', 'AuthController@history');
$router->get('/profile/ratings', 'AuthController@ratings');

$router->prefix('admin', function() use ($router) {
    $router->get('/', 'Admin\DashboardController@index');
    $router->get('/dashboard', 'Admin\DashboardController@index');

    $router->get('/login', 'Admin\AuthController@loginForm');
    $router->post('/login', 'Admin\AuthController@login');
    $router->get('/logout', 'Admin\AuthController@logout');

    $router->get('/media', 'Admin\MediaController@index');
    $router->post('/media', 'Admin\MediaController@store');
    $router->delete('/media/{id}', 'Admin\MediaController@destroy');

    $router->get('/movies', 'Admin\MovieController@index');
    $router->get('/movies/create', 'Admin\MovieController@create');
    $router->post('/movies', 'Admin\MovieController@store');
    $router->get('/movies/{id}/edit', 'Admin\MovieController@edit');
    $router->put('/movies/{id}', 'Admin\MovieController@update');
    $router->delete('/movies/{id}', 'Admin\MovieController@destroy');

    $router->get('/series', 'Admin\SeriesController@index');
    $router->get('/series/create', 'Admin\SeriesController@create');
    $router->post('/series', 'Admin\SeriesController@store');
    $router->get('/series/{id}/edit', 'Admin\SeriesController@edit');
    $router->put('/series/{id}', 'Admin\SeriesController@update');
    $router->delete('/series/{id}', 'Admin\SeriesController@destroy');
    $router->get('/series/{id}/episodes', 'Admin\SeriesController@episodes');
    $router->post('/series/{id}/episodes', 'Admin\SeriesController@storeEpisode');
    $router->put('/episodes/{id}', 'Admin\SeriesController@updateEpisode');
    $router->delete('/episodes/{id}', 'Admin\SeriesController@destroyEpisode');

    $router->get('/genres', 'Admin\GenreController@index');
    $router->post('/genres', 'Admin\GenreController@store');
    $router->put('/genres/{id}', 'Admin\GenreController@update');
    $router->delete('/genres/{id}', 'Admin\GenreController@destroy');

    $router->get('/countries', 'Admin\CountryController@index');
    $router->post('/countries', 'Admin\CountryController@store');
    $router->put('/countries/{id}', 'Admin\CountryController@update');
    $router->delete('/countries/{id}', 'Admin\CountryController@destroy');

    $router->get('/actors', 'Admin\ActorController@index');
    $router->post('/actors', 'Admin\ActorController@store');
    $router->put('/actors/{id}', 'Admin\ActorController@update');
    $router->delete('/actors/{id}', 'Admin\ActorController@destroy');

    $router->get('/directors', 'Admin\DirectorController@index');
    $router->post('/directors', 'Admin\DirectorController@store');
    $router->put('/directors/{id}', 'Admin\DirectorController@update');
    $router->delete('/directors/{id}', 'Admin\DirectorController@destroy');

    $router->get('/categories', 'Admin\CategoryController@index');
    $router->post('/categories', 'Admin\CategoryController@store');
    $router->put('/categories/{id}', 'Admin\CategoryController@update');
    $router->delete('/categories/{id}', 'Admin\CategoryController@destroy');

    $router->get('/users', 'Admin\UserController@index');
    $router->put('/users/{id}', 'Admin\UserController@update');
    $router->delete('/users/{id}', 'Admin\UserController@destroy');

    $router->get('/comments', 'Admin\CommentController@index');
    $router->delete('/comments/{id}', 'Admin\CommentController@destroy');

    $router->get('/settings', 'Admin\SettingController@index');
    $router->post('/settings', 'Admin\SettingController@update');

    $router->get('/ads', 'Admin\AdController@index');
    $router->post('/ads', 'Admin\AdController@store');
    $router->put('/ads/{id}', 'Admin\AdController@update');
    $router->delete('/ads/{id}', 'Admin\AdController@destroy');

    $router->get('/featured', 'Admin\FeaturedController@index');
    $router->post('/featured', 'Admin\FeaturedController@store');
    $router->delete('/featured/{id}', 'Admin\FeaturedController@destroy');

    $router->get('/announcements', 'Admin\AnnouncementController@index');
    $router->post('/announcements', 'Admin\AnnouncementController@store');
    $router->put('/announcements/{id}', 'Admin\AnnouncementController@update');
    $router->delete('/announcements/{id}', 'Admin\AnnouncementController@destroy');

    $router->get('/logs', 'Admin\LogController@index');
    $router->get('/seo', 'Admin\SeoController@index');
    $router->post('/seo', 'Admin\SeoController@update');

    $router->get('/backup', 'Admin\BackupController@index');
    $router->post('/backup/database', 'Admin\BackupController@export');
    $router->post('/backup/restore', 'Admin\BackupController@import');
});

$api = new \Core\Router();

$api->get('/movies', 'Api\MovieController@index');
$api->get('/latest', 'Api\MovieController@latest');
$api->get('/trending', 'Api\MovieController@trending');
$api->get('/search', 'Api\MovieController@search');
$api->get('/genres', 'Api\GenreController@index');
$api->get('/categories', 'Api\CategoryController@index');
$api->get('/movie/{slug}', 'Api\MovieController@show');
$api->get('/series', 'Api\SeriesController@index');
$api->get('/episodes', 'Api\EpisodeController@index');
$api->get('/settings', 'Api\SettingController@index');

$GLOBALS['_router'] = $router;
$GLOBALS['_api_router'] = $api;
