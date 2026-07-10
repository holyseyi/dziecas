
<section class="py-12 container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">Watch History</h1>
    <?php if (empty($history)): ?>
        <p class="text-gray-500">No history yet.</p>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($history as $h): ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                    <p class="font-medium"><?= e($h['item_type']) ?> #<?= e($h['item_id']) ?></p>
                    <p class="text-gray-500 text-sm"><?= formatDate($h['watched_at']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
