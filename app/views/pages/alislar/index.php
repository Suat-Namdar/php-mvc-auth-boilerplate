<?php
ob_start();
include_once __DIR__ . '/../../layouts/datatable_header.php';
$header_add = ob_get_clean();
?>

<?php
$datalar = $datalar ?? []; // Varsayılan olarak boş dizi
ob_start();
?>
<section class="bg-white rounded p-4 shadow-lg">
    <div class="max-w-full overflow-x-auto inline-flex justify-between items-center mb-3">
        <h2 class="font-bold text-xl">
            <i class="fa-solid fa-briefcase mr-2"></i>
            <?= $title ?? '' ?>
        </h2>

        <button id="openFormModal"
            class="absolute right-8 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-2 px-4 rounded">
            <i class="fa-solid fa-plus mr-2"></i>
            Yeni Kayıt Ekle
        </button>
    </div>

    <div class="max-w-full overflow-x-auto border-b border-gray-300 mb-4"></div>

    <div class="max-w-full overflow-x-auto">
        <table id="dataTable" class="w-full table-auto">
            <thead>
                <tr class="text-center bg-gray-300">
                    <th class="py-3 px-4 border-r border-white font-medium w-[15px]">No</th>
                    <th class="py-3 px-4 border-r border-white font-medium">Fatura Tarihi</th>
                    <th class="py-3 px-4 border-r border-white font-medium">Plaka</th>
                    <th class="py-3 px-4 border-r border-white font-medium">Alış Türü</th>
                    <th class="py-3 px-4 border-r border-white font-medium">Adet</th>
                    <th class="py-3 px-4 border-r border-white font-medium">Birim Fiyat</th>
                    <th class="py-3 px-4 border-r border-white font-medium">Toplam Fiyat</th>
                    <th class="py-3 px-4 font-medium w-[15px]">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datalar as $data): ?>
                    <tr class="text-center text-nowrap">
                        <td class="border-b border-[#eee] py-3 px-4"><?= $data->id ?></td>
                        <td class="border-b border-[#eee] py-3 px-4" data-type="tarih"><?= $data->fatura_tarihi ?? '' ?>
                        </td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $data->aracPlaka ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $data->alisTurAdi ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4"><?= $data->adet ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4" data-type="fiyat"><?= $data->birim_fiyat ?? '' ?></td>
                        <td class="border-b border-[#eee] py-3 px-4" data-type="fiyat"><?= $data->toplam_fiyat ?? '' ?><span
                                class="font-bold"></span></td>
                        <!-- İşlemler sütunu -->
                        <td class="border-b border-[#eee]">
                            <a href="javascript:void(0)" class="viewFormBtn hover:text-blue-500 px-1"
                                data-id="<?= $data->id ?>">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="javascript:void(0)" class="editFormBtn hover:text-green-500 px-1"
                                data-id="<?= $data->id ?>">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="javascript:void(0)" class="deleteFormBtn hover:text-red-500 px-1"
                                data-id="<?= $data->id ?>">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal -->
<div id="FormModal" class="fixed z-[9999] inset-0 hidden bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-1/4 -translate-y-1/4 mx-20 p-3 w-xl rounded-md border bg-white shadow-lg">
        <div class="flex items-center justify-between border-b border-gray-300 pb-3">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-900 text-center flex-1">
                Yeni Kayıt Ekle
            </h3>
            <button id="closeFormModal" class="text-gray-500 hover:text-gray-700 mr-2">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>
        </div>
        
        <form id="dataForm" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="id" id="data_id">
            <!-- Form alanları -->
            <div class="mb-4">
                Id: <span class="text-red-500" id="dataID"></span>
                <label for="fatura_tarihi" class="block text-gray-700">Fatura Tarihi</label>
                <input type="date" name="fatura_tarihi" id="fatura_tarihi" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="arac_id" class="block text-gray-700">Araç ID</label>
                <input type="number" name="arac_id" id="arac_id" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <!-- Butonlar -->
            <div class="flex justify-end">
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
    function openFormModal(mode, data = {}) {
        $('#FormModal').removeClass('hidden');

        if (mode === 'create') {
            $('#modalTitle').text('Yeni Kayıt Ekle');
            $('#dataForm').attr('action', '/alislar');
            $('#formMethod').val('POST');
            $('#modalSubmitBtn').show().html('<i class="fa-solid fa-plus mr-2 text-white"></i>Ekle');
            $('#dataForm input, #dataForm select').prop('readonly', false).prop('disabled', false);
            $('#dataForm')[0].reset();
            $('#data_id').val('');
        }
        if (mode === 'view') {
            $('#modalTitle').text('Kayıt Detayı');
            $('#dataID').text(data.id);
            $('#modalSubmitBtn').hide();
            $('#dataForm input, #dataForm select').prop('readonly', true).prop('disabled', true);
            // Alanları doldur
            for (const key in data) {
                $('#' + key).val(data[key]);
            }
        }
        if (mode === 'edit') {
            $('#modalTitle').text('Kaydı Güncelle');
            $('#dataID').text(data.id);
            $('#dataForm').attr('action', '/alislar/' + data.id);
            $('#formMethod').val('PUT');
            $('#modalSubmitBtn').show().html('<i class="fa-solid fa-floppy-disk mr-2 text-white"></i>Güncelle');
            $('#dataForm input, #dataForm select').prop('readonly', false).prop('disabled', false);
            // Alanları doldur
            for (const key in data) {
                $('#' + key).val(data[key]);
            }
        }
        if (mode === 'delete') {
            $('#modalTitle').text('Kaydı Sil');
            $('#dataID').text(data.id);
            $('#dataForm').attr('action', '/alislar/' + data.id);
            $('#formMethod').val('DELETE');
            $('#modalSubmitBtn').show().html('<i class="fa-solid fa-trash mr-2 text-white"></i>Sil');
            $('#dataForm input, #dataForm select').prop('readonly', false).prop('disabled', false);
            // Alanları doldur
            for (const key in data) {
                $('#' + key).val(data[key]);
            }
        }
    }

    $('#openFormModal').click(function () {
        openFormModal('create');
    });
    $('#closeFormModal').click(function () {
        $('#FormModal').addClass('hidden');
    });
    $(window).click(function (event) {
        if (event.target.id == 'FormModal') {
            $('#FormModal').addClass('hidden');
        }
    });

    // Düzenle ve Görüntüle butonları için örnek (her satırda data-* attribute ile veri taşıyabilirsiniz)
    $('.editFormBtn').click(function () {
        const dataId = $(this).data('id');
        const data = <?= json_encode($datalar) ?>.find(item => item.id == dataId);
        openFormModal('edit', data);
    });
    $('.viewFormBtn').click(function () {
        const dataId = $(this).data('id');
        const data = <?= json_encode($datalar) ?>.find(item => item.id == dataId);
        openFormModal('view', data);
    });
    $('.deleteFormBtn').click(function () {
        const dataId = $(this).data('id');
        const data = <?= json_encode($datalar) ?>.find(item => item.id == dataId);
        openFormModal('delete', data);
    });
</script>

<?php
include_once __DIR__ . '/../../layouts/datatable_scripts.php';
$scripts = ob_get_clean();
?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/authenticated.php';
?>