@extends('template.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <style>
        #kunjungan-table_wrapper .dataTables_filter {
            display: flex;
            align-items: center;
            justify-content: flex-end; /* Dorong ke kanan */
            gap: 10px;
        }

        #filter-poli {
            display: inline-block; /* Tetap berada dalam satu baris */
            margin-left: 10px;
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

    </style>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="mt-3 col-12">
                    <div class="row d-flex">
                        <div class="mb-3 col-md-12" id="kecelakan-col" style="display: none;">
                            <div class="card h-100" id="kecelakan-card" style="display: none;">
                                <div class="card-header bg-light" id="kecelakan-header" style="display: none;">
                                    <h5><i class="fa fa-user"></i> Pilih Data Pasien</h5>
                                </div>
                                <div class="card-body" id="kecelakan-section" style="display: none;">
                                    <table id="patienttbl" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No. RM</th>
                                                <th>Nama Pasien</th>
                                                <th>Tgl. Lahir</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Alamat</th>
                                                <th>No. Telepon</th>
                                                <th width="15%">Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Table data will be populated here -->
                                        </tbody>
                                    </table>
                                    <div id="noPatientAction" class="text-center mt-3" style="display: none;">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#adddoctor">
                                        <i class="fas fa-plus"></i> Tambah Baru
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Start Form -->
                        <form action="{{ route('regis.rajal.add') }}" method="POST" class="row w-100">
                            @csrf
                            <!-- Kelola Data Pasien -->
                            <div class="mb-3 col-md-12" id="dataCard" style="display: none;">
                                <div class="card h-100">
                                    <div class="card-header bg-light d-flex align-items-center justify-content-between">
                                        <h5 class="me-2"><i class="fa fa-user"></i> Registrasi Pasien Rawat Jalan</h5>
                                        <h5 class="ms-custom"><i class="fa fa-user"></i> Identitas Pasien</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Kelola Data Pasien -->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-md-7">
                                                        <label for="tgl_kunjungan">Tanggal Daftar</label>
                                                        <input type="date" class="form-control" id="tgl_kunjungan" name="tgl_kunjungan">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label for="timepicker">Jam</label>
                                                        <div class="input-group date" id="timepicker" data-target-input="nearest">
                                                            <input type="text" class="form-control timepicker-input" data-target="#timepicker" id="time" name="time">
                                                            <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                                                <div class="input-group-text">
                                                                    <i class="far fa-clock"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-10">
                                                        <label for="nama">Cari RM ,NO BPJS,ID, Nama Pasien </label>
                                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Cari pasien">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label>&nbsp;</label>
                                                        <button type="button" class="btn btn-primary btn-block" id="search-button">Cari</button>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="poli">Poli</label>
                                                        <select class="form-control select2bs4" style="width: 100%;" id="poli" name="poli">
                                                            <option value="" disabled selected>-- Pilih --</option>
                                                            @foreach ($poli as $data)
                                                                <option value="{{ $data->id }}">{{ $data->nama_poli }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="dokter">Dokter</label>
                                                        <select class="form-control select2bs4" style="width: 100%;" id="dokter" name="dokter">
                                                            <option value="" disabled selected>-- Pilih --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="no_reg">No. Reg</label>
                                                        <input type="text" class="form-control" id="no_reg" name="no_reg">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="no_rawat">No. Rawat</label>
                                                        <input type="text" class="form-control" id="no_rawat" name="no_rawat">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label for="penjamin">Penjamin</label>
                                                        <select class="form-control select2bs4" style="width: 100%;" id="penjamin" name="penjamin">
                                                            <option value="" disabled selected>-- Pilih --</option>
                                                            @foreach ($penjab as $data)
                                                                <option value="{{ $data->id }}">{{ $data->pj }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Data Pasien -->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label for="no_rm">Nomor RM</label>
                                                        <input type="text" class="form-control" id="no_rm" name="no_rm" placeholder="Nomor Rekam Medis" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label for="nama_pasien">Nama Pasien</label>
                                                        <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Nama Pasien" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label for="tgl_lahir">Tanggal Lahir</label>
                                                        <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal Lahir Pasien" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label for="seks">Jenis Kelamin</label>
                                                        <input type="text" class="form-control" id="seks" name="seks" placeholder="Jenis Kelamin Pasien" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label for="telepon">Telepon</label>
                                                        <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Nomor Telepon Pasien" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-floppy-disk"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->

                        </form>
                        <!-- End Form -->
                    </div>
                </div>

                <div class="mt-3 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 card-title">Pendaftaran Pasien Rawat Jalan</h3>
                            <div class="text-right card-tools">
                                <button type="button" class="btn btn-primary" id="showCardButton">
                                    <i class="fas fa-plus"></i> Registrasi Rawat Jalan
                                </button>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body" id="kunjungan-section">
                            <div id="filter-container" class="d-flex align-items-center mb-2">
                                <!-- Filter Poliklinik -->
                                <div class="d-flex align-items-center me-2">
                                    <label for="filter-poli" class="me-2">Poliklinik:</label>
                                    <select id="filter-poli" class="form-control" style="width: 150px;">
                                        <option value="">Semua Poliklinik</option>
                                        @foreach ($poli as $poli)
                                            <option value="{{ $poli->nama_poli }}">{{ $poli->nama_poli }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex align-items-center me-2">
                                    <label for="start-date" class="me-2">Rentang Tanggal:</label>
                                    <input type="date" id="start-date" class="form-control" style="width: 150px;">
                                    <span class="mx-2">-</span>
                                    <input type="date" id="end-date" class="form-control" style="width: 150px;">
                                </div>

                                <!-- Tombol Filter -->
                                <button id="filter-date" class="btn btn-primary me-2">Filter</button>

                                <!-- Tombol Reset -->
                                <button id="reset-date" class="btn btn-secondary">Reset</button>
                            </div>

                            <table id="kunjungan-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>ID. Kunjungan</th>
                                        <th>Antrian</th>
                                        <th>Poliklinik</th>
                                        <th>Dokter</th>
                                        <th>Penjamin</th>
                                        <th>No. Asuransi</th>
                                        <th>Tgl. Kunjungan</th>
                                        <th>Status</th>
                                        <th>Status Lanjutan</th>
                                        <th width="10%">Pilihan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rajal as $data)
                                        <tr>
                                            <td>{{ $data->no_rm }}</td>
                                            <td>{{ $data->nama_pasien }}</td>
                                            <td>{{ $data->no_rawat }}</td>
                                            <td>{{ $data->nomor_antrean }}</td>
                                            <td>{{ $data->poli->nama_poli }}</td>
                                            <td>{{ $data->doctor->nama_dokter }}</td>
                                            <td>{{ $data->penjab->pj }}</td>
                                            <td>{{ $data->pasien->no_bpjs ?? '' }}</td>
                                            <td>{{ $data->tgl_kunjungan }}</td>
                                            <td>{{ $data->status }}</td>
                                            <td>{{ $data->status_lanjut }}</td>
                                            <td class="text-center">
                                                <div class="d-inline-flex gap-3">
                                                    <button type="button" class="btn btn-flat btn-primary d-flex align-items-center justify-content-center shadow-sm"
                                                        style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;"
                                                        data-toggle="modal" data-target="#editDoctorModal"
                                                        onclick="setEditDoctor('{{ $data->id }}', '{{ $data->doctor_id }}')">
                                                        <i class="fa fa-user-md" style="margin-right: 5px;"></i> Edit Dokter
                                                    </button>
                                                    <span>
                                                        <button  type="button" class="btn btn-flat btn-danger  d-flex align-items-center justify-content-center shadow-sm"
                                                        style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;"
                                                        data-toggle="modal" data-target="#confirmDeleteModal" onclick="setDeleteAction('{{ route('rajal.delete', $data->id) }}')">
                                                            <i class="fa fa-edit" style="margin-right: 5px;"></i> Batal
                                                        </button>
                                                    </span>
                                                </div>
                                            </td>
                                            <style>
                                                .btn-container {
                                                    gap: 10px; /* Spacing between buttons */
                                                }
                                                .btn-group .dropdown-menu {
                                                    min-width: 150px; /* Adjust the width of the dropdown */
                                                }
                                            </style>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="editDoctorModal" tabindex="-1" role="dialog" aria-labelledby="editDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDoctorModalLabel">Edit Dokter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editDoctorForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editPatientId" name="patient_id">

                    <div class="form-group">
                        <label for="doctorSelect">Pilih Dokter</label>
                        <select class="form-control" id="doctorSelect" name="doctor_id">
                            <option value="">-- Pilih Dokter --</option>
                            @foreach ($dokter as $doctors)
                                <option value="{{ $doctors->id }}">{{ $doctors->nama_dokter }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Konfirmasi Pembatalan Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin membatalkan Pasien ini?</p>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')

                        <!-- Input Alasan Pembatalan -->
                        <div class="form-group">
                            <label for="cancelReason">Alasan Pembatalan</label>
                            <input type="text" class="form-control" name="reason" id="cancelReason" required placeholder="Masukkan alasan pembatalan">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-danger">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function setEditDoctor(patientId, doctorId) {
    document.getElementById("editPatientId").value = patientId;
    document.getElementById("doctorSelect").value = doctorId; // Set nilai default dokter
    document.getElementById("editDoctorForm").action = `/rajal/update-doctor/${patientId}`;
}

    </script>
    <script>
        // Fungsi untuk mengganti URL 'action' pada form
        function setDeleteAction(action) {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.setAttribute('action', action);
        }
    </script>

<!-- /.content-wrapper -->
    <style>
        .ms-custom {
            margin-left: -40px; /* adjust as needed */
        }
    </style>

    <script>
        $(document).ready(function () {
            $('#poli').change(function () {
                var selectedPoli = $(this).val(); // Ambil ID poli yang dipilih

                // Lakukan permintaan AJAX untuk mendapatkan daftar dokter berdasarkan poli
                $.ajax({
                    url: "/api/doctor/filter", // Ganti dengan route filter dokter
                    method: 'GET',
                    data: { poli_id: selectedPoli },
                    success: function(response) {
                        $('#dokter').empty(); // Kosongkan dropdown dokter
                        $('#dokter').append('<option value="" disabled selected>-- Pilih Dokter --</option>'); // Tambahkan pilihan default

                        // Looping dan menambahkan dokter ke dropdown
                        $.each(response.dokter, function(index, dokter) {
                            $('#dokter').append('<option value="'+ dokter.id +'">' + dokter.nama_dokter + '</option>');
                        });
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#showCardButton').click(function() {
                if ($('#dataCard').is(':visible')) {
                    $('#dataCard').hide(); // Sembunyikan jika terlihat
                } else {
                    $('#dataCard').show(); // Tampilkan jika tersembunyi
                }
            });
        });
    </script>

    <script>
        window.onload = function() {
            // Mengambil tanggal dan waktu saat ini
            var now = new Date();

            // Mengatur nilai input tanggal (YYYY-MM-DD)
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear() + "-" + month + "-" + day;
            document.getElementById("tgl_kunjungan").value = today;

            // Mengatur nilai input waktu (HH:MM)
            var hours = ("0" + now.getHours()).slice(-2);
            var minutes = ("0" + now.getMinutes()).slice(-2);
            var currentTime = hours + ":" + minutes;
            document.getElementById("time").value = currentTime;
        };
    </script>

    <script>
        $(document).ready(function() {
            const searchButton = document.getElementById('search-button');
            const kecelakanSection = document.getElementById('kecelakan-section');
            const kecelakanHeader = document.getElementById('kecelakan-header');
            const kecelakanCard = document.getElementById('kecelakan-card');
            const kecelakanCol = document.getElementById('kecelakan-col');

            // Event listener ketika tombol search diklik
            $('#search-button').click(function() {
                // Ambil nilai dari input nama
                var namaPasien = $('#nama').val();

                // Panggil AJAX ke server untuk mencari pasien
                $.ajax({
                    url: '/api/search-pasien-rajal', // URL untuk request pencarian
                    method: 'GET',
                    data: { nama: namaPasien },
                    success: function(response) {
                        // Kosongkan tabel sebelum mengisi data baru
                        $('#patienttbl tbody').empty();

                        // Periksa apakah ada hasil
                        if (response.length > 0) {
                            // Looping melalui hasil dan tambahkan ke tabel
                            $.each(response, function(index, pasien) {
                                var row = '<tr>' +
                                    '<td>' + pasien.no_rm + '</td>' +
                                    '<td>' + pasien.nama + '</td>' +
                                    '<td>' + pasien.tanggal_lahir + '</td>' +
                                    '<td>' + (pasien.seks ? pasien.seks.nama : 'Tidak Diketahui') + '</td>' +  // Menampilkan nama seks, jika tersedia
                                    '<td>' + pasien.Alamat + '</td>' +
                                    '<td>' + pasien.telepon + '</td>' +
                                    '<td>' +
                                        '<button class="btn btn-primary select-patient" data-id="' + pasien.no_rm + '" data-nama="' + pasien.nama + '" data-tgl="' + pasien.tanggal_lahir + '" data-seks="' + (pasien.seks ? pasien.seks.nama : '') + '" data-telepon="' + pasien.telepon + '">Pilih</button>' +
                                    '</td>' +
                                    '</tr>';
                                $('#patienttbl tbody').append(row);
                            });
                        } else {
                            // Jika tidak ada hasil, tampilkan pesan kosong
                            $('#patienttbl tbody').append('<tr><td colspan="7">Pasien tidak ditemukan</td></tr>');
                            $('#noPatientAction').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error searching pasien:', error);
                    }
                });

                // Tampilkan atau sembunyikan kecelakanSection
                const isCurrentlyVisible = kecelakanSection.style.display === 'block';

                if (isCurrentlyVisible) {
                    // Sembunyikan jika sedang terlihat
                    kecelakanSection.style.display = 'none';
                    kecelakanHeader.style.display = 'none';
                    kecelakanCard.style.display = 'none';
                    kecelakanCol.style.display = 'none';
                } else {
                    // Tampilkan jika sedang tersembunyi
                    kecelakanSection.style.display = 'block';
                    kecelakanHeader.style.display = 'block';
                    kecelakanCard.style.display = 'block';
                    kecelakanCol.style.display = 'block';
                }
            });

            // Event listener untuk tombol "Pilih"
            $(document).on('click', '.select-patient', function() {
                // Ambil data dari atribut tombol
                var noRm = $(this).data('id');
                var nama = $(this).data('nama');
                var tglLahir = $(this).data('tgl');
                var seks = $(this).data('seks');
                var telepon = $(this).data('telepon');

                // Isi field input di card dengan data pasien yang dipilih
                $('#no_rm').val(noRm);
                $('#nama_pasien').val(nama);
                $('#tgl_lahir').val(tglLahir);
                $('#seks').val(seks);
                $('#telepon').val(telepon);

                // Sembunyikan kecelakanSection dan elemen terkait
                kecelakanSection.style.display = 'none';
                kecelakanHeader.style.display = 'none';
                kecelakanCard.style.display = 'none';
                kecelakanCol.style.display = 'none';
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Menjalankan AJAX saat input No. Reg difokuskan (diklik)
            $('#no_reg').focus(function() {
                $.ajax({
                    url: '/api/generate-no-reg-rajal', // URL ke controller yang menangani nomor registrasi
                    type: 'GET',
                    success: function(response) {
                        // Menampilkan nomor registrasi di input field
                        $('#no_reg').val(response.no_reg);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Gagal menghasilkan nomor registrasi.');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Menjalankan AJAX saat input No. Rawat difokuskan (diklik)
            $('#no_rawat').focus(function() {
                $.ajax({
                    url: '/api/generate-no-rawat-rajal', // URL ke route yang menggenerate nomor rawat
                    method: 'GET',
                    success: function(response) {
                        // Set nilai input dengan nomor rawat yang dihasilkan
                        $('#no_rawat').val(response.no_rawat);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error generating No. Rawat:', error);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            var table = $("#kunjungan-table").DataTable({
                "responsive": true,
                "autoWidth": false,
                "paging": true,
                "lengthChange": true,
                "buttons": ["csv", "excel", "pdf", "print"],
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

            // Pindahkan dropdown ke area pencarian
            $('#filter-container').appendTo('#kunjungan-table_wrapper .dataTables_filter');

            // Filter berdasarkan Poliklinik
            $('#filter-poli').on('change', function() {
                var poli = $(this).val(); // Ambil nilai dari dropdown
                table.column(4) // Kolom ke-4 adalah Poliklinik (indeks mulai dari 0)
                    .search(poli)
                    .draw(); // Terapkan filter dan refresh tabel
            });



            // Filter berdasarkan Rentang Tanggal
            $('#filter-date').on('click', function () {
                var startDate = $('#start-date').val();
                var endDate = $('#end-date').val();

                if (!startDate || !endDate) {
                    alert('Silakan pilih kedua tanggal!');
                    return;
                }

                var start = new Date(startDate).getTime();
                var end = new Date(endDate).getTime();

                // Terapkan filter tanggal
                $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                    var tanggal = new Date(data[8]).getTime(); // Kolom tanggal (sesuaikan dengan kolom tanggal Anda)
                    return tanggal >= start && tanggal <= end;
                });

                table.draw();
                $.fn.dataTable.ext.search.pop();
            });

            // Reset Filter Tanggal
            $('#reset-date').on('click', function () {
                $('#start-date').val(''); // Kosongkan input tanggal mulai
                $('#end-date').val('');   // Kosongkan input tanggal akhir

                table.draw(); // Reset tabel
            });
        });
    </script>

@endsection
