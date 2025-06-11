
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

<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            dom: 'lBfrtip', // l: length, B: buttons, f: filter, r: processing, t: table, i: info, p: pagination
            language: {
                url: "//cdn.datatables.net/plug-ins/2.3.2/i18n/tr.json",
                "lengthMenu": "Sayfada _MENU_ kayıt göster. &nbsp;",
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: 'font-bold',
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf"></i> PDF',
                    className: 'font-bold',
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Yazdır',
                    className: 'font-bold',
                }
            ],
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        // Get the input element from the second header row
                        var input = $('input', this.header(1));
                        var column = this;

                        // Event listener for user input
                        input.on('keyup', function () {
                            if (column.search() !== input.val()) {
                                column.search(input.val()).draw();
                            }
                        });
                    });
            }
        });
    });
</script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons JS ve bağımlılıkları -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
