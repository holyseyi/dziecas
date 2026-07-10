
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 mb-8">
    <h1 class="text-2xl font-bold mb-6">Contact Us</h1>
    <p class="text-gray-600 dark:text-gray-400 mb-4">Have questions or suggestions? Reach out to us.</p>
    <form method="POST" action="<?= url('/contact') ?>" class="max-w-xl">
        <?= csrf_field() ?>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Your Name</label>
            <input type="text" name="name" required class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Email</label>
            <input type="email" name="email" required class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Message</label>
            <textarea name="message" rows="5" required class="w-full bg-gray-50 dark:bg-gray-700 border rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500"></textarea>
        </div>
        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg transition">Send Message</button>
    </form>
</div>
