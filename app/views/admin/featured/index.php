
<h2 class="text-xl font-bold mb-6">Featured Content</h2>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr><th class="px-4 py-3">Section</th><th class="px-4 py-3">Type</th><th class="px-4 py-3">Item ID</th><th class="px-4 py-3">Label</th><th class="px-4 py-3">Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($content as $c): ?>
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 transition">
                    <td class="px-4 py-3"><?= e($c['section']) ?></td>
                    <td class="px-4 py-3"><?= e($c['item_type']) ?></td>
                    <td class="px-4 py-3"><?= e($c['item_id']) ?></td>
                    <td class="px-4 py-3"><?= e($c['label'] ?? '') ?></td>
                    <td class="px-4 py-3">
                        <button onclick="deleteItem('/admin/featured/<?= $c['id'] ?>')" class="text-red-500 hover:underline text-sm">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
