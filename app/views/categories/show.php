<section class="py-12 container mx-auto px-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="p-4">
            <h2 class="text-xl font-bold mb-4"><?= e($category['name']) ?></h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6"><?= e($category['description'] ?? '') ?></p>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <?php foreach ($movies as $movie): ?>
                    <?= standalonePartial('movie-card', ['movie' => $movie]) ?>
                <?php endforeach; ?>
                <?php foreach ($series as $series): ?>
                    <?= standalonePartial('series-card', ['series' => $series]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
