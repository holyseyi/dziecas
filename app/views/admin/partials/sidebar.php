<div class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-white p-6 space-y-6 z-50">
    <a href="<?= url('/admin') ?>" class="text-2xl font-bold text-primary-400 block mb-8">&#127909; MovieHub</a>
    <nav class="space-y-1">
        <a href="<?= url('/admin/dashboard') ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            Dashboard
        </a>
        <a href="<?= url('/admin/movies') ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h18M3 16h18"/></svg>
            Movies
        </a>
        <a href="<?= url('/admin/series') ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Series
        </a>
        <div class="pt-4 mt-4 border-t border-gray-700">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Manage</p>
            <a href="<?= url('/admin/genres') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm">Genres</a>
            <a href="<?= url('/admin/categories') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm">Categories</a>
            <a href="<?= url('/admin/countries') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm">Countries</a>
            <a href="<?= url('/admin/actors') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm">Actors</a>
            <a href="<?= url('/admin/directors') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm">Directors</a>
            <a href="<?= url('/admin/users') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm">Users</a>
            <a href="<?= url('/admin/comments') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm">Comments</a>
        </div>
        <div class="pt-4 mt-4 border-t border-gray-700">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">System</p>
            <a href="<?= url('/admin/ads') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm">Ads</a>
            <a href="<?= url('/admin/featured') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm">Featured</a>
            <a href="<?= url('/admin/announcements') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm">Announcements</a>
            <a href="<?= url('/admin/settings') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm">Settings</a>
            <a href="<?= url('/admin/seo') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm">SEO</a>
            <a href="<?= url('/admin/logs') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm">Logs</a>
            <a href="<?= url('/admin/backup') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-sm">Backup</a>
        </div>
    </nav>
</div>
