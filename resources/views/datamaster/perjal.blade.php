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
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0 card-title">Kelola Tarif Perawatan Rawat Jalan</h3>
                                <div class="text-right card-tools">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#adddoctor">
                                        <i class="fas fa-plus"></i> Tambah Baru
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                              <table id="janjitbl" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                  <th class="text-center">Kode Perawatan </th>
                                  <th class="text-center">Nama Perawatan </th>
                                  <th class="text-center">Tarif Dokter</th>
                                  <th class="text-center">Tarif Perawat </th>
                                  <th class="text-center">Total Tarif </th>
                                  <th class="text-center">Pilihan </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->kode }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->tarifdok }}</td>
                                                <td>{{ $item->tarifper }}</td>
                                                <td>{{ $item->total }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $item->id }}">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $item->id }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                </td>
                                            </tr>
                                    @endforeach
                                </tbody>
                              </table>
                            </div>
                            <!-- /.card-body -->
                          </div>
                    </div>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <div class="modal fade" id="adddoctor" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Kelola Tarif Perawatan Jalan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addFormpermesion" action="{{ route('datmas.perjal.add') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kode Rawat Jalan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="kode_perjal" name="kode_perjal" placeholder="Generate Kode Barang" readonly>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary" id="generateKodeButton">Generate</button>
                                        </span>
                                    </div>
                                </div>
                                @error('kode_perjal')
                                    <small>
                                        <div id="error-kode_perjal" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kategori </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="kategori" name="kategori">
                                        <option value="" disabled selected>-- Pilih Kategori --</option>
                                        @foreach ($katper as $data_katper)
                                        <option value="{{$data_katper->kode_rawatan}}" {{ old('kategori') == $data_katper->kode_rawatan ? 'selected' : '' }}>{{$data_katper->nama_rawatan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('kategori')
                                    <small>
                                        <div id="error-kategori" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Nama </label>
                                    <input type="text" class="form-control" id="nama_perjal" name="nama_perjal" value="{{ old('nama_perjal') }}">
                                </div>
                                @error('nama_perjal')
                                    <small>
                                        <div id="error-nama_perjal" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Tarif Dokter </label>
                                    <input type="number" class="form-control" id="tarif_dokter" name="tarif_dokter" value="{{ old('tarif_dokter') }}">
                                </div>
                                @error('tarif_dokter')
                                    <small>
                                        <div id="error-tarif_dokter" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Tarif Perawat </label>
                                    <input type="number" class="form-control" id="tarif_perawat" name="tarif_perawat" value="{{ old('tarif_perawat') }}">
                                </div>
                                @error('tarif_perawat')
                                    <small>
                                        <div id="error-tarif_perawat" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Total Tarif </label>
                                    <input type="number" class="form-control" id="total_tarif" name="total_tarif" value="{{ old('total_tarif') }}">
                                </div>
                                @error('total_tarif')
                                    <small>
                                        <div id="error-total_tarif" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Penanggung Jawab</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="penjab" name="penjab">
                                        <<option value="" disabled selected>-- Pilih Penjab --</option>
                                        @foreach ($penjab as $data_penjab)
                                        <option value="{{$data_penjab->id}}" {{ old('penjab') == $data_penjab->id ? 'selected' : '' }}>{{$data_penjab->pj}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('penjab')
                                    <small>
                                        <div id="error-penjab" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Poliklinik</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="poli" name="poli">
                                        <option value="" disabled selected>-- Pilih Poli --</option>
                                        @foreach ($poli as $data_poli)
                                        <option value="{{$data_poli->id}}" {{ old('poli') == $data_poli->id ? 'selected' : '' }}>{{$data_poli->nama_poli}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('poli')
                                    <small>
                                        <div id="error-poli" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Status </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="status" name="status">
                                        <option value="">--- pilih ---</option>
                                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="tidak aktif" {{ old('status') == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                                @error('status')
                                    <small>
                                        <div id="error-status" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseModal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button> <!-- Submit button -->
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    @foreach ($data as $delete)
    <div class="modal fade" id="deleteModal{{ $delete->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Tarif Perawatan Rawat Jalan ini?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('datmas.perjal.delete', $delete->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Edit -->
    @foreach ($data as $edit)
    <div class="modal fade" id="editModal{{ $edit->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Tarif Perawatan Rawat Jalan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('datmas.perjal.update', $edit->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kode Rawat Jalan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="kode_perjal_update" name="kode_perjal_update" value="{{ $edit->kode }}" required readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kategori </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="kategori_update" name="kategori_update">
                                        <option value="" disabled selected>-- Pilih Kategori --</option>
                                        @foreach ($katper as $katper_update)
                                        <option value="{{ $katper_update->kode_rawatan }}" {{ $edit->katper_id == $katper_update->kode_rawatan ? 'selected' : '' }}>
                                            {{ $katper_update->nama_rawatan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Nama </label>
                                    <input type="text" class="form-control" id="nama_perjal_update" name="nama_perjal_update" value="{{ $edit->nama }}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Tarif Dokter </label>
                                    <input type="number" class="form-control" id="tarif_dokter_update" name="tarif_dokter_update" value="{{ $edit->tarifdok }}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Tarif Perawat </label>
                                    <input type="number" class="form-control" id="tarif_perawat_update" name="tarif_perawat_update" value="{{ $edit->tarifper }}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Total Tarif </label>
                                    <input type="number" class="form-control" id="total_tarif_update" name="total_tarif_update" value="{{ $edit->total }}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Penanggung Jawab</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="penjab_update" name="penjab_update">
                                        <<option value="" disabled selected>-- Pilih Penjab --</option>
                                        @foreach ($penjab as $penjab_update)
                                        <option value="{{$penjab_update->id}}" {{ $edit->penjab_id == $penjab_update->id ? 'selected' : '' }}>
                                            {{$penjab_update->pj}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Poliklinik</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="poli_update" name="poli_update">
                                        <option value="" disabled selected>-- Pilih Poli --</option>
                                        @foreach ($poli as $poli_update)
                                        <option value="{{$poli_update->id}}" {{ $edit->poli_id == $poli_update->id ? 'selected' : '' }}>
                                            {{$poli_update->nama_poli}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Status </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="status_update" name="status_update">
                                        <option value="" selected disabled>--- pilih ---</option>
                                        <option value="aktif" {{ $edit->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="tidak aktif" {{ $edit->status == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
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
    </div>
    @endforeach

    <script>
        $(document).ready(function () {
            console.log("Script Started");

            const tarifDokterInput = document.getElementById("tarif_dokter");
            const tarifPerawatInput = document.getElementById("tarif_perawat");
            const totalTarifInput = document.getElementById("total_tarif");

            // Event listener untuk Select2 di dalam modal
            $('#kategori').on('select2:select', function (e) {
                const selectedValue = $(this).val().trim(); // Ambil nilai yang dipilih
                console.log("Kategori Dipilih:", selectedValue); // Debugging

                // Jika kategori adalah ADM atau KNS, set input tarif ke 0 dan readonly
                if (selectedValue === "ADM" || selectedValue === "KNS") {
                    console.log("Set Tarif Dokter & Perawat ke 0 dan ReadOnly");
                    tarifDokterInput.value = 0;
                    tarifPerawatInput.value = 0;
                    totalTarifInput.value = "";
                    tarifDokterInput.readOnly = true;
                    tarifPerawatInput.readOnly = true;
                    totalTarifInput.readOnly = false;
                    $('#error-tarif_dokter').fadeOut();
                    $('#error-tarif_perawat').fadeOut();
                    $('#error-total_tarif').fadeIn();
                } else {
                    console.log("Non-ADM/KNS, ReadOnly Total Tarif");
                    totalTarifInput.value = "";
                    tarifDokterInput.value = "";
                    tarifPerawatInput.value = "";
                    tarifDokterInput.readOnly = false;
                    tarifPerawatInput.readOnly = false;
                    totalTarifInput.readOnly = true;
                    $('#error-total_tarif').fadeOut();
                    $('#error-tarif_dokter').fadeIn();
                    $('#error-tarif_perawat').fadeIn();
                }
            });

        //Data Update
            $(document).on('shown.bs.modal', '[id^="editModal"]', function () {
                let modal = $(this); // Ambil modal yang sedang aktif
                let tarifDokterUpdateInput = modal.find("#tarif_dokter_update");
                let tarifPerawatUpdateInput = modal.find("#tarif_perawat_update");
                let totalTarifUpdateInput = modal.find("#total_tarif_update");
                let kategoriUpdateSelect = modal.find("#kategori_update");

                function applyCategoryLogic(selectedValue) {
                    console.log("Kategori Dipilih:", selectedValue); // Debugging

                    if (selectedValue === "ADM" || selectedValue === "KNS") {
                        console.log("Set Tarif Dokter & Perawat ke 0 dan ReadOnly");
                        tarifDokterUpdateInput.val(0).prop("readonly", true);
                        tarifPerawatUpdateInput.val(0).prop("readonly", true);
                        totalTarifUpdateInput.prop("readonly", false);
                        $('#error-tarif_dokter').fadeOut();
                        $('#error-tarif_perawat').fadeOut();
                        $('#error-total_tarif').fadeIn();
                    } else {
                        console.log("Non-ADM/KNS, ReadOnly Total Tarif");
                        tarifDokterUpdateInput.prop("readonly", false);
                        tarifPerawatUpdateInput.prop("readonly", false);
                        totalTarifUpdateInput.prop("readonly", true);
                        $('#error-total_tarif').fadeOut();
                        $('#error-tarif_dokter').fadeIn();
                        $('#error-tarif_perawat').fadeIn();
                    }
                }

                // Jalankan langsung saat modal dibuka
                let selectedValue = kategoriUpdateSelect.val().trim();
                applyCategoryLogic(selectedValue);

                // Tambahkan event listener untuk perubahan select
                kategoriUpdateSelect.on("select2:select", function (e) {
                    applyCategoryLogic($(this).val().trim());
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Ketika tombol "Generate" diklik
            $('#generateKodeButton').click(function() {
                // Panggil route Laravel menggunakan AJAX
                $.ajax({
                    url: '/api/generate-kode-perjal', // Route untuk generate kode
                    type: 'GET',
                    success: function(response) {
                        // Tampilkan kode yang dihasilkan di input field
                        $('#kode_perjal').val(response.kode_perjal);

                        $('#error-kode_perjal').fadeOut(); // Hilangkan error jika ada input
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText); // Handle error
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Fungsi untuk menghitung total tarif saat tarif dokter atau perawat berubah
            function hitungTotalTarif() {
                // Ambil nilai dari input tarif dokter dan perawat
                var tarifDokter = parseFloat($('#tarif_dokter').val()) || 0;
                var tarifPerawat = parseFloat($('#tarif_perawat').val()) || 0;

                // Hitung total tarif
                var totalTarif = tarifDokter + tarifPerawat;

                // Tampilkan hasil pada input total_tarif
                $('#total_tarif').val(totalTarif);
            }

            // Trigger fungsi hitungTotalTarif setiap kali input berubah
            $('#tarif_dokter, #tarif_perawat').on('input', function() {
                hitungTotalTarif();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Summernote
            $('#template').summernote()

            $("#janjitbl").DataTable({
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
    </script>

    <script>
        $(document).ready(function() {
            $('#nama_perjal').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-nama_perjal').fadeOut(); // Hilangkan error jika ada input
                }
            });
            $('#tarif_dokter').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-tarif_dokter').fadeOut(); // Hilangkan error jika ada input
                }
            });
            $('#tarif_perawat').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-tarif_perawat').fadeOut(); // Hilangkan error jika ada input
                }
            });
            $('#total_tarif').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-total_tarif').fadeOut(); // Hilangkan error jika ada input
                }
            });

            $('#status').on('change', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-status').fadeOut(); // Hilangkan error jika ada input
                }
            });
            $('#poli').on('change', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-poli').fadeOut(); // Hilangkan error jika ada input
                }
            });
            $('#penjab').on('change', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-penjab').fadeOut(); // Hilangkan error jika ada input
                }
            });
            $('#kategori').on('change', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-kategori').fadeOut(); // Hilangkan error jika ada input
                }
            });

            // Submit form dengan AJAX untuk menangani error tanpa reload
            $('#addFormpermesion').on('submit', function(e) {
                    e.preventDefault(); // Mencegah form submit normal

                    let form = $('#addFormpermesion');
                    let formData = form.serialize();

                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                title: 'Berhasil',
                                autohide: true,
                                delay: 10000,
                                body: 'Data berhasil ditambahkan!'
                            })
                            $('#addFormpermesion')[0].reset();
                            $('#status').val("").trigger('change.select2');
                            $('#poli').val("").trigger('change.select2');
                            $('#penjab').val("").trigger('change.select2');
                            $('#kategori').val("").trigger('change.select2');
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) { // Validasi gagal (Laravel)
                                let errors = xhr.responseJSON.errors;

                                if (errors.kode_perjal) {
                                    $('#error-kode_perjal').remove(); // Hapus error lama jika ada
                                    $('#kode_perjal').parent().append('<div id="error-kode_perjal" style="color: red;">' + errors.kode_perjal[0] + '</div>');
                                }
                                if (errors.nama_perjal) {
                                    $('#error-nama_perjal').remove(); // Hapus error lama jika ada
                                    $('#nama_perjal').after('<div id="error-nama_perjal" style="color: red;">' + errors.nama_perjal[0] + '</div>');
                                }
                                if (errors.tarif_dokter) {
                                    $('#error-tarif_dokter').remove(); // Hapus error lama jika ada
                                    $('#tarif_dokter').after('<div id="error-tarif_dokter" style="color: red;">' + errors.tarif_dokter[0] + '</div>');
                                }
                                if (errors.tarif_perawat) {
                                    $('#error-tarif_perawat').remove(); // Hapus error lama jika ada
                                    $('#tarif_perawat').after('<div id="error-tarif_perawat" style="color: red;">' + errors.tarif_perawat[0] + '</div>');
                                }
                                if (errors.total_tarif) {
                                    $('#error-total_tarif').remove(); // Hapus error lama jika ada
                                    $('#total_tarif').after('<div id="error-total_tarif" style="color: red;">' + errors.total_tarif[0] + '</div>');
                                }

                                if (errors.status) {
                                    $('#error-status').remove(); // Hapus error lama jika ada
                                    $('#status').parent().append('<div id="error-status" style="color: red;">' + errors.status[0] + '</div>');
                                }
                                if (errors.poli) {
                                    $('#error-poli').remove(); // Hapus error lama jika ada
                                    $('#poli').parent().append('<div id="error-poli" style="color: red;">' + errors.poli[0] + '</div>');
                                }
                                if (errors.penjab) {
                                    $('#error-penjab').remove(); // Hapus error lama jika ada
                                    $('#penjab').parent().append('<div id="error-penjab" style="color: red;">' + errors.penjab[0] + '</div>');
                                }
                                if (errors.kategori) {
                                    $('#error-kategori').remove(); // Hapus error lama jika ada
                                    $('#kategori').parent().append('<div id="error-kategori" style="color: red;">' + errors.kategori[0] + '</div>');
                                }

                                $('#adddoctor').modal('show'); // Pastikan modal tetap terbuka jika ada error
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi kesalahan!',
                                    text: 'Silakan coba lagi.',
                                });
                            }
                        }
                    });
                });

                // Tutup modal hanya jika tombol Batal ditekan
                $('#btnCloseModal').on('click', function() {
                    $('#adddoctor').modal('hide');
                    location.reload();
                });

            // Jika form dikirim dan masih ada error, buka kembali modal saat halaman reload
            @if ($errors->any())
                $(document).ready(function() {
                    $('#adddoctor').modal('show');
                });
            @endif
        });
    </script>

@endsection
