@extends('template.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <div class="mt-3 col-12">
                        {{-- <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tbl-request" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Klinik</th>
                                                    <th>Kode</th>
                                                    <th>Tanggal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($dataRequestObat as $obat)
                                                <tr
                                                    class="{{ $obat->status == '0' ? 'bg-0-light' : 'bg-1-light' }}"
                                                    data-kode="{{ $obat->kode }}"
                                                    data-tanggal="{{ $obat->created_at->format('Y-m-d') }}"
                                                    onclick="showDetails(this)"
                                                >
                                                    <td>
                                                        @if (Str::startsWith($obat->kode, 'BLRJ'))
                                                            Klinik Balaraja
                                                        @elseif (Str::startsWith($obat->kode, 'KRS'))
                                                            Klinik Kresek
                                                        @else
                                                            Unknown Clinic
                                                        @endif
                                                    </td>
                                                    <td>{{ $obat->kode }}</td>
                                                    <td>{{ $obat->created_at->format('Y-m-d') }}</td>
                                                </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">Tidak ada data obat sementara</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <!-- Dropdown filter untuk Nama Klinik -->
                                                        <div class="col-md-6" id="filter-container"></div>

                                                        <!-- Kontrol pagination -->
                                                        <div class="col-md-6" id="pagination-container"></div>
                                                    </div>
                                                </div>
                                                <table id="tbl-request" class="table table-bordered">
                                                    {{-- <table id="tbl-request" class="table table-striped"> --}}
                                                    <thead>
                                                        <tr>
                                                            <th>Klinik</th>
                                                            <th>Kode</th>
                                                            <th>Tanggal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($dataRequestObat as $obat)
                                                        <tr
                                                            class="{{ $obat->status == '0' ? 'bg-0-light' : 'bg-1-light' }}"
                                                            data-kode="{{ $obat->kode }}"
                                                            data-kodeKlinik="{{ $obat->kode_klinik }}"
                                                            data-namaKlinik="{{ $obat->nama_klinik }}"
                                                            data-tanggal="{{ $obat->created_at->format('Y-m-d') }}"
                                                            onclick="showDetails(this)"
                                                        >
                                                            <td>{{ $obat->nama_klinik }}</td>
                                                            <td>{{ $obat->kode }}</td>
                                                            <td>{{ $obat->created_at->format('Y-m-d') }}</td>
                                                        </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="text-center">Tidak ada data obat sementara</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                <h5>Detail Obat</h5>
                                                <table id="tbl-detail" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Kode Obat</th>
                                                            <th>Nama Obat</th>
                                                            <th>Jumlah</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Detail akan diisi secara dinamis -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                <button class="btn btn-success" onclick="confirmRequest()">Konfirmasi Permintaan</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <select class="form-control select2bs4" style="width: 100%;" id="nama_obat_manual" name="nama_obat_manual">
                                                            <option value=" " disabled selected> -- Pilih Obat -- </option>
                                                            @foreach ($dabar as $data)
                                                                <option value="{{$data->kode}}"> {{$data->nama}} ({{$data->industri}})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" id="qty_manual" name="qty_manual" placeholder="Masukan Qty nya">
                                                    </div>
                                                    <div class="col-md-3 d-flex align-items-center">
                                                        <span id="stok_manual"></span>
                                                    </div>
                                                    <!-- Tombol di kolom terakhir -->
                                                    <div class="col-md-2 d-flex flex-column align-items-end">
                                                        <button type="button" class="btn btn-info" style="width: 100px;" id="addManual">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <table id="tbl-details" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Kode Obat</th>
                                                            <th>Nama Obat</th>
                                                            <th>Harga Dasar</th>
                                                            <th>Qty</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Detail harga jual akan diisi secara dinamis -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-12 d-flex justify-content-end">
                                                <button class="btn btn-success" id="confirmRequestButton">Konfirmasi Permintaan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Konfirmasi Mutasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBodyText">
                    <!-- Pesan konfirmasi akan diisi dinamis -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalCancelButton">Tidak</button>
                    <button type="button" class="btn btn-primary" id="modalProceedButton">Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>


    <style>
        .bg-0-light {
        background-color: #f5c2c6; /* Warna merah sangat muda */
        color: #000000; /* Warna teks merah */
        }

        .bg-1-light {
            background-color: #b3deb1; /* Warna hijau sangat muda */
            color: #000000; /* Warna teks hijau */
        }

        .selected-row {
            background-color: #007bff !important; /* Biru */
            color: white; /* Untuk memastikan teks tetap terlihat */
        }

        #pagination-container {
            text-align: right !important;
        }

        /* Hapus margin bawaan dari elemen pagination */
        .dataTables_paginate {
            margin: 0 !important;
        }

        /* Pastikan pagination berada di dalam #pagination-container */
        #pagination-container .dataTables_paginate {
            display: inline-block;
        }
    </style>

    <script>
        $(document).ready(function () {
            // Inisialisasi DataTable
            const table = $("#tbl-request").DataTable({
                "responsive": true,
                "autoWidth": false,
                "paging": true, // Aktifkan pagination
                "pageLength": 2, // Maksimal 5 data per halaman
                "searching": true, // Aktifkan searching untuk filter dropdown
                "lengthChange": false, // Sembunyikan dropdown panjang data
                "info": false, // Sembunyikan teks info
                "language": {
                    "paginate": {
                        "previous": "<",
                        "next": ">"
                    }
                },
                "dom": 'tp', // Hanya tampilkan pagination & tabel
                "drawCallback": function () {
                    // Selalu pindahkan pagination ke dalam #pagination-container setelah DataTable refresh
                    const pagination = $(this.api().table().container()).find('.dataTables_paginate');
                    $('#pagination-container').append(pagination);
                }
            });

            // Tambahkan dropdown filter untuk Nama Klinik
            const klinikDropdown = $('<select class="form-control"><option value="">Semua Klinik</option></select>')
                .appendTo('#filter-container') // Tambahkan dropdown ke dalam #filter-container
                .on('change', function () {
                    // Ambil nilai dari dropdown dan filter tabel
                    const val = $.fn.dataTable.util.escapeRegex($(this).val());
                    table.column(0).search(val ? '^' + val + '$' : '', true, false).draw();
                });

            // Menambahkan opsi ke dropdown berdasarkan data di kolom Nama Klinik (kolom 0)
            table.column(0).data().unique().sort().each(function (d) {
                klinikDropdown.append('<option value="' + d + '">' + d + '</option>');
            });

            // Pindahkan elemen pagination secara manual setelah halaman pertama kali dimuat
            const pagination = table.table().container().querySelector('.dataTables_paginate');
            $('#pagination-container').append(pagination);
        });
    </script>

    <script>
        // function renderPriceDetails(detailsToAdd) {
        //     const tableBody = document.querySelector("#tbl-details tbody");
        //     tableBody.innerHTML = ""; // Kosongkan tabel harga jual sebelumnya

        //     console.log("Render detail harga jual untuk obat yang valid...");

        //     detailsToAdd.forEach(detail => {
        //     console.log("Memulai pengecekan harga jual untuk:", detail);

        //     // Ambil harga jual dari API atau database
        //     fetch(`/api/get-price/${detail.kode_obat}`)
        //         .then(response => response.json())
        //         .then(data => {
        //         console.log("Response harga jual:", data);

        //         if (data.success) {
        //             const price = data.price; // Ambil harga jual

        //             // Buat baris baru untuk tabel harga jual menggunakan template literal yang benar
        //             const row = `
        //             <tr>
        //                 <td>${detail.kode_obat}</td>
        //                 <td>${detail.nama_obat}</td>
        //                 <td>${price.harga_dasar}</td>
        //                 <td>${price.harga_2}</td>
        //                 <td>${detail.qty}</td>
        //             </tr>
        //             `;

        //             // Tambahkan baris ke dalam body tabel
        //             tableBody.innerHTML += row;
        //         } else {
        //             console.error("Gagal mengambil harga jual.");
        //         }
        //         })
        //         .catch(error => console.error("Error:", error));
        //     });
        // }
    </script>

{{-- BY REQUEST KLINIK --}}
    <script>
        // Fungsi untuk menangkap data dari baris yang diklik dan mengubah warnanya
        function showDetails(row) {
            const kode = row.getAttribute("data-kode");
            const tanggal = row.getAttribute("data-tanggal");

            console.log("Data Kode Obat yang dipilih:", kode);
            console.log("Tanggal yang dipilih:", tanggal);

            // Kosongkan tabel #tbl-details
            const detailsTableBody = document.querySelector("#tbl-details tbody");
            detailsTableBody.innerHTML = ""; // Kosongkan tabel harga jual

            console.log("Tabel #tbl-details telah dikosongkan.");

            // Menghapus kelas selected-row dari baris lain yang sudah dipilih
            const allRows = document.querySelectorAll('#tbl-request tbody tr');
            allRows.forEach(r => r.classList.remove('selected-row'));

            // Menambahkan kelas selected-row ke baris yang sedang dipilih
            row.classList.add('selected-row');
            console.log("Baris dengan kode " + kode + " telah dipilih");

            // Ambil data detail melalui AJAX
            fetch(`/api/data-request-detail/${kode}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Response data detail obat:", data);

                    if (data.success) {
                        const tableBody = document.querySelector("#tbl-detail tbody");
                        tableBody.innerHTML = ""; // Kosongkan tabel detail sebelumnya

                        data.details.forEach(detail => {
                            console.log("Detail obat yang diterima:", detail);
                            const row = `
                                <tr>
                                    <td>${detail.kode_obat}</td>
                                    <td>${detail.nama_obat}</td>
                                    <td>${detail.qty}</td>
                                </tr>
                            `;
                            tableBody.innerHTML += row;
                        });
                    } else {
                        alert("Gagal mengambil data detail.");
                    }
                })
                .catch(error => console.error("Error:", error));
        }

        function confirmRequest() {
            const tableBody = document.querySelector("#tbl-detail tbody");
            const rowBody = tableBody.querySelectorAll("tr");    // Mengambil baris dari tabel detail
            let detailsToAdd = []; // Menyimpan data obat yang lolos pengecekan
            let pendingRequests = 0; // Menghitung jumlah permintaan yang sedang diproses
            let insufficientStockMessages = []; // Menyimpan pesan stok tidak mencukupi

            console.log("Memulai pengecekan stok untuk permintaan...");

            // Ambil kode_req dari baris yang dipilih (yang memiliki kelas 'selected-row')
            const selectedRow = document.querySelector("#tbl-request tbody .selected-row");
            if (selectedRow) {
                const kode_req = selectedRow.getAttribute("data-kode");
                const kode_klinik = selectedRow.getAttribute("data-kodeKlinik");
                const nama_klinik = selectedRow.getAttribute("data-namaKlinik");
                console.log("Kode permintaan yang dipilih:", kode_req);

                // Loop untuk mengecek stok per obat
                rowBody.forEach(row => {
                    const kode_obat = row.querySelector("td:nth-child(1)").innerText;
                    const nama_obat = row.querySelector("td:nth-child(2)").innerText;
                    const qty = parseInt(row.querySelector("td:nth-child(3)").innerText, 10);

                    console.log(`Pengecekan stok untuk obat ${nama_obat} (${kode_obat}) dengan qty ${qty}`);

                    // Tambahkan ke jumlah permintaan yang sedang diproses
                    pendingRequests++;

                    // Cek stok di gudang
                    fetch(`/api/check-stock/${kode_obat}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log("Response cek stok:", data);

                            if (data.success) {
                                const availableStock = data.stock; // Stok yang tersedia di gudang

                                // Cek apakah qty yang diminta melebihi stok yang tersedia
                                if (qty > availableStock) {
                                    console.log(`Stok tidak mencukupi untuk ${nama_obat}. Stok tersedia hanya ${availableStock}.`);
                                    insufficientStockMessages.push(`Stok tidak mencukupi untuk ${nama_obat}. Stok tersedia hanya ${availableStock}.`);
                                } else {
                                    console.log(`Permintaan untuk ${nama_obat} valid. Menambahkan ke daftar.`);
                                    // Jika valid, tambahkan ke detailsToAdd dengan kode_req
                                    detailsToAdd.push({
                                        kode_klinik: kode_klinik,
                                        nama_klinik: nama_klinik,
                                        kode_req: kode_req,
                                        kode_obat: kode_obat,
                                        nama_obat: nama_obat,
                                        qty: qty
                                    });
                                }
                                console.log("Data yang akan dikirimkan #2:", detailsToAdd);
                            } else {
                                console.error("Gagal memeriksa stok.");
                            }
                        })
                        .catch(error => console.error("Error:", error))
                        .finally(() => {
                            // Kurangi jumlah permintaan yang sedang diproses
                            pendingRequests--;

                            // Jika semua permintaan selesai diproses, lanjutkan ke render tabel harga jual
                            if (pendingRequests === 0) {
                                if (detailsToAdd.length > 0) {
                                    let message = "Apakah Anda yakin ingin melanjutkan?";
                                    if (insufficientStockMessages.length > 0) {
                                        message = insufficientStockMessages.join("\n") + "\n" + message;
                                    }
                                    // Tampilkan modal konfirmasi
                                    document.getElementById('modalBodyText').innerText = message;
                                    $('#confirmationModal').modal('show');

                                    // Tangani tombol "Lanjutkan"
                                    document.getElementById('modalProceedButton').onclick = function () {
                                        $('#confirmationModal').modal('hide');
                                        renderPriceDetails(detailsToAdd);
                                    };

                                    // Tangani tombol "Tidak"
                                    document.getElementById('modalCancelButton').onclick = function () {
                                        $('#confirmationModal').modal('hide');
                                    };
                                } else {
                                    console.log("Semua permintaan tidak memenuhi kriteria stok.");
                                    // Tampilkan modal konfirmasi
                                    document.getElementById('modalBodyText').innerText = "Semua permintaan tidak memenuhi kriteria stok.";
                                    $('#confirmationModal').modal('show');
                                }
                            }
                        });
                });
            } else {
                console.log("Tidak ada baris yang dipilih.");
            }
        }

        function renderPriceDetails(detailsToAdd) {
            const tableBody = document.querySelector("#tbl-details tbody");
            tableBody.innerHTML = ""; // Kosongkan tabel harga jual sebelumnya

            console.log("Render detail harga jual untuk obat yang valid...");

            detailsToAdd.forEach(detail => {
            console.log("Memulai pengecekan harga jual untuk:", detail);

            // Ambil harga jual dari API atau database
            fetch(`/api/get-price/${detail.kode_obat}`)
                .then(response => response.json())
                .then(data => {
                console.log("Response harga jual:", data);

                if (data.success) {
                    const price = data.price; // Ambil harga jual

                    // Buat baris baru untuk tabel harga jual menggunakan template literal yang benar
                    const row = `
                    <tr>
                        <td>${detail.kode_obat}</td>
                        <td>${detail.nama_obat}</td>
                        <td>${price.harga_dasar}</td>
                        <td>${price.harga_2}</td>
                        <td>${detail.qty}</td>
                    </tr>
                    `;

                    // Tambahkan baris ke dalam body tabel
                    tableBody.innerHTML += row;
                } else {
                    console.error("Gagal mengambil harga jual.");
                }
                })
                .catch(error => console.error("Error:", error));
            });
        }
    </script>

{{-- MANUAL MENAMBAHKAN --}}
    {{-- <script>
        $(document).ready(function() {
            $('#nama_obat_manual').change(function() {
                // Ambil nilai kode obat yang dipilih
                let kodeObat = $(this).val();

                if (kodeObat) {
                    // Lakukan AJAX request ke server untuk mendapatkan stok
                    $.ajax({
                        url: '/cek-stok-obat-manual', // Endpoint Laravel untuk cek stok
                        method: 'GET',
                        data: { kode: kodeObat },
                        success: function(response) {
                            // Tampilkan stok di elemen #stok_manual
                            if (response.success) {
                                $('#stok_manual').text('Sisa Stok : ' + response.stok);
                            } else {
                                $('#stok_manual').text('Sisa Stok : Tidak ditemukan');
                            }
                        },
                        error: function() {
                            $('#stok_manual').text('Sisa Stok : Error mengambil data');
                        }
                    });
                } else {
                    $('#stok_manual').text('');
                }
            });
        });
        // Menangani penambahan obat secara manual
        document.getElementById('addManual').addEventListener('click', function() {
            const selectElement = document.getElementById('nama_obat_manual');
            const namaObat = selectElement.options[selectElement.selectedIndex].text;  // Mendapatkan nama obat yang ditampilkan
            const kodeObat = selectElement.value;  // Mendapatkan kode obat yang disimpan di value
            const qty = parseInt(document.getElementById('qty_manual').value, 10);
            let detailsToAdd = []; // Menyimpan data obat yang lolos pengecekan

            if (!kodeObat || !namaObat || isNaN(qty)) {
                alert("Mohon pilih obat dan masukkan jumlah yang valid.");
                return;
            }

            // Mengecek stok untuk obat yang dipilih
            fetch(`/api/check-stock/${kodeObat}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const availableStock = data.stock;

                        if (qty > availableStock) {
                            // Jika stok tidak mencukupi
                            showModal(`Stok tidak mencukupi untuk obat ini. Stok tersedia hanya ${availableStock}.`, () => {
                                // Tambahkan stok yang tersedia ke tabel
                                detailsToAdd.push([{ kode_obat: kodeObat, nama_obat: namaObat, qty: availableStock }]);
                            });
                        } else {
                            // Jika stok cukup
                            showModal(`Stok mencukupi untuk ${qty} unit. Lanjutkan permintaan?`, () => {
                                detailsToAdd.push([{ kode_obat: kodeObat, nama_obat: namaObat, qty: qty }]);
                            });
                        }
                    } else {
                        console.error("Gagal memeriksa stok.");
                    }
                })
                .catch(error => console.error("Error:", error));

                $('#nama_obat_manual').val('').trigger('change');
                document.getElementById('qty_manual').value = ""; // Reset input qty
        });

        // Fungsi untuk menampilkan modal konfirmasi
        function showModal(message, onConfirm) {
            const modalBody = document.getElementById("modalBodyText");
            const proceedButton = document.getElementById("modalProceedButton");

            // Isi modal dengan pesan
            modalBody.innerHTML = message;

            // Tampilkan modal
            $('#confirmationModal').modal('show');

            // Ketika tombol "Lanjutkan" diklik
            proceedButton.onclick = function() {
                // Jalankan aksi yang diberikan ketika konfirmasi
                // onConfirm();
                renderPriceDetails(detailsToAdd);

                // Tutup modal setelah konfirmasi
                $('#confirmationModal').modal('hide');
            };
        }

        // Fungsi untuk merender harga obat ke tabel
        function renderPriceDetails(detailsToAdd) {
            const tableBody = document.querySelector("#tbl-details tbody");

            // Menambahkan baris baru di tabel
            detailsToAdd.forEach(detail => {
                // Ambil harga jual untuk obat yang ditambahkan
                fetch(`/api/get-price/${detail.kode_obat}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const price = data.price; // Ambil harga jual

                            // Buat baris baru untuk tabel harga jual
                            const row = `
                                <tr>
                                    <td>${detail.kode_obat}</td>
                                    <td>${detail.nama_obat}</td>
                                    <td>${price.harga_dasar}</td>
                                    <td>${price.harga_2}</td>
                                    <td>${detail.qty}</td>
                                </tr>
                            `;

                            // Tambahkan baris ke dalam body tabel
                            tableBody.innerHTML += row;
                        } else {
                            console.error("Gagal mengambil harga jual.");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        }
    </script> --}}

{{-- MANUAL MENAMBAHKAN --}}
    <script>
        $(document).ready(function() {
            $('#nama_obat_manual').change(function() {
                // Ambil nilai kode obat yang dipilih
                let kodeObat = $(this).val();

                if (kodeObat) {
                    // Lakukan AJAX request ke server untuk mendapatkan stok
                    $.ajax({
                        url: '/api/cek-stok-obat-manual', // Endpoint Laravel untuk cek stok
                        method: 'GET',
                        data: { kode: kodeObat },
                        success: function(response) {
                            // Tampilkan stok di elemen #stok_manual
                            if (response.success) {
                                $('#stok_manual').text('Sisa Stok : ' + response.stok);
                            } else {
                                $('#stok_manual').text('Sisa Stok : Tidak ditemukan');
                            }
                        },
                        error: function() {
                            $('#stok_manual').text('Sisa Stok : Error mengambil data');
                        }
                    });
                } else {
                    $('#stok_manual').text('');
                }
            });
        });

        // Menangani penambahan obat secara manual
        document.getElementById('addManual').addEventListener('click', function() {
            const selectElement = document.getElementById('nama_obat_manual');
            const namaObat = selectElement.options[selectElement.selectedIndex].text;  // Mendapatkan nama obat yang ditampilkan
            const kodeObat = selectElement.value;  // Mendapatkan kode obat yang disimpan di value
            const qty = parseInt(document.getElementById('qty_manual').value, 10);
            let detailsToAdd = []; // Menyimpan data obat yang lolos pengecekan

            if (!kodeObat || !namaObat || isNaN(qty)) {
                alert("Mohon pilih obat dan masukkan jumlah yang valid.");
                return;
            }

            // Ambil kode_req dari baris yang dipilih (yang memiliki kelas 'selected-row')
            const selectedRow = document.querySelector("#tbl-request tbody .selected-row");
            if (selectedRow) {
                const kode_req = selectedRow.getAttribute("data-kode");
                const kode_klinik = selectedRow.getAttribute("data-kodeKlinik");
                const nama_klinik = selectedRow.getAttribute("data-namaKlinik");

                // Mengecek stok untuk obat yang dipilih
                fetch(`/api/check-stock/${kodeObat}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const availableStock = data.stock;

                            if (qty > availableStock) {
                                // Jika stok tidak mencukupi
                                showModal(`Stok ${namaObat} tidak mencukupi untuk obat ini. Stok tersedia hanya ${availableStock}. Lanjutkan permintaan?`, () => {
                                    // Tambahkan stok yang tersedia ke tabel
                                    detailsToAdd.push({ kode_klinik: kode_klinik, nama_klinik: nama_klinik, kode_req: kode_req, kode_obat: kodeObat, nama_obat: namaObat, qty: availableStock});
                                    renderPriceDetails(detailsToAdd); // Panggil renderPriceDetails setelah modal konfirmasi
                                    console.log("Data yang akan dikirimkan #1:", detailsToAdd);
                                });
                            } else {
                                // Jika stok cukup
                                showModal(`Stok ${namaObat} mencukupi untuk ${qty} unit. Lanjutkan permintaan?`, () => {
                                    detailsToAdd.push({ kode_klinik: kode_klinik, nama_klinik: nama_klinik, kode_req: kode_req, kode_obat: kodeObat, nama_obat: namaObat, qty: qty });
                                    renderPriceDetails(detailsToAdd); // Panggil renderPriceDetails setelah odal konfirmasi
                                    console.log("Data yang akan dikirimkan #2:", detailsToAdd);
                                });
                            }
                        } else {
                            console.error("Gagal memeriksa stok.");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            } else {
                console.log("Tidak ada baris yang dipilih.");
            }

            // Reset input setelah selesai
            $('#nama_obat_manual').val('').trigger('change');
            document.getElementById('qty_manual').value = ""; // Reset input qty
        });

        // Fungsi untuk menampilkan modal konfirmasi
        function showModal(message, onConfirm) {
            const modalBody = document.getElementById("modalBodyText");
            const proceedButton = document.getElementById("modalProceedButton");

            // Isi modal dengan pesan
            modalBody.innerHTML = message;

            // Tampilkan modal
            $('#confirmationModal').modal('show');

            // Ketika tombol "Lanjutkan" diklik
            proceedButton.onclick = function() {
                // Jalankan aksi yang diberikan ketika konfirmasi
                onConfirm();

                // Tutup modal setelah konfirmasi
                $('#confirmationModal').modal('hide');
            };
        }

        // Fungsi untuk merender detail harga jual
        function renderPriceDetails(detailsToAdd) {
            const tableBody = document.querySelector("#tbl-details tbody");

            console.log("Render detail harga jual untuk obat yang valid...");

            detailsToAdd.forEach(detail => {
                console.log("Memulai pengecekan harga jual untuk:", detail);

                // Ambil harga jual dari API atau database
                fetch(`/api/get-price/${detail.kode_obat}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Response harga jual:", data);

                        if (data.success) {
                            const price = data.price; // Ambil harga jual

                            // Buat baris baru untuk tabel harga jual menggunakan template literal yang benar
                            const row = `
                            <tr>
                                <td hidden>${detail.kode_klinik}</td>
                                <td hidden>${detail.nama_klinik}</td>
                                <td hidden>${detail.kode_req}</td>
                                <td>${detail.kode_obat}</td>
                                <td>${detail.nama_obat}</td>
                                <td>${price.harga_dasar}</td>
                                <td>${detail.qty}</td>
                            </tr>
                            `;

                            // Tambahkan baris ke dalam body tabel
                            tableBody.innerHTML += row;
                        } else {
                            console.error("Gagal mengambil harga jual.");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        }

        // Fungsi untuk mengambil data dari tabel
        function getTableData() {
            const tableBody = document.querySelector("#tbl-details tbody");
            const rows = tableBody.querySelectorAll("tr"); // Ambil semua baris dalam tabel
            let tableData = [];

            rows.forEach(row => {
                const cells = row.querySelectorAll("td"); // Ambil semua sel dalam baris
                const rowData = {
                    kode_klinik: cells[0].innerText, // Hidden kolom pertama
                    nama_klinik: cells[1].innerText, // Hidden kolom kedua
                    kode_req: cells[2].innerText,   // Hidden kolom ketiga
                    kode_obat: cells[3].innerText,  // Kolom keempat
                    nama_obat: cells[4].innerText,  // Kolom kelima
                    harga_dasar: cells[5].innerText, // Kolom keenam
                    qty: cells[6].innerText         // Kolom kedelapan
                };
                tableData.push(rowData); // Tambahkan data baris ke dalam array
            });

            return tableData; // Pastikan fungsi mengembalikan data tabel
        }

        document.getElementById("confirmRequestButton").addEventListener("click", function () {
            // Ambil data dari tabel menggunakan fungsi yang sudah dibuat sebelumnya
            const tableData = getTableData();
            // // Ambil token CSRF dari meta tag
            // const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            console.log("Data yang akan dikirim:", tableData);

            // Atur CSRF token untuk semua permintaan AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Kirim data menggunakan AJAX
            $.ajax({
                url: '/gudang-utama/add', // Endpoint tujuan
                type: 'POST',            // Metode HTTP
                dataType: 'json',        // Format data yang diharapkan
                contentType: 'application/json', // Format data yang dikirim
                data: JSON.stringify({ details: tableData }), // Data dikirim dalam format JSON
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        alert("Data berhasil disimpan!");
                        console.log("Response dari server:", response);

                        // Redirect ke URL yang diberikan server
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        }
                    } else {
                        alert("Gagal menyimpan data: " + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error
                    alert("Terjadi kesalahan saat mengirim data.");
                    console.error("AJAX Error:", error, xhr.responseText);
                }
            });
        });

    </script>



@endsection

