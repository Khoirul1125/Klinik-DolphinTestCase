@extends('template.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <style>
            /* Styling untuk filter */
            #patienttbl_wrapper .dataTables_filter {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 10px;
            }

            #filter-container label {
                margin-right: 8px;
            }

            #filter-container .form-control {
                margin-right: 12px;
                width: 150px;
            }

            #filter-container .btn {
                margin-right: 8px;
            }

            .selected-row {
                background-color: #007bff !important;
                color: white;
            }

            /* Ukuran font lebih kecil */
            #patienttbl thead th {
                font-size: 13px;
                white-space: nowrap; /* Mencegah teks terpotong */
                text-align: center; /* Untuk menyamakan alignment */
            }

            #patienttbl tbody td {
                font-size: 12px;
            }

            /* Scrollable Table */
            .table-responsive {
                width: 100%;
                overflow-x: auto !important;
            }
        </style>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="mt-3 col-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12 mb-3">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h3 class="card-title">Pendataan Faktur Lunas Kasir</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <!-- Filter -->
                                                <div id="filter-container" class="d-flex align-items-center mb-2">
                                                    <div class="d-flex align-items-center me-2">
                                                        <label for="start-date" class="me-2">Tanggal:</label>
                                                        <input type="date" id="start-date" class="form-control">
                                                        <span>-</span>
                                                        <input type="date" id="end-date" class="form-control">
                                                    </div>
                                                    <select id="filter-jenis" class="form-control" style="width: 150px;">
                                                        <option value="">Semua Jenis</option>
                                                        <option value="BPJS">BPJS</option>
                                                        <option value="ASURANSI">ASURANSI</option>
                                                        <option value="UMUM">UMUM</option>
                                                    </select>
                                                    <button id="filter-date" class="btn btn-primary">Filter</button>
                                                    {{-- <button id="reset-date" class="btn btn-secondary">Reset</button> --}}
                                                </div>

                                                <!-- Tabel dengan Scroll -->
                                                <div class="table-responsive">
                                                    <table id="patienttbl" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>No Faktur</th>
                                                                <th>Tanggal</th>
                                                                <th>No RM</th>
                                                                <th>Nama</th>
                                                                <th>Jenis Kelamin</th>
                                                                <th>Jenis</th>
                                                                <th>Perawatan</th>
                                                                <th>Item</th>
                                                                <th>Hrg Satuan</th>
                                                                <th>qty</th>
                                                                <th>sub Total</th>
                                                                <th>Total</th>
                                                                <th>Dokter</th>
                                                                <th>Petugas</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div> <!-- End table-responsive -->
                                            </div>
                                            <div class="card-footer">
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <button id="reset-date" class="btn btn-secondary mr-2">Reset</button>
                                                    <button id="print-data" class="btn btn-primary">Save & Print</button>
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

    {{-- <script>
        $(document).ready(function() {
            $("#patienttbl").DataTable({
                "responsive": true,
                "autoWidth": false,
                "buttons": false,
                "lengthChange": true, // Corrected: Removed conflicting lengthChange option
                "language": {
                    "lengthMenu": "Tampil  _MENU_",
                    "info": "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
                    "search": "Cari :",
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Berikutnya"
                    }
                }
            });
        });
    </script> --}}
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

            // Inisialisasi DataTable
            var table = $("#patienttbl").DataTable({
                "responsive": true,
                "autoWidth": false,
                "paging": true,
                "lengthChange": true,
                "ordering": false,
                "buttons": ["csv", "excel", "pdf", "print"],
                "columnDefs": [
                    { "width": "1%", "targets": 0 },
                    { "width": "5%", "targets": 1 },
                    { "width": "5%", "targets": 2 },
                    { "width": "5%", "targets": 3 },
                    { "width": "5%", "targets": 4 },
                    { "width": "5%", "targets": 5 },
                    { "width": "5%", "targets": 6 },
                    { "width": "5%", "targets": 7 },
                    { "width": "5%", "targets": 8 },
                    { "width": "5%", "targets": 9 },
                    { "width": "5%", "targets": 10 },
                    { "width": "5%", "targets": 11 },
                    { "width": "5%", "targets": 12 },
                    { "width": "5%", "targets": 13 },
                    { "width": "5%", "targets": 14 }
                ],
                "language": {
                    "lengthMenu": "Tampil _MENU_",
                    "info": "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
                    "search": "Cari :",
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Berikutnya"
                    }
                }
            });

            $('#filter-container').appendTo('#patienttbl_wrapper .dataTables_filter');

            // // Reset Filter
            $('#reset-date').on('click', function () {
                $('#start-date').val("");
                $('#end-date').val("");
                $('#filter-jenis').val("");

                let table = $("#patienttbl").DataTable();
                table.clear().draw(); // Kosongkan tabel sebelum reload

                $('#filter-date').click(); // Trigger ulang filter dengan data awal
            });

            $('#filter-date').on('click', function () {
                let startDate = $('#start-date').val();
                let endDate = $('#end-date').val();
                let jenis = $('#filter-jenis').val();

                fetch(`/api/kasir/obatfilter?start_date=${startDate}&end_date=${endDate}&jenis=${jenis}`)
                    .then(response => response.json())
                    .then(data => {
                        table.clear().draw();

                        data.forEach((item, index) => {
                            let firstRow = true;

                            // Jika tidak ada detail obat atau tindakan, hanya tampilkan faktur
                            if ((!item.details_obat || item.details_obat.length === 0) &&
                                (!item.details_tindakan || item.details_tindakan.length === 0) &&
                                (!item.potongan && !item.administrasi && !item.materai)) {

                                table.row.add([
                                    index + 1,
                                    item.kode_faktur ?? "-",
                                    new Date(item.created_at).toLocaleDateString("id-ID"),
                                    item.no_rm,
                                    item.nama,
                                    item.rawat ?? "-",
                                    item.jenis_px ?? "-",
                                    item.penjamin ?? "-",
                                    "-", "-", "-", "-", // Tidak ada detail
                                    item.tagihan ?? 0,
                                    item.details_apotek?.dokter ?? "-",
                                    item.user_name,
                                ]).draw();
                            } else {
                                // Menampilkan data obat
                                item.details_obat.forEach((obat) => {
                                    table.row.add([
                                        firstRow ? (index + 1) : "",
                                        firstRow ? (item.kode_faktur ?? "-") : "",
                                        firstRow ? new Date(item.created_at).toLocaleDateString("id-ID") : "",
                                        firstRow ? item.no_rm : "",
                                        firstRow ? item.nama : "",
                                        firstRow ? (item.rawat ?? "-") : "",
                                        firstRow ? (item.jenis_px ?? "-") : "",
                                        firstRow ? (item.penjamin ?? "-") : "",
                                        obat.nama,
                                        obat.harga,
                                        obat.kuantitas,
                                        obat.total_harga,
                                        firstRow ? (item.tagihan ?? 0) : "",
                                        firstRow ? (item.details_apotek?.dokter ?? "-") : "",
                                        firstRow ? item.user_name : "",
                                    ]).draw();
                                    firstRow = false;
                                });

                                // Menampilkan data tindakan jika ada
                                item.details_tindakan.forEach((tindakan) => {
                                    table.row.add([
                                        firstRow ? (index + 1) : "",
                                        firstRow ? (item.kode_faktur ?? "-") : "",
                                        firstRow ? new Date(item.created_at).toLocaleDateString("id-ID") : "",
                                        firstRow ? item.no_rm : "",
                                        firstRow ? item.nama : "",
                                        firstRow ? (item.rawat ?? "-") : "",
                                        firstRow ? (item.jenis_px ?? "-") : "",
                                        firstRow ? (item.penjamin ?? "-") : "",
                                        tindakan.nama,
                                        tindakan.harga,
                                        tindakan.qty,
                                        tindakan.total_harga,
                                        firstRow ? (item.tagihan ?? 0) : "",
                                        firstRow ? (item.details_apotek?.dokter ?? "-") : "",
                                        firstRow ? item.user_name : "",
                                    ]).draw();
                                    firstRow = false;
                                });

                                // 🔥 Menampilkan Potongan, Administrasi, dan Materai jika nilai **lebih dari 0**
                                let biayaTambahan = [
                                    { nama: "Potongan", nilai: item.potongan },
                                    { nama: "Administrasi", nilai: item.administrasi },
                                    { nama: "Materai", nilai: item.materai }
                                ];

                                biayaTambahan.forEach((biaya) => {
                                    if (biaya.nilai > 0) {
                                        table.row.add([
                                            "", "", "", "", "", "", "", "", // Kosong agar sejajar
                                            biaya.nama, "-", "-", biaya.nilai, "", "", ""
                                        ]).draw();
                                    }
                                });
                            }
                        });
                    })
                    .catch(error => console.error("Error fetching data:", error));
            });

            document.getElementById("print-data").addEventListener("click", function () {
                let csrfToken = "{{ csrf_token() }}";
                let tableData = getTableData(); // Ambil data dari tabel
                let startDate = document.getElementById("start-date").value;
                let endDate = document.getElementById("end-date").value;

                console.log("Data yang dikirim:", tableData);

                if (tableData.length === 0) {
                    alert("Tidak ada data untuk dicetak.");
                    return;
                }

                fetch("/layanan/datadetail/pdf", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({
                        data: tableData,
                        start_date: startDate,
                        end_date: endDate
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.pdf_url) {
                        setTimeout(() => {
                            $(document).Toasts('create', {
                                class: 'bg-maroon',
                                title: 'Berhasil',
                                body: 'Unduh PDF: <a href="' + data.pdf_url + '" target="_blank">Klik di sini untuk mengunduh</a>'
                            });
                        }, 2000);
                    } else {
                        alert("Gagal membuat PDF.");
                    }
                })
                .catch(error => console.error("Error:", error));
            });

            // Fungsi untuk mengambil data tabel
            function getTableData() {
                let table = document.getElementById("patienttbl");
                let rows = table.querySelectorAll("tbody tr");
                let data = [];

                rows.forEach((row) => {
                    let rowData = [];
                    row.querySelectorAll("td").forEach((cell) => {
                        rowData.push(cell.innerText.trim());
                    });
                    data.push(rowData);
                });

                return data;
            }
        });
    </script>

@endsection
