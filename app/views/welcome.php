<?php
$title = 'Welcome';
ob_start();
?>

<div class="min-h-screen flex items-center justify-center px-4 -mt-20">
    <div class="max-w-md w-full p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold text-center mt-8 mb-6">Oturum Açalım!</h1>
        <form action="/login" method="POST">
            <div class="mb-6">
                <label for="email" class="block mb-2 text-sm text-gray-600">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                    required autofocus>
            </div>
            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm text-gray-600">Şifre</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                    required>
            </div>
            <?php if (\core\Flasher::hasValidationError('auth')): ?>
                <small class="text-red-500 flex justify-center"><?= \core\Flasher::getValidationError('auth'); ?></small>
            <?php endif; ?>
            <button type="submit"
                class="w-32 bg-cyan-500 text-white py-2 rounded-lg mx-auto block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 mt-4 mb-6">Giriş Yap</button>
        </form>
        <p class="text-xs text-gray-600 text-center mt-10">&copy; 2025 Tüm Hakları Saklıdır.</p>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'layouts/guest.php';
?>