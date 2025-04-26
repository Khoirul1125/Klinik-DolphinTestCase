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
                                <h3 class="card-title mb-0">DAFTAR HARGA JUAL OBAT / ALKES </h3>
                                <div class="text-right card-tools">
                                    <button type="button" class="btn btn-primary" id="syncButton">
                                        <i class="fas fa-sync"></i> Sync
                                    </button>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="tbl-harga" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama (Satuan)</th>
                                            <th>Harga Dasar</th>
                                            <th>HJ. Net I (UGD/IGD)</th>
                                            <th>HJ. Net II(RAJAL)</th>
                                            <th>HJ. Net III(RANAP)</th>
                                            <th>HJ. Net IV(ASURANSI)</th>
                                            <th>HJ. Net V(UMUM)</th>
                                            <th>Faktur Diskon</th>
                                            <th>Faktur PPN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($harga as $data)
                                            <tr>
                                                <td>{{ $data->kode_barang }}</td>
                                                <td>{{ $data->nama_barang }}</td>
                                                <td>{{ $data->harga_dasar }}</td>
                                                <td>{{ $data->harga_1 }}</td>
                                                <td>{{ $data->harga_2 }}</td>
                                                <td>{{ $data->harga_3 }}</td>
                                                <td>{{ $data->harga_4 }}</td>
                                                <td>{{ $data->harga_5 }}</td>
                                                <td>{{ $data->disc }}</td>
                                                <td>{{ $data->ppn }}</td>
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
            $("#tbl-harga").DataTable({
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
            // Ketika tombol Sync ditekan, lakukan refresh halaman
            $('#syncButton').on('click', function() {
                location.reload(); // Refresh halaman
            });
        });
    </script>

@endsection
