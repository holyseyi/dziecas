
<h2 class="text-xl font-bold mb-6">Audit Logs</h2>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr><th class="px-4 py-3">Action</th><th class="px-4 py-3">Entity</th><th class="px-4 py-3">IP</th><th class="px-4 py-3">Time</th></tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr class="border-t border-gray-200 dark:border-gray-700">
                    <td class="px-4 py-3"><?= e($log['action']) ?></td>
                    <td class="px-4 py-3"><?= e($log['entity_type'] ?? '') ?> #<?= e($log['entity_id'] ?? '') ?></td>
                    <td class="px-4 py-3 text-gray-500"><?= e($log['ip_address']) ?></td>
                    <td class="px-4 py-3 text-gray-500"><?= formatDate($log['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
