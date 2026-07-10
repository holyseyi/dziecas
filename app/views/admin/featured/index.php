
<h2 class="text-xl font-bold mb-6">Home Page Content</h2>

<?= $this->partial('admin.partials.home-content', [
    'homeContent' => $content ?? [],
    'movies' => \Core\Database::getInstance()->fetchAll("SELECT id, title FROM movies WHERE status = 'published' ORDER BY title ASC"),
    'series' => \Core\Database::getInstance()->fetchAll("SELECT id, title FROM series WHERE status = 'published' ORDER BY title ASC")
]) ?>
