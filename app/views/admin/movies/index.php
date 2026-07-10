
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">Movies</h2>
    <a href="<?= url('/admin/movies/create') ?>" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm transition">Add Movie</a>
</div>

<?php if (!empty($movies)): ?>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Views</th>
                    <th class="px-4 py-3">Rating</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movies as $movie): ?>
                    <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-4 py-3"><?= $movie['id'] ?></td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="<?= asset('uploads/posters/' . ($movie['poster'] ?? 'default.jpg')) ?>" class="w-8 h-12 object-cover rounded bg-gray-700">
                                <div>
                                    <p class="font-medium"><?= e($movie['title']) ?></p>
                                    <p class="text-gray-500 text-xs"><?= formatDate($movie['published_at']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3"><?= ucfirst($movie['status']) ?></td>
                        <td class="px-4 py-3"><?= formatNumber((int)$movie['view_count']) ?></td>
                        <td class="px-4 py-3"><?= number_format($movie['imdb_rating'], 1) ?></td>
                        <td class="px-4 py-3">
                            <a href="<?= url('/movie/' . $movie['slug']) ?>" target="_blank" class="text-primary-500 hover:underline mr-2 text-sm">View</a>
                            <a href="<?= url('/admin/movies/' . $movie['id'] . '/edit') ?>" class="text-blue-500 hover:underline mr-2 text-sm">Edit</a>
                            <button onclick="deleteItem('/admin/movies/<?= $movie['id'] ?>')" class="text-red-500 hover:underline text-sm">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if (($pagination['total_pages'] ?? 1) > 1): ?>
        <div class="flex justify-center mt-6">
            <div class="flex gap-2">
                <?php for ($i = 1; $i <= ($pagination['total_pages'] ?? 1); $i++): ?>
                    <a href="?page=<?= $i ?>" class="px-3 py-2 rounded <?= $i == ($pagination['page'] ?? 1) ? 'bg-primary-600 text-white' : 'bg-white hover:bg-gray-100' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
        </div>
    <?php endif; ?>
<?php else: ?>
    <p class="text-gray-500 text-center py-8">No movies found.</p>
<?php endif; ?>

<script>
function deleteItem(url) { if (confirm('Are you sure?')) fetch(url, { method: 'DELETE', headers: {'X-CSRF-TOKEN': '<?= e($_SESSION['_csrf_token'] ?? '') ?>'}' }).then(() => location.reload()); }
</script>
