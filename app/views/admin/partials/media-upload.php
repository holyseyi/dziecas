<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
    <h3 class="text-lg font-bold mb-1">Upload Video / Music to Home</h3>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Upload a video or audio file and optionally pin it to a home page section.</p>
    <form id="media-upload-form" method="POST" action="<?= path('/admin/media') ?>" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
        <?= csrf_field() ?>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Type</label>
            <select name="type" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2">
                <option value="video">Video</option>
                <option value="music">Music</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <label class="block text-xs text-gray-500 mb-1">Title</label>
            <input name="title" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2" placeholder="e.g. Official Trailer">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Home Section</label>
            <input name="section" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2" placeholder="e.g. Trailers (optional)">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">File</label>
            <input type="file" name="file" required accept="video/*,audio/*" class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1.5">
        </div>
        <div>
            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 rounded-lg transition">Upload</button>
        </div>
        <div class="md:col-span-6">
            <label class="block text-xs text-gray-500 mb-1">Description (optional)</label>
            <textarea name="description" rows="2" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2" placeholder="Short description shown on the home page"></textarea>
        </div>
    </form>
    <p id="media-upload-status" class="text-sm mt-3 hidden"></p>
</div>
