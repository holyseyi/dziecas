

<article>
    <div class="relative h-[60vh] md:h-[70vh]">
        <img src="<?= asset('uploads/banners/' . ($movie['banner'] ?? '')) ?>" alt="<?= e($movie['title']) ?>" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent"></div>
    </div>

    <div class="container mx-auto px-4 -mt-48 relative z-10">
        <div class="flex flex-col md:flex-row gap-8 pb-12">
            <div class="flex-shrink-0">
                <img src="<?= asset('uploads/posters/' . ($movie['poster'] ?? 'default.jpg')) ?>" alt="<?= e($movie['title']) ?>" class="w-64 mx-auto md:mx-0 rounded-xl shadow-2xl border-4 border-gray-800">
            </div>
            <div class="flex-1 text-white">
                <h1 class="text-3xl md:text-5xl font-bold mb-2"><?= e($movie['title']) ?></h1>
                <?php if ($movie['original_title']): ?>
                    <p class="text-gray-400 text-lg mb-4"><?= e($movie['original_title']) ?></p>
                <?php endif; ?>

                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <?php if ($movie['imdb_rating'] > 0): ?>
                        <span class="bg-yellow-500 text-black px-3 py-1 rounded-full font-bold">&#9733; <?= number_format($movie['imdb_rating'], 1) ?></span>
                    <?php endif; ?>
                    <?php if ($movie['duration'] > 0): ?>
                        <span><?= floor($movie['duration'] / 60) ?>h <?= $movie['duration'] % 60 ?>m</span>
                    <?php endif; ?>
                    <span><?= formatDate($movie['release_date']) ?></span>
                    <span class="bg-gray-700 px-2 py-1 rounded text-sm"><?= e($movie['quality']) ?></span>
                </div>

                <div class="flex flex-wrap gap-2 mb-6">
                    <?php foreach (($movie['genres'] ?? []) as $genre): ?>
                        <span class="bg-primary-600/30 text-primary-300 px-3 py-1 rounded-full text-sm"><?= e($genre['name']) ?></span>
                    <?php endforeach; ?>
                </div>

                <div class="space-y-4 text-gray-300 mb-8 max-w-3xl">
                    <p><?= nl2br(e($movie['description'])) ?></p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-8">
                    <?php if ($movie['country']): ?>
                        <div><span class="text-gray-500">Country:</span> <span class="text-gray-300"><?= e($movie['country']['name']) ?></span></div>
                    <?php endif; ?>
                    <?php if ($movie['language']): ?>
                        <div><span class="text-gray-500">Language:</span> <span class="text-gray-300"><?= e($movie['language']['name']) ?></span></div>
                    <?php endif; ?>
                    <?php if ($movie['director']): ?>
                        <div><span class="text-gray-500">Director:</span> <a href="<?= url('/director/' . $movie['director']['slug']) ?>" class="text-primary-400 hover:underline"><?= e($movie['director']['name']) ?></a></div>
                    <?php endif; ?>
                    <div><span class="text-gray-500">Views:</span> <span class="text-gray-300"><?= formatNumber((int)$movie['view_count']) ?></span></div>
                </div>

                <div class="flex flex-wrap items-center gap-4">
                    <?php if (($movie['streaming_links'] ?? []) || $this->isAuthenticated()): ?>
                        <a href="<?= url('/movie/' . $movie['slug'] . '?stream=1') ?>" class="bg-primary-600 hover:bg-primary-700 px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            Watch Now
                        </a>
                    <?php endif; ?>
                    <a href="<?= url('/report-broken-link?id=' . $movie['id']) ?>" class="border border-gray-600 hover:border-white px-4 py-3 rounded-lg transition text-sm">Report Broken Link</a>
                    <button onclick="shareMovie(<?= e($movie['id']) ?>)" class="border border-gray-600 hover:border-white px-4 py-3 rounded-lg transition text-sm">Share</button>
                </div>
            </div>
        </div>

        <?php if (($movie['actors'] ?? [])): ?>
            <div class="py-12 border-t border-gray-800">
                <h2 class="text-2xl font-bold mb-6 text-white">Cast</h2>
                <div class="flex gap-6 overflow-x-auto pb-4">
                    <?php foreach ($movie['actors'] as $actor): ?>
                        <a href="<?= url('/actor/' . $actor['slug']) ?>" class="flex-shrink-0 text-center">
                            <img src="<?= asset('uploads/avatars/' . ($actor['image'] ?? 'default.png')) ?>" alt="" class="w-24 h-24 rounded-full bg-gray-800 mb-2 object-cover">
                            <p class="text-white font-medium"><?= e($actor['name']) ?></p>
                            <p class="text-gray-400 text-sm"><?= e($actor['character_name'] ?? '') ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (($movie['screenshots'] ?? [])): ?>
            <div class="py-12 border-t border-gray-800">
                <h2 class="text-2xl font-bold mb-6 text-white">Gallery</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($movie['screenshots'] as $shot): ?>
                        <img src="<?= asset('uploads/screenshots/' . $shot['image']) ?>" alt="" class="rounded-lg hover:opacity-80 transition cursor-pointer">
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (($movie['download_links'] ?? [])): ?>
            <div class="py-12 border-t border-gray-800">
                <h2 class="text-2xl font-bold mb-6 text-white">Download Links</h2>
                <div class="space-y-3">
                    <?php foreach ($movie['download_links'] as $link): ?>
                        <a href="<?= e($link['url']) ?>" target="_blank" class="flex items-center justify-between bg-gray-800 hover:bg-gray-700 p-4 rounded-lg transition">
                            <div>
                                <span class="font-semibold"><?= e($link['title']) ?></span>
                                <span class="text-gray-400 text-sm ml-2"><?= e($link['quality']) ?> - <?= e($link['format']) ?></span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="py-12 border-t border-gray-800">
            <h2 class="text-2xl font-bold mb-6 text-white">Related Movies</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <?php foreach ($relatedMovies as $related): ?>
                    <?php $this->partial('partials.movie-card', ['movie' => $related]); ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="py-12 border-t border-gray-800">
            <h2 class="text-2xl font-bold mb-6 text-white">Comments</h2>
            <form action="<?= url('/comment/movie/' . $movie['id']) ?>" method="POST" class="mb-8">
                <?= csrf_field() ?>
                <textarea name="content" rows="4" placeholder="Write a comment..." class="w-full bg-gray-800 text-white rounded-lg p-4 focus:outline-none focus:ring-2 focus:ring-primary-500"></textarea>
                <button type="submit" class="mt-3 bg-primary-600 hover:bg-primary-700 px-6 py-2 rounded-lg font-medium transition">Post Comment</button>
            </form>
            <div class="space-y-4">
                <?php foreach (($movie['comments'] ?? []) as $comment): ?>
                <div class="bg-gray-800 rounded-lg p-4">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="font-semibold text-white"><?= e($comment['author_name'] ?? 'User') ?></span>
                        <span class="text-gray-500 text-sm"><?= formatDate($comment['created_at']) ?></span>
                    </div>
                    <p class="text-gray-300"><?= e($comment['content']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</article>

