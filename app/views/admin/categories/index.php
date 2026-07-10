
<h2 class="text-xl font-bold mb-6">Categories</h2>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr><th class="px-4 py-3">ID</th><th class="px-4 py-3">Name</th><th class="px-4 py-3">Slug</th><th class="px-4 py-3">Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 transition">
                    <td class="px-4 py-3"><?= $cat['id'] ?></td>
                    <td class="px-4 py-3 font-medium"><?= e($cat['name']) ?></td>
                    <td class="px-4 py-3 text-gray-500"><?= e($cat['slug']) ?></td>
                    <td class="px-4 py-3">
                        <button onclick="deleteItem('/admin/categories/<?= $cat['id'] ?>')" class="text-red-500 hover:underline text-sm">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
