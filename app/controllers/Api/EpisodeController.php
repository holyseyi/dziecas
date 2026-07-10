<?php

declare(strict_types=1);

namespace Controllers\Api;

use Core\Controller;
use Models\Episode;

class EpisodeController extends Controller
{
    public function index(): void
    {
        $seriesId = (int)$this->input('series_id', 0);
        $where = $seriesId > 0 ? "series_id = :sid" : "1=1";
        $params = $seriesId > 0 ? ['sid' => $seriesId] : [];
        $this->json(['success' => true, 'data' => (new Episode())->fetchAll("SELECT * FROM episodes WHERE $where ORDER BY season, episode_number", $params)]);
    }
}
