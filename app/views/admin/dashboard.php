
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <?php foreach ($stats as $key => $value): ?>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <p class="text-gray-500 text-sm"><?= ucfirst(str_replace('_', ' ', $key)) ?></p>
            <p class="text-2xl font-bold"><?= e($value) ?></p>
        </div>
    <?php endforeach; ?>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-bold mb-4">Recent Comments</h3>
        <div class="space-y-3">
            <?php foreach (($stats['recent_comments'] ?? []) as $comment): ?>
                <div class="flex items-start justify-between border-b border-gray-200 dark:border-gray-700 pb-2 last:border-0">
                    <div>
                        <p class="font-medium text-sm"><?= e($comment['author_name']) ?></p>
                        <p class="text-gray-500 text-sm truncate w-64"><?= e($comment['content']) ?></p>
                    </div>
                    <span class="text-xs text-gray-400"><?= formatDate($comment['created_at']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-bold mb-4">Recent Users</h3>
        <div class="space-y-3">
            <?php foreach (($stats['recent_users'] ?? []) as $usr): ?>
                <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-2 last:border-0">
                    <div>
                        <p class="font-medium text-sm"><?= e($usr['username']) ?></p>
                        <p class="text-gray-500 text-sm"><?= e($usr['email']) ?></p>
                    </div>
                    <span class="text-xs text-gray-400"><?= formatDate($usr['created_at']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->partial('admin.partials.media-upload', []) ?>

<?= $this->partial('admin.partials.home-content', [
    'homeContent' => $homeContent ?? [],
    'movies' => $movies ?? [],
    'series' => $series ?? [],
    'media' => $media ?? []
]) ?>

<div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
    <h3 class="text-lg font-bold mb-4">Recent Activity</h3>
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th class="px-4 py-2">Action</th>
                <th class="px-4 py-2">Entity</th>
                <th class="px-4 py-2">Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (($stats['recent_audit'] ?? []) as $log): ?>
                <tr class="border-t border-gray-200 dark:border-gray-700">
                    <td class="px-4 py-2"><?= e($log['action']) ?></td>
                    <td class="px-4 py-2"><?= e($log['entity_type']) ?> #<?= e($log['entity_id']) ?></td>
                    <td class="px-4 py-2"><?= formatDate($log['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
