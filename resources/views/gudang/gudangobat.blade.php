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
                                <h3 class="mb-0 card-title">Kelola Data Gudang</h3>
                                <div class="text-right card-tools">
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                              <table id="gudangTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Kode Barang</th>
                                    <th class="text-center">quantity</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                {{-- @php
                                    dd($data);
                                @endphp --}}
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
</div>


<script>
    function loadGudangData() {
        $.ajax({
            url: '/api/gudang/getgudangobat', // URL yang digunakan untuk mengambil data
            method: 'GET',
            success: function(data) {
                let tbody = $('#gudangTable tbody');
                tbody.empty();  // Kosongkan tabel sebelum mengisi ulang
                data.forEach(function(item) {
                    tbody.append(`
                        <tr>
                            <td class="text-center">${item.nama_barang}</td>
                            <td class="text-center">${item.kode_barang}</td>
                            <td class="text-center">${item.total_qty}</td>
                        </tr>
                    `);
                });
            },
            error: function(error) {
                console.log("Error fetching data:", error);
            }
        });
    }

    // Panggil loadGudangData setiap 5 detik untuk memperbarui data secara real-time
    setInterval(loadGudangData, 5000);  // Setiap 5 detik
    loadGudangData();  // Panggil pertama kali saat halaman dimuat
</script>
@endsection
