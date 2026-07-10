<?php
$movieMap = [];
foreach (($movies ?? []) as $m) {
    $movieMap[(int)$m['id']] = $m['title'];
}
$seriesMap = [];
foreach (($series ?? []) as $s) {
    $seriesMap[(int)$s['id']] = $s['title'];
}
$mediaMap = [];
foreach (($media ?? []) as $mm) {
    $mediaMap[(int)$mm['id']] = $mm['title'];
}
?>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
    <h3 class="text-lg font-bold mb-4">Add Content to Home Page</h3>
    <form id="home-content-form" method="POST" action="<?= path('/admin/featured') ?>" class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
        <?= csrf_field() ?>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Type</label>
            <select name="item_type" id="hc-type" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2">
                <option value="movie">Movie</option>
                <option value="series">Series</option>
                <option value="media">Uploaded Media</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <label class="block text-xs text-gray-500 mb-1">Content</label>
            <select name="item_id" id="hc-item" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2"></select>
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Section</label>
            <input name="section" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2" placeholder="e.g. Spotlight">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Sort Order</label>
            <input name="sort_order" type="number" value="0" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2">
        </div>
        <div>
            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 rounded-lg transition">Add</button>
        </div>
    </form>
    <script type="application/json" id="hc-movies-data"><?= json_encode(array_map(fn($m) => ['id' => (int)$m['id'], 'title' => $m['title']], $movies ?? []), JSON_UNESCAPED_SLASHES) ?></script>
    <script type="application/json" id="hc-series-data"><?= json_encode(array_map(fn($s) => ['id' => (int)$s['id'], 'title' => $s['title']], $series ?? []), JSON_UNESCAPED_SLASHES) ?></script>
    <script type="application/json" id="hc-media-data"><?= json_encode(array_map(fn($mm) => ['id' => (int)$mm['id'], 'title' => $mm['title'] . ' (' . $mm['type'] . ')'], $media ?? []), JSON_UNESCAPED_SLASHES) ?></script>
</div>

<div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
    <h3 class="text-lg font-bold p-6 pb-3">Current Home Page Content</h3>
    <table class="w-full text-left">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th class="px-4 py-3">Section</th>
                <th class="px-4 py-3">Type</th>
                <th class="px-4 py-3">Title</th>
                <th class="px-4 py-3">Sort</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (($homeContent ?? []) as $c): ?>
                <?php
                $title = '#' . $c['item_id'];
                if ($c['item_type'] === 'series') {
                    $title = $seriesMap[$c['item_id']] ?? $title;
                } elseif ($c['item_type'] === 'media') {
                    $title = $mediaMap[$c['item_id']] ?? $title;
                } else {
                    $title = $movieMap[$c['item_id']] ?? $title;
                }
                ?>
                <tr class="border-t border-gray-200 dark:border-gray-700">
                    <td class="px-4 py-3"><?= e($c['section']) ?></td>
                    <td class="px-4 py-3"><?= e($c['item_type']) ?></td>
                    <td class="px-4 py-3"><?= e($title) ?></td>
                    <td class="px-4 py-3"><?= e($c['sort_order']) ?></td>
                    <td class="px-4 py-3">
                        <button onclick="deleteItem('/admin/featured/<?= $c['id'] ?>')" class="text-red-500 hover:underline text-sm">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($homeContent)): ?>
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">No home page content added yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
