<?php $this->view('partials.header'); ?>
<main class="flex-1">
    <section class="py-12 container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">TV Series</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($series as $series): ?>
                <?= standalonePartial('series-card', ['series' => $series]) ?>
            <?php endforeach; ?>
        </div>
        <?php if (($pagination['total_pages'] ?? 1) > 1): ?>
            <div class="flex justify-center gap-2 mt-8">
                <?php for ($i = 1; $i <= min(5, ($pagination['total_pages'] ?? 1)); $i++): ?>
                    <a href="?page=<?= $i ?>&sort=<?= e($sort ?? 'latest') ?>" class="px-4 py-2 rounded-lg <?= ($i == ($pagination['page'] ?? 1)) ? 'bg-primary-600 text-white' : 'bg-gray-800 hover:bg-gray-700' ?> transition"><?= $i ?></a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php $this->view('partials.footer'); ?>
