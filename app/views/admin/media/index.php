
<h2 class="text-xl font-bold mb-6">Media Library</h2>

<?php if (!empty($media)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($media as $m): ?>
            <?php $src = url('/storage/' . ($m['type'] === 'music' ? 'music' : 'videos') . '/' . $m['file_path']); ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="<?= $m['type'] === 'video' ? 'aspect-video bg-black' : 'h-40 bg-gradient-to-br from-primary-600 to-primary-800 flex items-center justify-center' ?>">
                    <?php if ($m['type'] === 'video'): ?>
                        <video class="w-full h-full object-contain" controls preload="metadata">
                            <source src="<?= e($src) ?>" type="video/mp4">
                        </video>
                    <?php else: ?>
                        <svg class="w-14 h-14 text-white/90" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55A4 4 0 1014 17V7h4V3h-6z"/></svg>
                    <?php endif; ?>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="font-semibold truncate"><?= e($m['title']) ?></h3>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-full <?= $m['type'] === 'video' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' ?>"><?= e($m['type']) ?></span>
                    </div>
                    <div class="mt-3 flex items-center gap-3">
                        <a href="<?= e($src) ?>" target="_blank" class="text-primary-500 hover:underline text-sm">Open</a>
                        <button onclick="deleteItem('/admin/media/<?= $m['id'] ?>')" class="text-red-500 hover:underline text-sm">Delete</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 text-center text-gray-500">
        No media uploaded yet. Use the <strong>Upload Video / Music to Home</strong> panel on the dashboard.
    </div>
<?php endif; ?>
