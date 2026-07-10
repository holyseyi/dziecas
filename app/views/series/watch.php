<section class="py-12 bg-gray-900">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-2 text-white"><?= e($series['title']) ?></h1>
        <p class="text-gray-400 mb-6">Season <?= $season ?> - Episode <?= $episode['episode_number'] ?></p>

        <div class="bg-gray-800 rounded-xl p-6 mb-8">
            <h2 class="text-xl font-bold text-white mb-2"><?= e($episode['title'] ?: 'Episode ' . $episode['episode_number']) ?></h2>
            <p class="text-gray-300 mb-6"><?= nl2br(e($episode['description'])) ?></p>
            <div class="flex flex-wrap gap-2 mb-6">
                <span class="bg-primary-600/30 text-primary-300 px-3 py-1 rounded-full text-sm"><?= $episode['duration'] ?> min</span>
                <span class="bg-gray-700 text-gray-300 px-3 py-1 rounded-full text-sm"><?= formatDate($episode['air_date']) ?></span>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl p-6 mb-6">
            <h3 class="text-lg font-bold text-white mb-4">Streaming Links</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <?php foreach ($streamingLinks as $link): ?>
                    <a href="<?= e($link['url']) ?>" target="_blank" class="bg-gray-700 hover:bg-gray-600 p-4 rounded-lg transition flex items-center justify-between">
                        <div>
                            <p class="font-medium text-white"><?= e($link['title']) ?></p>
                            <p class="text-gray-400 text-sm"><?= e($link['quality']) ?> - <?= e($link['format']) ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if (!empty($downloadLinks)): ?>
            <div class="bg-gray-800 rounded-xl p-6">
                <h3 class="text-lg font-bold text-white mb-4">Download Links</h3>
                <div class="space-y-3">
                    <?php foreach ($downloadLinks as $link): ?>
                        <a href="<?= e($link['url']) ?>" target="_blank" class="flex items-center justify-between bg-gray-700 hover:bg-gray-600 p-4 rounded-lg transition">
                            <div>
                                <p class="font-medium text-white"><?= e($link['title']) ?></p>
                                <p class="text-gray-400 text-sm"><?= e($link['quality']) ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
