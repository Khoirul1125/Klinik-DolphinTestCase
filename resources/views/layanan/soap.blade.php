@extends('template.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mt-2">
                    <div class="col-md-12 d-flex justify-content-center align-items-center">
                        <h1 class="m-0">SOAP (Perawat)</h1>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <form action="{{ route('layanan.rawat-jalan.soap-perawat.index.add') }}" method="POST" class="row w-100" onsubmit="return validateInputs();">
                    @csrf
                    <div class="mt-3 col-12">
                        <div class="row">
                            <!-- Identitas Pasien -->
                            <div class="col-md-3 align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-header bg-light">
                                        <h5><i class="fa fa-user"></i> Data Pasien</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle"
                                                 src="{{ asset('uploads/patient_photos/' . $profile->user->profile) }}"
                                                 alt="User profile picture">
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="tgl_kunjungan">Tanggal</label>
                                                <input type="date" class="form-control" id="tgl_kunjungan" name="tgl_kunjungan">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
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
                                                <label for="no_rm">No. RM</label>
                                                <input type="text" class="form-control" id="no_rm" name="no_rm" value="{{$rajaldata->no_rm}}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="nama_pasien">Nama Pasien</label>
                                                <input type="text" class="form-control" id="nama_pasien" value="{{$rajaldata->nama_pasien}}" name="nama_pasien" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="seks">Jenis Kelamin</label>
                                                <input type="text" class="form-control" id="seks" value="{{$rajaldata->seks}}" name="seks" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="penjab">Penjamin</label>
                                                <input type="text" class="form-control" id="penjab" value="{{$rajaldata->penjab->pj}}" name="penjab" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="tgl_lahir">Tanggal Lahir</label>
                                                <input type="text" class="form-control" value="{{$rajaldata->tgl_lahir}}" id="tgl_lahir" name="tgl_lahir" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="umur">Umur</label>
                                                <input type="text" class="form-control" value="{{ $umur }}" id="umur" name="umur" readonly>
                                                <input type="hidden" class="form-control" value="{{ $umurHidden }}" id="umurHidden" name="umurHidden" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="card w-100">
                                    <div class="card-header bg-light">
                                        <h5><i class="fa fa-user"></i> Pemeriksaan Lanjutan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="penyakit_dulu">Rwy. Penyakit Dahulu</label>
                                                <textarea class="form-control" id="penyakit_dulu" name="penyakit_dulu" readonly></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="penyakit_keluarga">Rwy. Penyakit Keluarga</label>
                                                <div class="form-control" id="penyakit_keluarga" name="penyakit_keluarga" readonly style="height: 80px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 #ddd;">
                                                    @foreach ($rwy_keluarga as $data)
                                                        <p style="margin: 0; padding: 0;">{{ $data->keluarga }} - {{ $data->penyakit_keluarga }}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-1">
                                                <select class="form-control select2bs4" style="width: 100%;" id="keluarga" name="keluarga">
                                                    <option value="Ayah">Ayah</option>
                                                    <option value="Ibu">Ibu</option>
                                                    <option value="Kakek">Kakek</option>
                                                    <option value="Nenek">Nenek</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-center" style="padding: 10px;">
                                                <label for="sakit_keluarga">Penyakit:</label>
                                            </div>
                                            <div class="col-md-9 d-flex align-items-center" style="padding: 8px;">
                                                <input type="text" class="form-control" id="sakit_keluarga" name="sakit_keluarga">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="riwayat_obat">Rwy. Obat</label>
                                                <textarea class="form-control" id="riwayat_obat" name="riwayat_obat" readonly></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="riwayat_penunjang">Rwy. Penunjang (Jika Ada)</label>
                                                <textarea class="form-control" id="riwayat_penunjang" name="riwayat_penunjang"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <!-- Pemeriksaan -->
                            <div class="col-md-9 align-items-stretch">
                                {{-- Subyektif --}}
                                <div class="card w-100">
                                    <div class="card-header bg-light">
                                        <h5><i class="fa fa-stethoscope"></i> Subyektif</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Keluhan :</label>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" id="penyakit" name="penyakit" placeholde="Masukan Keluhan">
                                                </div>
                                                <div class="col-md-5 d-flex align-items-center">
                                                    <label class="mr-3 mb-0">Sejak</label>
                                                    <input type="number" class="form-control mr-2" id="durasi" name="durasi" placeholder="Masukkan durasi">
                                                    <select class="form-control select2bs4" id="waktu" name="waktu">
                                                        <option value="" disabled selected>-- Pilih Hari --</option>
                                                        <option value="Hari">Hari</option>
                                                        <option value="Minggu">Minggu</option>
                                                        <option value="Bulan">Bulan</option>
                                                        <option value="Tahun">Tahun</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 d-flex justify-content-end">
                                                    <button type="button" class="btn btn-primary" onclick="addData()">Tambahkan</button>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="tableData" name="tableData" value="[]">

                                       <!-- Tabel -->
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered" id="SubTabel">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 5%; text-align: center;">No</th>
                                                            <th style="width: 80%">Subyektif</th>
                                                            <th style="width: 15%; text-align: center;">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Data akan diisi secara dinamis -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Obyektif --}}
                                <div class="card w-100">
                                    <div class="card-header bg-light d-flex align-items-center">
                                        <h5 class="mb-0 flex-grow-1"><i class="fa fa-stethoscope"></i> Obyektif</h5>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="tidakDapatDiperiksa">
                                            <label class="form-check-label" for="tidakDapatDiperiksa">
                                                Check untuk pasien yang tidak bisa diperiksa
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label>Tensi (mmHg)</label>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" id="sistol" name="sistol" onchange="updateTensi()">
                                                    </div>
                                                    <div class="col-md-1 d-flex justify-content-center align-items-center">
                                                        <span>/</span> <!-- Menambahkan pemisah / -->
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" id="distol" name="distol" onchange="updateTensi()">
                                                    </div>
                                                    <input type="hidden" id="tensi" name="tensi">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="suhu">Suhu (°C)</label>
                                                <input type="text" class="form-control" id="suhu" name="suhu" onchange="validateSuhu(this)">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="nadi">Nadi (/mnt)</label>
                                                <input type="text" class="form-control" id="nadi" name="nadi" onchange="validateNadi()">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="rr">RR (/mnt)</label>
                                                <input type="text" class="form-control" id="rr" name="rr" onchange="validateRR(this)">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="tinggi">Tinggi (Cm)</label>
                                                <input type="text" class="form-control" id="tinggi" name="tinggi" onchange="validateTB()">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="berat">Berat (/Kg)</label>
                                                <input type="text" class="form-control" id="berat" name="berat" onchange="validateTB()">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label for="spo2">SpO2</label>
                                                <input type="text" class="form-control" id="spo2" name="spo2" onchange="validateSpO2(this)">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="alergi">Alergi</label>
                                                <input type="text" class="form-control" id="alergi" name="alergi">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="lingkar_perut">Lingkar Perut</label>
                                                <input type="text" class="form-control" id="lingkar_perut" name="lingkar_perut">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Data BMI</label>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" id="nilai_bmi" name="nilai_bmi" readonly>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="status_bmi" name="status_bmi" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label for="eye">EYE</label>
                                                <select class="form-control select2bs4" style="width: 100%;" id="eye" name="eye">
                                                    <option value="" disabled selected>-- Pilih --</option>
                                                    @foreach ($eye as $data)
                                                        <option value="{{$data->skor}}">{{$data->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="verbal">VERBAL</label>
                                                <select class="form-control select2bs4" style="width: 100%;" id="verbal" name="verbal">
                                                    <option value="" disabled selected>-- Pilih --</option>
                                                    @foreach ($verbal as $data)
                                                        <option value="{{$data->skor}}">{{$data->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="motorik">MOTORIK</label>
                                                <select class="form-control select2bs4" style="width: 100%;" id="motorik" name="motorik">
                                                    <option value="" disabled selected>-- Pilih --</option>
                                                    @foreach ($motorik as $data)
                                                    <option value="{{$data->skor}}">{{$data->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="sadar">Kesadaran</label>
                                                <select class="form-control" style="width: 100%;" id="sadar" name="sadar" readonly>
                                                    <option value="" disabled selected> </option>
                                                    @foreach ($nilai as $data)
                                                        <option value="{{ $data->skor }}">{{ $data->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group mt-5 mb-3">
                                            <h5 style="font-weight: bold;"><i class="fa fa-notes-medical"></i> Head To Toe</h5>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select class="form-control select2bs4" style="width: 100%;" id="htt_pemeriksaan" name="htt_pemeriksaan">
                                                        <option value="-" disabled selected> -- Silahkan Pilih -- </option>
                                                        @foreach ($htt_pemeriksaan as $data)
                                                            <option value="{{ $data->nama_pemeriksaan }}" data-kode_pemeriksaan="{{ $data->kode_pemeriksaan }}">
                                                                {{ $data->nama_pemeriksaan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 d-flex align-items-center">
                                                    <label class="mb-0 text-center mr-3 ">Di</label>
                                                    <select class="form-control select2bs4" style="width: 100%;" id="htt_pemeriksaan_sub" name="htt_pemeriksaan_sub">
                                                    </select>
                                                </div>
                                                <div class="col-md-3 d-flex align-items-center">
                                                    <label class="mb-0 text-center mr-3 ">Pada</label>
                                                    <input type="text" class="form-control" id="htt_pemeriksaan_detail" name="htt_pemeriksaan_detail">
                                                </div>
                                                <div class="col-md-2 d-flex justify-content-end">
                                                    <button type="button" class="btn btn-primary" onclick="addDataHtt_Text()">Tambahkan</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <textarea class="form-control" id="summernote" name="summernote"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end">
                                        {{-- <button type="button" class="mr-2 btn btn-primary" data-norm="{{$rajaldata->no_rm}}" onclick="layanan(this.getAttribute('data-norm'))"> --}}
                                        <button type="button" class="mr-2 btn btn-primary" data-norm="{{base64_encode($rajaldata->no_rawat)}}" onclick="layanan(this.getAttribute('data-norm'))">
                                            <i class=""></i> TINDAKAN
                                        </button>
                                        <button type="submit" class="btn btn-primary">Tambahkan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 card-title">Pasien</h3>
                        </div>
                        <div class="card-body" id="kunjungan-section">
                            <table id="kunjungan-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Suhu(C)</th>
                                        <th>Tensi(mmHg)</th>
                                        <th>Nadi(menit)</th>
                                        <th>RR(menit)</th>
                                        <th>Tinggi(cm)</th>
                                        <th>Berat(Kg)</th>
                                        <th>GCS(E,V,M)</th>
                                        <th>SPO2</th>
                                        <th>Alergi</th>
                                        <th>Instruksi & Evaluasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pemeriksaans as $index => $pemeriksaan)
                                    <tr>
                                        <td rowspan="8" style="vertical-align:top;">{{ $index + 1 }}</td>
                                        <td rowspan="7" style="vertical-align:top;white-space: nowrap;">{{ $pemeriksaan->tgl_kunjungan }}<br>{{ $pemeriksaan->time }}</td>
                                        <td>{{ $pemeriksaan->tensi }}</td>
                                        <td>{{ $pemeriksaan->suhu }}</td>
                                        <td>{{ $pemeriksaan->nadi }}</td>
                                        <td>{{ $pemeriksaan->rr }}</td>
                                        <td>{{ $pemeriksaan->tinggi_badan }}</td>
                                        <td>{{ $pemeriksaan->berat_badan }}</td>
                                        <td>{{ $pemeriksaan->spo2 }}</td>
                                        <td>{{ $pemeriksaan->gcs }}</td>
                                        <td>{{ $pemeriksaan->alergi }}</td>
                                        <td rowspan="8" style="vertical-align:top;">
                                            <b>Instruksi:</b> {{ $pemeriksaan->instruksi }}<br><br>
                                            <b>Evaluasi:</b> {{ $pemeriksaan->evaluasi }}<br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Kesadaran</b></td>
                                        <td colspan="7"> {{ $pemeriksaan->kesadaran }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Lingkar Perut</b></td>
                                        <td colspan="7"> {{ $pemeriksaan->lingkar_perut }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Subyektif</b></td>
                                        <td colspan="7"> {{ $pemeriksaan->subyektif }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Obyektif</b></td>
                                        <td colspan="7"> {{ $pemeriksaan->pemeriksaan_fisik }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Assesment</b></td>
                                        <td colspan="7"> {{ $pemeriksaan->assessmen }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Plan</b></td>
                                        <td colspan="7"> {{ $pemeriksaan->plan }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">
                                            <form action="{{ route('delete.route', $pemeriksaan->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}

            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Konfirmasi Tindakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBodyText">
                <!-- Pesan konfirmasi akan diisi dinamis -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalCancelButton">Tidak</button>
                <button type="button" class="btn btn-primary" id="modalProceedButton">Lanjutkan</button>
            </div>
        </div>
    </div>
</div>


    <!-- /.content-wrapper -->
    <script>
         $(document).ready(function() {
            // Set input detail pemeriksaan menjadi readonly secara default
            $('#htt_pemeriksaan_detail').prop('readonly', true);

            // Event listener untuk perubahan pada select htt_pemeriksaan
            $('#htt_pemeriksaan').on('change', function() {
                var kodePemeriksaan = $(this).find(':selected').data('kode_pemeriksaan'); // Ambil kode_pemeriksaan yang dipilih

                // Kosongkan dropdown htt_pemeriksaan_sub terlebih dahulu
                $('#htt_pemeriksaan_sub').empty();

                // Menambahkan opsi default
                $('#htt_pemeriksaan_sub').append('<option value="-" disabled selected> -- Silahkan Pilih -- </option>');
                $('#htt_pemeriksaan_detail').prop('readonly', true);

                // Lakukan pencocokan dan perbarui pilihan sub pemeriksaan sesuai dengan kode yang dipilih
                @foreach ($htt_sub_pemeriksaan as $data)
                    // Cek apakah kode_pemeriksaan pada data sub sesuai dengan kode_pemeriksaan yang dipilih
                    if('{{ $data->kode_pemeriksaan }}' === kodePemeriksaan) {
                        // Menambahkan sub pemeriksaan yang sesuai ke dalam dropdown
                        $('#htt_pemeriksaan_sub').append('<option value="{{ $data->nama_subpemeriksaan }}" data-kode_pemeriksaan_sub="{{ $data->kode_subpemeriksaan }}">{{ $data->nama_subpemeriksaan }}</option>');
                    }
                @endforeach
            });

            // Event listener untuk perubahan pada select htt_pemeriksaan_sub
            $('#htt_pemeriksaan_sub').on('change', function() {
                // Jika sub pemeriksaan dipilih, hapus readonly dari input detail pemeriksaan
                $('#htt_pemeriksaan_detail').prop('readonly', false);
            });
        });

        let nomorUtama = 0;
        let pemeriksaanDict = {}; // Menyimpan hierarki data

        function addDataHtt_Text() {
            let kodePemeriksaan = $('#htt_pemeriksaan').find(':selected').data('kode_pemeriksaan');
            let namaPemeriksaan = $('#htt_pemeriksaan option:selected').text().trim();
            let kodeSubPemeriksaan = $('#htt_pemeriksaan_sub').find(':selected').data('kode_pemeriksaan_sub');
            let namaSubPemeriksaan = $('#htt_pemeriksaan_sub option:selected').text().trim();
            let namaDetailPemeriksaan = $('#htt_pemeriksaan_detail').val().trim(); // Ambil nilai input text detail

            // Validasi: Semua kolom harus diisi
            if (!namaPemeriksaan || !namaSubPemeriksaan || !namaDetailPemeriksaan) {
                    const message = `Semua kolom harus diisi !`;

                    // Tampilkan pesan di modal
                    document.getElementById('modalBodyText').innerText = message;
                    $('#confirmationModal').modal('show');

                    // Tangani tombol "Lanjutkan"
                    document.getElementById('modalProceedButton').onclick = function () {
                        $('#htt_pemeriksaan').val('-').trigger('change');
                        $('#htt_pemeriksaan_sub').empty().append('<option value="-" disabled selected> -- Silahkan Pilih -- </option>');
                        $('#htt_pemeriksaan_detail').val('').prop('readonly', true);
                        $('#confirmationModal').modal('hide');
                    };

                    // Tangani tombol "Tidak"
                    document.getElementById('modalCancelButton').onclick = function () {
                        $('#htt_pemeriksaan').val('-').trigger('change');
                        $('#htt_pemeriksaan_sub').empty().append('<option value="-" disabled selected> -- Silahkan Pilih -- </option>');
                        $('#htt_pemeriksaan_detail').val('').prop('readonly', true);
                        $('#confirmationModal').modal('hide');
                    };
            } else {
                // Jika pemeriksaan belum ada, tambahkan ke dalam objek
                if (kodePemeriksaan && !pemeriksaanDict[kodePemeriksaan]) {
                    nomorUtama++;
                    pemeriksaanDict[kodePemeriksaan] = {
                        nomor: nomorUtama,
                        nama: namaPemeriksaan,
                        subPemeriksaan: {}
                    };
                }

                // Jika sub pemeriksaan belum ada, tambahkan
                if (kodePemeriksaan && kodeSubPemeriksaan && !pemeriksaanDict[kodePemeriksaan].subPemeriksaan[kodeSubPemeriksaan]) {
                    let nomorSub = Object.keys(pemeriksaanDict[kodePemeriksaan].subPemeriksaan).length + 1;
                    pemeriksaanDict[kodePemeriksaan].subPemeriksaan[kodeSubPemeriksaan] = {
                        nomor: nomorSub,
                        nama: namaSubPemeriksaan,
                        detailPemeriksaan: []
                    };
                }

                // Jika detail pemeriksaan belum ada dalam sub pemeriksaan, tambahkan
                if (!pemeriksaanDict[kodePemeriksaan].subPemeriksaan[kodeSubPemeriksaan].detailPemeriksaan.includes(namaDetailPemeriksaan)) {
                    pemeriksaanDict[kodePemeriksaan].subPemeriksaan[kodeSubPemeriksaan].detailPemeriksaan.push(namaDetailPemeriksaan);
                }

                // Update tampilan Summernote
                updateSummernote();

                // Reset form
                $('#htt_pemeriksaan').val('-').trigger('change');
                $('#htt_pemeriksaan_sub').empty().append('<option value="-" disabled selected> -- Silahkan Pilih -- </option>');
                $('#htt_pemeriksaan_detail').val('').prop('readonly', true);
            }
        }

        function updateSummernote() {
            let content = '';

            Object.values(pemeriksaanDict).forEach(pemeriksaan => {
                content += `<h3>${pemeriksaan.nomor}. Inspeksi ${pemeriksaan.nama}</h3>`;

                Object.values(pemeriksaan.subPemeriksaan).forEach(sub => {
                    content += `<h4 style="margin-left: 30px;">${pemeriksaan.nomor}.${sub.nomor} ${sub.nama}</h4>`;

                    sub.detailPemeriksaan.forEach(detail => {
                        content += `<h5 style="margin-left: 70px;">- ${detail}</h5>`; // Tambahkan detail dalam list
                    });
                });
            });

            $('#summernote').summernote('code', content);
        }
    </script>

    <script>
        let dataArray = []; // Array untuk menyimpan data sementara

        // Fungsi menambahkan data ke array dan tabel
        function addData() {
            const penyakit = document.getElementById("penyakit").value;
            const durasi = document.getElementById("durasi").value;
            const waktu = document.getElementById("waktu").value;

            // if (!penyakit || !durasi || !waktu) {
            //     alert("Semua kolom harus diisi!");
            //     return;
            // }

            // Cek jika semua kolom kosong
            if (!penyakit && !durasi && !waktu) {
                alert("Semua kolom harus diisi!");
                return;
            } else if (!penyakit) {
                alert("Kolom Penyakit harus diisi!");
                return;
            } else if (!durasi) {
                alert("Kolom Durasi harus diisi!");
                return;
            } else if (!waktu) {
                alert("Kolom Pilihan hari, bulan, tahun harus diisi!");
                return;
            }

            // Tambahkan data ke array
            dataArray.push({ penyakit, durasi, waktu });
            console.log("Data ditambahkan:", { penyakit, durasi, waktu });

            // Render ulang tabel
            renderTable();

            // Reset input fields setelah data ditambahkan
            $('#penyakit').val('');
            $('#durasi').val('');
            $("#waktu").val("").trigger("change");

            // Setelah data ditambahkan, ubah dataArray menjadi JSON dan simpan di input hidden
            const tableData = document.getElementById("tableData");
            tableData.value = JSON.stringify(dataArray); // Mengubah array menjadi string JSON
        }

        // Fungsi untuk merender tabel
        function renderTable() {
            const tableBody = document.getElementById("SubTabel").querySelector("tbody");
            tableBody.innerHTML = ""; // Kosongkan tabel
            console.log("Merender tabel...");

            dataArray.forEach((data, index) => {
                const row = `
                    <tr>
                        <td style="text-align: center;">${index + 1}</td>
                        <td>${data.penyakit} Sejak ${data.durasi} ${data.waktu}</td>
                        <td style="text-align: center;">
                            <button class="btn btn-danger btn-sm" onclick="removeData(${index})">Hapus</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });

            console.log("Tabel dirender, data array saat ini:", dataArray);
        }

        // Fungsi untuk menghapus data dari array
        function removeData(index) {
            console.log("Menghapus data index:", index);
            dataArray.splice(index, 1); // Hapus data berdasarkan index
            console.log("Data setelah dihapus:", dataArray);

            renderTable(); // Render ulang tabel

            // Setelah data dihapus, ubah dataArray menjadi JSON dan simpan di input hidden
            const tableData = document.getElementById("tableData");
            tableData.value = JSON.stringify(dataArray); // Mengubah array menjadi string JSON
        }
    </script>

{{-- SCRIPT untuk checkbox --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const checkbox = document.getElementById("tidakDapatDiperiksa");
            const inputs = ["sistol", "distol", "tensi", "nadi", "rr", "spo2"];

            // Fungsi untuk mengubah status input (readonly) dan nilai berdasarkan checkbox
            function toggleInputs() {
                const isChecked = checkbox.checked;

                inputs.forEach(id => {
                    const input = document.getElementById(id);
                    if (input) {
                        // Jika checkbox dicentang
                        input.readOnly = isChecked;  // Set readonly sesuai status checkbox
                        input.value = isChecked ? "-" : "";  // Set value "-" jika dicentang, kosongkan jika tidak
                    }
                });
            }

            // Event listener untuk checkbox change event
            checkbox.addEventListener("change", toggleInputs);

            // Menjalankan fungsi toggleInputs saat halaman pertama kali dimuat untuk memastikan keadaan awal
            toggleInputs();
        });
    </script>


{{-- UPDATE --}}
    {{-- SCRIPT UNTUK TEKANAN DARAH --}}
    <script>
        function updateTensi() {
            // Ambil nilai dari input sistol dan distol
            const sistol = document.getElementById('sistol').value.trim();
            const distol = document.getElementById('distol').value.trim();
            const umur = document.getElementById('umurHidden').value.trim();

            // Variabel untuk menyimpan tahun dan bulan
            let tahun = 0;
            let bulan = 0;

            // Regular Expression untuk mengekstrak Tahun dan Bulan
            const regex = /(\d+)\s*Tahun\s*(\d+)\s*Bulan/;

            // Cek apakah format umur sesuai dengan pola "X Tahun Y Bulan"
            const match = umur.match(regex);

            if (match) {
                // Jika cocok, ekstrak tahun dan bulan
                tahun = parseInt(match[1]) || 0;
                bulan = parseInt(match[2]) || 0;
            }

            // Pastikan kedua input sistol dan distol diisi sebelum melanjutkan
            if (sistol && distol) {
                const sistolValue = parseInt(sistol);
                const distolValue = parseInt(distol);

                // Gabungkan nilai sistol dan distol ke dalam format "sistol/distol"
                const tensiValue = `${sistolValue}/${distolValue}`;
                document.getElementById('tensi').value = tensiValue;

                // Validasi apakah nadi sesuai dengan rentang umur dan apakah nadi adalah angka
                if (isNaN(sistol) || isNaN(distol)) {
                    const message = `Data Tensi Ada Yang Tidak Sesuai.\nMohon isi yang benar!`;

                    // Tampilkan pesan di modal
                    document.getElementById('modalBodyText').innerText = message;
                    $('#confirmationModal').modal('show');

                    // Tangani tombol "Lanjutkan"
                    document.getElementById('modalProceedButton').onclick = function () {
                        document.getElementById('sistol').value = '';
                        document.getElementById('distol').value = '';
                        document.getElementById('tensi').value = '';
                        $('#confirmationModal').modal('hide');
                    };

                    // Tangani tombol "Tidak"
                    document.getElementById('modalCancelButton').onclick = function () {
                        document.getElementById('sistol').value = '';
                        document.getElementById('distol').value = '';
                        document.getElementById('tensi').value = '';
                        $('#confirmationModal').modal('hide');
                    };
                }

                // Tentukan pesan untuk kondisi tertentu
                let message = '';
                if (tahun >= 0 && tahun <= 5){
                    if (sistolValue <= 74 || distolValue <= 49) {
                        message = 'Data Tensi Terdeteksi HIPOTENSI. Apakah Anda ingin melanjutkan?';
                    } else if ((sistolValue >= 75 && sistolValue <= 100) && (distolValue >= 50 && distolValue <= 65)) {
                        message = 'Data Tensi Normal. Apakah Anda ingin melanjutkan?';
                    } else if (sistolValue >= 101 || distolValue >= 66) {
                        message = 'Data Tensi Terdeteksi HIPERTENSI. Apakah Anda ingin melanjutkan?';
                    }
                } else if (tahun >= 6 && tahun <= 12){
                    if (sistolValue <= 89 || distolValue <= 59) {
                        message = 'Data Tensi Terdeteksi HIPOTENSI. Apakah Anda ingin melanjutkan?';
                    } else if ((sistolValue >= 90 && sistolValue <= 110) && (distolValue >= 60 && distolValue <= 75)) {
                        message = 'Data Tensi Normal. Apakah Anda ingin melanjutkan?';
                    } else if (sistolValue >= 111 || distolValue >= 76) {
                        message = 'Data Tensi Terdeteksi HIPERTENSI. Apakah Anda ingin melanjutkan?';
                    }
                } else if (tahun >= 13 && tahun <= 17){
                    if (sistolValue <= 89 || distolValue <= 59) {
                        message = 'Data Tensi Terdeteksi HIPOTENSI. Apakah Anda ingin melanjutkan?';
                    } else if ((sistolValue >= 90 && sistolValue <= 120) && (distolValue >= 60 && distolValue <= 80)) {
                        message = 'Data Tensi Normal. Apakah Anda ingin melanjutkan?';
                    } else if (sistolValue >= 121 || distolValue >= 81) {
                        message = 'Data Tensi Terdeteksi HIPERTENSI. Apakah Anda ingin melanjutkan?';
                    }
                } else if (tahun >= 18 && tahun <= 64){
                    if (sistolValue <= 89 || distolValue <= 59) {
                        message = 'Data Tensi Terdeteksi HIPOTENSI. Apakah Anda ingin melanjutkan?';
                    } else if ((sistolValue >= 90 && sistolValue <= 120) && (distolValue >= 60 && distolValue <= 80)) {
                        message = 'Data Tensi Normal. Apakah Anda ingin melanjutkan?';
                    } else if (sistolValue >= 121 || distolValue >= 81) {
                        message = 'Data Tensi Terdeteksi HIPERTENSI. Apakah Anda ingin melanjutkan?';
                    }
                } else if (tahun >= 65){
                    if (sistolValue <= 89 || distolValue <= 59) {
                        message = 'Data Tensi Terdeteksi HIPOTENSI. Apakah Anda ingin melanjutkan?';
                    } else if ((sistolValue >= 90 && sistolValue <= 140) && (distolValue >= 60 && distolValue <= 90)) {
                        message = 'Data Tensi Normal. Apakah Anda ingin melanjutkan?';
                    } else if (sistolValue >= 141 || distolValue >= 91) {
                        message = 'Data Tensi Terdeteksi HIPERTENSI. Apakah Anda ingin melanjutkan?';
                    }
                }

                if (message) {
                    // Tampilkan modal konfirmasi dengan pesan yang sesuai
                    document.getElementById('modalBodyText').innerText = message;
                    $('#confirmationModal').modal('show');

                    // Tangani tombol "Lanjutkan"
                    document.getElementById('modalProceedButton').onclick = function () {
                        $('#confirmationModal').modal('hide');
                        // Aksi lanjut, jika diperlukan
                    };

                    // Tangani tombol "Tidak"
                    document.getElementById('modalCancelButton').onclick = function () {
                        document.getElementById('sistol').value = '';
                        document.getElementById('distol').value = '';
                        document.getElementById('tensi').value = '';
                        $('#confirmationModal').modal('hide');
                    };
                }
            }
        }
    </script>

{{-- UPDATE --}}
    {{-- SCRIPT UNTUK RR --}}
    <script>
        function validateRR(input) {
            const rrValue = parseInt(input.value.trim()); // Mengambil dan mengubah nilai input menjadi angka
            const umur = document.getElementById('umurHidden').value.trim();

            // Variabel untuk menyimpan tahun dan bulan
            let tahun = 0;
            let bulan = 0;

            // Regular Expression untuk mengekstrak Tahun dan Bulan
            const regex = /(\d+)\s*Tahun\s*(\d+)\s*Bulan/;

            // Cek apakah format umur sesuai dengan pola "X Tahun Y Bulan"
            const match = umur.match(regex);

            if (match) {
                // Jika cocok, ekstrak tahun dan bulan
                tahun = parseInt(match[1]) || 0;
                bulan = parseInt(match[2]) || 0;
            }

            // Validasi apakah nadi sesuai dengan rentang umur dan apakah nadi adalah angka
            if (isNaN(rrValue)) {
                const message = `Data Respiratory Rate Tidak Sesuai.\nMohon isi yang benar!`;

                // Tampilkan pesan di modal
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tangani tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    input.value = ''; // Menghapus nilai input jika tidak dilanjutkan
                    input.focus();    // Mengembalikan fokus ke input
                    $('#confirmationModal').modal('hide');
                };

                // Tangani tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    input.value = ''; // Menghapus nilai input jika tidak dilanjutkan
                    input.focus();    // Mengembalikan fokus ke input
                    $('#confirmationModal').modal('hide');
                };
            }

            let message = '';
            if (tahun == 0 && bulan >= 0 && bulan <= 12) {
                if (rrValue <= 29) {
                    message = "Data Respiratory Rate terindikasi terlalu rendah. Apakah Anda ingin melanjutkan?";
                } else if (rrValue >= 30 && rrValue <= 60) {
                    message = "Data Respiratory Rate terindikasi Normal. Apakah Anda ingin melanjutkan?";
                } else if (rrValue >= 61) {
                    message = "Data Respiratory Rate terindikasi terlalu cepat. Apakah Anda ingin melanjutkan?";
                }
            } else if (tahun == 1 && tahun == 2) {
                if (rrValue <= 23) {
                    message = "Data Respiratory Rate terindikasi terlalu rendah. Apakah Anda ingin melanjutkan?";
                } else if (rrValue >= 24 && rrValue <= 40) {
                    message = "Data Respiratory Rate terindikasi Normal. Apakah Anda ingin melanjutkan?";
                } else if (rrValue >= 41) {
                    message = "Data Respiratory Rate terindikasi terlalu cepat. Apakah Anda ingin melanjutkan?";
                }
            } else if (tahun >= 3 && tahun <= 5) {
                if (rrValue <= 21) {
                    message = "Data Respiratory Rate terindikasi terlalu rendah. Apakah Anda ingin melanjutkan?";
                } else if (rrValue >= 22 && rrValue <= 34) {
                    message = "Data Respiratory Rate terindikasi Normal. Apakah Anda ingin melanjutkan?";
                } else if (rrValue >= 35) {
                    message = "Data Respiratory Rate terindikasi terlalu cepat. Apakah Anda ingin melanjutkan?";
                }
            } else if (tahun >= 6 && tahun <= 12) {
                if (rrValue <= 17) {
                    message = "Data Respiratory Rate terindikasi terlalu rendah. Apakah Anda ingin melanjutkan?";
                } else if (rrValue >= 18 && rrValue <= 30) {
                    message = "Data Respiratory Rate terindikasi Normal. Apakah Anda ingin melanjutkan?";
                } else if (rrValue >= 31) {
                    message = "Data Respiratory Rate terindikasi terlalu cepat. Apakah Anda ingin melanjutkan?";
                }
            } else if (tahun >= 13 && tahun <= 17) {
                if (rrValue <= 11) {
                    message = "Data Respiratory Rate terindikasi terlalu rendah. Apakah Anda ingin melanjutkan?";
                } else if (rrValue >= 12 && rrValue <= 20) {
                    message = "Data Respiratory Rate terindikasi Normal. Apakah Anda ingin melanjutkan?";
                } else if (rrValue >= 21) {
                    message = "Data Respiratory Rate terindikasi terlalu cepat. Apakah Anda ingin melanjutkan?";
                }
            } else if (tahun >= 18 && tahun <= 64) {
                if (rrValue <= 17) {
                    message = "Data Respiratory Rate terindikasi terlalu rendah. Apakah Anda ingin melanjutkan?";
                } else if (rrValue >= 18 && rrValue <= 24) {
                    message = "Data Respiratory Rate terindikasi Normal. Apakah Anda ingin melanjutkan?";
                } else if (rrValue >= 25) {
                    message = "Data Respiratory Rate terindikasi terlalu cepat. Apakah Anda ingin melanjutkan?";
                }
            } else if (tahun >= 65) {
                if (rrValue <= 11) {
                    message = "Data Respiratory Rate terindikasi terlalu rendah. Apakah Anda ingin melanjutkan?";
                } else if (rrValue >= 12 && rrValue <= 28) {
                    message = "Data Respiratory Rate terindikasi Normal. Apakah Anda ingin melanjutkan?";
                } else if (rrValue >= 29) {
                    message = "Data Respiratory Rate terindikasi terlalu cepat. Apakah Anda ingin melanjutkan?";
                }
            }

            if (message) {
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    $('#confirmationModal').modal('hide');
                };

                // Tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    input.value = ''; // Menghapus nilai input jika tidak dilanjutkan
                    input.focus();    // Mengembalikan fokus ke input
                    $('#confirmationModal').modal('hide');
                };
            }
        }
    </script>

{{-- UPDATE --}}
    {{-- SCRIPT UNTUK SUHU --}}
    <script>
       function validateSuhu(input) {
            let suhuValue = input.value.trim();

            // Cek jika nilai mengandung koma
            if (suhuValue.includes(',')) {
                const message = `Mohon gunakan titik (.) sebagai pemisah desimal, bukan koma !`;

                // Tampilkan pesan di modal
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tangani tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    input.value = ''; // Hapus input
                    $('#confirmationModal').modal('hide');
                };

                // Tangani tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    input.value = ''; // Hapus input
                    $('#confirmationModal').modal('hide');
                };
            }

            const suhuNumber = parseFloat(suhuValue);

            // Validasi apakah nadi sesuai dengan rentang umur dan apakah nadi adalah angka
            if (isNaN(suhuNumber)) {
                const message = `Data Suhu Tidak Sesuai.\nMohon isi yang benar!`;

                // Tampilkan pesan di modal
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tangani tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    input.value = ''; // Hapus input
                    $('#confirmationModal').modal('hide');
                };

                // Tangani tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    input.value = ''; // Hapus input
                    $('#confirmationModal').modal('hide');
                };
            }

            let message = '';
            if (suhuNumber < 34.4) {
                message = "suhu terindikasi Hipotermia (terlalu rendah). \nApakah Anda ingin melanjutkan?";
            } else if (suhuNumber >= 34.4 && suhuNumber <= 37.4) {
                message = "suhu normal. \nPerlu diperhatikan bahwa suhu yang diukur di dahi seringkali lebih rendah dibandingkan pengukuran suhu oral atau rektal. \nApakah Anda ingin melanjutkan?";
            } else if (suhuNumber >= 37.5 && suhuNumber <= 37.9) {
                message = "suhu terindikasi Demam Ringan, \nbisa menunjukkan adanya infeksi atau kondisi inflamasi ringan. \nApakah Anda ingin melanjutkan?";
            } else if (suhuNumber >= 38 && suhuNumber <= 38.9) {
                message = "suhu terindikasi Demam, \numumnya menunjukkan bahwa tubuh sedang melawan infeksi atau kondisi inflamasi lainnya. \nApakah Anda ingin melanjutkan?";
            } else if (suhuNumber >= 39) {
                message = "suhu terindikasi Demam Tinggi, \nmenunjukkan kondisi yang mungkin memerlukan evaluasi dan perawatan medis lebih lanjut. \nApakah Anda ingin melanjutkan?";
            }

            if (message) {
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    $('#confirmationModal').modal('hide');
                };

                // Tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    input.value = ''; // Hapus input
                    $('#confirmationModal').modal('hide');
                };
            }
        }

    </script>

    {{-- SCRIPT UNTUK SpO2 --}}
    <script>
        function validateSpO2(input) {
            const value = parseFloat(input.value.trim());

            // Validasi apakah nadi sesuai dengan rentang umur dan apakah nadi adalah angka
            if (isNaN(value)) {
                const message = `Data spo2 Tidak Sesuai.\nMohon isi yang benar!`;

                // Tampilkan pesan di modal
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tangani tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    input.value = ''; // Hapus input
                    input.focus();    // Kembalikan fokus ke input
                    $('#confirmationModal').modal('hide');
                };

                // Tangani tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    input.value = ''; // Hapus input
                    input.focus();    // Kembalikan fokus ke input
                    $('#confirmationModal').modal('hide');
                };
            }

            if (value < 95 || value > 100) {
                let message = '';

                if (value < 95) {
                    message = "Data SpO2 terdeteksi rendah. SpO2 normalnya adalah 95% atau lebih. Apakah Anda ingin melanjutkan?";
                } else if (value > 100) {
                    message = "Data SpO2 terdeteksi terlalu tinggi. SpO2 normalnya adalah 100% atau kurang. Apakah Anda ingin melanjutkan?";
                }

                // Tampilkan pesan di modal
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tangani tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    $('#confirmationModal').modal('hide');
                    input.dataset.validated = "true"; // Tandai input sebagai divalidasi
                };

                // Tangani tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    input.value = ''; // Hapus input
                    input.focus();    // Kembalikan fokus ke input
                    $('#confirmationModal').modal('hide');
                };
            }
        }

    </script>

{{-- UPDATE --}}
    {{-- SCRIPT UNTUK DENYUT NADI --}}
    <script>
        function validateNadi() {
            const nadi = parseInt(document.getElementById('nadi').value.trim());
            const umur = document.getElementById('umurHidden').value.trim();

            // Variabel untuk menyimpan tahun dan bulan
            let tahun = 0;
            let bulan = 0;

            // Regular Expression untuk mengekstrak Tahun dan Bulan
            const regex = /(\d+)\s*Tahun\s*(\d+)\s*Bulan/;

            // Cek apakah format umur sesuai dengan pola "X Tahun Y Bulan"
            const match = umur.match(regex);

            if (match) {
                // Jika cocok, ekstrak tahun dan bulan
                tahun = parseInt(match[1]) || 0;
                bulan = parseInt(match[2]) || 0;
            }

            // Validasi apakah nadi sesuai dengan rentang umur dan apakah nadi adalah angka
            if (isNaN(nadi)) {
                const message = `Data Nadi Tidak Sesuai.\nMohon isi yang benar!`;

                // Tampilkan pesan di modal
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tangani tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    document.getElementById('nadi').value = ''; // Kosongkan input
                    document.getElementById('nadi').focus();    // Fokuskan kembali ke input nadi
                    $('#confirmationModal').modal('hide');
                    console.log('Data nadi dihapus.');
                };

                // Tangani tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    document.getElementById('nadi').value = ''; // Kosongkan input
                    document.getElementById('nadi').focus();    // Fokuskan kembali ke input nadi
                    $('#confirmationModal').modal('hide');
                    console.log('Data nadi dihapus.');
                };
            }

            // Menentukan rentang denyut nadi berdasarkan umur
            let message = '';
            if (tahun == 0 && bulan >= 0 && bulan <= 12) {
                if (nadi >= 100 && nadi <= 160) {
                    message = `Data Nadi Sesuai.\nApakah Anda ingin melanjutkan?`;
                } else  {
                    message = `Data Nadi Tidak Sesuai.\nRentang Nadi Normal untuk umur ${tahun} Tahun dan ${bulan} Bulan adalah antara 100 dan 160 denyut per menit.\nApakah Anda ingin melanjutkan?`;
                }
            } else if (tahun >= 1 && tahun <= 2) {
                if (nadi >= 90 && nadi <= 150) {
                    message = `Data Nadi Sesuai.\nApakah Anda ingin melanjutkan?`;
                } else {
                    message = `Data Nadi Tidak Sesua☻i.\nRentang Nadi Normal untuk umur ${tahun} Tahun dan ${bulan} Bulan adalah antara 90 dan 150 denyut per menit.\nApakah Anda ingin melanjutkan?`;
                }
            } else if (tahun >= 3 && tahun <= 5) {
                if (nadi >= 80 && nadi <= 140) {
                    message = `Data Nadi Sesuai.\nApakah Anda ingin melanjutkan?`;
                } else {
                    message = `Data Nadi Tidak Sesuai.\nRentang Nadi Normal untuk umur ${tahun} Tahun dan ${bulan} Bulan adalah antara 80 dan 140 denyut per menit.\nApakah Anda ingin melanjutkan?`;
                }
            } else if (tahun >= 6 && tahun <= 10) {
                if (nadi >= 70 && nadi <= 130) {
                    message = `Data Nadi Sesuai.\nApakah Anda ingin melanjutkan?`;
                } else {
                    message = `Data Nadi Tidak Sesuai.\nRentang Nadi Normal untuk umur ${tahun} Tahun dan ${bulan} Bulan adalah antara 70 dan 130 denyut per menit.\nApakah Anda ingin melanjutkan?`;
                }
            } else if (tahun >= 11) {
                if (nadi >= 60 && nadi <= 100) {
                    message = `Data Nadi Sesuai.\nApakah Anda ingin melanjutkan?`;
                } else {
                    message = `Data Nadi Tidak Sesuai.\nRentang Nadi Normal untuk umur ${tahun} Tahun dan ${bulan} Bulan adalah antara 60 dan 100 denyut per menit.\nApakah Anda ingin melanjutkan?`;
                }
            }

            if (message) {
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tangani tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    $('#confirmationModal').modal('hide');
                    console.log('Melanjutkan dengan data nadi yang tidak sesuai.');
                };

                // Tangani tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    document.getElementById('nadi').value = ''; // Kosongkan input
                    document.getElementById('nadi').focus();    // Fokuskan kembali ke input nadi
                    $('#confirmationModal').modal('hide');
                    console.log('Data nadi dihapus.');
                };
            }
        }
    </script>

    {{-- SCRIPT UNTUK Tinggi dan Berat Badan --}}
    <script>
        function validateTB() {
            // Ambil nilai dari input sistol dan distol
            const tinggi = document.getElementById('tinggi').value.trim();
            const berat = document.getElementById('berat').value.trim();

            // Reset nilai tinggiMeter dan beratKg
            let tinggiMeter = 0;
            let beratKg = 0;

            // Pastikan kedua input tinggi dan berat diisi sebelum melanjutkan
            if (tinggi && berat) {
                // Validasi apakah nadi sesuai dengan rentang umur dan apakah nadi adalah angka
                if (isNaN(tinggi) || isNaN(berat) || tinggi <= 0 || berat <= 0) {
                    const message = `Data Tinggi / Berat Badan Ada Yang Tidak Sesuai.\nMohon isi yang benar!`;

                    // Tampilkan pesan di modal
                    document.getElementById('modalBodyText').innerText = message;
                    $('#confirmationModal').modal('show');

                    // Tangani tombol "Lanjutkan"
                    document.getElementById('modalProceedButton').onclick = function () {
                        document.getElementById('tinggi').value = '';
                        document.getElementById('berat').value = '';
                        document.getElementById('berat').focus();
                        document.getElementById('tinggi').focus();
                        $('#confirmationModal').modal('hide');
                    };

                    // Tangani tombol "Tidak"
                    document.getElementById('modalCancelButton').onclick = function () {
                        document.getElementById('tinggi').value = '';
                        document.getElementById('berat').value = '';
                        document.getElementById('berat').focus();
                        document.getElementById('tinggi').focus();
                        $('#confirmationModal').modal('hide');
                    };
                } else {
                    // Konversi tinggi badan dari cm ke meter
                    tinggiMeter = parseFloat(tinggi) / 100;
                    beratKg = parseFloat(berat);

                    // Hitung BMI menggunakan rumus BMI = berat / (tinggi^2)
                    const bmi = beratKg / (tinggiMeter * tinggiMeter);

                    // Tampilkan hasil BMI di modal atau input lain
                    const bmiMessage = `Data BMI nya adalah: ${bmi.toFixed(2)}`;

                    // Tentukan kategori BMI
                    let bmiCategory = '';
                    if (bmi < 18.5) {
                        bmiCategory = 'Berat badan kurang (Underweight)';
                    } else if (bmi >= 18.5 && bmi <= 24.9) {
                        bmiCategory = 'Berat badan normal';
                    } else if (bmi >= 25 && bmi <= 29.9) {
                        bmiCategory = 'Kelebihan berat badan (overweight)';
                    } else {
                        bmiCategory = 'Obesitas';
                    }

                    document.getElementById("nilai_bmi").value = bmi.toFixed(2); // Format 1 desimal
                    document.getElementById("status_bmi").value = bmiCategory;

                    // Gabungkan pesan BMI dan kategori
                    const message = bmiMessage + `, Dengan kategori: ${bmiCategory}\nApakah Anda ingin melanjutkan?`;

                    if (message) {
                        // Tampilkan modal konfirmasi dengan pesan yang sesuai
                        document.getElementById('modalBodyText').innerText = message;
                        $('#confirmationModal').modal('show');

                        // Tangani tombol "Lanjutkan"
                        document.getElementById('modalProceedButton').onclick = function () {
                            $('#confirmationModal').modal('hide');
                            // Aksi lanjut, jika diperlukan
                        };

                        // Tangani tombol "Tidak"
                        document.getElementById('modalCancelButton').onclick = function () {
                            document.getElementById('tinggi').value = '';
                            document.getElementById('berat').value = '';
                            document.getElementById('berat').focus();
                            document.getElementById('tinggi').focus();
                            $('#confirmationModal').modal('hide');
                        };
                    }
                }
            }
        }
    </script>

    {{-- SCRIPT KESADARAN --}}
    <script>
        $(document).ready(function() {
            // Function to calculate and select "sadar" based on sum of eye, verbal, motorik
            function updateSadarSelection() {
                let eyeScore = parseInt($('#eye').val()) || 0;
                let verbalScore = parseInt($('#verbal').val()) || 0;
                let motorikScore = parseInt($('#motorik').val()) || 0;

                // Calculate total score
                let totalScore = eyeScore + verbalScore + motorikScore;

                // Find and select the option in "sadar" that matches the totalScore
                $('#sadar').val(totalScore).trigger('change');
            }

            // Attach event listeners to each dropdown to trigger the update when value changes
            $('#eye, #verbal, #motorik').on('change', updateSadarSelection);
        });

    </script>
    {{-- SCRIPT OBAT --}}
    <script>
        let patientWindow = null; // Variabel untuk menyimpan referensi jendela yang sudah dibuka

        function bukaJendelaPasien(norm) {
            const url = `/regis/obat/${norm}`;

            // Jika jendela sudah dibuka dan belum ditutup, fokus pada jendela itu
            if (patientWindow && !patientWindow.closed) {
                patientWindow.focus();
            } else {
                // Jika belum ada jendela atau jendela sebelumnya ditutup, buka jendela baru
                patientWindow = window.open(url, "_blank", "width=800,height=600");
            }
        }

    </script>


    <script>
        function layanan(norm) {
            const url = `/layanan/rawat-jalan/soap-dokter/tindakan/${norm}`; // Ganti norm sesuai parameter

            // Membuka jendela baru dengan URL yang sudah disiapkan
            window.open(url, "_blank" );
        }
    </script>

    <script>
        $(document).ready(function() {
            function toggleTableVisibility() {
                // Check ICD-10 table
                const icd10Table = $(".icd_10 tbody");
                console.log(icd10Table.children("tr").length); // Debug the row count
                if (icd10Table.children("tr").length === 0) {
                    icd10Table.closest(".isi_10").hide(); // Hide the ICD-10 row if no data
                }

                const icd9Table = $(".icd_9 tbody");
                console.log(icd9Table.children("tr").length); // Debug the row count

                if (icd9Table.children("tr").length === 1) {
                    icd9Table.closest(".isi_9").hide();
                }


                const kosongRow = $(".kosong");

                if (icd10Table.children("tr").length === 0 && icd9Table.children("tr").length === 1) {
                    kosongRow.show();  // Show "Data Tidak Ada" row if both tables are empty
                } else {
                    kosongRow.hide();  // Hide "Data Tidak Ada" row if either table has data
                }

            }


            // Initial call to check visibility when the page loads
            toggleTableVisibility();

            // Use this event to recheck visibility when a new row is added or deleted dynamically
            $(document).on('rowAdded rowRemoved', function() {
                toggleTableVisibility();
            });

            // Example event trigger for row addition and removal
            $(document).on('click', '.deleteICD10, .deleteICD9', function() {
                $(this).closest('tr').remove();
                $(document).trigger('rowRemoved');
            });

            // To handle rows added via AJAX or other methods, trigger the 'rowAdded' event after adding a row
            // $(document).trigger('rowAdded');
        });
    </script>

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
            $("#patienttbl").DataTable({
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

{{-- SCRIPT UNTUK SEMUA PEMERIKSAAN ABNORMAL --}}
    {{-- <script>
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function kulit() {
            var checkbox = document.getElementById("abnormal_kulit");
            var inputField = document.getElementById("input_kulit");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Normal"; // Set kembali nilai awal ke "Normal"
            }
        }
    </script>
    <script>
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function kuku() {
            var checkbox = document.getElementById("abnormal_kuku");
            var inputField = document.getElementById("input_kuku");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Normal"; // Set kembali nilai awal ke "Normal"
            }
        }
    </script>
    <script>
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function wajah() {
            var checkbox = document.getElementById("abnormal_wajah");
            var inputField = document.getElementById("input_wajah");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Normal"; // Set kembali nilai awal ke "Normal"
            }
        }
    </script>
    <script>
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function mata() {
            var checkbox = document.getElementById("abnormal_mata");
            var inputField = document.getElementById("input_mata");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Normal"; // Set kembali nilai awal ke "Normal"
            }
        }
    </script>
    <script>
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function telinga() {
            var checkbox = document.getElementById("abnormal_telinga");
            var inputField = document.getElementById("input_telinga");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Normal"; // Set kembali nilai awal ke "Normal"
            }
        }
    </script>
    <script>
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function hidung_sinus() {
            var checkbox = document.getElementById("abnormal_hidung_sinus");
            var inputField = document.getElementById("input_hidung_sinus");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Normal"; // Set kembali nilai awal ke "Normal"
            }
        }
    </script>
    <script>
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function mulut_bibir() {
            var checkbox = document.getElementById("abnormal_mulut_bibir");
            var inputField = document.getElementById("input_mulut_bibir");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Normal"; // Set kembali nilai awal ke "Normal"
            }
        }
    </script>
    <script>
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function leher() {
            var checkbox = document.getElementById("abnormal_leher");
            var inputField = document.getElementById("input_leher");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Normal"; // Set kembali nilai awal ke "Normal"
            }
        }
    </script>
    <script>
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function dada_punggung() {
            var checkbox = document.getElementById("abnormal_dada_punggung");
            var inputField = document.getElementById("input_dada_punggung");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Normal"; // Set kembali nilai awal ke "Normal"
            }
        }
    </script>
    <script>
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function abdomen() {
            var checkbox = document.getElementById("abnormal_abdomen");
            var inputField = document.getElementById("input_abdomen");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Normal"; // Set kembali nilai awal ke "Normal"
            }
        }
    </script>
    <script>
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function ekstremitas_atas() {
            var checkbox = document.getElementById("abnormal_ekstremitas_atas");
            var inputField = document.getElementById("input_ekstremitas_atas");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Normal"; // Set kembali nilai awal ke "Normal"
            }
        }
    </script>
    <script>
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function ekstremitas_bawah() {
            var checkbox = document.getElementById("abnormal_ekstremitas_bawah");
            var inputField = document.getElementById("input_ekstremitas_bawah");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Normal"; // Set kembali nilai awal ke "Normal"
            }
        }
    </script>
    <script>
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function genitalia_pria() {
            var checkbox = document.getElementById("abnormal_genitalia_pria");
            var inputField = document.getElementById("input_genitalia_pria");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Normal"; // Set kembali nilai awal ke "Normal"
            }
        }
    </script>
    <script>
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function psikososial_spiritual() {
            var checkbox = document.getElementById("abnormal_psikososial_spiritual");
            var inputField = document.getElementById("input_psikososial_spiritual");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Normal"; // Set kembali nilai awal ke "Normal"
            }
        }
    </script> --}}


@endsection
