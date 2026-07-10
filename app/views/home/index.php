<section class="relative h-[70vh] md:h-[80vh] overflow-hidden">
    <?php if (!empty($heroMovie) && is_array($heroMovie) && !empty($heroMovie['banner'])): ?>
        <img src="<?= asset('uploads/banners/' . $heroMovie['banner']) ?>" alt="<?= e($heroMovie['title'] ?? '') ?>" class="absolute inset-0 w-full h-full object-cover opacity-40">
    <?php endif; ?>
    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
    <div class="relative container mx-auto px-4 h-full flex items-end pb-16">
        <div class="max-w-2xl">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 leading-tight"><?= e($heroMovie['title'] ?? 'Welcome to MovieHub') ?></h1>
            <p class="text-gray-300 text-lg mb-6 line-clamp-3"><?= e(truncate($heroMovie['description'] ?? 'Discover the latest movies, TV series, anime, and more. Browse by genre, country, or year.', 250)) ?></p>
            <div class="flex items-center gap-4 mb-6">
                <?php if (!empty($heroMovie['imdb_rating'])): ?>
                    <span class="bg-yellow-500 text-black px-3 py-1 rounded-full font-bold text-sm">&#9733; <?= number_format($heroMovie['imdb_rating'], 1) ?></span>
                <?php endif; ?>
                <?php if (!empty($heroMovie['duration'])): ?>
                    <span class="text-gray-300"><?= floor($heroMovie['duration'] / 60) ?>h <?= $heroMovie['duration'] % 60 ?>m</span>
                <?php endif; ?>
                <?php if (!empty($heroMovie['release_date'])): ?>
                    <span class="text-gray-300"><?= formatDate($heroMovie['release_date']) ?></span>
                <?php endif; ?>
            </div>
            <div class="flex items-center gap-4">
                <?php if (!empty($heroMovie) && !empty($heroMovie['slug'])): ?>
                    <a href="<?= url('/movie/' . $heroMovie['slug']) ?>" class="bg-primary-600 hover:bg-primary-700 px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        Watch Now
                    </a>
                <?php endif; ?>
                <a href="<?= url('/movies') ?>" class="bg-white/10 hover:bg-white/20 px-6 py-3 rounded-lg font-semibold transition backdrop-blur-sm">
                    Browse All
                </a>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($featuredContent)): ?>
    <?php
    $homeSections = [];
    foreach ($featuredContent as $fc) {
        $homeSections[$fc['section']][] = $fc;
    }
    ?>
    <?php foreach ($homeSections as $sectionName => $items): ?>
        <section class="py-12 container mx-auto px-4">
            <div class="flex items-center gap-3 mb-8">
                <span class="w-1.5 h-8 rounded-full bg-primary-600"></span>
                <h2 class="text-3xl font-bold"><?= e($sectionName) ?></h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($items as $fc): ?>
                    <?php if ($fc['item_type'] === 'media'): ?>
                        <?php $item = (new \Models\Media())->find((int)$fc['item_id']); ?>
                        <?php if ($item): ?><?= standalonePartial('media-card', ['media' => $item]) ?><?php endif; ?>
                    <?php elseif ($fc['item_type'] === 'series'): ?>
                        <?php $item = (new \Models\Series())->find((int)$fc['item_id']); ?>
                        <?php if ($item): ?><?= standalonePartial('series-card', ['series' => $item]) ?><?php endif; ?>
                    <?php else: ?>
                        <?php $item = (new \Models\Movie())->find((int)$fc['item_id']); ?>
                        <?php if ($item): ?><?= standalonePartial('movie-card', ['movie' => $item]) ?><?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (!empty($featuredMovies) || !empty($latestMovies)): ?>
<section class="py-12 container mx-auto px-4">
    <?php if (!empty($featuredMovies)): ?>
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold">Featured Movies</h2>
            <a href="<?= url('/movies') ?>" class="text-primary-500 hover:underline">View All</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-12">
            <?php foreach ($featuredMovies as $movie): ?>
                <?= standalonePartial('movie-card', ['movie' => $movie]) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold">Latest Uploads</h2>
        <a href="<?= url('/latest') ?>" class="text-primary-500 hover:underline">View All</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <?php foreach ($latestMovies as $movie): ?>
            <?= standalonePartial('movie-card', ['movie' => $movie]) ?>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($trendingMovies) || !empty($trendingSeries)): ?>
<section class="py-12 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-white">Trending Now</h2>
            <a href="<?= url('/trending') ?>" class="text-primary-400 hover:underline">View All</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <?php foreach ($trendingMovies as $movie): ?>
                <?= standalonePartial('movie-card', ['movie' => $movie]) ?>
            <?php endforeach; ?>
            <?php foreach ($trendingSeries as $series): ?>
                <?= standalonePartial('series-card', ['series' => $series]) ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($recentlyUpdatedSeries)): ?>
<section class="py-12 container mx-auto px-4">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold">Recently Updated Series</h2>
        <a href="<?= url('/series') ?>" class="text-primary-500 hover:underline">View All</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php foreach ($recentlyUpdatedSeries as $series): ?>
            <?= standalonePartial('series-card', ['series' => $series]) ?>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($genres)): ?>
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Browse by Genre</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <?php foreach ($genres as $genre): ?>
                <a href="<?= url('/genre/' . $genre['slug']) ?>" class="bg-white dark:bg-gray-800 rounded-xl p-6 text-center shadow-sm hover:shadow-md transition border border-gray-200 dark:border-gray-700">
                    <div class="text-2xl mb-2">&#127909;</div>
                    <h3 class="font-semibold"><?= e($genre['name']) ?></h3>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
