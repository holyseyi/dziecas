<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers/functions.php';

$api = new \Core\Router();
$api->prefix('api', function() use ($api) {
    $api->get('/', function() {
        echo json_encode(['success' => true, 'message' => 'MovieHub API']);
    });
    $api->get('/movies', 'Api\MovieController@index');
    $api->get('/movies/latest', 'Api\MovieController@latest');
    $api->get('/movies/trending', 'Api\MovieController@trending');
    $api->get('/movies/search', 'Api\MovieController@search');
    $api->get('/movies/{slug}', 'Api\MovieController@show');
    $api->get('/series', 'Api\SeriesController@index');
    $api->get('/series/{slug}', 'Api\SeriesController@show');
    $api->get('/genres', 'Api\GenreController@index');
    $api->get('/categories', 'Api\CategoryController@index');
    $api->get('/episodes', 'Api\EpisodeController@index');
    $api->get('/settings', 'Api\SettingController@index');
});

$GLOBALS['_api_router'] = $api;
