<?php
$title = 'İşler Listesi';
ob_start();
?>

<section class="bg-white rounded p-4 shadow-lg">
    <h2 class="font-bold text-xl mb-4">İşler Listesi</h2>
    <div class="max-w-full overflow-x-auto">
        <button id="openIslerModal"
            class="bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-2 px-4 rounded mb-4">
            Yeni İş Ekle
        </button>
        <table class="w-full table-auto">
            <thead>
                <tr class="text-center bg-gray-300">
                    <th class="py-3 px-4 border-r border-white font-medium w-[20px]">No</th>
                    <th class="py-3 px-4 border-r border-white font-medium w-40">tarih</th>
                    <th class="py-3 px-4 border-r border-white font-medium">plaka</th>
                    <th class="py-3 px-4 border-r border-white font-medium">yukleme_yeri</th>
                    <th class="py-3 px-4 border-r border-white font-medium">bosaltma_yeri</th>
                    <th class="py-3 px-4 border-r border-white font-medium">fiyat</th>
                    <th class="py-3 px-4 border-r border-white font-medium">fatura_firma</th>
                    <th class="py-3 px-4 border-r border-white font-medium">fatura_no</th>
                    <th class="py-3 px-4 border-r border-white font-medium">fatura_tarihi</th>
                    <th class="py-3 px-4 border-r border-white font-medium">odeme_tarihi</th>
                    <th class="py-3 px-4 font-medium">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($isler['data'] as $is): ?>
                    <tr class="text-center text-nowrap">
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->id ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->tarih ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->aracPlaka ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->yuklemeYeri ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->bosaltmaYeri ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->fiyat ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->firmaAdi ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->fatura_no ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->fatura_tarihi ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->odeme_tarihi ?? '' ?></td>

                        <td class="border-b border-[#eee] p3-5 px-4">
                            <form action="/isler/<?= $is->id ?>" method="post"
                                class="flex items-center space-x-3.5 justify-center">
                                <a href="/isler/<?= $is->id ?>" class="hover:text-blue-500">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <input type="text" name="_method" value="DELETE" hidden>
                                <button class="hover:text-red-500"
                                    onclick="return confirm('Are you sure want to delete <?= $is->id ?>?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <?= $pagination ?>
    </div>
</section>

<div id="islerModal" class="fixed z-[9999] inset-0 hidden bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-1/4 -translate-y-1/4 mx-20 p-5 border w-xl shadow-lg rounded-md bg-white">
        <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Yeni İş Ekle</h3>
        <form action="/isler" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="tarih" class="block text-gray-700">Tarih</label>
                <input type="date" name="tarih" id="tarih" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="arac_id" class="block text-gray-700">Arac ID</label>
                <input type="number" name="arac_id" id="arac_id" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="yukleme_yeri" class="block text-gray-700">Yukleme Yeri</label>
                <input type="text" name="yukleme_yeri" id="yukleme_yeri" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="bosaltma_yeri" class="block text-gray-700">Bosaltma Yeri</label>
                <input type="text" name="bosaltma_yeri" id="bosaltma_yeri" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="fiyat" class="block text-gray-700">Fiyat</label>
                <input type="number" name="fiyat" id="fiyat" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="fatura_no" class="block text-gray-700">Fatura No</label>
                <input type="text" name="fatura_no" id="fatura_no" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="fatura_tarihi" class="block text-gray-700">Fatura Tarihi</label>
                <input type="date" name="fatura_tarihi" id="fatura_tarihi" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="odeme_tarihi" class="block text-gray-700">Odeme Tarihi</label>
                <input type="date" name="odeme_tarihi" id="odeme_tarihi" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>


            <div class="flex justify-end">
                <button type="button" id="closeIslerModal"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Cancel</button>
                <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded">
                    Add
                </button>
            </div>
        </form>
    </div>
</div>

<?php
ob_start();
?>
<script>
    $(document).ready(function () {
        $('#openIslerModal').click(function () {
            $('#islerModal').removeClass('hidden');
        });

        $('#closeIslerModal').click(function () {
            $('#islerModal').addClass('hidden');
        });

        $(window).click(function (event) {
            if (event.target.id == 'islerModal') {
                $('#islerModal').addClass('hidden');
            }
        });
    })
</script>
<?php
$scripts = ob_get_clean();
?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/authenticated.php';
?>