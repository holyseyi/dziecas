<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Core\CsrfMiddleware;
use Models\SiteSetting as SettingModel;

class SeoController extends Controller
{
    public function index(): void { $this->admin(); $this->view('admin.seo.index', ['title' => 'SEO Settings', 'settings' => (new SettingModel())->all()]); }
    public function update(): void { $this->admin(); if (!CsrfMiddleware::check()) { $this->back(); return; } $db = \Core\Database::getInstance(); foreach (['seo_title', 'seo_description', 'seo_keywords', 'canonical_url'] as $k) { $db->query("UPDATE site_settings SET value = :v, updated_at = CURRENT_TIMESTAMP WHERE `key` = :k", ['v' => $this->input($k, ''), 'k' => $k]); } $this->withSuccess('SEO settings updated'); $this->redirect('/admin/seo'); }
}
