<h2 class="text-xl font-bold mb-6">Series</h2>
<div class="flex justify-between items-center mb-6">
    <a href="<?= url('/admin/series/create') ?>" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm transition">Add Series</a>
</div>
<?php if (!empty($series)): ?>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr><th class="px-4 py-3">ID</th><th class="px-4 py-3">Title</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Seasons</th><th class="px-4 py-3">Views</th><th class="px-4 py-3">Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($series as $s): ?>
                    <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-4 py-3"><?= $s['id'] ?></td>
                        <td class="px-4 py-3 font-medium"><?= e($s['title']) ?></td>
                        <td class="px-4 py-3"><?= ucfirst($s['status']) ?></td>
                        <td class="px-4 py-3"><?= $s['total_seasons'] ?? 1 ?></td>
                        <td class="px-4 py-3"><?= formatNumber((int)$s['view_count']) ?></td>
                        <td class="px-4 py-3">
                            <a href="<?= url('/series/' . $s['slug']) ?>" target="_blank" class="text-primary-500 hover:underline mr-2 text-sm">View</a>
                            <a href="<?= url('/admin/series/' . $s['id'] . '/episodes') ?>" class="text-blue-500 hover:underline mr-2 text-sm">Episodes</a>
                            <button onclick="deleteItem('/admin/series/<?= $s['id'] ?>')" class="text-red-500 hover:underline text-sm">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p class="text-gray-500 text-center py-8">No series found.</p>
<?php endif; ?>
<script>
function deleteItem(url) { if (confirm('Are you sure?')) { const xhr = new XMLHttpRequest(); xhr.open('DELETE', url, true); xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('input[name="csrf_token"]').value); xhr.onload = () => location.reload(); xhr.send(); } }
</script>
