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
                    <th class="py-3 px-4 border-r border-white font-medium" >fiyat</th>
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
                        <td class="border-b border-[#eee] py-3 px-4" data-type="tarih"><?= $is->tarih ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->aracPlaka ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->yuklemeYeri ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->bosaltmaYeri ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4" data-type="fiyat"><?= $is->fiyat ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->firmaAdi ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $is->fatura_no ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4" data-type="tarih"><?= $is->fatura_tarihi ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4" data-type="tarih"><?= $is->odeme_tarihi ?? '' ?></td>

                        <td class="border-b border-[#eee] p3-5 px-4">
                            <a href="javascript:void(0)" class="viewIsBtn hover:text-blue-500"
                                data-is='<?= json_encode($is, JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>'>
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="javascript:void(0)" class="editIsBtn hover:text-green-500"
                                data-is='<?= json_encode($is, JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>'>
                                <i class="fa-solid fa-pen"></i>
                            </a>
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

<!-- Modal -->
<div id="islerModal" class="fixed z-[9999] inset-0 hidden bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-1/4 -translate-y-1/4 mx-20 p-5 border w-xl shadow-lg rounded-md bg-white">
        <h3 id="modalTitle" class="text-xl font-bold text-gray-900 mb-4 text-center">Yeni İş Ekle</h3>
        <form id="islerForm" action="/isler" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="id" id="is_id">
            <!-- Form alanları -->
            <div class="mb-4">
                <label for="tarih" class="block text-gray-700">Tarih</label>
                <input type="date" name="tarih" id="tarih" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="arac_id" class="block text-gray-700">Araç ID</label>
                <input type="number" name="arac_id" id="arac_id" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <!-- ...diğer alanlar... -->
            <div class="flex justify-end">
                <button type="button" id="closeIslerModal"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Cancel</button>
                <button type="submit" id="modalSubmitBtn"
                    class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded">
                    Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

<?php
ob_start();
?>
<script>
    // Modalı aç/kapat fonksiyonları
    function openIslerModal(mode, data = {}) {
        $('#islerModal').removeClass('hidden');

        if (mode === 'create') {
            $('#modalTitle').text('Yeni İş Ekle');
            $('#islerForm').attr('action', '/isler');
            $('#formMethod').val('POST');
            $('#modalSubmitBtn').show().text('Ekle');
            $('#islerForm input, #islerForm select').prop('readonly', false).prop('disabled', false);
            $('#islerForm')[0].reset();
            $('#is_id').val('');
        }
        if (mode === 'edit') {
            $('#modalTitle').text('İşi Güncelle');
            $('#islerForm').attr('action', '/isler/' + data.id);
            $('#formMethod').val('PUT');
            $('#modalSubmitBtn').show().text('Güncelle');
            $('#islerForm input, #islerForm select').prop('readonly', false).prop('disabled', false);
            // Alanları doldur
            for (const key in data) {
                $('#' + key).val(data[key]);
            }
        }
        if (mode === 'view') {
            $('#modalTitle').text('İş Detayı');
            $('#modalSubmitBtn').hide();
            $('#islerForm input, #islerForm select').prop('readonly', true).prop('disabled', true);
            // Alanları doldur
            for (const key in data) {
                $('#' + key).val(data[key]);
            }
        }
    }

    $('#openIslerModal').click(function () {
        openIslerModal('create');
    });

    $('#closeIslerModal').click(function () {
        $('#islerModal').addClass('hidden');
    });

    $(window).click(function (event) {
        if (event.target.id == 'islerModal') {
            $('#islerModal').addClass('hidden');
        }
    });

    // Düzenle ve Görüntüle butonları için örnek (her satırda data-* attribute ile veri taşıyabilirsiniz)
    $('.editIsBtn').click(function () {
        const data = $(this).data('is');
        openIslerModal('edit', data);
    });
    $('.viewIsBtn').click(function () {
        const data = $(this).data('is');
        openIslerModal('view', data);
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tarihleri formatla
        document.querySelectorAll('td[data-type="tarih"]').forEach(function (td) {
            if (td.textContent.trim()) {
                const date = new Date(td.textContent.trim());
                if (!isNaN(date)) {
                    td.textContent = date.toLocaleDateString('tr-TR');
                }
            }
        });
        // Fiyatları formatla
        document.querySelectorAll('td[data-type="fiyat"]').forEach(function (td) {
            const val = parseFloat(td.textContent.replace(',', '.'));
            if (!isNaN(val)) {
                td.textContent = val.toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' ₺';
            }
        });
    });
</script>

<?php
$scripts = ob_get_clean();
?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/authenticated.php';
?>