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
                                <h3 class="mb-0 card-title">Kelola Head To Toe Pemeriksaan</h3>
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
                                    <th >Kode Pemeriksaan</th>
                                    <th class="text-center">Pemeriksaan</th>
                                    <th class="text-center" style="">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_pemeriksaan as $data)
                                            <tr>
                                                <td class="text-center">{{ $data->kode_pemeriksaan }}</td>
                                                <td class="text-center">{{ $data->nama_pemeriksaan }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#htt{{ $data->id }}">
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('datmas.httpemeriksaan.delete',$data->id) }}" method="POST" >
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="htt{{ $data->id }}" tabindex="-1" aria-labelledby="httLabel{{ $data->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="httLabel{{ $data->id }}">Edit Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('datmas.httpemeriksaan.edit', $data->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="mb-3">
                                                                    <label for="nama" class="form-label">Nama</label>
                                                                    <input type="text" name="nama" class="form-control" value="{{ $data->nama_pemeriksaan }}" required>
                                                                </div>


                                                                <div class="mb-3">
                                                                    <label for="kode" class="form-label">Kode</label>
                                                                    <input type="text" name="kode" class="form-control" value="{{ $data->kode_pemeriksaan }}" required>
                                                                </div>


                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                    <h5 class="modal-title" id="addModalLabel">Kelola Head To Toe Pemeriksaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addFormpermesion"  action="{{ route('datmas.httpemeriksaan.add') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Nama Pemeriksaan </label>
                                    <input type="text" class="form-control" id="nama" name="nama">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kode Pemeriksaan </label>
                                    <input type="text" class="form-control" id="kode" name="kode" readonly>
                                </div>
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
            $('#nama').on('input', function() {
                let nama = $(this).val().trim(); // Ambil nilai nama
                if (nama.length > 0) {
                    $.ajax({
                        url: '/api/get-next-kode-pemeriksaan',
                        type: 'GET',
                        data: { kode_pemeriksaan: 'H' }, // Prefix untuk kode
                        success: function(response) {
                            $('#kode').val(response.next_kode); // Set hasil ke input kode
                        },
                        error: function(xhr) {
                            console.error('Error mengambil kode pemeriksaan:', xhr);
                        }
                    });
                } else {
                    $('#kode').val(''); // Kosongkan kode jika nama kosong
                }
            });
                $('#addFormpermesion').on('submit', function(e) {
                e.preventDefault(); // Mencegah reload halaman

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $(document).Toasts('create', {
                            class: 'bg-success',
                            title: 'Berhasil',
                            autohide: true,
                            delay: 10000,
                            body: 'Data berhasil ditambahkan!'
                        })
                        $('#addFormpermesion')[0].reset(); // Reset form tanpa menutup modal
                    },
                    error: function(xhr) {
                        alert('Gagal menambahkan data. Coba lagi!');
                    }
                });
            });

            // Tutup modal hanya jika tombol Batal ditekan
            $('#btnCloseModal').on('click', function() {
                $('#modalID').modal('hide'); // Ganti dengan ID modal yang benar
                location.reload();
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
