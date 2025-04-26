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
                                <h3 class="mb-0 card-title">Kelola Data Kode Satuan</h3>
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
                                  <th class="text-center">Kode Satuan</th>
                                  <th class="text-center">Nama Satuan</th>
                                  <th class="text-center">Pilihan</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->kode_satuan }}</td>
                                                <td>{{ $item->nama_satuan }}</td>
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
                    <h5 class="modal-title" id="addModalLabel">Kelola Data Kode Satuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addFormpermesion" action="{{ route('datmas.satuan.add') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Kode Satuan</label>
                                    <input type="text" class="form-control" id="kode_satuan" name="kode_satuan" value="{{ old('kode_satuan') }}" readonly>
                                </div>
                            </div>
                            @error('kode_satuan')
                                <small>
                                    <div id="error-kode_satuan" style="color: red;">{{ $message }}</div>
                                </small>
                            @enderror
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Nama Satuan</label>
                                    <input type="text" class="form-control" id="nama_satuan" name="nama_satuan" value="{{ old('nama_satuan') }}">
                                </div>
                            </div>
                            @error('nama_satuan')
                                <small>
                                    <div id="error-nama_satuan" style="color: red;">{{ $message }}</div>
                                </small>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseModal">Batal</button>
                    <button type="submit" id="submitForm" class="btn btn-primary">Tambah</button> <!-- Submit button -->
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
                    Apakah Anda yakin ingin menghapus Satuan ini?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('datmas.satuan.delete', $delete->id) }}" method="POST">
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
                    <h5 class="modal-title" id="editModalLabel">Edit Satuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('datmas.satuan.update', $edit->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Kode Satuan</label>
                                    <input type="text" class="form-control" name="kode_satuan" value="{{ $edit->kode_satuan }}" required readonly>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Nama Satuan</label>
                                    <input type="text" class="form-control" name="nama_satuan" value="{{ $edit->nama_satuan }}" required>
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
        $('#nama_satuan').on('input', function() {
            let nama = $(this).val().trim(); // Ambil nilai nama
            if (nama.length > 0) {
                $.ajax({
                    url: '/api/get-next-kode-satuan',
                    type: 'GET',
                    data: { kode_pemeriksaan: 'ST' }, // Prefix untuk kode
                    success: function(response) {
                        $('#kode_satuan').val(response.next_kode); // Set hasil ke input kode

                        // Setelah kode_industri terisi otomatis, hilangkan error
                        if ($('#kode_satuan').val().trim().length > 0) {
                            $('#error-kode_satuan').fadeOut(); // Sembunyikan error
                        }
                    },
                    error: function(xhr) {
                        console.error('Error mengambil kode pemeriksaan:', xhr);
                    }
                });
            } else {
                $('#kode_satuan').val(''); // Kosongkan kode jika nama kosong
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#nama_satuan').on('input', function() {
            if ($(this).val().trim().length > 0) {
                $('#error-nama_satuan').fadeOut(); // Hilangkan error jika ada input
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
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) { // Validasi gagal (Laravel)
                            let errors = xhr.responseJSON.errors;

                            if (errors.kode_satuan) {
                                $('#error-kode_satuan').remove(); // Hapus error lama jika ada
                                $('#kode_satuan').after('<div id="error-kode_satuan" style="color: red;">' + errors.kode_satuan[0] + '</div>');
                            }

                            if (errors.nama_satuan) {
                                $('#error-nama_satuan').remove(); // Hapus error lama jika ada
                                $('#nama_satuan').after('<div id="error-nama_satuan" style="color: red;">' + errors.nama_satuan[0] + '</div>');
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
