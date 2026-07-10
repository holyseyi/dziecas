<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Core\CsrfMiddleware;
use Models\SiteSetting as SettingModel;

class SettingController extends Controller
{
    public function index(): void
    {
        $this->admin();
        $this->view('admin.settings.index', [
            'title' => 'Settings - Admin',
            'settings' => (new SettingModel())->all()
        ]);
    }

    public function update(): void
    {
        $this->admin();
        if (!CsrfMiddleware::check()) { $this->back(); return; }

        foreach ($_POST as $key => $value) {
            if (in_array($key, ['csrf_token', '_method'])) continue;
            $db = \Core\Database::getInstance();
            $existing = $db->fetch("SELECT id FROM site_settings WHERE `key` = :key", ['key' => $key]);
            if ($existing) {
                $db->query("UPDATE site_settings SET value = :value, updated_at = CURRENT_TIMESTAMP WHERE `key` = :key", ['value' => is_array($value) ? json_encode($value) : $value, 'key' => $key]);
            } else {
                $db->query("INSERT INTO site_settings (`key`, value) VALUES (:key, :value)", ['key' => $key, 'value' => is_array($value) ? json_encode($value) : $value]);
            }
        }

        $this->withSuccess('Settings saved successfully');
        $this->redirect('/admin/settings');
    }
}
