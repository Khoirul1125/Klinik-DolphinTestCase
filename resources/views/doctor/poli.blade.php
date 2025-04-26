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
                                <h3 class="mb-0 card-title">Data Master Poli</h3>
                                <div class="text-right card-tools d-flex justify-content-end">
                                    <form id="uploadDataPoliForm" action="{{ route('doctor.poli.update') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                    <button type="button" class="mr-2 btn btn-primary" onclick="document.getElementById('uploadDataPoliForm').submit();">
                                        <i class="fas fa-plus"></i> Update Data Poli
                                    </button>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="sekstbl" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Poli</th>
                                            <th>Kode Poli</th>
                                            <th>Jenis Poli</th>
                                            <th>Status</th>
                                            <!-- <th width="20%">Pilihan</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $data)
                                            <tr>
                                                <td>{{ $data->nama_poli }}</td>
                                                <td>{{ $data->kode_poli }}</td>
                                                <td>{{ $data->jenis_poli }}</td>
                                                <td>{{ $data->status }}</td>
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

    <script>
        $(document).ready(function() {
            $("#sekstbl").DataTable({
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
