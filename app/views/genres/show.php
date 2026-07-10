<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 mb-8">
    <h1 class="text-2xl font-bold mb-6 text-white"><?= e($genre['name']) ?></h1>
    <p class="text-gray-400 mb-6"><?= e($genre['description'] ?? '') ?></p>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <?php foreach ($movies as $movie): ?>
            <?= standalonePartial('movie-card', ['movie' => $movie]) ?>
        <?php endforeach; ?>
        <?php foreach ($series as $series): ?>
            <?= standalonePartial('series-card', ['series' => $series]) ?>
        <?php endforeach; ?>
    </div>
</div>
