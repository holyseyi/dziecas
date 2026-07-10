<h2 class="text-xl font-bold mb-6"><?= e($movie['title'] ?? 'Add Movie') ?></h2>
<form method="POST" action="<?= url('/admin/movies' . (($movie['id'] ?? '') ? '/' . $movie['id'] : '')) ?>" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-xl p-6 space-y-4">
    <?= csrf_field() ?>
    <?= ($movie['id'] ?? '') ? method_field('PUT') : '' ?>
    <div>
        <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Title</label>
        <input type="text" name="title" value="<?= e($old('title', $movie['title'] ?? '')) ?>" required class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500">
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Original Title</label>
            <input type="text" name="original_title" value="<?= e($old('original_title', $movie['original_title'] ?? '')) ?>" class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2">
        </div>
        <div>
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Duration (minutes)</label>
            <input type="number" name="duration" value="<?= e($old('duration', $movie['duration'] ?? '')) ?>" class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2">
        </div>
    </div>
    <div>
        <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Description</label>
        <textarea name="description" rows="4" class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2"><?= e($old('description', $movie['description'] ?? '')) ?></textarea>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Category</label>
            <select name="category_id" class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2">
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($movie['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= e($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Country</label>
            <select name="country_id" class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2">
                <option value="">Select Country</option>
                <?php foreach ($countries as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= ($movie['country_id'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Release Date</label>
            <input type="date" name="release_date" value="<?= e($old('release_date', $movie['release_date'] ?? '')) ?>" class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2">
        </div>
        <div>
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">IMDB Rating</label>
            <input type="number" step="0.1" name="imdb_rating" value="<?= e($old('imdb_rating', $movie['imdb_rating'] ?? '')) ?>" class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2">
        </div>
    </div>
    <div class="flex items-center gap-3">
        <label class="flex items-center gap-2">
            <input type="checkbox" name="featured" value="1" class="rounded" <?= ($movie['featured'] ?? 0) ? 'checked' : '' ?>> Featured
        </label>
        <label class="flex items-center gap-2">
            <input type="checkbox" name="trending" value="1" class="rounded" <?= ($movie['trending'] ?? 0) ? 'checked' : '' ?>> Trending
        </label>
        <label class="flex items-center gap-2">
            <input type="checkbox" name="editor_pick" value="1" class="rounded" <?= ($movie['editor_pick'] ?? 0) ? 'checked' : '' ?>> Editor's Pick
        </label>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Poster</label>
            <input type="file" name="poster" accept="image/*" class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2">
        </div>
        <div>
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Banner</label>
            <input type="file" name="banner" accept="image/*" class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2">
        </div>
    </div>
    <div>
        <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Status</label>
        <select name="status" class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2">
            <option value="draft" <?= ($movie['status'] ?? 'draft') == 'draft' ? 'selected' : '' ?>>Draft</option>
            <option value="published" <?= ($movie['status'] ?? '') == 'published' ? 'selected' : '' ?>>Published</option>
        </select>
    </div>
    <div class="flex items-center gap-4">
        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition">Save</button>
        <a href="<?= url('/admin/movies') ?>" class="text-gray-600 dark:text-gray-400 hover:underline">Cancel</a>
    </div>
</form>
