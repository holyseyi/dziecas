<?php
$isVideo = ($media['type'] ?? 'video') === 'video';
$src = url('/storage/' . ($isVideo ? 'videos' : 'music') . '/' . $media['file_path']);
?>
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700 flex flex-col">
    <div class="<?= $isVideo ? 'aspect-video bg-black' : 'p-6 bg-gradient-to-br from-primary-600 to-primary-800' ?>">
        <?php if ($isVideo): ?>
            <video class="w-full h-full object-contain" controls preload="metadata" poster="<?= asset('images/favicon.svg') ?>">
                <source src="<?= e($src) ?>" type="<?= $isVideo ? 'video/mp4' : 'audio/mpeg' ?>">
                Your browser does not support the video tag.
            </video>
        <?php else: ?>
            <div class="flex items-center justify-center h-32">
                <svg class="w-16 h-16 text-white/90" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55A4 4 0 1014 17V7h4V3h-6z"/></svg>
            </div>
        <?php endif; ?>
    </div>
    <div class="p-5 flex-1 flex flex-col">
        <div class="flex items-center gap-2 mb-2">
            <span class="text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded-full <?= $isVideo ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300' ?>">
                <?= $isVideo ? 'Video' : 'Music' ?>
            </span>
        </div>
        <h3 class="font-bold text-lg text-gray-900 dark:text-white leading-tight"><?= e($media['title']) ?></h3>
        <?php if (!empty($media['description'])): ?>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 line-clamp-2"><?= e(truncate($media['description'], 140)) ?></p>
        <?php endif; ?>
        <?php if (!$isVideo): ?>
            <div class="mt-4">
                <audio class="w-full" controls preload="none">
                    <source src="<?= e($src) ?>" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            </div>
        <?php endif; ?>
    </div>
</div>
