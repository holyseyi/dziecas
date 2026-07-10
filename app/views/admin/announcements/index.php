
<h2 class="text-xl font-bold mb-6">Announcements</h2>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr><th class="px-4 py-3">Title</th><th class="px-4 py-3">Type</th><th class="px-4 py-3">Position</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($announcements as $ad): ?>
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-medium"><?= e($ad['title']) ?></td>
                    <td class="px-4 py-3"><?= ucfirst($ad['type']) ?></td>
                    <td class="px-4 py-3"><?= ucfirst($ad['position']) ?></td>
                    <td class="px-4 py-3"><?= ucfirst($ad['status']) ?></td>
                    <td class="px-4 py-3">
                        <button onclick="deleteItem('/admin/announcements/<?= $ad['id'] ?>')" class="text-red-500 hover:underline text-sm">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
