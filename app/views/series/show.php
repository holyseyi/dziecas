
<section class="py-12 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="flex items-start gap-8">
            <img src="<?= asset('uploads/posters/' . ($series['poster'] ?? 'default.jpg')) ?>" alt="<?= e($series['title']) ?>" class="w-48 rounded-xl shadow-2xl bg-gray-800">
            <div class="text-white flex-1">
                <h1 class="text-3xl md:text-5xl font-bold mb-2"><?= e($series['title']) ?></h1>
                <p class="text-gray-400 mt-2 mb-4"><?= e(truncate($series['description'], 250)) ?></p>
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <span class="bg-gray-700 px-3 py-1 rounded-full text-sm"><?= ($series['total_seasons'] ?? 1) ?> Seasons</span>
                    <span class="bg-gray-700 px-3 py-1 rounded-full text-sm"><?= ($series['total_episodes'] ?? 0) ?> Episodes</span>
                    <?php if ($series['imdb_rating'] > 0): ?>
                        <span class="bg-yellow-500 text-black px-3 py-1 rounded-full font-bold text-sm">&#9733; <?= number_format($series['imdb_rating'], 1) ?></span>
                    <?php endif; ?>
                </div>
                <div class="flex flex-wrap gap-2 mb-8">
                    <?php foreach (($series['genres'] ?? []) as $genre): ?>
                        <a href="<?= url('/genre/' . $genre['slug']) ?>" class="bg-primary-600/30 text-primary-300 px-3 py-1 rounded-full text-sm hover:bg-primary-600/50 transition"><?= e($genre['name']) ?></a>
                    <?php endforeach; ?>
                </div>

                <h3 class="text-xl font-bold mb-4">Seasons</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <?php foreach ($seasons as $s): ?>
                        <a href="<?= url('/series/' . $series['slug'] . '/season/' . $s['season']) ?>" class="bg-gray-700 hover:bg-gray-600 rounded-lg p-4 text-center transition">
                            <div class="text-2xl font-bold"><?= $s['season'] ?></div>
                            <div class="text-gray-400 text-sm">Season</div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
