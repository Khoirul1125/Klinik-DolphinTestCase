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
                            <h4>Jadwal Dokter: {{ $doctor->user->name }} (Hari: {{ $schedule->hari }})</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Total Kuota</th>
                                    <td>{{ $schedule->total_quota }}</td>
                                </tr>
                                <tr>
                                    <th>Kuota yang Tersisa</th>
                                    <td>{{ $remainingQuota }}</td>
                                </tr>
                                <tr>
                                    <th>Kuota yang Terpakai</th>
                                    <td>{{ $schedule->total_quota - $remainingQuota }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.card-header -->
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
    <div class="modal fade" id="adddoctor" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addFormpermesion" action="{{ route('dokter.jadwal.add', ['id' => $doctor->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="row">
                                <!-- Kolom Hari -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="hari">Hari</label>
                                        <select class="form-control" id="hari" name="hari" required>
                                            <option value="1">Senin</option>
                                            <option value="2">Selasa</option>
                                            <option value="3">Rabu</option>
                                            <option value="4">Kamis</option>
                                            <option value="5">Jumat</option>
                                            <option value="6">Sabtu</option>
                                            <option value="7">Minggu</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kolom Jam Mulai -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="start">Jam Mulai</label>
                                        <input type="time" class="form-control" id="start" name="start" required onchange="hitungQuota()">
                                    </div>
                                </div>

                                <!-- Kolom Jam Akhir -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="end">Jam Akhir</label>
                                        <input type="time" class="form-control" id="end" name="end" required onchange="hitungQuota()">
                                    </div>
                                </div>
                            </div>

                            <!-- Baris baru untuk Quota dan Quota Total -->
                            <div class="row">
                                <!-- Kolom Quota -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="quota">Quota</label>
                                        <input type="number" class="form-control" id="quota" name="quota" required min="1" onchange="hitungQuota()">
                                    </div>
                                </div>

                                <!-- Kolom Quota Total -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_quota">Quota Total</label>
                                        <input type="text" class="form-control" id="total_quota" name="total_quota">
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="userinput" name="userinput" value="{{ auth()->user()->name }}">
                            <input type="hidden" id="userinputid" name="userinputid" value="{{ auth()->user()->id }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button> <!-- Submit button -->
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function hitungQuota() {
            // Ambil nilai jam mulai, jam akhir, dan quota
            var jamMulai = document.getElementById('start').value;
            var jamAkhir = document.getElementById('end').value;
            var quota = parseFloat(document.getElementById('quota').value);

            // Pastikan semua input valid
            if (jamMulai && jamAkhir && quota) {
                // Hitung selisih jam mulai dan jam akhir
                var mulai = new Date('1970-01-01T' + jamMulai + 'Z');
                var akhir = new Date('1970-01-01T' + jamAkhir + 'Z');
                var diffJam = (akhir - mulai) / (1000 * 60 * 60); // konversi ms ke jam

                // Periksa jika jam mulai lebih besar dari jam akhir (misalnya, melewati tengah malam)
                if (diffJam < 0) {
                    diffJam += 24; // jika jam akhir lebih kecil dari jam mulai, tambahkan 24 jam
                }

                // Hitung quota total
                var quotaTotal = diffJam * quota;

                // Set nilai quota total di form
                document.getElementById('total_quota').value = Math.round(quotaTotal)   ; // Menampilkan dengan 2 desimal
            }
        }
    </script>


@endsection
