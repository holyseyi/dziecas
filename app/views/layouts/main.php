<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? APP_NAME) ?></title>
    <meta name="description" content="<?= e($seo_description ?? '') ?>">
    <meta name="keywords" content="<?= e($seo_keywords ?? '') ?>">
    <link rel="canonical" href="<?= e($canonical_url ?? url()) ?>">
    <meta property="og:title" content="<?= e($seo_title ?? $title ?? APP_NAME) ?>">
    <meta property="og:description" content="<?= e($seo_description ?? '') ?>">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/svg+xml" href="<?= asset('images/favicon.svg') ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { colors: { primary: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 900: '#1e3a8a' }, dark: { 800: '#1e293b', 900: '#0f172a', 950: '#020617' } } } } };
    </script>
    <?= $styles ?? '' ?>
</head>
<body class="bg-gray-50 dark:bg-dark-950 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col font-sans antialiased">
    <?= \Core\View::partial('header', ['user' => $user ?? null]) ?>
    <main class="flex-1">
        <?= $content ?>
    </main>
    <?= \Core\View::partial('footer') ?>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="<?= asset('js/app.js') ?>"></script>
    <?= $scripts ?? '' ?>
</body>
</html>
