<section class="py-12 container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">Entertainment News</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($news as $n): ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="font-bold text-lg mb-2"><?= e($n['title']) ?></h3>
                <p class="text-gray-500 text-sm"><?= formatDate($n['created_at']) ?></p>
                <p class="text-gray-600 dark:text-gray-400 mt-2"><?= e(truncate($n['content'], 150)) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
