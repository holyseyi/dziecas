<?php

declare(strict_types=1);

namespace Helpers;

class UploadHelper
{
    public static function upload(?array $file, string $folder): ?string
    {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        
        if (!in_array($file['type'], $allowedTypes)) {
            return null;
        }

        $maxSize = UPLOAD_MAX_SIZE;
        if ($file['size'] > $maxSize) {
            return null;
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $folder . '_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $uploadPath = STORAGE_PATH . 'uploads/' . $folder . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return null;
        }

        return $filename;
    }

    /**
     * Upload a video or music file. Returns the stored filename (relative to
     * uploads/<folder>/) or null on failure.
     */
    public static function uploadMedia(?array $file, string $type): ?string
    {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $videoTypes = ['video/mp4', 'video/webm', 'video/ogg', 'video/quicktime'];
        $audioTypes = [
            'audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/x-wav',
            'audio/ogg', 'audio/webm', 'audio/aac', 'audio/x-m4a', 'audio/mp4',
        ];

        $allowed = $type === 'music' ? $audioTypes : $videoTypes;

        if (!in_array($file['type'], $allowed, true)) {
            return null;
        }

        $maxSize = defined('MEDIA_MAX_SIZE') ? (int)MEDIA_MAX_SIZE : (defined('UPLOAD_MAX_SIZE') ? (int)UPLOAD_MAX_SIZE : 50 * 1024 * 1024);
        if ($file['size'] > $maxSize) {
            return null;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = $type . '_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $folder = $type === 'music' ? 'music' : 'videos';
        $uploadPath = STORAGE_PATH . 'uploads/' . $folder . '/' . $filename;

        if (!is_dir(dirname($uploadPath))) {
            @mkdir(dirname($uploadPath), 0777, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return null;
        }

        return $filename;
    }
}
