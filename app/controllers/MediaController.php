<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;

class MediaController extends Controller
{
    /**
     * Stream a file from the storage/uploads directory with HTTP range support
     * so uploaded videos and music can be played/seeked in the browser.
     *
     * Route: GET /storage/{path}  (path may contain subfolders, e.g. videos/abc.mp4)
     */
    public function serve(string $path): void
    {
        $path = ltrim($path, '/');
        if ($path === '' || str_contains($path, '..') || str_contains($path, "\0")) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid path']);
            exit;
        }

        $base = rtrim(STORAGE_PATH, '/') . '/uploads/';
        $file = $base . $path;

        if (!is_file($file) || !is_readable($file)) {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'File not found']);
            exit;
        }

        $this->streamFile($file);
    }

    private function streamFile(string $file): void
    {
        $size = filesize($file);
        $mime = mime_content_type($file) ?: 'application/octet-stream';

        header('Content-Type: ' . $mime);
        header('Accept-Ranges: bytes');
        header('Content-Length: ' . $size);
        header('Cache-Control: public, max-age=31536000');

        $range = $_SERVER['HTTP_RANGE'] ?? null;

        if ($range && preg_match('/bytes=(\d*)-(\d*)/', $range, $m)) {
            $start = $m[1] === '' ? 0 : (int)$m[1];
            $end = $m[2] === '' ? $size - 1 : (int)$m[2];
            $end = min($end, $size - 1);

            if ($start > $end || $start >= $size) {
                http_response_code(416);
                header('Content-Range: bytes */' . $size);
                exit;
            }

            $length = $end - $start + 1;
            http_response_code(206);
            header('Content-Range: bytes ' . $start . '-' . $end . '/' . $size);
            header('Content-Length: ' . $length);

            $fp = fopen($file, 'rb');
            fseek($fp, $start);
            echo fread($fp, $length);
            fclose($fp);
            exit;
        }

        http_response_code(200);
        readfile($file);
        exit;
    }
}
