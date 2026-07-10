
<h2 class="text-xl font-bold mb-6">Genres</h2>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr><th class="px-4 py-3">ID</th><th class="px-4 py-3">Name</th><th class="px-4 py-3">Slug</th><th class="px-4 py-3">Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($genres as $genre): ?>
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 transition">
                    <td class="px-4 py-3"><?= $genre['id'] ?></td>
                    <td class="px-4 py-3 font-medium"><?= e($genre['name']) ?></td>
                    <td class="px-4 py-3 text-gray-500"><?= e($genre['slug']) ?></td>
                    <td class="px-4 py-3">
                        <button onclick="editItem('/admin/genres/<?= $genre['id'] ?>', <?= json_encode($genre) ?>)" class="text-blue-500 hover:underline text-sm mr-2">Edit</button>
                        <button onclick="deleteItem('/admin/genres/<?= $genre['id'] ?>')" class="text-red-500 hover:underline text-sm">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
function deleteItem(url) { if (confirm('Are you sure?')) { const xhr = new XMLHttpRequest(); xhr.open('DELETE', url, true); xhr.setRequestHeader('X-CSRF-TOKEN', '<?= e($_SESSION['_csrf_token'] ?? '') ?>'); xhr.onload = () => location.reload(); xhr.send(); } }
</script>
