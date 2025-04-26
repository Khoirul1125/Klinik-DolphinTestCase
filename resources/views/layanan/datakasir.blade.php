@extends('template.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                                                            <th>No RM</th>
                                                            <th>Nama</th>
                                                            <th>Jenis</th>
                                                            <th>Alamat</th>
                                                            <th>No Faktur</th>
                                                            <th>Cash</th>
                                                            <th>Debit</th>
                                                            <th>Credit Card</th>
                                                            <th>Credit</th>
                                                            <th>Transfer</th>
                                                            <th>QR</th>
                                                            <th>Kembalian</th>
                                                            <th>Total</th>
                                                            <th>Tanggal</th>
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

<!-- JavaScript -->
<script>
    $(document).ready(function () {
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
            "buttons": ["csv", "excel", "pdf", "print"],
            "columnDefs": [
                { "width": "1%", "targets": 0 },  // No
                { "width": "5%", "targets": 1 },  // No RM
                { "width": "5%", "targets": 2 },  // Nama
                { "width": "5%", "targets": 3 },  // Jenis
                { "width": "10%", "targets": 4 },  // Alamat
                { "width": "5%", "targets": 5 },  // No Faktur
                { "width": "5%", "targets": 6 },  // Cash
                { "width": "5%", "targets": 7 },  // Debit
                { "width": "5%", "targets": 8 },  // Credit Card
                { "width": "5%", "targets": 9 },  // Credit
                { "width": "5%", "targets": 10 }, // Transfer
                { "width": "5%", "targets": 11 }, // QR
                { "width": "5%", "targets": 12 }, // Kembalian
                { "width": "5%", "targets": 13 }, // Total
                { "width": "5%", "targets": 14 }  // Tanggal
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

        // Mapping metode pembayaran ke kolom tabel
        function getPaymentColumn(paymentType) {
            const mapping = {
                "Cash": "cash",
                "Debit Card": "debit",
                "Credit Card": "credit_card",
                "Credit": "credit",
                "Transfer": "transfer",
                "Qris": "qr",
                "Penjamin": "credit" // Penjamin masuk ke kolom Credit
            };
            return mapping[paymentType] || null;
        }

        // Fungsi untuk mendapatkan total pembayaran berdasarkan metode yang digunakan
        function calculatePayments(item) {
            let payments = {
                cash: 0,
                debit: 0,
                credit_card: 0,
                credit: 0,
                transfer: 0,
                qr: 0
            };

            // Cek pembayaran pertama
            let column1 = getPaymentColumn(item.bayar_1);
            if (column1) payments[column1] += parseFloat(item.uang_bayar_1) || 0;

            // Cek pembayaran kedua
            let column2 = getPaymentColumn(item.bayar_2);
            if (column2) payments[column2] += parseFloat(item.uang_bayar_2) || 0;

            // Cek pembayaran ketiga
            let column3 = getPaymentColumn(item.bayar_3);
            if (column3) payments[column3] += parseFloat(item.uang_bayar_3) || 0;

            return payments;
        }

        // Fungsi untuk menghitung kembalian
        function calculateChange(payments, tagihan) {
            let totalPaid = payments.cash + payments.debit + payments.credit_card + payments.credit + payments.transfer + payments.qr;
            let change = totalPaid - (parseFloat(tagihan) || 0);

            return change > 0 ? change : "-"; // Jika kembalian lebih dari 0, tampilkan angka, jika tidak, tampilkan "-"
        }

        // Ubah data tabel dengan logika pembayaran & kembalian baru
        $('#filter-date').on('click', function () {
            let startDate = $('#start-date').val();
            let endDate = $('#end-date').val();
            let jenis = $('#filter-jenis').val();

            fetch(`/api/kasir/filter?start_date=${startDate}&end_date=${endDate}&jenis=${jenis}`)
            .then(response => response.json())
            .then(data => {
                table.clear().draw();
                data.forEach((item, index) => {
                    let payments = calculatePayments(item);
                    let change = calculateChange(payments, item.tagihan);

                    table.row.add([
                        index + 1,
                        item.no_rm,
                        item.nama,
                        item.jenis_px,
                        item?.details_apotek?.alamat ?? "-",
                        item.kode_faktur ?? "-",
                        payments.cash,          // Cash
                        payments.debit,         // Debit
                        payments.credit_card,   // Credit Card
                        payments.credit,        // Credit (termasuk Penjamin)
                        payments.transfer,      // Transfer
                        payments.qr,            // QR
                        change,                 // Kembalian
                        item.tagihan ?? 0,
                        new Date(item.created_at).toLocaleDateString("id-ID")
                    ]).draw();
                });
            })
            .catch(error => console.error("Error fetching data:", error));
        });

        // // Reset Filter
        $('#reset-date').on('click', function () {
            $('#start-date').val("");
            $('#end-date').val("");
            $('#filter-jenis').val("");

            let table = $("#patienttbl").DataTable();
            table.clear().draw(); // Kosongkan tabel sebelum reload

            $('#filter-date').click(); // Trigger ulang filter dengan data awal
        });


        // Fungsi untuk mengambil data dari tabel
        function getTableData() {
            let table = document.querySelector("#patienttbl tbody");
            let rows = table.querySelectorAll("tr");
            let data = [];

            rows.forEach(row => {
                let rowData = [];
                row.querySelectorAll("td").forEach(cell => {
                    rowData.push(cell.innerText.trim()); // Ambil teks dalam setiap sel
                });
                data.push(rowData);
            });

            return data;
            console.log(data);
        }

        document.getElementById("print-data").addEventListener("click", function () {
            let csrfToken = "{{ csrf_token() }}";
            let tableData = getTableData(); // Ambil data tabel
            let startDate = document.getElementById("start-date").value;
            let endDate = document.getElementById("end-date").value;

            console.log("Data yang dikirim:", tableData);

            if (tableData.length === 0) {
                alert("Tidak ada data untuk dicetak.");
                return;
            }

            fetch("/layanan/datakasir/pdf", {
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
    });
</script>
@endsection
