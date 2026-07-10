<section class="py-12 container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">Movies from <?= e($year) ?></h1>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <?php foreach ($movies as $movie): ?>
            <?= standalonePartial('movie-card', ['movie' => $movie]) ?>
        <?php endforeach; ?>
    </div>
</section>
