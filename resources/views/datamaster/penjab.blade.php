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
                                <h3 class="mb-0 card-title">Data Penanggung Jawab</h3>
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
                                  <th class="text-center">Kode </th>
                                  <th class="text-center">Nama </th>
                                  <th class="text-center">Perusahaan </th>
                                  <th class="text-center">Alamat </th>
                                  <th class="text-center">No Telepon </th>
                                  <th class="text-center">Attn </th>
                                  <th class="text-center">Status </th>
                                  <th>Pilihan</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->kode }}</td>
                                                <td>{{ $item->pj }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->alamat }}</td>
                                                <td>{{ $item->telp }}</td>
                                                <td>{{ $item->attn }}</td>
                                                <td>{{ $item->status }}</td>
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
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Penanggung Jawab</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addFormpermesion" action="{{ route('datmas.penjab.add') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Penanggung Jawab </label>
                                    <input type="text" class="form-control" id="nama_penjab" name="nama_penjab" value="{{ old('nama_penjab') }}">
                                </div>
                                @error('nama_penjab')
                                    <small>
                                        <div id="error-nama_penjab" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Kode </label>
                                    <input type="text" class="form-control" id="kode_penjab" name="kode_penjab" value="{{ old('kode_penjab') }}" readonly>
                                </div>
                                @error('kode_penjab')
                                    <small>
                                        <div id="error-kode_penjab" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nama Perusahaan </label>
                                    <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}">
                                </div>
                                @error('nama_perusahaan')
                                    <small>
                                        <div id="error-nama_perusahaan" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Alamat Asuransi </label>
                                    <input type="text" class="form-control" id="Alamat" name="Alamat" value="{{ old('Alamat') }}">
                                </div>
                                @error('Alamat')
                                    <small>
                                        <div id="error-Alamat" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>No. Telepon </label>
                                    <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon') }}">
                                </div>
                                @error('telepon')
                                    <small>
                                        <div id="error-telepon" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Attn </label>
                                    <input type="text" class="form-control" id="attn" name="attn" value="{{ old('attn') }}">
                                </div>
                                @error('attn')
                                    <small>
                                        <div id="error-attn" style="color: red;">{{ $message }}</div>
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
                    Apakah Anda yakin ingin menghapus Penanggung Jawab ini?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('datmas.penjab.delete', $delete->id) }}" method="POST">
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
                    <h5 class="modal-title" id="editModalLabel">Edit Penanggung Jawab</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('datmas.penjab.update', $edit->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Kode </label>
                                    <input type="text" class="form-control" id="kode_penjab_update" name="kode_penjab_update" value="{{ $edit->kode }}" required readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Penanggung Jawab </label>
                                    <input type="text" class="form-control" id="nama_penjab_update" name="nama_penjab_update" value="{{ $edit->pj }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nama Perusahaan </label>
                                    <input type="text" class="form-control" id="nama_perusahaan_update" name="nama_perusahaan_update" value="{{ $edit->nama }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Alamat Asuransi </label>
                                    <input type="text" class="form-control" id="Alamat_update" name="Alamat_update" value="{{ $edit->alamat }}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>No. Telepon </label>
                                    <input type="text" class="form-control" id="telepon_update" name="telepon_update" value="{{ $edit->telp }}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Attn </label>
                                    <input type="text" class="form-control" id="attn_update" name="attn_update" value="{{ $edit->attn }}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Status </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="status_update" name="status_update" required>
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
        $(document).ready(function() {
            $('#nama_penjab').on('input', function() {
                let nama = $(this).val().trim(); // Ambil nilai nama
                if (nama.length > 0) {
                    $.ajax({
                        url: '/api/get-next-kode-penjab',
                        type: 'GET',
                        data: { kode_pemeriksaan: 'P' }, // Prefix untuk kode
                        success: function(response) {
                            $('#kode_penjab').val(response.next_kode); // Set hasil ke input kode
                        },
                        error: function(xhr) {
                            console.error('Error mengambil kode pemeriksaan:', xhr);
                        }
                    });
                } else {
                    $('#kode_penjab').val(''); // Kosongkan kode jika nama kosong
                }
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
            $('#nama_penjab').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-nama_penjab').fadeOut(); // Hilangkan error jika ada input
                }
            });

            $('#kode_penjab').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-kode_penjab').fadeOut(); // Hilangkan error jika ada input
                }
            });

            $('#nama_perusahaan').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-nama_perusahaan').fadeOut(); // Hilangkan error jika ada input
                }
            });

            $('#Alamat').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-Alamat').fadeOut(); // Hilangkan error jika ada input
                }
            });

            $('#telepon').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-telepon').fadeOut(); // Hilangkan error jika ada input
                }
            });

            $('#attn').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-attn').fadeOut(); // Hilangkan error jika ada input
                }
            });

            $('#status').on('change', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-status').fadeOut(); // Hilangkan error jika ada input
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
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) { // Validasi gagal (Laravel)
                                let errors = xhr.responseJSON.errors;

                                if (errors.nama_penjab) {
                                    $('#error-nama_penjab').remove(); // Hapus error lama jika ada
                                    $('#nama_penjab').after('<div id="error-nama_penjab" style="color: red;">' + errors.nama_penjab[0] + '</div>');
                                }
                                if (errors.kode_penjab) {
                                    $('#error-kode_penjab').remove(); // Hapus error lama jika ada
                                    $('#kode_penjab').after('<div id="error-kode_penjab" style="color: red;">' + errors.kode_penjab[0] + '</div>');
                                }
                                if (errors.nama_perusahaan) {
                                    $('#error-nama_perusahaan').remove(); // Hapus error lama jika ada
                                    $('#nama_perusahaan').after('<div id="error-nama_perusahaan" style="color: red;">' + errors.nama_perusahaan[0] + '</div>');
                                }
                                if (errors.Alamat) {
                                    $('#error-Alamat').remove(); // Hapus error lama jika ada
                                    $('#Alamat').after('<div id="error-Alamat" style="color: red;">' + errors.Alamat[0] + '</div>');
                                }
                                if (errors.telepon) {
                                    $('#error-telepon').remove(); // Hapus error lama jika ada
                                    $('#telepon').after('<div id="error-telepon" style="color: red;">' + errors.telepon[0] + '</div>');
                                }
                                if (errors.attn) {
                                    $('#error-attn').remove(); // Hapus error lama jika ada
                                    $('#attn').after('<div id="error-attn" style="color: red;">' + errors.attn[0] + '</div>');
                                }

                                if (errors.status) {
                                    $('#error-status').remove(); // Hapus error lama jika ada
                                    $('#status').parent().append('<div id="error-status" style="color: red;">' + errors.status[0] + '</div>');
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
