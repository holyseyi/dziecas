<?php if (!empty($success)): ?>
    <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg mb-6"><?= e($success) ?></div>
<?php endif; ?>

<form method="POST" action="<?= url('/movie/' . $movie['id'] . '/bookmark') ?>" class="mb-8">
    <?= csrf_field() ?>
    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
        <?= $isBookmarked ? 'Remove Bookmark' : 'Add Bookmark' ?>
    </button>
</form>

<h3 class="text-xl font-bold mb-4">Rate This Movie</h3>
<form action="<?= url('/rate/movie/' . $movie['id']) ?>" method="POST" class="mb-8">
    <?= csrf_field() ?>
    <div class="flex items-center gap-2">
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <button type="button" onclick="document.getElementById('rating-value').value=<?= $i ?>;this.parentElement.querySelectorAll('button').forEach((b,idx)=>{b.classList.toggle('text-yellow-400',idx<<?= $i ?>);b.classList.toggle('text-gray-400',idx>=<?= $i ?>);});document.getElementById('rating-form').dispatchEvent(new Event('submit'))" class="text-2xl text-gray-400 hover:text-yellow-400 transition">&#9733;</button>
        <?php endfor; ?>
    </div>
    <input type="hidden" name="rating" id="rating-value" value="<?= $userRating ?>">
</form>
