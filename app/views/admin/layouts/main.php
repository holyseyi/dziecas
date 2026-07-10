<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'MovieHub Admin') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { colors: { admin: { 700: '#1e293b', 800: '#0f172a', 900: '#020617' } } } } };
    </script>
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
    <body class="bg-gray-100 dark:bg-admin-900 text-gray-900 dark:text-gray-100 min-h-screen">
        <div class="flex min-h-screen">
            <?= $this->view('admin.partials.sidebar') ?>
            <div class="flex-1 p-8">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold"><?= e($title) ?></h1>
                    <div class="flex items-center gap-4">
                        <a href="<?= path('/') ?>" target="_blank" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">View Site</a>
                        <span class="text-sm"><?= e($_SESSION['user']['username'] ?? 'Admin') ?></span>
                        <a href="<?= path('/admin/logout') ?>" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition">Logout</a>
                    </div>
                </div>
                <?= $content ?>
            </div>
        </div>
    <script src="<?= asset('js/admin.js') ?>"></script>
</body>
</html>
