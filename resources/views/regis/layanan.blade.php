@extends('template.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <form action="{{ route('layanan.rawat-jalan.soap-dokter.index.tindakan.add') }}" method="POST" class="row w-100">
                    @csrf
                    <div class="mt-3 col-12">
                        <div class="row">
                            <!-- Identitas Pasien -->
                            <div class="col-md-6 align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-header bg-light">
                                        <h5><i class="fa fa-file-alt"></i> Tindakan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="no_rm">No. RM</label>
                                                <input type="text" class="form-control" id="no_rm" name="no_rm" value="{{$rajaldata->no_rm}}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="nama_pasien">Nama Pasien</label>
                                                <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="{{$rajaldata->nama_pasien}}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="tgl_kunjungan">Tanggal</label>
                                                <input type="date" class="form-control" id="tgl_kunjungan" name="tgl_kunjungan">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="time">Jam</label>
                                                <input type="time" class="form-control" id="time" name="time">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="no_rawat">Id Rawat</label>
                                                <input type="text" class="form-control" id="no_rawat" name="no_rawat" value="{{$rajaldata->no_rawat}}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="tindakan">Tindakan</label>
                                                <select class="form-control select2bs4" style="width: 100%;" id="tindakan" name="tindakan">
                                                    <option value="-" disabled selected>-- Pilih --</option>
                                                    @foreach ($perjal as $perjal)
                                                        <option value="{{ $perjal->nama }}" data-nama="{{ $perjal->nama }}" data-tarifdok="{{ $perjal->tarifdok }}" data-tarifper="{{ $perjal->tarifper }}">
                                                            {{ $perjal->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pemeriksaan -->
                            <div class="col-md-6 align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-header bg-light">
                                        <h5><i class="fa fa-file-alt"></i> Data Tindakan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-9">
                                                <label for="jenis_tindakan">Jenis</label>
                                                <input type="text" class="form-control" id="jenis_tindakan" name="jenis_tindakan" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="t_biaya">Total Biaya</label>
                                                <input type="text" class="form-control" id="t_biaya" name="t_biaya" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="provider-row" style="display: none;">
                                            <div class="col-md-12">
                                                <label for="provider">Jenis Provider</label>
                                                <select class="form-control select2bs4" style="width: 100%;" id="provider" name="provider">
                                                    <option value="" disabled selected>-- Pilih --</option>
                                                    <option value="Dokter">Dokter</option>
                                                    <option value="Perawat">Perawat</option>
                                                    <option value="Dokter & Perawat">Dokter & Perawat</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="dokter-row" style="display: none;">
                                            <div class="col-md-9">
                                                <label for="dokter">Dokter</label>
                                                <select class="form-control select2bs4" style="width: 100%;" id="dokter" name="dokter">
                                                    <option value="" disabled selected>-- Pilih --</option>
                                                    @foreach ($doctor as $data)
                                                    <option value="{{ $data->id }}">{{ $data->nama_dokter }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="b_dokter">Biaya Dokter</label>
                                                <input type="text" class="form-control" id="b_dokter" name="b_dokter" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="perawat-row" style="display: none;">
                                            <div class="col-md-9">
                                                <label for="perawat">Perawat</label>
                                                <select class="form-control select2bs4" style="width: 100%;" id="perawat" name="perawat">
                                                    <option value="" disabled selected>-- Pilih --</option>
                                                    @foreach ($perawat as $data)
                                                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="b_perawat">Biaya Perawat</label>
                                                <input type="text" class="form-control" id="b_perawat" name="b_perawat" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-floppy-disk"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 card-title">Rincian Tindakan</h3>
                        </div>
                        <div class="card-body" id="kunjungan-section">
                            <table id="kunjungan-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Tindakan</th>
                                        <th>Provider</th>
                                        <th>Dokter</th>
                                        <th>Perawat</th>
                                        <th>Total Biaya</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($layanan as $index => $data_tindakan)
                                    <tr>
                                        <td rowspan="2" style="vertical-align:top; text-align: center;">{{ $index + 1 }}</td>
                                        <td>{{ $data_tindakan->tgl_kunjungan }}<br>{{ $data_tindakan->time }}</td>
                                        <td>{{ $data_tindakan->jenis_tindakan }}</td>
                                        <td>{{ $data_tindakan->provider }}</td>
                                        <td>
                                            @if ($data_tindakan->doctor)
                                                {{ $data_tindakan->doctor->nama }} <br><br>
                                                <b>Tarif Dokter:</b> {{ $data_tindakan->b_dokter }}
                                            @else
                                                Dokter tidak tersedia
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data_tindakan->perawat)
                                                {{ $data_tindakan->perawat->nama }} <br><br>
                                                <b>Tarif perawat:</b> {{ $data_tindakan->b_perawat }}
                                            @else
                                                Perawat tidak tersedia
                                            @endif
                                        </td>
                                        <td></td>
                                        <td rowspan="2" style="text-align: center; vertical-align: middle;">
                                            <form action="{{ route('layanan.rawat-jalan.soap-dokter.index.tindakan.delete', $data_tindakan->no_rm) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                      <td colspan="5"><b>Total Biaya Tindakan</b></td>
                                      <td>Rp. <span class="pull-right">{{ $data_tindakan->total_biaya }},00</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
    <!-- /.content-wrapper -->

{{-- Script untuk umur dan tgl jam --}}
    <script>
        window.onload = function() {
            // Mengambil tanggal dan waktu saat ini
            var now = new Date();

            // Mengatur nilai input tanggal (YYYY-MM-DD)
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear() + "-" + month + "-" + day;
            document.getElementById("tgl_kunjungan").value = today;

            // Mengatur nilai input waktu (HH:MM)
            var hours = ("0" + now.getHours()).slice(-2);
            var minutes = ("0" + now.getMinutes()).slice(-2);
            var currentTime = hours + ":" + minutes;
            document.getElementById("time").value = currentTime;
        };
    </script>

    <script>
        $(document).ready(function() {
            $('#t_biaya').val('Pilih Provider');

            // Ketika ada perubahan pada pilihan di select #perjal
            $('#tindakan').change(function() {
                var selectedOption = $('#tindakan option:selected'); // Ambil elemen option yang dipilih
                var tarifDokter = parseFloat(selectedOption.data('tarifdok')) || 0; // Pastikan nilai ada, default ke 0
                var tarifPerawat = parseFloat(selectedOption.data('tarifper')) || 0; // Pastikan nilai ada, default ke 0
                var namaTindakan = selectedOption.data('nama'); // Pastikan nilai ada, default ke 0

                $('#b_dokter').val(tarifDokter); // Set nilai b dokter
                $('#b_perawat').val(tarifPerawat); // Set nilai b perawat
                $('#jenis_tindakan').val(namaTindakan);
                $('#provider-row').show();
            });

            $('#provider').change(function() {
                var providerValue = $(this).val();
                var tarifDokter = parseFloat($('#b_dokter').val()) || 0; // Ambil nilai dari input biaya dokter
                var tarifPerawat = parseFloat($('#b_perawat').val()) || 0; // Ambil nilai dari input biaya perawat

                // Tampilkan baris sesuai provider yang dipilih
                if (providerValue === 'Dokter') {
                    $('#dokter-row').show();
                    $('#perawat-row').hide();
                    $('#t_biaya').val(tarifDokter); // Total biaya hanya untuk dokter
                } else if (providerValue === 'Perawat') {
                    $('#perawat-row').show();
                    $('#dokter-row').hide();
                    $('#t_biaya').val(tarifPerawat); // Total biaya hanya untuk perawat
                } else if (providerValue === 'Dokter & Perawat') {
                    $('#dokter-row').show();
                    $('#perawat-row').show();
                    $('#t_biaya').val(tarifDokter + tarifPerawat); // Total biaya untuk dokter dan perawat
                } else {
                    $('#dokter-row').hide();
                    $('#perawat-row').hide();
                    $('#t_biaya').val('Pilih Provider'); // Set placeholder jika tidak ada pilihan
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#kunjungan-table").DataTable({
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
