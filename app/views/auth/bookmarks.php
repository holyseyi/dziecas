
<section class="py-12 container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8"><?= e($user['username']) ?>'s Bookmarks</h1>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <?php foreach ($bookmarks as $bookmark): ?>
            <?php if ($bookmark['item_type'] === 'movie'): ?>
                <?= standalonePartial('movie-card', ['movie' => ['title' => $bookmark['movie_title'], 'poster' => $bookmark['movie_poster'], 'slug' => $bookmark['movie_slug'], 'short_description' => '']]) ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>
