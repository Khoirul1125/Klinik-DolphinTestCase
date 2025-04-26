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
            font-size: 14px;
            white-space: nowrap; /* Mencegah teks terpotong */
            text-align: center; /* Untuk menyamakan alignment */
        }

        #patienttbl tbody td {
            font-size: 13px;
        }

        /* Scrollable Table */
        .table-responsive {
            width: 100%;
            overflow-x: auto !important;
        }
    </style>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="mt-3 col-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12 mb-3">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h3 class="card-title">Data Lama Pemeriksaan</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <!-- Filter -->
                                                <div id="filter-container" class="d-flex align-items-center mb-2">
                                                    <div class="d-flex align-items-center me-2">
                                                        <label for="start-date" class="me-2">No RM :</label>
                                                        <input type="input" id="input_rm" class="form-control">
                                                    </div>
                                                    <button id="filter-data" class="btn btn-primary">Cari</button>
                                                </div>

                                                <!-- Tabel dengan Scroll -->
                                                <div class="table-responsive">
                                                    <table id="patienttbl" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="10" class="text-center bg-primary text-white">Data Pasien</th>
                                                                {{-- <th colspan="6" class="text-center bg-success text-white">Vital Signs</th> --}}
                                                                <th class="text-center bg-warning text-dark">Tambahan</th>
                                                            </tr>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>No RM</th>
                                                                <th>Nama Pasien</th>
                                                                <th>Tanggal Lahir</th>
                                                                <th>Jenis Kelamin</th>
                                                                <th>Nama Dokter</th>
                                                                <th>Keadaan</th>
                                                                <th>Kesadaran</th>
                                                                <th>Nasabah</th>
                                                                <th>Rujuk Bagian</th>
                                                                <th>~</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div> <!-- End table-responsive -->
                                            </div>
                                            <div class="card-footer">
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <button id="reset-data" class="btn btn-secondary mr-2">Reset</button>
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
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <script>
        $(document).ready(function () {
            // Inisialisasi DataTable dengan opsi yang lebih terstruktur
            let table = $("#patienttbl").DataTable({
                responsive: true,
                autoWidth: false,
                paging: true,
                lengthChange: true,
                buttons: ["csv", "excel", "pdf", "print"],
                columnDefs: [
                    { width: "3%", targets: 0 },  // No
                    { width: "1%", targets: 1 },  // No RM
                    { width: "12%", targets: 2 }, // Nama Pasien
                    { width: "8%", targets: 3 }, // Tanggal Lahir
                    { width: "7%", targets: 4 },  // Jenis Kelamin
                    { width: "12%", targets: 5 }, // Nama Dokter
                    { width: "7%", targets: 6 },  // Tekanan Darah
                    { width: "5%", targets: 7 },  // Nadi
                    { width: "8%", targets: 8 },  // Suhu
                    { width: "5%", targets: 9 },  // Pernafasan
                    { width: "22%", targets: 10 } // Tambahan
                ],
                language: {
                    lengthMenu: "Tampil _MENU_",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
                    search: "Cari:",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    }
                }
            });

            // Pindahkan filter input ke dalam wrapper DataTable
            $('#filter-container').appendTo('#patienttbl_wrapper .dataTables_filter');

            // Fungsi untuk mengambil nilai parameter dari URL
            function getQueryParam(param) {
                let urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

            // Ambil `no_rm` dari URL
            let no_rm = getQueryParam("no_rm");

            if (no_rm) {
                $('#input_rm').val(no_rm); // Isi input dengan No RM

                // Tunggu 500ms sebelum klik tombol "Cari", untuk memastikan elemen sudah ada
                setTimeout(function () {
                    $('#filter-data').click();
                }, 500);
            }

            // Event listener untuk tombol "Cari"
            $('#filter-data').on('click', function () {
                let no_rm = $('#input_rm').val().trim();
                if (no_rm === "") {
                    alert("Masukkan No RM terlebih dahulu");
                    return;
                }

                fetch(`/api/data-lama-pemeriksaan?no_rm=${no_rm}`)
                    .then(response => response.json())
                    .then(data => {
                        let tbody = $("#patienttbl tbody");
                        tbody.empty(); // Hapus data lama dari tabel

                        if (data.length === 0) {
                            tbody.append(`<tr><td colspan="17" class="text-center">Data tidak ditemukan</td></tr>`);
                            return;
                        }

                        data.forEach((item, index) => {
                            let row = `<tr>
                                <td rowspan="8">${index + 1}</td>
                                <td>${item.no_rm}</td>
                                <td>${item.nama_pasien}</td>
                                <td>${item.tanggal_lahir}</td>
                                <td>${item.jenis_kelamin === "P" ? "Perempuan" : item.jenis_kelamin === "L" ? "Laki-Laki" : item.jenis_kelamin}</td>
                                <td>${item.nama_dokter}</td>
                                <td>${item.keadaan_umum || '-'}</td>
                                <td>${item.kesadaran_pasien || '-'}</td>
                                <td>${item.nasabah || '-'}</td>
                                <td>${item.rujuk_bagian || '-'}</td>
                                <td rowspan="8">
                                    <strong>Tanggal Pelayanan : </strong> ${item.tanggal_pelayanan || 'Data Tidak Ada'}
                                    <br><br>
                                    <strong>No_Kunjungan : </strong> ${item.no_kunjungan || 'Data Tidak Ada'}
                                    <br><br>
                                    <strong>Status Pcare : </strong> ${item.status_pcare === "-" ? "Data Tidak Ada" : item.status_pcare}
                                    <br><br>
                                    <strong>Jam_Masuk : </strong> ${item.jam_masuk || 'Data Tidak Ada'}
                                    <br><br>
                                    <strong>Jam_Keluar : </strong> ${item.jam_keluar || 'Data Tidak Ada'}
                                    <br><br>
                                    <strong>No_surat : </strong> ${item.no_surat || 'Data Tidak Ada'}
                                    <br><br>
                                    <strong>YTH : </strong> ${item.yth || 'Data Tidak Ada'}
                                    <br><br>
                                    <strong>Keterangan : </strong> ${item.keterangan || 'Data Tidak Ada'}
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9" class="text-center bg-olive text-white"><strong>Vital Signs</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Tekanan Darah :</strong> ${item.tekanan_darah || '-'}</td>
                                <td><strong>Nadi : </strong> ${item.nadi || '-'}</td>
                                <td><strong>Suhu : </strong> ${item.suhu || '-'}</td>
                                <td><strong>Pernafasan : </strong> ${item.pernafasan || '-'}</td>
                                <td colspan="2"><strong>Tinggi Badan : </strong> ${item.tinggi_badan || '-'}</td>
                                <td colspan="2"><strong>Berat Badan : </strong> ${item.berat_badan || '-'}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Resep</strong></td>
                                <td colspan="7">${item.resep || 'Data Tidak Ada'}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Diagnosa</strong></td>
                                <td colspan="7">${item.diagnosa || 'Data Tidak Ada'}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Tindakan</strong></td>
                                <td colspan="7">${item.tindakan || 'Data Tidak Ada'}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Laboratorium</strong></td>
                                <td colspan="7">${item.laboratorium || 'Data Tidak Ada'}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Radiologi</strong></td>
                                <td colspan="7">${item.radiologi || 'Data Tidak Ada'}</td>
                            </tr>`;
                            tbody.append(row);
                        });
                    })
                    .catch(error => console.error("Error fetching data:", error));
            });

            // Event listener untuk tombol "Reset"
            $('#reset-data').on('click', function () {
                $('#input_rm').val("");
                $("#patienttbl tbody").empty();
            });
        });
    </script>


@endsection
