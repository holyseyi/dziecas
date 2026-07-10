
<h2 class="text-xl font-bold mb-6">Site Settings</h2>
<form method="POST" action="<?= url('/admin/settings') ?>" class="bg-white dark:bg-gray-800 rounded-xl p-6 space-y-4">
    <?= csrf_field() ?>
    <?php foreach ($settings as $setting): ?>
        <div>
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1"><?= e(ucfirst(str_replace('_', ' ', $setting['key']))) ?></label>
            <input type="text" name="<?= e($setting['key']) ?>" value="<?= e($setting['value']) ?>" class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-2">
        </div>
    <?php endforeach; ?>
    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition">Save Settings</button>
</form>
