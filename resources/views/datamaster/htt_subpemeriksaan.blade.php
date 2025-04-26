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
                                <h3 class="mb-0 card-title">Kelola Head To Toe Sub Pemeriksaan</h3>
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
                                    <th class="text-center">Pemeriksaan</th>
                                    <th class="text-center">Sub Pemeriksaan</th>
                                    <th style="width: 15%">Kode Sub Pemeriksaan</th>
                                    <th style="width: 15%">action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($htt_sub_pemeriksaan as $data)
                                            <tr>
                                                <td>{{ $data->nama_pemeriksaan }}</td>
                                                <td>{{ $data->nama_subpemeriksaan }}</td>
                                                <td>{{ $data->kode_subpemeriksaan }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#httsub{{ $data->id }}">
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('datmas.httsubpemeriksaan.delete',$data->id) }}" method="POST" >
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="httsub{{ $data->id }}" tabindex="-1" aria-labelledby="httsubabel{{ $data->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="httsubabel{{ $data->id }}">Edit Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('datmas.httsubpemeriksaan.edit', $data->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="form-group">
                                                                    <label>Kode Pemeriksaan</label>
                                                                    <input type="text" name="kode_pemeriksaan" class="form-control" value="{{ $data->kode_pemeriksaan }}" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Nama Pemeriksaan</label>
                                                                    <input type="text" name="nama_pemeriksaan" class="form-control" value="{{ $data->nama_pemeriksaan }}" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Kode Sub Pemeriksaan</label>
                                                                    <input type="text" name="kode_subpemeriksaan" class="form-control" value="{{ $data->kode_subpemeriksaan }}" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Nama Sub Pemeriksaan</label>
                                                                    <input type="text" name="nama_subpemeriksaan" class="form-control" value="{{ $data->nama_subpemeriksaan }}" required>
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
                    <h5 class="modal-title" id="addModalLabel">Kelola Head To Toe Sub Pemeriksaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addFormpermesion" action="{{ route('datmas.httsubpemeriksaan.add') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Nama Pemeriksaan </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="nama_pemeriksaan" name="nama_pemeriksaan">
                                        <option value="" disabled selected> -- Silahkan Pilih -- </option>
                                        @foreach ($htt_pemeriksaan as $data)
                                            <option value="{{ $data->nama_pemeriksaan }}" data-kode="{{ $data->kode_pemeriksaan }}">
                                                {{ $data->nama_pemeriksaan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kode Pemeriksaan </label>
                                    <input type="text" class="form-control" id="kode_pemeriksaan" name="kode_pemeriksaan" readonly>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Nama SubPemeriksaan </label>
                                    <input type="text" class="form-control" id="nama_subpemeriksaan" name="nama_subpemeriksaan">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kode SubPemeriksaan </label>
                                    <input type="text" class="form-control" id="kode_subpemeriksaan" name="kode_subpemeriksaan" readonly>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button> <!-- Submit button -->
                </div>
                </form>
            </div>
        </div>
    </div>

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
            $('#nama_pemeriksaan').on('change', function() {
                var kodePemeriksaan = $(this).find(':selected').data('kode');
                $('#kode_pemeriksaan').val(kodePemeriksaan);

                if (kodePemeriksaan) {
                    generateKodeSubPemeriksaan(kodePemeriksaan);
                }
            });

            function generateKodeSubPemeriksaan(kodePemeriksaan) {
                $.ajax({
                    url: '/api/get-next-kode-subpemeriksaan', // Sesuaikan dengan route yang benar
                    type: 'GET',
                    data: { kode_pemeriksaan: kodePemeriksaan },
                    success: function(response) {
                        if (response.next_kode) {
                            $('#kode_subpemeriksaan').val(response.next_kode);
                        } else {
                            // $('#kode_subpemeriksaan').val(kodePemeriksaan + '1');
                            $('#kode_subpemeriksaan').val('Blank');
                        }
                    },
                    error: function() {
                        console.log('Gagal mengambil data dari server');
                    }
                });
            }
        });
    </script>



@endsection
