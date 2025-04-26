@extends('template.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="mt-3 col-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12 mb-3">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h3 class="card-title">Pendataan Faktur Masuk Kasir</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-8">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div id="filter-container" class="d-flex align-items-center mb-2">
                                                    <div class="d-flex align-items-center me-2">
                                                        <label for="start-date" class="me-2">Rentang Tanggal:</label>
                                                        <input type="date" id="start-date" class="form-control" style="width: 150px;">
                                                        <span>-</span>
                                                        <input type="date" id="end-date" class="form-control" style="width: 150px;">
                                                    </div>
                                                    <button id="filter-date" class="btn btn-primary me-2">Filter</button>
                                                    <button id="reset-date" class="btn btn-secondary">Reset</button>
                                                </div>
                                                <table id="patienttbl" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>No RM</th>
                                                            <th>Nama</th>
                                                            <th>Alamat</th>
                                                            <th>Poli</th>
                                                            <th>Total (Rp.)</th>
                                                            <th>Tanggal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Data akan diisi oleh AJAX -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Preview No Invoice <span id="preview-ubl"></span></label>
                                                        <table class="outer-table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <table id="preview-table" class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Nama</th>
                                                                                    <th>Harga</th>
                                                                                    <th>Qty</th>
                                                                                    <th>SubTot</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <!-- Data akan diisi oleh AJAX -->
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        #patienttbl_wrapper .dataTables_filter {
            display: flex;
            align-items: center;
            justify-content: flex-end; /* Dorong ke kanan */
            gap: 10px;
        }

        #filter-container label {
            margin-right: 8px; /* Memberikan ruang di sebelah kanan label */
        }

        #filter-container .form-control {
            margin-right: 12px; /* Memberikan jarak antar elemen input */
            width: 150px; /* Mengatur lebar input agar seragam */
        }

        #filter-container .mx-2 {
            margin-left: 8px;
            margin-right: 8px;
        }

        /* Menambahkan jarak pada tombol filter dan reset */
        #filter-container .btn {
            margin-right: 8px;
        }

        .selected-row {
            background-color: #007bff !important; /* Warna biru */
            color: white; /* Warna teks putih agar lebih jelas */
        }

    </style>

    <script>
        $(document).ready(function() {
            // Ambil tanggal hari ini
            var today = new Date();

            // Hitung awal bulan
            var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            var lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0); // Menggunakan 0 agar mendapatkan hari terakhir bulan ini

            // Format tanggal agar sesuai dengan input type="date" (YYYY-MM-DD)
            var formatDate = function (date) {
                var dd = date.getDate().toString().padStart(2, '0'); // Tambahkan leading zero jika perlu
                var mm = (date.getMonth() + 1).toString().padStart(2, '0'); // Bulan dimulai dari 0, jadi +1
                var yyyy = date.getFullYear();
                return yyyy + '-' + mm + '-' + dd;
            };

            // Set nilai awal untuk input tanggal
            $('#start-date').val(formatDate(firstDay));
            $('#end-date').val(formatDate(lastDay));

            var table = $("#patienttbl").DataTable({
                "responsive": true,
                "autoWidth": false,
                "paging": true,
                "lengthChange": true,
                "language": {
                    "lengthMenu": "Tampil _MENU_",
                    "info": "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
                    "search": "Cari :",
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Berikutnya"
                    }
                },
                "stateSave": true,
                "data": [], // Kosongkan data awal
                "columns": [
                    { "data": "index" },
                    { "data": "no_rm" },
                    { "data": "nama" },
                    { "data": "alamat" },
                    { "data": "nama_poli" },
                    { "data": "total" },
                    { "data": "created_at" }
                ]
            });

            // Pindahkan dropdown ke area pencarian
            $('#filter-container').appendTo('#patienttbl_wrapper .dataTables_filter');

            function fetchData() {
                let startDate = $('#start-date').val();
                let endDate = $('#end-date').val();

                if (!startDate || !endDate) {
                    alert("Silakan pilih rentang tanggal.");
                    return;
                }

                $.ajax({
                    url: "/api/kasir/transaksifilter", // Ganti dengan endpoint backend yang sesuai
                    type: "GET",
                    data: { start: startDate, end: endDate },
                    success: function(response) {
                        table.clear().rows.add(response.data).draw();
                    },
                    error: function() {
                        alert("Gagal mengambil data.");
                    }
                });
            }

            $('#filter-date').on('click', fetchData);

            $('#reset-date').on('click', function() {
                $('#start-date').val('');
                $('#end-date').val('');
                table.clear().draw();
            });

            $('#patienttbl tbody').on('click', 'tr', function () {
                let rowData = table.row(this).data();
                if (!rowData) return;

                // Hapus highlight dari semua baris
                $('#patienttbl tbody tr').removeClass('selected-row');

                // Tambahkan highlight ke baris yang diklik
                $(this).addClass('selected-row');

                $('#preview-ubl').text(`${rowData.kode_faktur} - (Pasien : ${rowData.nama})`);
                $('#preview-table tbody').empty();

                rowData.details.forEach(detail => {
                    $('#preview-table tbody').append(`
                        <tr>
                            <td>${detail.nama}</td>
                            <td>${detail.harga}</td>
                            <td>${detail.kuantitas}</td>
                            <td>${detail.total_harga}</td>
                        </tr>
                    `);
                });
            });

        });
    </script>
@endsection
