<section class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 py-12">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 w-full max-w-md">
        <h1 class="text-3xl font-bold text-center mb-8">Admin Login</h1>
        <?php if ($this->success()): ?>
            <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4"><?= e($this->success()) ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4"><?= e($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="<?= url('/admin/login') ?>">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Email</label>
                <input type="email" name="email" required class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Password</label>
                <input type="password" name="password" required class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500">
            </div>
            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition">Login</button>
        </form>
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-200 text-sm rounded-lg p-4">
            <p class="font-semibold mb-1">Demo Admin Login</p>
            <p>Email: <span class="font-mono">ddadzie124@gmail.com</span></p>
            <p>Password: <span class="font-mono">password</span></p>
        </div>

        <p class="mt-6 text-center text-sm text-gray-500"><a href="<?= url('/') ?>" class="text-primary-500 hover:underline">&larr; Back to site</a></p>
    </div>
</section>
