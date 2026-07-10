<section class="py-12 container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6 text-white"><?= e($director['name']) ?></h1>
    <div class="flex items-start gap-8 mb-8">
        <img src="<?= asset('uploads/avatars/' . ($director['image'] ?? 'default.png')) ?>" alt="" class="w-48 rounded-xl bg-gray-800">
        <div class="text-white">
            <p class="text-gray-400 mb-4"><?= nl2br(e($director['biography'])) ?></p>
        </div>
    </div>
    <h2 class="text-xl font-bold mb-4 text-white">Directed</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <?php foreach ($movies as $movie): ?>
            <?= standalonePartial('movie-card', ['movie' => $movie]) ?>
        <?php endforeach; ?>
    </div>
</section>
