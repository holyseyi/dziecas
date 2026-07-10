<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 mb-8">
    <h1 class="text-3xl font-bold mb-6 text-white"><?= e($article['title']) ?></h1>
    <p class="text-gray-400 mb-2"><?= formatDate($article['created_at']) ?></p>
    <div class="text-gray-300 mt-4"><?= nl2br(e($article['content'])) ?></div>
</div>
