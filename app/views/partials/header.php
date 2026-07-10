<header class="bg-gray-900 dark:bg-dark-950 text-white sticky top-0 z-50 shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <a href="<?= path('/') ?>" class="text-2xl font-bold text-primary-500 tracking-tight flex items-center gap-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h18M3 16h18"/></svg>
                MovieHub
            </a>

            <nav class="hidden lg:flex items-center gap-6">
                <a href="<?= path('/') ?>" class="text-gray-300 hover:text-white transition">Home</a>
                <a href="<?= path('/movies') ?>" class="text-gray-300 hover:text-white transition">Movies</a>
                <a href="<?= path('/series') ?>" class="text-gray-300 hover:text-white transition">TV Series</a>
                <a href="<?= path('/anime') ?>" class="text-gray-300 hover:text-white transition">Anime</a>
                <a href="<?= path('/kdramas') ?>" class="text-gray-300 hover:text-white transition">K-Dramas</a>
                <a href="<?= path('/hollywood') ?>" class="text-gray-300 hover:text-white transition">Hollywood</a>
                <a href="<?= path('/nollywood') ?>" class="text-gray-300 hover:text-white transition">Nollywood</a>
                <a href="<?= path('/bollywood') ?>" class="text-gray-300 hover:text-white transition">Bollywood</a>
                <a href="<?= path('/documentaries') ?>" class="text-gray-300 hover:text-white transition">Documentaries</a>
                <a href="<?= path('/trending') ?>" class="text-gray-300 hover:text-white transition">Trending</a>
                <a href="<?= path('/latest') ?>" class="text-gray-300 hover:text-white transition">Latest</a>
                <a href="<?= path('/popular') ?>" class="text-gray-300 hover:text-white transition">Popular</a>
            </nav>

            <div class="flex items-center gap-3">
                <form action="<?= path('/search') ?>" method="GET" class="hidden md:flex items-center">
                    <input type="text" name="q" placeholder="Search..." value="<?= e($query ?? '') ?>" class="bg-gray-800 text-white px-3 py-1.5 rounded-l-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 w-48">
                    <button type="submit" class="bg-primary-600 px-3 py-1.5 rounded-r-lg hover:bg-primary-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>

                <button id="theme-toggle" class="p-2 hover:bg-gray-800 rounded-lg transition" title="Toggle Theme">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>

                <?php if (!empty($user)): ?>
                    <div class="relative group">
                        <button class="flex items-center gap-2 hover:bg-gray-800 px-3 py-1.5 rounded-lg transition">
                            <img src="<?= asset('uploads/avatars/' . ($user['avatar'] ?? 'default.png')) ?>" alt="" class="w-8 h-8 rounded-full bg-gray-700">
                            <span class="hidden sm:inline"><?= e($user['username'] ?? 'User') ?></span>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                            <a href="<?= path('/profile') ?>" class="block px-4 py-2 hover:bg-gray-700 rounded-t-lg">Profile</a>
                            <a href="<?= path('/profile/bookmarks') ?>" class="block px-4 py-2 hover:bg-gray-700">Bookmarks</a>
                            <a href="<?= path('/profile/history') ?>" class="block px-4 py-2 hover:bg-gray-700">History</a>
                            <a href="<?= path('/profile/ratings') ?>" class="block px-4 py-2 hover:bg-gray-700">Ratings</a>
                            <a href="<?= path('/logout') ?>" class="block px-4 py-2 hover:bg-gray-700 rounded-b-lg text-red-400">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= path('/login') ?>" class="text-sm hover:text-primary-400 transition">Login</a>
                    <a href="<?= path('/register') ?>" class="bg-primary-600 px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-primary-700 transition">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
