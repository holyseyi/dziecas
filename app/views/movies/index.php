
<section class="py-12 container mx-auto px-4">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold">All Movies</h1>
        <div class="flex items-center gap-2">
            <label>Sort:</label>
            <select onchange="location = '?sort=' + this.value" class="bg-gray-800 text-white rounded-lg px-3 py-2 focus:outline-none">
                <option value="latest" <?= ($sort ?? 'latest') === 'latest' ? 'selected' : '' ?>>Latest</option>
                <option value="popular" <?= ($sort ?? '') === 'popular' ? 'selected' : '' ?>>Popular</option>
                <option value="trending" <?= ($sort ?? '') === 'trending' ? 'selected' : '' ?>>Trending</option>
                <option value="title" <?= ($sort ?? '') === 'title' ? 'selected' : '' ?>>A-Z</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        <?php foreach ($movies as $movie): ?>
                <?= standalonePartial('movie-card', ['movie' => $movie]); ?>
        <?php endforeach; ?>
    </div>

    <?php if (($pagination['total_pages'] ?? 1) > 1): ?>
        <div class="flex justify-center gap-2 mt-8">
            <?php for ($i = 1; $i <= min(5, ($pagination['total_pages'] ?? 1)); $i++): ?>
                <a href="?page=<?= $i ?>&sort=<?= e($sort ?? 'latest') ?>" class="px-4 py-2 rounded-lg <?= ($i == ($pagination['page'] ?? 1)) ? 'bg-primary-600 text-white' : 'bg-gray-800 hover:bg-gray-700' ?> transition"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</section>
