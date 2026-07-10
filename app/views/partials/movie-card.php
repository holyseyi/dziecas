<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="p-4 flex items-center gap-4">
        <img src="<?= asset('uploads/posters/' . ($movie['poster'] ?? 'default.jpg')) ?>" alt="" class="w-16 h-24 object-cover rounded-lg bg-gray-700">
        <div class="flex-1 min-w-0">
            <h3 class="font-semibold text-gray-900 dark:text-white truncate">
                <a href="<?= path('/movie/' . $movie['slug']) ?>" class="hover:text-primary-500 transition"><?= e($movie['title']) ?></a>
            </h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= e($movie['short_description'] ?? truncate($movie['description'], 100)) ?></p>
            <div class="flex items-center gap-3 mt-2">
                <?php if ($movie['imdb_rating'] > 0): ?>
                    <span class="text-yellow-500 text-sm">&#9733; <?= number_format($movie['imdb_rating'], 1) ?></span>
                <?php endif; ?>
                <span class="text-gray-400 text-sm"><?= formatDate($movie['release_date']) ?></span>
                <span class="text-gray-400 text-sm">&#128065; <?= formatNumber((int)$movie['view_count']) ?></span>
            </div>
        </div>
    </div>
</div>
