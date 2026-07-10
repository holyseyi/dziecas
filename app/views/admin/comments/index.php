
<h2 class="text-xl font-bold mb-6">Comments</h2>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr><th class="px-4 py-3">ID</th><th class="px-4 py-3">Author</th><th class="px-4 py-3">Content</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Date</th><th class="px-4 py-3">Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment): ?>
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 transition">
                    <td class="px-4 py-3"><?= $comment['id'] ?></td>
                    <td class="px-4 py-3"><?= e($comment['author_name']) ?></td>
                    <td class="px-4 py-3 truncate max-w-xs"><?= e($comment['content']) ?></td>
                    <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs <?= $comment['status'] === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>"><?= ucfirst($comment['status']) ?></span></td>
                    <td class="px-4 py-3 text-sm text-gray-500"><?= formatDate($comment['created_at']) ?></td>
                    <td class="px-4 py-3">
                        <button onclick="deleteItem('/admin/comments/<?= $comment['id'] ?>')" class="text-red-500 hover:underline text-sm">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
function deleteItem(url) { if (confirm('Are you sure?')) { const xhr = new XMLHttpRequest(); xhr.open('DELETE', url, true); xhr.setRequestHeader('X-CSRF-TOKEN', '<?= e($_SESSION['_csrf_token'] ?? '') ?>'); xhr.onload = () => location.reload(); xhr.send(); } }
</script>
