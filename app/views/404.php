<?php 
http_response_code(404);
$content = '
<section class="bg-white rounded p-4 shadow-lg">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold text-center">404 Not Found</h1>
        <p class="text-center mt-4">Aradığınız sayfa mevcut değil.</p>
    </div>
</section>
';
include_once __DIR__ . '/layouts/guest.php';
