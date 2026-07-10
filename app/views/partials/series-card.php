<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="p-4">
        <div class="flex items-start gap-4">
            <img src="<?= asset('uploads/posters/' . ($series['poster'] ?? 'default.jpg')) ?>" alt="" class="w-20 h-28 object-cover rounded-lg bg-gray-700 flex-shrink-0">
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-gray-900 dark:text-white truncate">
                    <a href="<?= path('/series/' . $series['slug']) ?>" class="hover:text-primary-500 transition"><?= e($series['title']) ?></a>
                </h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= e($series['short_description'] ?? truncate($series['description'], 120)) ?></p>
                <div class="flex items-center gap-3 mt-2">
                    <?php if ($series['imdb_rating'] > 0): ?>
                        <span class="text-yellow-500 text-sm">&#9733; <?= number_format($series['imdb_rating'], 1) ?></span>
                    <?php endif; ?>
                    <span class="bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 px-2 py-0.5 rounded text-xs font-medium"><?= $series['total_seasons'] ?? 1 ?> <?= ($series['total_seasons'] ?? 1) > 1 ? 'Seasons' : 'Season' ?></span>
                    <span class="text-gray-400 text-sm">&#128065; <?= formatNumber((int)$series['view_count']) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
