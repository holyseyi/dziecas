
<h2 class="text-xl font-bold mb-6">Advertisements</h2>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr><th class="px-4 py-3">Name</th><th class="px-4 py-3">Position</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Clicks</th><th class="px-4 py-3">Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($ads as $ad): ?>
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-medium"><?= e($ad['name']) ?></td>
                    <td class="px-4 py-3"><?= e($ad['position']) ?></td>
                    <td class="px-4 py-3"><?= ucfirst($ad['status']) ?></td>
                    <td class="px-4 py-3"><?= (int)$ad['click_count'] ?></td>
                    <td class="px-4 py-3">
                        <button onclick="deleteItem('/admin/ads/<?= $ad['id'] ?>')" class="text-red-500 hover:underline text-sm">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="mt-6 bg-white dark:bg-gray-800 rounded-xl p-6">
    <h3 class="font-bold mb-4">Add New Ad</h3>
    <form method="POST" action="<?= url('/admin/ads') ?>" class="space-y-4">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Name</label>
                <input type="text" name="name" required class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Position</label>
                <select name="position" class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2">
                    <option value="header">Header</option>
                    <option value="sidebar">Sidebar</option>
                    <option value="footer">Footer</option>
                    <option value="in-content">In-Content</option>
                    <option value="popup">Popup</option>
                </select>
            </div>
        </div>
        <div>
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Ad Code</label>
            <textarea name="code" rows="3" class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2"></textarea>
        </div>
        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition">Add Ad</button>
    </form>
</div>
