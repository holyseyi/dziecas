<?php

declare(strict_types=1);

namespace Controllers\Api;

use Core\Controller;
use Models\SiteSetting;

class SettingController extends Controller
{
    public function index(): void
    {
        $db = \Core\Database::getInstance();
        $settings = $db->fetchAll("SELECT `key`, value FROM site_settings WHERE is_public = 1");
        $data = [];
        foreach ($settings as $s) {
            $data[$s['key']] = $s['value'];
        }
        $this->json(['success' => true, 'data' => $data]);
    }
}
