
<section class="min-h-screen flex items-center justify-center py-12">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 w-full max-w-md">
        <h1 class="text-3xl font-bold text-center mb-8">Login</h1>
        <?php if (!empty($error)): ?>
            <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4"><?= e($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="<?= url('/login') ?>">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Email</label>
                <input type="email" name="email" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Password</label>
                <input type="password" name="password" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition">Login</button>
        </form>
        <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
            Don't have an account? <a href="<?= url('/register') ?>" class="text-primary-500 hover:underline">Register</a>
        </p>
    </div>
</section>
