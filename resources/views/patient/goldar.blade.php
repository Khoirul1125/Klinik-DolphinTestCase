@extends('template.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row ">
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title mb-0">Golongan Darah</h3>
                                <div class="card-tools text-right">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#adddoctor">
                                        <i class="fas fa-plus"></i> Tambah Baru
                                    </button>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="goldartbl" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Golongan Darah</th>
                                            <th>Rhesus Golongan Darah</th>
                                            <th width="20%">Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($goldar as $item)
                                            <tr>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->resus }}</td>
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
                        <!-- /.card -->
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
                    <h5 class="modal-title" id="addModalLabel">Tambah Golongan Darah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addFormpermesion" action="{{ route('patient.goldar.add') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nama Golongan Darah</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
                                </div>
                                @error('nama')
                                    <small>
                                        <div id="error-nama" style="color: red;">{{ $message }}</div>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Resus Darah</label>
                                    <select class="form-control select2bs4" id="resus" name="resus">
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="+" {{ old('resus') == '+' ? 'selected' : '' }}>Positif ( + )</option>
                                        <option value="-" {{ old('resus') == '-' ? 'selected' : '' }}>Negatif ( - )</option>
                                    </select>
                                </div>
                                @error('resus')
                                    <small>
                                        <div id="error-resus" style="color: red;">{{ $message }}</div>
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
    @foreach ($goldar as $delete)
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
                    Apakah Anda yakin ingin menghapus Golongan Darah ini?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('datmas.goldar.delete', $delete->id) }}" method="POST">
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
    @foreach ($goldar as $edit)
    <div class="modal fade" id="editModal{{ $edit->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Golongan Darah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('datmas.goldar.update', $edit->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nama Golongan Darah</label>
                                    <input type="text" class="form-control" name="nama_update" value="{{ $edit->nama }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Resus Golongan Darah</label>
                                    <select class="form-control select2bs4" id="resus_update" name="resus_update" required>
                                        <option value="+" {{ $edit->resus == '+' ? 'selected' : '' }}>Positif ( + )</option>
                                        <option value="-" {{ $edit->resus == '-' ? 'selected' : '' }}>Negatif ( - )</option>
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
            $("#goldartbl").DataTable({
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
            $('#nama').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-nama').fadeOut(); // Hilangkan error jika ada input
                }
            });

            $('#resus').on('change', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-resus').fadeOut(); // Hilangkan error jika ada input
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
                            $('#resus').val("").trigger('change.select2');
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) { // Validasi gagal (Laravel)
                                let errors = xhr.responseJSON.errors;

                                if (errors.nama) {
                                    $('#error-nama').remove(); // Hapus error lama jika ada
                                    $('#nama').after('<div id="error-nama" style="color: red;">' + errors.nama[0] + '</div>');
                                }

                                if (errors.resus) {
                                    $('#error-resus').remove(); // Hapus error lama jika ada
                                    $('#resus').parent().append('<div id="error-resus" style="color: red;">' + errors.resus[0] + '</div>');
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
