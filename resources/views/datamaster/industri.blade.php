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
                                <h3 class="mb-0 card-title">Kelola Data Supplier</h3>
                                <div class="text-right card-tools">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modalAddPemeriksaan">
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
                                  <th class="text-center">Alamat </th>
                                  <th class="text-center">PIC </th>
                                  <th class="text-center">No. Telepon </th>
                                  <th class="text-center">Pilihan</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $data)
                                            <tr>
                                                <td>{{ $data->kode_industri }}</td>
                                                <td>{{ $data->nama_industri }}</td>
                                                <td>{{ $data->Alamat }}</td>
                                                <td>{{ $data->PIC }}</td>
                                                <td>{{ $data->telepon }}</td>
                                                <td></td>
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

    <div class="modal fade" id="modalAddPemeriksaan" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Kelola Data Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addFormpermesion" action="{{ route('datmas.industri.add') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nama </label>
                                    <input type="text" class="form-control" id="nama_industri" name="nama_industri" value="{{ old('nama_industri') }}" >
                                </div>
                                @error('nama_industri')
                                <small>
                                    <div id="error-nama_industri" style="color: red;">{{ $message }}</div>
                                </small>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Kode</label>
                                    <input type="text" class="form-control" id="kode_industri" name="kode_industri" value="{{ old('kode_industri') }}"  readonly>
                                </div>
                                @error('kode_industri')
                                <small>
                                    <div id="error-kode_industri" style="color: red;">{{ $message }}</div>
                                </small>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Alamat </label>
                                    <input type="text" class="form-control" id="Alamat" name="Alamat" value="{{ old('Alamat') }}" >
                                </div>
                                @error('Alamat')
                                <small>
                                    <div id="error-Alamat" style="color: red;">{{ $message }}</div>
                                </small>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Telepon </label>
                                    <input type="text" class="form-control" id="telepon" name="telepon"value="{{ old('telepon') }}"  >
                                </div>
                                @error('telepon')
                                <small>
                                    <div id="error-telepon" style="color: red;">{{ $message }}</div>
                                </small>
                                @enderror
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>PIC</label>
                                    <input type="text" class="form-control" id="PIC" name="PIC" value="{{ old('PIC') }}">
                                </div>
                                @error('PIC')
                                <small>
                                    <div id="error-pic" style="color: red;">{{ $message }}</div>
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

    <script>
        $(document).ready(function() {
            // Hilangkan error saat mulai mengetik
            $('#PIC').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-pic').fadeOut(); // Hilangkan error jika ada input
                }
            });
            $('#telepon').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-telepon').fadeOut(); // Hilangkan error jika ada input
                }
            });
            $('#Alamat').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-Alamat').fadeOut(); // Hilangkan error jika ada input
                }
            });
            $('#kode_industri').on('change input', function() {
                // Jika kode_industri terisi (tidak kosong)
                if ($(this).val().trim().length > 0) {
                    $('#error-kode_industri').fadeOut(); // Sembunyikan error
                }
            });
            $('#nama_industri').on('input', function() {
                if ($(this).val().trim().length > 0) {
                    $('#error-nama_industri').fadeOut(); // Hilangkan error jika ada input
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

                            if (errors.PIC) {
                                $('#error-pic').remove(); // Hapus error lama jika ada
                                $('#PIC').after('<div id="error-pic" style="color: red;">' + errors.PIC[0] + '</div>');
                            }

                            if (errors.telepon) {
                                $('#error-telepon').remove(); // Hapus error lama jika ada
                                $('#telepon').after('<div id="error-telepon" style="color: red;">' + errors.telepon[0] + '</div>');
                            }

                            if (errors.Alamat) {
                                $('#error-Alamat').remove(); // Hapus error lama jika ada
                                $('#Alamat').after('<div id="error-Alamat" style="color: red;">' + errors.Alamat[0] + '</div>');
                            }

                            if (errors.kode_industri) {
                                $('#error-kode_industri').remove(); // Hapus error lama jika ada
                                $('#kode_industri').after('<div id="error-kode_industri" style="color: red;">' + errors.kode_industri[0] + '</div>');
                            }

                            if (errors.nama_industri) {
                                $('#error-nama_industri').remove(); // Hapus error lama jika ada
                                $('#nama_industri').after('<div id="error-nama_industri" style="color: red;">' + errors.nama_industri[0] + '</div>');
                            }

                            $('#modalAddPemeriksaan').modal('show'); // Pastikan modal tetap terbuka jika ada error
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
                $('#modalAddPemeriksaan').modal('hide');
                location.reload();
            });

            // Jika form dikirim dan masih ada error, buka kembali modal saat halaman reload
            @if ($errors->any())
                $(document).ready(function() {
                    $('#modalAddPemeriksaan').modal('show');
                });
            @endif
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#nama_industri').on('input', function() {
                let nama = $(this).val().trim(); // Ambil nilai nama
                if (nama.length > 0) {
                    $.ajax({
                        url: '/api/get-next-kode-industri',
                        type: 'GET',
                        data: { kode_pemeriksaan: 'S' }, // Prefix untuk kode
                        success: function(response) {
                            $('#kode_industri').val(response.next_kode); // Set hasil ke input kode

                            // Setelah kode_industri terisi otomatis, hilangkan error
                            if ($('#kode_industri').val().trim().length > 0) {
                                $('#error-kode_industri').fadeOut(); // Sembunyikan error
                            }
                        },
                        error: function(xhr) {
                            console.error('Error mengambil kode pemeriksaan:', xhr);
                        }
                    });
                } else {
                    $('#kode_industri').val(''); // Kosongkan kode jika nama kosong
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


@endsection
