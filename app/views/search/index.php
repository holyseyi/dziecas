<section class="py-12 container mx-auto px-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold mb-4">Search Results for "<?= e($query) ?>"</h1>
        <?php if (empty($results['movies']) && empty($results['series'])): ?>
            <p class="text-gray-500">No results found.</p>
        <?php else: ?>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <?php foreach (($results['movies'] ?? []) as $movie): ?>
                    <?= standalonePartial('movie-card', ['movie' => $movie]) ?>
                <?php endforeach; ?>
                <?php foreach (($results['series'] ?? []) as $series): ?>
                    <?= standalonePartial('series-card', ['series' => $series]) ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
