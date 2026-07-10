<section class="py-12 bg-gray-900">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-2 text-white"><?= e($series['title']) ?></h1>
        <p class="text-gray-400 mb-8">Season <?= $season ?></p>
        <div class="bg-gray-800 rounded-xl overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-gray-300">#</th>
                        <th class="px-4 py-3 text-gray-300">Title</th>
                        <th class="px-4 py-3 text-gray-300">Duration</th>
                        <th class="px-4 py-3 text-gray-300">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($episodes as $ep): ?>
                        <tr class="border-t border-gray-700 hover:bg-gray-700 transition">
                            <td class="px-4 py-3 text-white"><?= $ep['episode_number'] ?></td>
                            <td class="px-4 py-3 text-white"><?= e($ep['title'] ?: 'Episode ' . $ep['episode_number']) ?></td>
                            <td class="px-4 py-3 text-gray-300"><?= $ep['duration'] ? $ep['duration'] . ' min' : 'N/A' ?></td>
                            <td class="px-4 py-3">
                                <a href="<?= url('/series/' . $series['slug'] . '/season/' . $season . '/episode/' . $ep['episode_number']) ?>" class="text-primary-400 hover:underline">Watch</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
