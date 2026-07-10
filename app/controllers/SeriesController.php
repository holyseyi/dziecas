<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Core\Database;
use Models\Series;
use Models\Episode;
use Models\Genre;
use Models\Category;
use Models\Country;
use Models\Director;
use Models\Actor;
use Models\Rating;
use Models\Comment;
use Models\Bookmark;
use Models\StreamingLink;
use Models\DownloadLink;

class SeriesController extends Controller
{
    public function index(): void
    {
        $page = (int)($this->input('page', 1));
        $perPage = PER_PAGE;
        $sort = $this->input('sort', 'latest');
        $genre = $this->input('genre');
        $country = $this->input('country');

        $db = Database::getInstance();
        $where = "status = 'published'";
        $params = [];

        if ($genre) {
            $where .= " AND id IN (SELECT series_id FROM movie_genres WHERE genre_id = (SELECT id FROM genres WHERE slug = :genre))";
            $params['genre'] = $genre;
        }
        if ($country) {
            $where .= " AND country_id = (SELECT id FROM countries WHERE slug = :country)";
            $params['country'] = $country;
        }

        $orderBy = match ($sort) {
            'popular' => 'view_count DESC',
            'trending' => 'user_rating DESC',
            'title' => 'title ASC',
            default => 'published_at DESC'
        };

        $results = (new Series())->paginate($page, $perPage, $orderBy, $where, $params);

        $this->configPageTitle('TV Series');
        $this->view('series.index', [
            'title' => 'TV Series',
            'series' => $results['items'],
            'pagination' => $results
        ]);
    }

    public function show(string $slug): void
    {
        $seriesModel = new Series();
        $series = $seriesModel->findBy('slug', $slug);

        if (!$series || ($series['status'] !== 'published' && !$this->isAdmin())) {
            $this->view('errors.404', ['title' => 'Not Found']);
            http_response_code(404);
            return;
        }

        $db = Database::getInstance();
        $series['genres'] = $db->fetchAll(
            "SELECT g.* FROM genres g JOIN movie_genres mg ON g.id = mg.genre_id WHERE mg.series_id = :id",
            ['id' => $series['id']]
        );

        $series['actors'] = $series['director_id'] ? $db->fetchAll(
            "SELECT a.*, am.role, am.character_name FROM actors a JOIN actor_movies am ON a.id = am.actor_id WHERE am.series_id = :id",
            ['id' => $series['id']]
        ) : [];

        $seasons = $db->fetchAll(
            "SELECT DISTINCT season FROM episodes WHERE series_id = :id ORDER BY season ASC",
            ['id' => $series['id']]
        );

        $this->view('series.show', [
            'title' => $series['title'] . ' - MovieHub',
            'series' => $series,
            'seasons' => $seasons
        ]);
    }

    public function season(string $seriesSlug, int $season): void
    {
        $seriesModel = new Series();
        $series = $seriesModel->findBy('slug', $seriesSlug);

        if (!$series) {
            $this->view('errors.404', ['title' => 'Not Found']);
            http_response_code(404);
            return;
        }

        $db = Database::getInstance();
        $episodes = $db->fetchAll(
            "SELECT * FROM episodes WHERE series_id = :sid AND season = :season ORDER BY episode_number ASC",
            ['sid' => $series['id'], 'season' => $season]
        );

        $this->view('series.season', [
            'title' => $series['title'] . ' - Season ' . $season,
            'series' => $series,
            'season' => $season,
            'episodes' => $episodes
        ]);
    }

    public function watch(string $seriesSlug, int $season, int $episode): void
    {
        $seriesModel = new Series();
        $series = $seriesModel->findBy('slug', $seriesSlug);

        if (!$series) {
            $this->view('errors.404', ['title' => 'Not Found']);
            http_response_code(404);
            return;
        }

        $episodeModel = new Episode();
        $ep = $episodeModel->fetch(
            "SELECT * FROM episodes WHERE series_id = :sid AND season = :season AND episode_number = :episode",
            ['sid' => $series['id'], 'season' => $season, 'episode' => $episode]
        );

        if (!$ep) {
            $this->view('errors.404', ['title' => 'Not Found']);
            http_response_code(404);
            return;
        }

        $db = Database::getInstance();
        $streamingLinks = $db->fetchAll("SELECT * FROM streaming_links WHERE episode_id = :eid", ['eid' => (int)$ep['id']]);
        $downloadLinks = $db->fetchAll("SELECT * FROM download_links WHERE episode_id = :eid", ['eid' => (int)$ep['id']]);

        $this->view('series.watch', [
            'title' => $series['title'] . ' - S' . $season . 'E' . $episode,
            'series' => $series,
            'season' => $season,
            'episode' => $ep,
            'streamingLinks' => $streamingLinks,
            'downloadLinks' => $downloadLinks
        ]);
    }
}
