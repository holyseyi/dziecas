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
}
