
<section class="py-12 container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">My Ratings</h1>
    <?php if (empty($ratings)): ?>
        <p class="text-gray-500">No ratings yet.</p>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($ratings as $r): ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                    <p class="font-medium"><?= e($r['item_type']) ?> #<?= e($r['item_id']) ?></p>
                    <p class="text-yellow-500">&#9733; <?= $r['rating'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
