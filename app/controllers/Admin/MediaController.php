<?php

declare(strict_types=1);

namespace Controllers\Admin;

use Core\Controller;
use Middleware\CsrfMiddleware;
use Models\Media;
use Models\FeaturedContent;
use Helpers\UploadHelper;

class MediaController extends Controller
{
    public function index(): void
    {
        $this->admin();
        $this->view('admin.media.index', [
            'title' => 'Media Library',
            'media' => (new Media())->all('created_at DESC')
        ]);
    }

    public function store(): void
    {
        $this->admin();

        if (!CsrfMiddleware::check()) {
            $this->json(['error' => 'CSRF token mismatch'], 419);
            return;
        }

        $type = $this->input('type');
        if (!in_array($type, ['video', 'music'], true)) {
            $this->json(['error' => 'Invalid media type'], 422);
            return;
        }

        $title = trim($this->input('title', ''));
        if ($title === '') {
            $this->json(['error' => 'Title is required'], 422);
            return;
        }

        $file = $_FILES['file'] ?? null;
        $filename = UploadHelper::uploadMedia($file, $type);

        if ($filename === null) {
            $this->json(['error' => 'Upload failed. Use a valid ' . ($type === 'music' ? 'audio' : 'video') . ' file under the size limit.'], 422);
            return;
        }

        $description = trim($this->input('description', ''));
        $id = (new Media())->create([
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'file_path' => $filename,
            'status' => 'active'
        ]);

        // Optionally pin the upload directly to a home page section.
        $section = trim($this->input('section', ''));
        if ($section !== '') {
            (new FeaturedContent())->create([
                'item_type' => 'media',
                'item_id' => (int)$id,
                'section' => $section,
                'sort_order' => (int)$this->input('sort_order', 0),
                'label' => $title
            ]);
        }

        $this->json(['success' => true, 'id' => $id]);
    }

    public function destroy(string $id): void
    {
        $this->admin();

        if (!CsrfMiddleware::check()) {
            $this->json(['error' => 'CSRF token mismatch'], 419);
            return;
        }

        $media = (new Media())->find((int)$id);
        if ($media) {
            $folder = $media['type'] === 'music' ? 'music' : 'videos';
            $file = rtrim(STORAGE_PATH, '/') . '/uploads/' . $folder . '/' . $media['file_path'];
            if (is_file($file)) {
                @unlink($file);
            }
            (new Media())->delete((int)$id);
        }

        $this->json(['success' => true]);
    }
}
