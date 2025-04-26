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
                        <h1 class="m-0">SOAP</h1>
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
                <form action="{{ route('layanan.rawat-jalan.soap-dokter.index.add') }}" method="POST" class="row w-100">
                    @csrf
                    <div class="mt-3 col-12">
                        <div class="row">
                            <!-- Identitas Pasien -->
                            <div class="col-md-3 align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-header bg-light d-flex align-items-center w-100">
                                        <h5 class="mb-0 flex-grow-1"><i class="fa fa-user"></i> Data Pasien</h5>
                                        <button class="btn btn-primary btn-sm" id="open-tab-btn" >Data Lama</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle"
                                                 src="{{ asset('uploads/patient_photos/' . $profile->user->profile) }}"
                                                 alt="User profile picture">
                                        </div>
                                        <input type="text" class="form-control" id="no_reg" name="no_reg" value="{{$rajaldata->no_reg}}" hidden>
                                        <input type="text" class="form-control" id="no_rm" name="no_rm" value="{{$rajaldata->no_rm}}" hidden>
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
                                                <input type="text" class="form-control" value="{{$umur}}" id="umur" name="umur" readonly>
                                                <input type="hidden" class="form-control" value="{{ $umurHidden }}" id="umurHidden" name="umurHidden" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card w-100">
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
                                </div>
                            </div>

                            <!-- Pemeriksaan -->
                            <div class="col-md-9 align-items-stretch">
                                {{-- Subyektif --}}
                                <div class="card w-100">
                                    <div class="card-header bg-light">
                                        <h5><i class="fa fa-stethoscope"></i> Subyektif</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Input untuk penyakit yang diderita -->
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
                                    <div class="card-header bg-light">
                                        <h5><i class="fa fa-stethoscope"></i> Obyektif</h5>
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
                                        <div class="form-group row mt-3 mb-0">
                                            <div class="col-md-12">
                                                <h5 style="font-weight: bold;"><i class="fa fa-notes-medical"></i> Head To Toe</h5>
                                                <textarea class="form-control" id="summernote" name="summernote"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <h5 style="font-weight: bold;"><i class="fa fa-notes-medical"></i> Expertise Dokter</h5>
                                                <textarea class="form-control" id="cerita_dokter" name="cerita_dokter"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Assesment --}}
                                <div class="card w-100">
                                    <div class="card-header bg-light">
                                        <h5><i class="fa fa-stethoscope"></i> Assesment</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <textarea class="form-control" id="assessmen" name="assessmen"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end">
                                        <button type="button" id="ai" class="btn btn-primary">Bantuan Dholpi AI</button>
                                    </div>

                                </div>
                                {{-- Plan --}}
                                <div class="card w-100">
                                    <div class="card-header bg-light">
                                        <h5><i class="fa fa-file-alt"></i> Plan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <textarea class="form-control" id="plan" name="plan"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="instruksi">Instruksi</label>
                                                <textarea class="form-control" id="instruksi" name="instruksi"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="evaluasi">Evaluasi</label>
                                                <textarea class="form-control" id="evaluasi" name="evaluasi"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12 align-items-stretch">
                                <!-- Tabel ICD -->
                                <div class="card w-100">
                                    <div class="card-header bg-light d-flex align-items-center">
                                        <h5 class="mb-0"><i class="fa fa-stethoscope"></i> Diagnosa Medis Dan Tindakan Medis</h5>
                                        <div class="ml-auto">
                                            <button type="button" class="ml-2 btn btn-secondary" id="toggleICD">
                                                <i class="fa fa-print"></i> ICD 10 & 9
                                            </button>
                                            <button type="button" class="ml-2 btn btn-primary" data-norm="{{base64_encode($rajaldata->no_rawat)}}" onclick="diet(this.getAttribute('data-norm'))">
                                                <i class=""></i> DIET
                                            </button>
                                            <button type="button" class="ml-2 btn btn-primary" data-norm="{{base64_encode($rajaldata->no_rawat)}}" onclick="layanan(this.getAttribute('data-norm'))">
                                                <i class=""></i> TINDAKAN
                                            </button>
                                            <button type="button" class="ml-2 btn btn-primary" data-norm="{{base64_encode($rajaldata->no_rawat)}}" onclick="bukaJendelaPasien(this.getAttribute('data-norm'))">
                                                <i class=""></i> RESEP OBAT
                                            </button>
                                            <button type="button" class="ml-2 btn btn-primary" data-norm="{{base64_encode($rajaldata->no_rawat)}}" onclick="bukaJendelaPasienanotomi(this.getAttribute('data-norm'))">
                                                <i class=""></i> ODONTOGRAM
                                            </button>
                                            {{-- @if($rajaldata->poli_id == '1')
                                            @endif --}}
                                            <button type="button" class="ml-2 btn btn-primary" data-toggle="modal" data-target="#speechModal">
                                                <i class="fa-regular fa-message"></i>
                                            </button>
                                            <button id="record_button" type="button" class="ml-2 btn btn-primary"><i class="fa-solid fa-microphone-lines"></i></button>



                                        </div>
                                    </div>
                                    <div class="card w-100" id="icdCard" style="display: none;">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <div class="form-group row align-items-center">
                                                        <label for="icd10" class="ml-2 col-form-label">Diagnosa (ICD 10)</label>
                                                        <div class="ml-1">
                                                            <button type="button" class="ml-2 btn btn-default" id="kodeICD10">KODE ICD 10</button>
                                                            <button type="button" class="ml-2 btn btn-default dropdown-toggle" id="dropdownMenuButtonICD10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span id="prioritas_icd_10" class="caret">Pilih</span>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonICD10">
                                                                <li><a class="dropdown-item" data-value="Primary">Primary</a></li>
                                                                <li><a class="dropdown-item" data-value="Sekunder">Sekunder</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="input-group" style="display: flex; align-items: center;">
                                                        <select class="form-control select2bs4" style="width: 80%;" id="icd10" name="icd10">
                                                            <option value="" disabled selected>-- Pilih --</option>
                                                            @foreach ($icd10 as $data)
                                                                <option value="{{$data->kode}}" data-nama="{{$data->nama}}">{{$data->kode}} - {{$data->nama}}</option>
                                                            @endforeach
                                                        </select>
                                                        <!-- Tombol check yang sejajar dengan dropdown -->
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-secondary" id="acceptICD10">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row align-items-center">
                                                        <label for="icd9" class="ml-2 col-form-label">Tindakan (ICD 9)</label>
                                                        <div class="ml-1">
                                                            <!-- Tombol yang akan menampilkan kode ICD 9 -->
                                                            <button type="button" class="ml-2 btn btn-default" id="kodeICD9">KODE ICD 9</button>
                                                            <!-- Dropdown Prioritas -->
                                                            <button type="button" class="ml-2 btn btn-default dropdown-toggle" id="dropdownMenuButtonICD9" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span id="prioritas_icd_9" class="caret">Pilih</span>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonICD9">
                                                                <li><a class="dropdown-item" data-value="Primary">Primary</a></li>
                                                                <li><a class="dropdown-item" data-value="Sekunder">Sekunder</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <!-- Dropdown ICD 9 menggunakan -->
                                                    <div class="input-group" style="display: flex; align-items: center;">
                                                        <select class="form-control select2bs4" style="width: 80%;" id="icd9" name="icd9">
                                                            <option value="" disabled selected>-- Pilih --</option>
                                                            @foreach ($icd9 as $data)
                                                                <option value="{{$data->id}}" data-code="{{$data->kode}}" data-nama="{{$data->nama}}">{{$data->kode}} - {{$data->nama}}</option>
                                                            @endforeach
                                                        </select>
                                                        <!-- Tombol Accept -->
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-secondary" id="acceptICD9">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive no-margin" style="padding: 13px;"> <!-- Padding untuk jarak -->
                                        <table class="table table-bordered no-padding icd" width="100%" style="border-spacing: 0; border-collapse: collapse;">
                                            <tbody>
                                                <tr class="kosong">
                                                    <td colspan="4" style="text-align:center;">Data Tidak Ada</td>
                                                </tr>

                                                <tr class="isi_10">
                                                    <td valign="top" width="200px" style="vertical-align: middle;"> Diagnosa/Penyakit/ICD 10 </td>
                                                    <td valign="top" width="1px" style="vertical-align: middle;"> : </td>
                                                    <td valign="top">
                                                        <table width="100%" cellpadding="3px" cellspacing="0" class="icd_10">
                                                            <thead>
                                                                <tr align="center">
                                                                    <td valign="top" width="100px" style="border: none;">Kode</td>
                                                                    <td valign="top" style="border: none;">Nama Penyakit</td>
                                                                    <td valign="top" width="100px" style="border: none;">Prioritas</td>
                                                                    <td valign="top" width="100px" style="border: none;">Aksi</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($diagnosas as $item)
                                                                    <tr align="center" data-id="{{ $item->id }}">
                                                                        <td valign="top" style="border: none;">{{ $item->kode }}</td>
                                                                        <td valign="top" style="border: none;">{{ $item->icd10->nama }}</td>
                                                                        <td valign="top" style="border: none;">{{ $item->prioritas }}</td>
                                                                        <td valign="top" style="border: none;">
                                                                            <button type="button" class="btn btn-danger btn-sm deleteICD10">Hapus</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr class="isi_9">
                                                    <td valign="top" width="250px" style="vertical-align: middle;">Tindakan/Penyakit/ICD 9</td>
                                                    <td valign="top" width="1px" style="vertical-align: middle;">:</td>
                                                    <td valign="top">
                                                        <table width="100%" cellpadding="3px" cellspacing="0" class="icd_9">
                                                            <tbody>
                                                                <tr align="center">
                                                                    <td valign="top" width="100px" style="border: none;">Kode</td>
                                                                    <td valign="top" style="border: none;">Nama Tindakan</td>
                                                                    <td valign="top" width="100px" style="border: none;">Prioritas</td>
                                                                    <td valign="top" width="100px" style="border: none;">Aksi</td>
                                                                </tr>
                                                                <!-- Baris baru akan ditambahkan di sini -->
                                                                @foreach($prosedur as $item)
                                                                    <tr align="center" data-id="{{ $item->id }}">
                                                                        <td valign="top" style="border: none;">{{ $item->kode }}</td>
                                                                        <td valign="top" style="border: none;">{{ $item->icd9->nama }}</td>
                                                                        <td valign="top" style="border: none;">{{ $item->prioritas }}</td>
                                                                        <td valign="top" style="border: none;">
                                                                            <button type="button" class="btn btn-danger btn-sm deleteICD9">Hapus</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-floppy-disk"></i> Simpan
                                        </button>
                                        {{-- <button type="button" class="ml-2 btn btn-secondary" id="toggleICD">
                                            <i class="fa fa-print"></i> ICD 10 & 9
                                        </button> --}}
                                        {{-- <button type="button" class="ml-2 btn btn-info">
                                            <i class="fa fa-history"></i> Riwayat
                                        </button>
                                        <button type="button" class="ml-2 btn btn-success">
                                            <i class="fa fa-check"></i> Selesai
                                        </button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="col-12">
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
                                        <th>Tensi(mmHg)</th>
                                        <th>Suhu(C)</th>
                                        <th>Nadi(menit)</th>
                                        <th>RR(menit)</th>
                                        <th>Tinggi(cm)</th>
                                        <th>Berat(Kg)</th>
                                        <th>SPO2</th>
                                        <th>L. Perut</th>
                                        <th>Alergi</th>
                                        <th>Instruksi & Evaluasi</th>
                                        {{-- <th>Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pemeriksaans as $index => $pemeriksaan)
                                    <tr>
                                        <td rowspan="10" style="vertical-align:top;">{{ $index + 1 }}</td>
                                        <td rowspan="10" style="vertical-align:top;white-space: nowrap;">{{ $pemeriksaan->tgl_kunjungan }}<br>{{ $pemeriksaan->time }}</td>
                                        <td>{{ $pemeriksaan->tensi }}</td>
                                        <td>{{ $pemeriksaan->suhu }}</td>
                                        <td>{{ $pemeriksaan->nadi }}</td>
                                        <td>{{ $pemeriksaan->rr }}</td>
                                        <td>{{ $pemeriksaan->tinggi_badan }}</td>
                                        <td>{{ $pemeriksaan->berat_badan }}</td>
                                        <td>{{ $pemeriksaan->spo2 }}</td>
                                        <td>{{ $pemeriksaan->lingkar_perut }}</td>
                                        <td>{{ $pemeriksaan->alergi }}</td>
                                        <td rowspan="9" style="vertical-align:top;">
                                            <b>Instruksi:</b> {{ $pemeriksaan->instruksi }}<br><br>
                                            <b>Evaluasi:</b> {{ $pemeriksaan->evaluasi }}<br><br>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>GCS (E, V, M)</b></td>
                                        <td colspan="8">{{ $pemeriksaan->nilai_eye->nama }}, {{ $pemeriksaan->nilai_verbal->nama }}, {{ $pemeriksaan->nilai_motorik->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Kesadaran</b></td>
                                        <td colspan="8"> {{ $pemeriksaan->gcs_nilai->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Lingkar Perut</b></td>
                                        <td colspan="8"> {{ $pemeriksaan->lingkar_perut }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Subyektif</b></td>
                                        <td colspan="8">{{ implode(', ', json_decode($pemeriksaan->subyektif)) }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Obyektif</b></td>
                                        {{-- <td colspan="8"> {{ strip_tags($pemeriksaan->htt_pemeriksaan) }} </td> --}}
                                        <td colspan="8">
                                            <?php
                                            $data = $pemeriksaan->htt_pemeriksaan;

                                            // Tambahkan newline setelah setiap <h3> agar data kelompok baru dimulai di baris baru
                                            $data = preg_replace('/<\/?h3[^>]*>/', "\n", $data);

                                            // Ganti semua <h4> dan <h5> dengan spasi agar tetap dalam satu baris
                                            $data = preg_replace('/<\/?h[4-5][^>]*>/', ' ', $data);

                                            // Hapus semua tag HTML yang tersisa
                                            $data = strip_tags($data);

                                            // Hilangkan spasi berlebih
                                            $data = trim(preg_replace('/\s+/', ' ', $data));

                                            // Tampilkan dengan nl2br agar newline (\n) bisa muncul sebagai <br>
                                            echo nl2br($data);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Cerita Dokter</b></td>
                                        <td colspan="8"> {{ $pemeriksaan->cerita_dokter }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Assesment</b></td>
                                        <td colspan="8"> {{ $pemeriksaan->assessmen }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Plan</b></td>
                                        <td colspan="8"> {{ $pemeriksaan->plan }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">
                                            <form action="{{ route('layanan.rawat-jalan.soap-dokter.index.delete',base64_encode($pemeriksaan->no_rawat)) }}" method="POST" style="display:inline;">
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
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


<!-- Modal untuk menampilkan hasil rekaman -->
<div class="modal fade" id="speechModal" tabindex="-1" role="dialog" aria-labelledby="speechModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="speechModalLabel">Hasil Record Suara</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" id="hidden_text" name="speech_text"></textarea>
            </div>
        </div>
    </div>
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

    {{-- Data Lama --}}
    <script>
        document.getElementById("open-tab-btn").addEventListener("click", function (event) {
            event.preventDefault(); // Mencegah tombol bertindak sebagai submit

            // Ambil nilai no_rm dari input SOAP (gantilah "no_rm" jika ID berbeda)
            let no_rm = document.getElementById("no_rm").value.trim();

            if (no_rm === "") {
                alert("Masukkan No RM terlebih dahulu!");
                return;
            }

            // Buka tab baru ke /data-lama/pemeriksaan dengan no_rm sebagai parameter
            window.open(`/data-lama/pemeriksaan?no_rm=${no_rm}`, '_blank');
        });
    </script>

    {{-- speek to text --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if ('webkitSpeechRecognition' in window) {
                var recognition = new webkitSpeechRecognition();
                recognition.continuous = true;  // Memastikan rekaman tetap berjalan
                recognition.interimResults = true;
                recognition.lang = 'id-ID';

                var recognizing = false;
                var final_transcript = '';

                recognition.onstart = function () {
                    recognizing = true;
                    document.getElementById("record_button").innerHTML = '<i class="fa-solid fa-microphone-lines-slash"></i>';
                    console.log("Rekaman dimulai...");
                };

                recognition.onresult = function (event) {
                    let interim_transcript = '';
                    for (let i = event.resultIndex; i < event.results.length; ++i) {
                        if (event.results[i].isFinal) {
                            final_transcript += event.results[i][0].transcript + ' ';
                        } else {
                            interim_transcript += event.results[i][0].transcript + ' ';
                        }
                    }

                    // Simpan hasil transkripsi ke input hidden
                    document.getElementById("hidden_text").value = final_transcript.trim();
                    console.log("Hasil rekaman (final):", final_transcript.trim());
                    console.log("Hasil sementara:", interim_transcript.trim());
                };

                recognition.onerror = function (event) {
                    console.error("Error:", event.error);
                    if (event.error === 'no-speech') {
                        console.log("Tidak ada suara terdeteksi.");
                    } else if (event.error === 'audio-capture') {
                        console.log("Mikrofon tidak ditemukan.");
                    } else if (event.error === 'not-allowed') {
                        console.log("Izin mikrofon tidak diberikan.");
                    }
                };

                recognition.onend = function () {
                    console.log("Rekaman berhenti...");
                    if (recognizing) {
                        console.log("Restarting recognition...");
                        recognition.start();  // Restart jika user belum menekan stop
                    } else {
                        document.getElementById("record_button").innerHTML = '<i class="fa-solid fa-microphone-lines"></i>';
                    }
                };

                document.getElementById("record_button").addEventListener("click", function () {
                    if (recognizing) {
                        recognizing = false;
                        recognition.stop();
                        console.log("Perekaman dihentikan oleh user.");
                        let data = document.getElementById("hidden_text").value;
                        console.log("Mengirim teks ke Laravel:", data);

                        // Kirim ke Laravel hanya jika ada data
                        if (data !== "") {
                            sendDataToServerspek(data);
                        }
                    } else {
                        final_transcript = '';  // Reset transkrip sebelum mulai
                        document.getElementById("hidden_text").value = '';
                        recognizing = true;
                        recognition.start();
                        console.log("Perekaman dimulai.");
                    }
                });

                function sendDataToServerspek(text) {
                    const dataToSend = { "question": text };

                    fetch('/speech-to-ai', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(dataToSend)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(result => {
                        extractAndFillSOAP(result);
                        console.log('Response from server:', result);
                    })
                    .catch(error => {
                        console.error('Error occurred:', error.message);
                        alert(`Error occurred: ${error.message}`);
                    });
                }

                function extractAndFillSOAP(response) {
                try {
                    // Ekstrak JSON dari teks menggunakan regex
                    const jsonMatch = response.ai_response.text.match(/```json\n([\s\S]*?)\n```/);
                    if (!jsonMatch) {
                        console.error("JSON tidak ditemukan dalam respons.");
                        return;
                    }

                    // Parse JSON
                    const soapData = JSON.parse(jsonMatch[1]);

                    console.log(soapData);
                    // Masukkan data ke dalam input masing-masing
                    document.getElementById("instruksi").value = Array.isArray(soapData.Objective) ? soapData.Objective.join(", ") : soapData.Objective;
                    document.getElementById("assessmen").value =  Array.isArray(soapData.Assessment) ? soapData.Assessment.join(", ") : soapData.Assessment;
                    document.getElementById("plan").value =  Array.isArray(soapData.Plan) ? soapData.Plan.join(", ") : soapData.Plan;

                    console.log("Data SOAP berhasil dimasukkan ke dalam input form.");
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                }
            }
            } else {
                alert("Browser tidak mendukung Web Speech API. Gunakan Chrome terbaru.");
            }
        });
    </script>

    {{-- dari data perawat ke dokter --}}
    <script>
        let dataArray = []; // Array untuk menyimpan data sementara

        document.addEventListener('DOMContentLoaded', function () {
            const noRawat = "{{ $rajaldata->no_rawat }}"; // Gunakan nilai no_rawat yang tersedia
            const inputtableData = document.getElementById('tableData');
            const inputSistol = document.getElementById('sistol');
            const inputDistol = document.getElementById('distol');
            const inputTensi = document.getElementById('tensi');
            const inputSuhu = document.getElementById('suhu');
            const inputNadi = document.getElementById('nadi');
            const inputRR = document.getElementById('rr');
            const inputTinggi = document.getElementById('tinggi');
            const inputBerat = document.getElementById('berat');
            const inputEye = document.getElementById('eye');
            const inputVerbal = document.getElementById('verbal');
            const inputMotorik = document.getElementById('motorik');
            const inputSadar = document.getElementById('sadar');
            const inputSpo2 = document.getElementById('spo2');
            const inputAlergi = document.getElementById('alergi');
            const inputLingkarPerut = document.getElementById('lingkar_perut');
            const inputNilaiBMI = document.getElementById('nilai_bmi');
            const inputStatusBMI = document.getElementById('status_bmi');

            // Encode no_rawat untuk menangani karakter spesial
            const encodedNoRawat = encodeURIComponent(noRawat);

            // Fetch data suhu saat halaman dimuat dengan query string
            fetch(`/api/load-data/soap?no_rawat=${encodedNoRawat}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Log data untuk melihat respons JSON

                    // Pengecekan awal untuk data kosong
                    if (!data.input_perawat || data.input_perawat.length === 0) {
                        alert("Perawat tidak menginputkan Data Subyektif dan Objektif.");
                        return; // Menghentikan eksekusi lebih lanjut jika data tidak ada
                    }

                    // Ambil baris pertama data (sesuai kebutuhan Anda)
                    const perawatData = data.input_perawat[0];

                    // Cek jika stts_soap bernilai 2
                    if (perawatData.stts_soap == 2) {
                        console.log("stts_soap bernilai 2, tidak menjalankan fungsi utama.");
                        return; // Hentikan eksekusi tanpa alert
                    }

                    const tensi = data.input_perawat[0].tensi;
                    const [sistol, distol] = tensi.split('/');
                    inputSistol.value = sistol;
                    inputDistol.value = distol;
                    inputtableData.value = data.input_perawat[0].subyektif;
                    inputTensi.value = data.input_perawat[0].tensi;
                    inputSuhu.value = data.input_perawat[0].suhu;
                    inputNadi.value = data.input_perawat[0].nadi;
                    inputRR.value = data.input_perawat[0].rr;
                    inputTinggi.value = data.input_perawat[0].tinggi_badan;
                    inputBerat.value = data.input_perawat[0].berat_badan;
                    inputSpo2.value = data.input_perawat[0].spo2;
                    inputAlergi.value = data.input_perawat[0].alergi;
                    inputLingkarPerut.value = data.input_perawat[0].lingkar_perut;
                    inputNilaiBMI.value = data.input_perawat[0].nilai_bmi;
                    inputStatusBMI.value = data.input_perawat[0].status_bmi;
                    const inputHttPemeriksaan= data.input_perawat[0].headtotoe;
                    $('#summernote').summernote('code', inputHttPemeriksaan);

                    const eyeValue = data.input_perawat[0].eye; // Nilai skor dari API atau backend
                    const verbalValue = data.input_perawat[0].verbal; // Nilai verbal
                    const motorikValue = data.input_perawat[0].motorik; // Nilai motorik

                    if (inputEye) {
                        inputEye.value = eyeValue; // Pilih nilai sesuai skor
                        $('#eye').val(eyeValue).trigger('change'); // Jika menggunakan Select2
                    }

                    if (inputVerbal) {
                        inputVerbal.value = verbalValue;
                        $('#verbal').val(verbalValue).trigger('change'); // Jika menggunakan Select2
                    }

                    if (inputMotorik) {
                        inputMotorik.value = motorikValue;
                        $('#motorik').val(motorikValue).trigger('change'); // Jika menggunakan Select2
                    }

                    let subyektif = data.input_perawat[0].subyektif; // Data awal

                    try {
                        // Langkah 1: Hilangkan escape karakter pertama
                        let parsedSubyektif = JSON.parse(subyektif);

                        // Langkah 2: Parse string JSON ke array
                        let subyektifData = JSON.parse(parsedSubyektif);

                        // Periksa apakah hasil parsing adalah array
                        if (Array.isArray(subyektifData)) {
                            subyektifData.forEach(item => {
                                const parts = item.match(/^(.*?) sejak (\d+) (.*)$/);
                                if (parts) {
                                    const [_, penyakit, durasi, waktu] = parts; // Destructuring hasil regex
                                    dataArray.push({ penyakit, durasi, waktu });
                                }
                            });
                            console.log("Data Array yang Diproses:", dataArray);
                        } else {
                            console.error("subyektifData bukan array:", subyektifData);
                        }
                    } catch (error) {
                        console.error("Gagal memproses subyektif:", error);
                    }

                    renderTable();
                    const tableData = document.getElementById("tableData");
                    tableData.value = JSON.stringify(dataArray); // Mengubah array menjadi string JSON
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat data sebelumnya. Silakan coba lagi.');
                });
        });

        // Fungsi menambahkan data ke array dan tabel
        function addData() {
            const penyakit = document.getElementById("penyakit").value;
            const durasi = document.getElementById("durasi").value;
            const waktu = document.getElementById("waktu").value;

            if (!penyakit || !durasi || !waktu) {
                alert("Semua kolom harus diisi!");
                console.log("Input tidak lengkap");
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
            $('#waktu').val(''); // Menambahkan reset untuk field 'waktu'

            // Setelah data ditambahkan, ubah dataArray menjadi JSON dan simpan di input hidden
            const tableData = document.getElementById("tableData");
            tableData.value = JSON.stringify(dataArray); // Mengubah array menjadi string JSON
        }

        // Fungsi untuk merender tabel
        function renderTable() {
            const tableBody = document.getElementById("SubTabel").querySelector("tbody");
            console.log("Merender tabel...");

            // Kosongkan isi tabel terlebih dahulu
            tableBody.innerHTML = "";

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

    {{-- SCRIPT AI DOLPHI --}}
    <script>
        // Fungsi untuk mendapatkan data dari form dan menggabungkannya menjadi satu string
        function getFormData() {
            let summernoteContent = document.getElementById('summernote').value;
            // Buat elemen sementara untuk menghapus format HTML
            let tempElement = document.createElement("div");
            tempElement.innerHTML = summernoteContent;

            // Ambil hanya teks tanpa format & gambar
            let pureText = tempElement.innerText || tempElement.textContent;
            let formData = {
                subyektif: document.getElementById('tableData').value,
                tensi: document.getElementById('tensi').value,
                suhu: document.getElementById('suhu').value,
                nadi: document.getElementById('nadi').value,
                rr: document.getElementById('rr').value,
                tinggi: document.getElementById('tinggi').value,
                berat: document.getElementById('berat').value,
                eye: document.getElementById('eye').value,
                verbal: document.getElementById('verbal').value,
                motorik: document.getElementById('motorik').value,
                sadar: document.getElementById('sadar').value,
                spo2: document.getElementById('spo2').value,
                alergi: document.getElementById('alergi').value,
                lingkarPerut: document.getElementById('lingkar_perut').value,
                assessment: document.getElementById('assessmen').value,
                summernote: pureText,
                cerita: document.getElementById('cerita_dokter').value,
            };


            // Gabungkan data menjadi satu teks yang berkesinambungan
            const combinedData = `
                S: ${formData.subyektif}.
                Tensi: ${formData.tensi}, Suhu: ${formData.suhu}°C, Nadi: ${formData.nadi} bpm, RR: ${formData.rr}x/menit.
                TB: ${formData.tinggi} cm, BB: ${formData.berat} kg, LP: ${formData.lingkarPerut} cm.
                GCS: E${formData.eye} V${formData.verbal} M${formData.motorik}, Sadar: ${formData.sadar}, SpO2: ${formData.spo2}%.
                Alergi: ${formData.alergi}.
                Pemeriksaan Head-to-Toe: ${formData.summernote}.
                Keluhan: ${formData.cerita}.
                Assessment: ${formData.assessment}.

            `.trim(); // Menghapus spasi atau baris ekstra

            return { question: combinedData };
        }

        // Fungsi untuk mengirim data ke server
        function sendDataToServer() {
            // Ambil data form
            const dataToSend = getFormData();
            console.log(JSON.stringify(dataToSend));

            // Mengirim data ke controller Laravel
            fetch('/predict', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF Token
                },
                body: JSON.stringify(dataToSend)
            })
            .then(response => {
                // Periksa apakah respons HTTP berhasil
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json(); // Parsing JSON dari respons
            })
            .then(result => {
                // Cetak hasil JSON ke konsol
                console.log('Response from server:', result);

                // Periksa apakah status dalam respon adalah success
                if (result.status === 'success') {
                    const resultText = result.data.text;

                    if (resultText) {
                        // Menampilkan hasil di jendela baru
                        openResultInNewWindow(resultText);
                    } else {
                        console.warn('No message content found in the response.');
                        alert('No message content found in the response.');
                    }
                } else {
                    console.error('Error from server:', result.message);
                    alert(`Error from server: ${result.message}`);
                }
            })
            .catch(error => {
                console.error('Error occurred:', error.message);
                alert(`Error occurred: ${error.message}`);
            });
        }

        // Fungsi untuk menampilkan hasil pada jendela baru
        function openResultInNewWindow(resultText) {
            const newWindow = window.open("", "_blank", "width=800,height=600");

            if (newWindow) {
                newWindow.document.write(`
                    <html>
                    <head>
                        <title>Dolphi AI Result</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; color: #333; line-height: 1.6; }
                            h2 { color: #007bff; text-align: center; }
                            pre { background-color: #f4f4f4; padding: 10px; border-radius: 5px; font-size: 14px; white-space: pre-wrap; word-wrap: break-word; }
                        </style>
                    </head>
                    <body>
                        <h2>Hasil Prediksi Dolphi AI</h2>
                        <pre>${resultText}</pre>
                    </body>
                    </html>
                `);
                newWindow.document.close();
            } else {
                alert('Popup blocked! Please allow popups for this website.');
            }
        }

        // Event listener untuk tombol 'Bantuan Dholpi AI'
        document.getElementById('ai').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah pengiriman form secara default

            // Kirim data ke server
            sendDataToServer();
        });
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
            const url = "{{ route('layanan.rawat-jalan.soap-dokter.index.resep.obat', ['norm' => ':norm']) }}".replace(':norm', norm);

            // Jika jendela sudah dibuka dan belum ditutup, fokus pada jendela itu
            if (patientWindow && !patientWindow.closed) {
                patientWindow.focus();
            } else {
                // Jika belum ada jendela atau jendela sebelumnya ditutup, buka jendela baru
                patientWindow = window.open(url, "_blank", "width=800,height=600");
            }
        }

    </script>

    {{-- SCRIPT GIGI --}}
    <script>
        let patientWindowanot = null; // Variabel untuk menyimpan referensi jendela yang sudah dibuka

        function bukaJendelaPasienanotomi(norm) {
            const url = "{{ route('layanan.rawat-jalan.soap-dokter.index.odontogram', ['norm' => ':norm']) }}".replace(':norm', norm);

            // Jika jendela sudah dibuka dan belum ditutup, fokus pada jendela itu
            if (patientWindowanot && !patientWindowanot.closed) {
                patientWindowanot.focus();
            } else {
                // Jika belum ada jendela atau jendela sebelumnya ditutup, buka jendela baru
                patientWindowanot = window.open(url, "_blank", "width=1280,height=800");
            }
        }

    </script>

    {{-- diet --}}
    <script>
        function diet(norm) {
            const url = "{{ route('soap.diet', ['norm' => ':norm']) }}".replace(':norm', norm);


            // Membuka jendela baru dengan URL yang sudah disiapkan
            window.open(url, "_blank", "width=800,height=600");
        }
    </script>

    {{-- layanan --}}
    <script>
        function layanan(norm) {
            const url = "{{ route('layanan.rawat-jalan.soap-dokter.index.tindakan', ['norm' => ':norm']) }}".replace(':norm', norm);

            // Membuka jendela baru dengan URL yang sudah disiapkan
            window.open(url, "_blank" );
        }
    </script>

    {{-- icd load data--}}
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

    {{-- script untuk membuka card ICD --}}
    <script>
        document.getElementById('toggleICD').addEventListener('click', function() {
            var icdCard = document.getElementById('icdCard');

            // Memeriksa apakah card sedang ditampilkan atau disembunyikan
            if (icdCard.style.display === "none" || icdCard.style.display === "") {
                icdCard.style.display = "block";  // Menampilkan card
            } else {
                icdCard.style.display = "none";  // Menyembunyikan card
            }
        });
    </script>

    {{-- Final Script untuk ICD-10 --}}
    <script>
        $(document).ready(function () {
            var selectedICD10 = null;
            var selectedPriorityICD10 = null;

            // Event listener for ICD-10 select dropdown
            $('#icd10').on('change', function () {
                var selectedOption = $(this).find('option:selected');
                selectedICD10 = {
                    code: selectedOption.val(),
                    name: selectedOption.data('nama')
                };
                // Display the selected code on the button
                $('#kodeICD10').text(selectedICD10.code);
            });

            // Event listener for priority dropdown items, specifically for ICD-10
            $('#dropdownMenuButtonICD10').next('.dropdown-menu').find('.dropdown-item').on('click', function () {
                selectedPriorityICD10 = $(this).data('value');
                // Display the selected priority in the span
                $('#prioritas_icd_10').text(selectedPriorityICD10);
            });

            // Event listener for clicking the Accept button
            $('#acceptICD10').on('click', function () {
                if (!selectedICD10 || !selectedPriorityICD10) {
                    alert('Pilih Diagnosa dan Prioritas!');
                    return;
                }

                // Check if the selected ICD-10 already exists in the table
                var exists = false;
                $('.icd_10 tbody tr').each(function () {
                    var code = $(this).find('td:first').text().trim();
                    if (code === selectedICD10.code) {
                        exists = true;
                        return false; // exit loop if found
                    }
                });

                if (exists) {
                    alert('Data sudah ada di tabel.');
                } else {
                    // Make an AJAX request to save the data to the database
                    $.ajax({
                        url: '{{ route("diagnosa.store") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            no_rawat: '{{ $rajaldata->no_rawat }}',
                            kode: selectedICD10.code,
                            prioritas: selectedPriorityICD10,
                            status_penyakit: 'your_status_value_here' // Set status_penyakit accordingly
                        },
                        success: function (response) {
                            if (response.success) {
                                // Add the new row to the table
                                var newRow = '<tr align="center" data-id="' + response.id + '">' +
                                    '<td valign="top" style="border: none;">' + selectedICD10.code + '</td>' +
                                    '<td valign="top" style="border: none;">' + selectedICD10.name + '</td>' +
                                    '<td valign="top" style="border: none;">' + selectedPriorityICD10 + '</td>' +
                                    '<td valign="top" style="border: none;"><button type="button" class="btn btn-danger btn-sm deleteICD10">Hapus</button></td>' +
                                    '</tr>';
                                $('.icd_10 tbody').append(newRow);

                                const icd10Table = $(".icd_10 tbody");
                                const kosongRow = $(".kosong");
                                kosongRow.hide();  // Hide "Data Tidak Ada" row if either table has data
                                icd10Table.closest(".isi_10").show(); // Show if data is present

                                // Reset the fields after adding the data
                                resetFieldsICD10();
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function (xhr) {
                            alert('Error occurred: ' + xhr.responseText);
                        }
                    });
                }
            });

            // Event listener for removing rows from the ICD-10 table and deleting from the database
            $(document).on('click', '.deleteICD10', function () {
                var row = $(this).closest('tr');
                var id = row.data('id'); // Get the ID from the data-id attribute

                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    // Send an AJAX request to delete the record from the database
                    $.ajax({
                        url: '{{ route("diagnosa.destroy") }}', // Route for deleting
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id  // Pass the ID to delete
                        },
                        success: function (response) {
                            if (response.success) {
                                row.remove(); // Remove the row from the table
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function (xhr) {
                            alert('Error occurred: ' + xhr.responseText);
                        }
                    });
                }
            });

            // Function to reset the form fields after accept
            function resetFieldsICD10() {
                $('#icd10').val('').trigger('change');
                $('#kodeICD10').text('KODE ICD 10');
                $('#prioritas_icd_10').text('Pilih');
                selectedICD10 = null;
                selectedPriorityICD10 = null;
            }
        });
    </script>

    {{-- Final Script ICD-9 --}}
    <script>
        $(document).ready(function () {
            var selectedICD9 = null;
            var selectedPriority = null;

            // Event listener for ICD-9 select dropdown
            $('#icd9').on('change', function () {
                var selectedOption = $(this).find('option:selected');
                selectedICD9 = {
                    id: selectedOption.val(),
                    code: selectedOption.data('code'),
                    name: selectedOption.data('nama')
                };
                // Display the selected code on the button
                $('#kodeICD9').text(selectedICD9.code);
            });

            // Event listener for priority dropdown items, specifically for ICD-9
            $('#dropdownMenuButtonICD9').next('.dropdown-menu').find('.dropdown-item').on('click', function () {
                selectedPriority = $(this).data('value');
                // Display the selected priority in the span
                $('#prioritas_icd_9').text(selectedPriority);
            });

            // Event listener for clicking the Accept button
            $('#acceptICD9').on('click', function () {
                if (!selectedICD9 || !selectedPriority) {
                    alert('Pilih Diagnosa dan Prioritas!');
                    return;
                }

                // Check if the selected ICD-9 already exists in the table
                var exists = false;
                $('.icd_9 tbody tr').each(function () {
                    var code = $(this).find('td:first').text().trim();
                    if (String(code) === String(selectedICD9.code)) {
                        exists = true;
                        return false; // exit loop if found
                    }
                });

                if (exists) {
                    alert('Data sudah ada di tabel.');
                } else {
                    // Make an AJAX request to save the data to the database
                    $.ajax({
                        url: '{{ route("prosedur.store") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            no_rawat: '{{ $rajaldata->no_rawat }}',
                            kode: selectedICD9.code,
                            prioritas: selectedPriority
                        },
                        success: function (response) {
                            if (response.success) {
                                // Add the new row to the table
                                var newRow = '<tr align="center" data-id="' + response.id + '">' +
                                    '<td valign="top" style="border: none;">' + selectedICD9.code + '</td>' +
                                    '<td valign="top" style="border: none;">' + selectedICD9.name + '</td>' +
                                    '<td valign="top" style="border: none;">' + selectedPriority + '</td>' +
                                    '<td valign="top" style="border: none;"><button type="button" class="btn btn-danger btn-sm deleteICD9">Hapus</button></td>' +
                                    '</tr>';
                                $('.icd_9 tbody').append(newRow);

                                const kosongRow = $(".kosong");
                                const icd9Table = $(".icd_9 tbody");
                                kosongRow.hide();  // Hide "Data Tidak Ada" row if either table has data
                                icd9Table.closest(".isi_9").show();

                                // Reset the fields after adding the data
                                resetFields();
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function (xhr) {
                            alert('Error occurred: ' + xhr.responseText);
                        }
                    });
                }
            });

            // Event listener for removing rows from the ICD-9 table and deleting from the database
            $(document).on('click', '.deleteICD9', function () {
                var row = $(this).closest('tr');
                var kode = row.find('td:first').text().trim(); // Get the ICD-9 code from the first column
                var id = row.data('id'); // Get the ID from the data-id attribute

                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    // Send an AJAX request to delete the record from the database
                    $.ajax({
                        url: '{{ route("prosedur.destroy") }}', // Route for deleting
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,  // Pass the ID to delete
                            kode: kode // (Optional) pass the kode if needed
                        },
                        success: function (response) {
                            if (response.success) {
                                row.remove(); // Remove the row from the table
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function (xhr) {
                            alert('Error occurred: ' + xhr.responseText);
                        }
                    });
                }
            });

            // Function to reset the form fields after accept
            function resetFields() {
                $('#icd9').val('').trigger('change');
                $('#kodeICD9').text('KODE ICD 9');
                $('#prioritas_icd_9').text('Pilih');
                selectedICD9 = null;
                selectedPriority = null;
            }
        });
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


@endsection
