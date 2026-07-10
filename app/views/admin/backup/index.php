
<h2 class="text-xl font-bold mb-6">Database Backup</h2>
<div class="bg-white dark:bg-gray-800 rounded-xl p-6">
    <p class="text-gray-600 dark:text-gray-400 mb-6">Export and import your SQLite database for backup and restore purposes.</p>
    <div class="flex items-center gap-4">
        <form method="POST" action="<?= url('/admin/backup/database') ?>" class="inline">
            <?= csrf_field() ?>
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg transition">Download Backup</button>
        </form>
    </div>
    <form method="POST" action="<?= url('/admin/backup/restore') ?>" enctype="multipart/form-data" class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
        <?= csrf_field() ?>
        <h3 class="font-bold mb-4">Restore Database</h3>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Database File</label>
            <input type="file" name="database" accept=".sqlite" required class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2">
        </div>
        <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg transition">Restore Database</button>
    </form>
</div>
