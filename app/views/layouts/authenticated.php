<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? "$title - Boilerplate" : 'Boilerplate' ?></title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/pagination.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?= $header_add ?? '' ?>
</head>

<body>
    <div class="flex h-dvh overflow-hidden">
        <?php include_once __DIR__ . '/../components/sidebar.php' ?>
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
            <?php include_once __DIR__ . '/../components/header.php' ?>

            <main class="antialiased p-4">
                <?php \core\Flasher::flash() ?>
                <?= $content ?>
            </main>

            <footer class="bg-gray-300 text-gray-600 text-center p-2 mt-auto">
                <p class="text-sm">Powered by <a href="https://getbootstrap.com">Bootstrap</a>
                    &copy; <?= date('Y') ?> Suat Namdar. All rights reserved.</p>
            </footer>
        </div>

        <script src="/js/script.js"></script>
        <?= isset($scripts) ? $scripts : '' ?>
    </div>
</body>

</html>