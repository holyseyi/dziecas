<footer class="bg-gray-900 dark:bg-dark-950 text-gray-400 py-12 mt-auto">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-white text-lg font-bold mb-4">MovieHub</h3>
                <p class="text-sm">Your ultimate destination for movies, TV series, anime, and more. Stream and download the latest entertainment.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Categories</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?= path('/movies') ?>" class="hover:text-primary-400 transition">Movies</a></li>
                    <li><a href="<?= path('/series') ?>" class="hover:text-primary-400 transition">TV Series</a></li>
                    <li><a href="<?= path('/anime') ?>" class="hover:text-primary-400 transition">Anime</a></li>
                    <li><a href="<?= path('/documentaries') ?>" class="hover:text-primary-400 transition">Documentaries</a></li>
                    <li><a href="<?= path('/music-videos') ?>" class="hover:text-primary-400 transition">Music Videos</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Browse</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?= path('/trending') ?>" class="hover:text-primary-400 transition">Trending</a></li>
                    <li><a href="<?= path('/latest') ?>" class="hover:text-primary-400 transition">Latest</a></li>
                    <li><a href="<?= path('/popular') ?>" class="hover:text-primary-400 transition">Popular</a></li>
                    <li><a href="<?= path('/hollywood') ?>" class="hover:text-primary-400 transition">Hollywood</a></li>
                    <li><a href="<?= path('/nollywood') ?>" class="hover:text-primary-400 transition">Nollywood</a></li>
                    <li><a href="<?= path('/bollywood') ?>" class="hover:text-primary-400 transition">Bollywood</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Legal</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?= path('/privacy') ?>" class="hover:text-primary-400 transition">Privacy Policy</a></li>
                    <li><a href="<?= path('/terms') ?>" class="hover:text-primary-400 transition">Terms of Service</a></li>
                    <li><a href="<?= path('/dmca') ?>" class="hover:text-primary-400 transition">DMCA</a></li>
                    <li><a href="<?= path('/contact') ?>" class="hover:text-primary-400 transition">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
            <p>&copy; <?= date('Y') ?> MovieHub. All rights reserved.</p>
        </div>
    </div>
</footer>
