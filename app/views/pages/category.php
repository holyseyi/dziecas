
<section class="py-12 container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6"><?= e($title) ?></h1>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <?php foreach ($items as $item): ?>
            <?= ($type ?? 'movie') === 'series' ? standalonePartial('series-card', ['series' => $item]) : standalonePartial('movie-card', ['movie' => $item]) ?>
        <?php endforeach; ?>
    </div>
</section>
