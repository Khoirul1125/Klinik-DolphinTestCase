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
                            <h3 class="mb-0 card-title">Apoteker</h3>
                            <div class="text-right card-tools">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#adddoctor">
                                    <i class="fas fa-plus"></i> Tambah Baru
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="doctortbl" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Poli</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Status Pekerja</th>
                                        <th width="20%">Pilihan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Uncomment this to display doctors --}}
                                    {{-- @foreach ($doctors as $doctor)
                                        <tr>
                                            <td>{{ $doctor->nik }}</td>
                                            <td>{{ $doctor->nama_dokter }}</td>
                                            <td>{{ $doctor->jabatans->nama}}</td>
                                            <td>{{ $doctor->polis->nama_poli }}</td>
                                            <td>{{ $doctor->seks }}</td>
                                            <td>{{ $doctor->statdok->nama }}</td>
                                            <td class="text-center">
                                                <div class="d-inline-flex gap-3"> <!-- Gunakan gap-3 untuk jarak lebih besar -->
                                                    <span>
                                                        <a href="#" class="btn btn-flat btn-info d-flex align-items-center justify-content-center shadow-sm"
                                                           style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;">
                                                           <i class="fas fa-user" style="margin-right: 5px;"></i> Lengkapi Data
                                                        </a>
                                                    </span>
                                                    <span>
                                                        <a href="#" class="btn btn-flat btn-warning d-flex align-items-center justify-content-center shadow-sm"
                                                           style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;">
                                                            <i class="fa fa-edit" style="margin-right: 5px;"></i> Edit
                                                        </a>
                                                    </span>
                                                    <span>
                                                        <a href="#" class="btn btn-flat btn-danger d-flex align-items-center justify-content-center shadow-sm"
                                                           style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;">
                                                            <i class="fa fa-edit" style="margin-right: 5px;"></i> Hapus
                                                        </a>
                                                    </span>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach --}}
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

<!-- Modal for Add Doctor -->
<div class="modal fade" id="adddoctor" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Identitas Apoteker</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('doctor.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div>
                                <!-- Bingkai Gambar dengan Rasio 3:4 -->
                                <div id="imageFrame" style="display: flex; justify-content: center; align-items: center; width: 80%; height: 0; padding-bottom: 110%; position: relative; overflow: hidden; background-color: #f0f0f0; cursor: pointer; margin-top: 75px; margin-left: 20px;" onclick="document.getElementById('foto').click();">
                                    <!-- Gambar Profil Pengguna -->
                                    <img class="profile-user-img img-fluid" alt="Foto profile" id="previewImage" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <!-- Input file disembunyikan, akan di-trigger oleh klik pada imageFrame -->
                                <input type="file" class="form-control d-none" id="foto" name="foto" accept="image/*" onchange="previewImage(event)">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h3 style="text-align: left;">BIODATA</h3>
                            <div class="col-2" style="padding-left: 0; text-align: left;">
                                <hr style="width: 85%; margin-left: 0;">
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="nama" class="form-control" id="nama_apoteker" name="nama_apoteker">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Alamat </label>
                                        <input type="text" class="form-control" placeholder="Alamat" id="Alamat" name="Alamat" value="{{ old('Alamat') }}" >
                                    </div>
                                    @error('Alamat')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Nomer KTP</label>
                                        <input type="ktp" class="form-control" id="ktp" name="ktp">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="nik" name="nik"  oninput="cekSatuSehat()" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tempat Tanggal Lahir</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat" style="width: 60%;">
                                            <input type="date" class="form-control" id="expspri" name="expspri" style="width: 40%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Provinsi</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="provinsi" name="provinsi">
                                            <option value="" disabled selected >Provinsi</option>
                                            @foreach ($provinsi as $item)
                                                <option value="{{ $item->kode }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Kota/Kabupaten</label>
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="kota_kabupaten" name="kota_kabupaten" >
                                            <option value="" disabled selected>Kota/Kabupaten</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Kecamatan</label>
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}">
                                            <option value="" disabled selected>Kecamatan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Desa/Kelurahan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="desa" name="desa" value="{{ old('desa') }}">
                                            <option value="" disabled selected>Desa/Kelurahan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label>RT </label>
                                        <input type="text" class="form-control" placeholder="001" id="rt" name="rt" value="{{ old('rt') }}" >
                                    </div>
                                    @error('rt')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label>RW </label>
                                        <input type="text" class="form-control" placeholder="002" id="rw" name="rw" value="{{ old('rw') }}" >
                                    </div>
                                    @error('rw')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Kode Pos </label>
                                        <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" >
                                    </div>
                                    @error('kode_pos')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Seks</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="seks" name="seks">
                                            @foreach ($sex as $data)
                                                <option value="{{$data->id}}">{{$data->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Status Pernikahan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="pernikahan" name="pernikahan">
                                            <option value="" disabled selected>--- pilih ---</option>
                                            <option value="menikah" {{ old('pernikahan') == 'menikah' ? 'selected' : '' }}>Menikah</option>
                                            <option value="belum_nikah" {{ old('pernikahan') == 'belum_nikah' ? 'selected' : '' }}>Belum Menikah</option>
                                            <option value="cerai_hidup" {{ old('pernikahan') == 'cerai_hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                            <option value="cerai_mati" {{ old('pernikahan') == 'cerai_mati' ? 'selected' : '' }}>Cerai Mati</option>
                                        </select>
                                        @error('pernikahan')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Golongan Darah</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="goldar" name="goldar">
                                            <option value="" disabled selected>--- pilih ---</option>
                                            @foreach ($goldar as $data)
                                                <option value="{{ $data->id }}" {{ old('goldar') == $data->id ? 'selected' : '' }}>
                                                    {{ $data->nama }} {{ $data->resus }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('goldar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Kewarganegaraan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="kewarganegaraan" name="kewarganegaraan">
                                            <option value="" {{ old('kewarganegaraan') == '' ? 'selected' : '' }}>--- pilih ---</option>
                                            <option value="wni" {{ old('kewarganegaraan') == 'wni' ? 'selected' : '' }}>Warga Negara Indonesia</option>
                                            <option value="wna" {{ old('kewarganegaraan') == 'wna' ? 'selected' : '' }}>Warga Negara Asing</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Agama</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="agama" name="agama">
                                            <option value="" disabled selected>--- pilih ---</option>
                                            <option value="islam" {{ old('agama') == 'islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="katolik" {{ old('agama') == 'katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                                            <option value="protestan" {{ old('agama') == 'protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                            <option value="hindu" {{ old('agama') == 'hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="buddha" {{ old('agama') == 'buddha' ? 'selected' : '' }}>Buddha</option>
                                            <option value="khonghucu" {{ old('agama') == 'khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                        </select>
                                        @error('agama')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Suku</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="suku" name="suku">
                                            @foreach ($suku as $data)
                                                <option value="{{ $data->id }}" {{ old('suku') == $data->id ? 'selected' : '' }}>
                                                    {{ $data->nama_suku }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('suku')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Bangsa</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="bangsa" name="bangsa">
                                            @foreach ($bangsa as $data)
                                                <option value="{{ $data->id }}" {{ old('bangsa') == $data->id ? 'selected' : '' }}>
                                                    {{ $data->nama_bangsa }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bangsa')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Bahasa</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="bahasa" name="bahasa">
                                            @foreach ($bahasa as $data)
                                                <option value="{{ $data->id }}" {{ old('bahasa') == $data->id ? 'selected' : '' }}>
                                                    {{ $data->bahasa }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bahasa')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="Email" class="form-control" id="email" name="email">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" id="username" name="username" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" id="password" name="password" autocomplete >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Telepon</label>
                                        <input type="text" class="form-control" id="telepon" name="telepon">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <h3 style="text-align: left;">STATUS</h3>
                            <div class="col-2" style="padding-left: 0; text-align: left;">
                                <hr style="width: 55%; margin-left: 0;">
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tanggal Masuk</label>
                                        <input type="date" class="form-control" id="tglawal" name="tglawal" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="aktivasi" name="aktivasi">
                                            <option value="">--- pilih ---</option>
                                            <option value="aktif">Aktif</option>
                                            <option value="tidak aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="poli" name="poli">
                                            <option value="" disabled selected>--- Pilih Unit ---</option>
                                            @foreach ($poli as $poli)
                                            <option value="{{$poli->id}}">{{$poli->nama_poli}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="jabatan" name="jabatan">
                                            <option value="" disabled selected>--- Pilih Jabatan ---</option>
                                            @foreach ($jabatan as $jabatan)
                                            <option value="{{$jabatan->id}}">{{$jabatan->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nomor NPWP</label>
                                        <input type="text" class="form-control" id="npwp" name="npwp">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nomor STR</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="str" name="str" style="width: 60%;">
                                            <input type="date" class="form-control" id="expstr" name="expstr" style="width: 40%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Nomor SIP </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="sip" name="sip" placeholder="Nomor SIP" style="width: 60%;">
                                            <input type="date" class="form-control" id="expspri" name="expspri" style="width: 40%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Nomor PK </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="sip" name="pk" placeholder="Nomor PK" style="width: 60%;">
                                            <input type="date" class="form-control" id="expspri" name="expspri" style="width: 40%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>ID Satu Sehat</label>
                                        <input type="text" class="form-control" id="kode" name="kode" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Nomor NPWP</label>
                                        <input type="text" class="form-control" id="npwp" name="npwp">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <h3 style="text-align: left;">PENDIDIKAN</h3>
                                        <div class="col-2" style="padding-left: 0; text-align: left;">
                                            <hr style="width: 90%; margin-left: 0;">
                                        </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Pendidikan</label>
                                                <select class="form-control select2bs4" style="width: 100%;" id="pendidikan" name="pendidikan">
                                                    <option value="" disabled selected>--- pilih ---</option>
                                                    <option value="sd" {{ old('pendidikan') == 'sd' ? 'selected' : '' }}>SD</option>
                                                    <option value="smp" {{ old('pendidikan') == 'smp' ? 'selected' : '' }}>SMP</option>
                                                    <option value="sma" {{ old('pendidikan') == 'sma' ? 'selected' : '' }}>SMA</option>
                                                    <option value="diploma" {{ old('pendidikan') == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                                    <option value="s1" {{ old('pendidikan') == 's1' ? 'selected' : '' }}>Sarjana</option>
                                                    <option value="s2" {{ old('pendidikan') == 's2' ? 'selected' : '' }}>Magister</option>
                                                    <option value="s3" {{ old('pendidikan') == 's3' ? 'selected' : '' }}>Doctoral Degree</option>
                                                </select>
                                                @error('pendidikan')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Status Pekerja</label>
                                                <select class="form-control select2bs4"  style="width: 100%;"  id="status_kerja" name="status_kerja">
                                                    <option value="" disabled selected>--- Pilih Status ---</option>
                                                    @foreach ($status as $status)
                                                    <option value="{{$status->id}}">{{$status->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control select2bs4" style="width: 100%;" id="aktivasi" name="aktivasi">
                                                    <option value="">--- pilih ---</option>
                                                    <option value="aktif">Aktif</option>
                                                    <option value="tidak aktif">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <input type="hidden" id="userinput" name="userinput" value="{{ auth()->user()->name }}">
                        <input type="hidden" id="userinputid" name="userinputid" value="{{ auth()->user()->id }}">

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
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('foto').addEventListener('change', function(event) {
            var reader = new FileReader();

            reader.onload = function() {
                var output = document.getElementById('previewImage');
                output.src = reader.result; // Menampilkan gambar pratinjau
            };

            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    });

</script>
<script>
   $(document).ready(function () {
    $('#nik').on('blur', function () {
        var nik = $(this).val();
        $('#username').val(nik);
    });
});

</script>
<script>
    $(document).ready(function() {
        // Trigger change event when user selects a provinsi
        $('#provinsi').on('change', function() {
            var kodeProvinsi = $(this).val();

            // Clear previous options in kota_kabupaten, kecamatan, and desa select boxes
            $('#kota_kabupaten').empty().append('<option value="" disabled selected>Kota/Kabupaten</option>');
            $('#kecamatan').empty().append('<option value="" disabled selected>Kecamatan</option>');
            $('#desa').empty().append('<option value="" disabled selected>Desa</option>');

            if (kodeProvinsi) {
                $.ajax({
                    url: '{{ route("wilayah.getKabupaten") }}', // Route to fetch kabupaten
                    type: 'GET',
                    data: { kode_provinsi: kodeProvinsi },
                    success: function(response) {
                        $.each(response, function(index, kabupaten) {
                            $('#kota_kabupaten').append('<option value="' + kabupaten.kode + '">' + kabupaten.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching kabupaten:', error);
                    }
                });
            }
        });

        // Trigger change event when user selects a kabupaten
        $('#kota_kabupaten').on('change', function() {
            var kodeKabupaten = $(this).val();

            // Clear previous options in kecamatan and desa select boxes
            $('#kecamatan').empty().append('<option value="" disabled selected>Kecamatan</option>');
            $('#desa').empty().append('<option value="" disabled selected>Desa</option>');

            if (kodeKabupaten) {
                $.ajax({
                    url: '{{ route("wilayah.getKecamatan") }}', // Route to fetch kecamatan
                    type: 'GET',
                    data: { kode_kabupaten: kodeKabupaten },
                    success: function(response) {
                        $.each(response, function(index, kecamatan) {
                            $('#kecamatan').append('<option value="' + kecamatan.kode + '">' + kecamatan.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching kecamatan:', error);
                    }
                });
            }
        });

        // Trigger change event when user selects a kecamatan
        $('#kecamatan').on('change', function() {
            var kodeKecamatan = $(this).val();

            // Clear previous options in desa select box
            $('#desa').empty().append('<option value="" disabled selected>Desa</option>');

            if (kodeKecamatan) {
                $.ajax({
                    url: '{{ route("wilayah.getDesa") }}', // Route to fetch desa
                    type: 'GET',
                    data: { kode_kecamatan: kodeKecamatan },
                    success: function(response) {
                        $.each(response, function(index, desa) {
                            $('#desa').append('<option value="' + desa.kode + '">' + desa.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching desa:', error);
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/get-dokter-bpjs',
            method: 'GET',
            success: function(data) {
                if (data.status === 'error') {
                    alert(data.message);
                    return;
                }

                const select = $('#nama_dokter');
                data.data.forEach(dokter => {
                    const option = $('<option></option>')
                        .attr('value', dokter.nama_dokter)
                        .attr('data-kode-dokter', dokter.kode_dokter)
                        .text(dokter.nama_dokter);
                    select.append(option);
                });

                // Initialize select2 for the new select element
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });

                // Update display input when a doctor is selected
                select.on('change', function() {
                    const selectedOption = $(this).find('option:selected');
                    const kodeDokter = selectedOption.data('kode-dokter');
                    const namaDokter = selectedOption.text();
                    console.log('Selected doctor:', namaDokter, kodeDokter);
                    $('#kode_dokter').val(kodeDokter);
                });

                // Debugging: Check if the event listener is attached
                console.log('Event listener attached to select element');
            },
            error: function(error) {
                console.error('Error fetching dokter data:', error);
            }
        });
    });
</script>
<script>
    $(document).on('change', '#tgllahir', function () {
        const tglLahir = $(this).val(); // Ambil nilai dari input tanggal lahir

        if (tglLahir) {
            // Format ulang tanggal lahir menjadi DDMMYYYY
            const formattedDate = tglLahir.split('-').reverse().join('');
            $('#password').val(formattedDate); // Set nilai elemen dengan ID #password
        } else {
            console.error('Tanggal lahir tidak valid.');
        }
    });
</script>
<script>
    function cekSatuSehat(attempts = 0) {
        var jenisKartu = $('#nik').val();
        if (jenisKartu.length === 16) {
            $.ajax({
                url: '/practitionejenisKartu/' + jenisKartu,
                method: 'GET',
                success: function(response) {
                    if (response && response.patient_data && response.patient_data.entry && response.patient_data.entry.length > 0) {
                        var data = response.patient_data.entry[0].resource; // Perbaikan di sini
                        var Nama = data.name[0] ? data.name[0].text : 'Nama Dokter tidak tersedia';
                        var TglLahir = data.birthDate || 'Tanggal Lahir tidak tersedia';
                        var Sex = data.gender || 'Jenis Kelamin tidak tersedia';
                        var Id = data.id || 'ID Satu Sehat tidak tersedia';

                        var Namas = $('#nama').val();
                        $.ajax({
                            url: '/search-matching-names/' + Namas , // Update this URL to match your route
                            type: 'GET',
                            success: function(response) {
                                if (response) {
                                    consol.log(response);
                                } else {
                                    $('#nama').val('Tidak ditemukan');
                                }
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                            }
                        });


                        $('#nama').val(Nama);
                        $('#tgllahir').val(TglLahir);
                        $('#kode').val(Id);
                    } else if (attempts < 3) {
                        cekSatuSehat(attempts + 1);
                    } else {
                        $('#nama').val('Tidak ditemukan');
                        $('#tgllahir').val('Tidak ditemukan');
                        $('#kode').val('Tidak ditemukan');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', status, error);
                    if (attempts < 3) {
                        cekSatuSehat(attempts + 1);
                    } else {
                        alert('Jaringan BPJS mungkin tidak stabil. Silahkan coba kembali.');
                    }
                }
            });
        }
    }
</script>

<script>
    $(document).ready(function() {
        $("#doctortbl").DataTable({
            "responsive": true,
            "autoWidth": false,
            "paging": true,
            "lengthChange": true,
            "buttons": ["csv", "excel", "pdf", "print"],
            "language": {
                "lengthMenu": "Tampil  _MENU_",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
                "search": "Cari :",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Berikutnya"
                }
            }
        }).buttons().container().appendTo('#doctortbl_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection
