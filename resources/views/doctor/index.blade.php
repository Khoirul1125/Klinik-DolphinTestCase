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
                            <h3 class="mb-0 card-title">Dokter</h3>
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
                                        <th width="30%">Pilihan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($doctors as $doctor)
                                        @php
                                            $dataLengkap = \App\Models\data_doctor::where('doctor_id', $doctor->id)->exists();
                                        @endphp

                                        <tr style="background-color: {{ $dataLengkap ? '#d4edda' : '#f8d7da' }};">
                                            <td>{{ $doctor->nik }}</td>
                                            <td>{{ $doctor->nama_dokter }}</td>
                                            <td>{{ $doctor->jabatans->nama }}</td>
                                            <td>{{ $doctor->polis->nama_poli }}</td>
                                            <td>{{ $doctor->seks }}</td>
                                            <td>{{ $doctor->statdok->nama }}</td>
                                            <td class="text-center">
                                                <div class="d-inline-flex gap-3">
                                                    <span>
                                                        @if($dataLengkap)
                                                            <button class="btn btn-flat btn-success d-flex align-items-center justify-content-center shadow-sm"
                                                                style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;"
                                                                disabled>
                                                                <i class="fas fa-check" style="margin-right: 5px;"></i> Sudah Lengkap
                                                            </button>
                                                        @else
                                                            <a href="{{ route('dokter.index.detail', ['id' => $doctor->id]) }}"
                                                               class="btn btn-flat btn-info d-flex align-items-center justify-content-center shadow-sm"
                                                               style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;">
                                                                <i class="fas fa-user" style="margin-right: 5px;"></i> Lengkapi Data
                                                            </a>
                                                        @endif
                                                    </span>
                                                    <span>
                                                        <a href="{{ route('dokter.index.jadwal', ['id' => $doctor->id]) }}"
                                                           class="btn btn-flat btn-primary d-flex align-items-center justify-content-center shadow-sm"
                                                           style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;">
                                                           <i class="fa-regular fa-clock" style="margin-right: 5px;"></i> Jadwal
                                                        </a>
                                                    </span>
                                                    <span>
                                                        <button type="button" class="btn btn-flat btn-warning d-flex align-items-center justify-content-center shadow-sm editBtn"
                                                            style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;"
                                                            data-toggle="modal" data-target="#doctoredit" data-id="{{ $doctor->id }}">
                                                            <i class="fa fa-edit" style="margin-right: 5px;"></i> Edit
                                                        </button>
                                                    </span>
                                                    <span>
                                                        <button type="button" class="btn btn-flat btn-danger d-flex align-items-center justify-content-center shadow-sm"
                                                            style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;"
                                                            data-toggle="modal" data-target="#deletdockter" data-id="{{ $doctor->id }}" data-name="{{ $doctor->nama_dokter }}">
                                                            <i class="fa fa-trash" style="margin-right: 5px;"></i> Hapus
                                                        </button>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-body">
                            <div class="p-2 mb-2" style="background-color: #d4edda; border-left: 5px solid #155724; padding: 10px;">
                                <strong>Hijau:</strong> Data Dokter sudah lengkap.
                            </div>
                            <div class="p-2 mb-2" style="background-color: #f8d7da; border-left: 5px solid #721c24; padding: 10px;">
                                <strong>Merah:</strong> Data Dokter Belum lengkap.
                            </div>
                        </div>
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
<div class="modal fade" id="adddoctor" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Identitas Dokter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dokter.index.add') }}" method="POST" enctype="multipart/form-data">
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
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>
                                            Nama <input type="checkbox" id="manual_check"> Input Manual
                                        </label>
                                        <div class="input-group" id="nama_dokter_container">
                                            <input type="text" class="form-control" id="nama_dokter_input" name="nama_dokter" placeholder="Masukkan Nama Dokter" style="width: 59%; display: none;">
                                            <select class="form-control select2bs4" id="nama_dokter" name="nama_dokter" style="width: 59%;">
                                                <option value="" disabled selected>--- Pilih Dokter ---</option>
                                            </select>
                                            <input type="text" class="form-control" placeholder="Kode Dokter" id="kode_dokter" name="kode_dokter" style="width: 41%;" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Alamat </label>
                                        <input type="text" class="form-control" placeholder="Alamat" id="Alamat" name="Alamat" value="{{ old('Alamat') }}" >
                                    </div>
                                    @error('Alamat')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>NIK / Nomer KTP</label>
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
                                            <input type="date" class="form-control" id="tgllahir" name="tgllahir" style="width: 40%;">
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
                                            <option value="" disabled selected>--- Pilih Jenis Kelamin ---</option>
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
                                            <option value="" disabled selected>--- Pilih Suku ---</option>
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
                                            <option value="" disabled selected>--- Pilih Bangsa ---</option>
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
                                            <option value="" disabled selected>--- Pilih Bahasa ---</option>
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
                                            @foreach ($poli as $poliadd)
                                            <option value="{{$poliadd->id}}">{{$poliadd->nama_poli}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="jabatan" name="jabatan">
                                            <option value="" disabled selected>--- Pilih Jabatan ---</option>
                                            @foreach ($jabatan as $jabatanadd)
                                            <option value="{{$jabatanadd->id}}">{{$jabatanadd->nama}}</option>
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
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nomor SIP </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="sip" name="sip" placeholder="Nomor SIP" style="width: 60%;">
                                            <input type="date" class="form-control" id="expspri" name="expspri" style="width: 40%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Pelatihan Khusus </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="pk" name="pk" placeholder="Nomor PK" style="width: 60%;">
                                            <input type="date" class="form-control" id="exppk" name="exppk" style="width: 40%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>ID Satu Sehat</label>
                                        <input type="text" class="form-control" id="kode" name="kode" >
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
                                                    <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                                                    <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                                    <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                                    <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>Sarjana</option>
                                                    <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>Magister</option>
                                                    <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>Doctoral Degree</option>
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
                                                    @foreach ($status as $statusadd)
                                                    <option value="{{$statusadd->id}}">{{$statusadd->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    {{-- Data Double Status --}}
                                        {{-- <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control select2bs4" style="width: 100%;" id="aktivasi" name="aktivasi">
                                                    <option value="">--- pilih ---</option>
                                                    <option value="aktif">Aktif</option>
                                                    <option value="tidak aktif">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div> --}}
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

<div class="modal fade" id="deletdockter" tabindex="-1" role="dialog" aria-labelledby="deletdockterModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletdockterModalLabel">Hapus Dokter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="deleteDoctorForm" method="POST">
                    @csrf
                    <input type="hidden" name="iddokter" id="iddokter" value="">
                    <h3 id="deleteDoctorMessage">Apakah Anda yakin ingin menghapus data dokter ini?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
                </form>
        </div>
    </div>
</div>

<div class="modal fade" id="doctoredit" tabindex="-1" role="dialog" aria-labelledby="doctoreditModalLabel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doctoreditModalLabel">Edit Identitas Dokter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dokter.index.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div>
                                <!-- Bingkai Gambar dengan Rasio 3:4 -->
                                <div id="imageFrame" style="display: flex; justify-content: center; align-items: center; width: 80%; height: 0; padding-bottom: 110%; position: relative; overflow: hidden; background-color: #f0f0f0; cursor: pointer; margin-top: 75px; margin-left: 20px;" onclick="document.getElementById('foto_edit').click();">
                                    <!-- Gambar Profil Pengguna -->
                                    <img class="profile-user-img img-fluid" alt="Foto profile" id="previewImage_edit" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <!-- Input file disembunyikan, akan di-trigger oleh klik pada imageFrame -->
                                <input type="file" class="form-control d-none" id="foto_edit" name="foto_edit" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h3 style="text-align: left;">BIODATA</h3>
                            <div class="col-2" style="padding-left: 0; text-align: left;">
                                <hr style="width: 85%; margin-left: 0;">
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <div class="input-group">
                                            <input type="nama" class="form-control" id="nama_dokter_edit" name="nama_dokter_edit" style="width: 59%;">

                                            <input type="text" class="form-control" placeholder="Kode Dokter" id="kode_dokter_edit" name="kode_dokter_edit" style="width: 41%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Alamat </label>
                                        <input type="text" class="form-control" placeholder="Alamat" id="Alamat_edit" name="Alamat_edit" value="{{ old('Alamat') }}" >
                                    </div>
                                    @error('Alamat')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>NIK / Nomer KTP</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="nik_edit" name="nik_edit"  oninput="cekSatuSehat()" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tempat Tanggal Lahir</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="tempat_lahir_edit" name="tempat_lahir_edit" placeholder="Tempat" style="width: 60%;">
                                            <input type="date" class="form-control" id="tanggal_lahir_edit" name="tanggal_lahir_edit" style="width: 40%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Provinsi</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="provinsi_edit" name="provinsi_edit">
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
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="kota_kabupaten_edit" name="kota_kabupaten_edit" >
                                            <option value="" disabled selected>Kota/Kabupaten</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Kecamatan</label>
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="kecamatan_edit" name="kecamatan_edit" value="{{ old('kecamatan') }}">
                                            <option value="" disabled selected>Kecamatan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Desa/Kelurahan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="desa_edit" name="desa_edit" value="{{ old('desa') }}">
                                            <option value="" disabled selected>Desa/Kelurahan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label>RT </label>
                                        <input type="text" class="form-control" placeholder="001" id="rt_edit" name="rt_edit" value="{{ old('rt') }}" >
                                    </div>
                                    @error('rt')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label>RW </label>
                                        <input type="text" class="form-control" placeholder="002" id="rw_edit" name="rw_edit" value="{{ old('rw') }}" >
                                    </div>
                                    @error('rw')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Kode Pos </label>
                                        <input type="text" class="form-control" id="kode_pos_edit" name="kode_pos_edit" value="{{ old('kode_pos') }}" >
                                    </div>
                                    @error('kode_pos')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Seks</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="seks_edit" name="seks_edit">
                                            <option value="" disabled selected>--- Pilih Jenis Kelamin ---</option>
                                            @foreach ($sex as $data)
                                                <option value="{{$data->id}}">{{$data->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Status Pernikahan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="pernikahan_edit" name="pernikahan_edit">
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
                                        <select class="form-control select2bs4" style="width: 100%;" id="goldar_edit" name="goldar_edit">
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
                                        <select class="form-control select2bs4" style="width: 100%;" id="kewarganegaraan_edit" name="kewarganegaraan_edit">
                                            <option value="" {{ old('kewarganegaraan') == '' ? 'selected' : '' }}>--- pilih ---</option>
                                            <option value="wni" {{ old('kewarganegaraan') == 'wni' ? 'selected' : '' }}>Warga Negara Indonesia</option>
                                            <option value="wna" {{ old('kewarganegaraan') == 'wna' ? 'selected' : '' }}>Warga Negara Asing</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Agama</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="agama_edit" name="agama_edit">
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
                                        <select class="form-control select2bs4" style="width: 100%;" id="suku_edit" name="suku_edit">
                                            <option value="" disabled selected>--- Pilih Suku ---</option>
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
                                        <select class="form-control select2bs4" style="width: 100%;" id="bangsa_edit" name="bangsa_edit">
                                            <option value="" disabled selected>--- Pilih Bangsa ---</option>
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
                                        <select class="form-control select2bs4" style="width: 100%;" id="bahasa_edit" name="bahasa_edit">
                                            <option value="" disabled selected>--- Pilih Bahasa ---</option>
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
                                        <input type="Email" class="form-control" id="email_edit" name="email_edit">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" id="username_edit" name="username_edit" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" id="password_edit" name="password_edit" autocomplete >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Telepon</label>
                                        <input type="text" class="form-control" id="telepon_edit" name="telepon_edit">
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
                                        <input type="date" class="form-control" id="tglawal_edit" name="tglawal_edit" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="aktivasi_edit" name="aktivasi_edit">
                                            <option value="">--- pilih ---</option>
                                            <option value="aktif">Aktif</option>
                                            <option value="tidak aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="poli_edit" name="poli_edit">
                                            <option value="" disabled selected>--- Pilih Unit ---</option>
                                            @foreach ($poli as $polis)
                                            <option value="{{$polis->id}}">{{$polis->nama_poli}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="jabatan_edit" name="jabatan_edit">
                                            <option value="" disabled selected>--- Pilih Jabatan ---</option>
                                            @foreach ($jabatan as $jabatanedit)
                                            <option value="{{$jabatanedit->id}}">{{$jabatanedit->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nomor NPWP</label>
                                        <input type="text" class="form-control" id="npwp_edit" name="npwp_edit" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nomor STR</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="str_edit" name="str_edit" style="width: 60%;">
                                            <input type="date" class="form-control" id="expstr_edit" name="expstr_edit" style="width: 40%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nomor SIP </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="sip_edit" name="sip_edit" placeholder="Nomor SIP" style="width: 60%;">
                                            <input type="date" class="form-control" id="expspri_edit" name="expspri_edit" style="width: 40%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Pelatihan Khusus </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="pk_edit" name="pk_edit" placeholder="Nomor PK" style="width: 60%;">
                                            <input type="date" class="form-control" id="exppk_edit" name="exppk_edit" style="width: 40%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>ID Satu Sehat</label>
                                        <input type="text" class="form-control" id="kode_edit" name="kode_edit" >
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
                                                <select class="form-control select2bs4" style="width: 100%;" id="pendidikan_edit" name="pendidikan_edit">
                                                    <option value="" disabled selected>--- pilih ---</option>
                                                    <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                                                    <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                                    <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                                    <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>Sarjana</option>
                                                    <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>Magister</option>
                                                    <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>Doctoral Degree</option>
                                                </select>
                                                @error('pendidikan')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Status Pekerja</label>
                                                <select class="form-control select2bs4"  style="width: 100%;"  id="status_kerja_edit" name="status_kerja_edit">
                                                    <option value="" disabled selected>--- Pilih Status ---</option>
                                                    @foreach ($status as $statusedit)
                                                    <option value="{{$statusedit->id}}">{{$statusedit->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    {{-- Data Double Status --}}
                                        {{-- <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control select2bs4" style="width: 100%;" id="aktivasi" name="aktivasi">
                                                    <option value="">--- pilih ---</option>
                                                    <option value="aktif">Aktif</option>
                                                    <option value="tidak aktif">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <input type="hidden" id="userinput_edit" name="userinput_edit" value="{{ auth()->user()->name }}">
                        <input type="hidden" id="userinputid_edit" name="userinputid_edit" value="{{ auth()->user()->id }}">
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
        // Ketika tombol Edit diklik
        $('.editBtn').on('click', function() {
            // Ambil ID dari tombol yang diklik
            var idPasien = $(this).data('id');

            // Panggil API untuk mendapatkan data pasien berdasarkan ID
            $.ajax({
                url: '/api/doctor/cari-data/' + idPasien,  // URL ke API
                method: 'GET',
                success: function(pasien) {
                    $('#doctoredit #nik_edit').val(pasien.nik);
                    $('#doctoredit #kode_dokter_edit').val(pasien.kode_dokter);
                    $('#doctoredit #nama_dokter_edit').val(pasien.nama_dokter);
                    $('#doctoredit #tempat_lahir_edit').val(pasien.tempat_lahir);
                    $('#doctoredit #tanggal_lahir_edit').val(pasien.tgllahir);
                    $('#doctoredit #username_edit').val(pasien.username);
                    $('#doctoredit #email_edit').val(pasien.email);
                    $('#doctoredit #email_edit').val(pasien.email);
                    $('#doctoredit #Alamat_edit').val(pasien.Alamat);
                    $('#doctoredit #rt_edit').val(pasien.rt);
                    $('#doctoredit #rw_edit').val(pasien.rw);
                    $('#doctoredit #kode_pos_edit').val(pasien.kode_pos);
                    $('#doctoredit #tglawal_edit').val(pasien.tglawal);
                    $('#doctoredit #aktivasi_edit').val(pasien.aktivasi);
                    $('#doctoredit #npwp_edit').val(pasien.npwp);
                    $('#doctoredit #str_edit').val(pasien.str);
                    $('#doctoredit #expstr_edit').val(pasien.expstr);
                    $('#doctoredit #sip_edit').val(pasien.str);
                    $('#doctoredit #expspri_edit').val(pasien.expspri);
                    $('#doctoredit #pk_edit').val(pasien.pk);
                    $('#doctoredit #exppk_edit').val(pasien.exppk);
                    $('#doctoredit #kode_edit').val(pasien.kode);
                    $('#doctoredit #status_kerja_edit').val(pasien.status_kerja).trigger('change');
                    $('#doctoredit #poli_edit').val(pasien.poli).trigger('change');
                    $('#doctoredit #jabatan_edit').val(pasien.jabatan).trigger('change');
                    $('#doctoredit #kewarganegaraan_edit').val(pasien.kewarganegaraan).trigger('change');
                    $('#doctoredit #provinsi_edit').val(pasien.provinsi_kode).trigger('change');
                    $('#doctoredit #seks_edit').val(pasien.seks).trigger('change');
                    $('#doctoredit #agama_edit').val(pasien.agama).trigger('change');
                    $('#doctoredit #pendidikan_edit').val(pasien.pendidikan).trigger('change');
                    $('#doctoredit #goldar_edit').val(pasien.goldar).trigger('change');
                    $('#doctoredit #pernikahan_edit').val(pasien.pernikahan).trigger('change');
                    $('#doctoredit #pekerjaan_edit').val(pasien.pekerjaan).trigger('change');
                    $('#doctoredit #telepon_edit').val(pasien.telepon).trigger('change');
                    $('#doctoredit #suku_edit').val(pasien.suku).trigger('change');
                    $('#doctoredit #bangsa_edit').val(pasien.bahasa).trigger('change');
                    $('#doctoredit #bahasa_edit').val(pasien.bangsa).trigger('change');
                    $('#doctoredit #provinsi_edit').val(pasien.provinsi).trigger('change');

                    // Set Kabupaten/Kota setelah Provinsi terpilih
                    if (pasien.kota_kabupaten) {
                        loadKabupatenEdit(pasien.provinsi, pasien.kota_kabupaten);
                    }

                    // Set Kecamatan setelah Kabupaten terpilih
                    if (pasien.kecamatan) {
                        loadKecamatanEdit(pasien.kota_kabupaten, pasien.kecamatan);
                    }

                    // Set Desa setelah Kecamatan terpilih
                    if (pasien.desa) {
                        loadDesaEdit(pasien.kecamatan, pasien.desa);
                    }

                    function loadKabupatenEdit(kodeProvinsi, selectedKabupaten = '') {
                        if (!kodeProvinsi) return;

                        $('#kota_kabupaten_edit').empty().append('<option value="" disabled selected>Kota/Kabupaten</option>');

                        $.ajax({
                            url: '/api/get-kabupaten',
                            type: 'GET',
                            data: { kode_provinsi: kodeProvinsi },
                            success: function(response) {
                                $.each(response, function(index, kabupaten) {
                                    var selected = kabupaten.kode == selectedKabupaten ? 'selected' : '';
                                    $('#kota_kabupaten_edit').append('<option value="' + kabupaten.kode + '" ' + selected + '>' + kabupaten.name + '</option>');
                                });

                                if (selectedKabupaten) {
                                    $('#kota_kabupaten_edit').trigger('change');
                                }
                            }
                        });
                    }
                    function loadKecamatanEdit(kodeKabupaten, selectedKecamatan = '') {
                        if (!kodeKabupaten) return;

                        $('#kecamatan_edit').empty().append('<option value="" disabled selected>Kecamatan</option>');

                        $.ajax({
                            url: '/api/get-kecamatan',
                            type: 'GET',
                            data: { kode_kabupaten: kodeKabupaten },
                            success: function(response) {
                                var kecamatanFound = false; // Flag untuk cek apakah kecamatan ditemukan

                                $.each(response, function(index, kecamatan) {
                                    // Konversi ke string untuk memastikan perbandingan berhasil
                                    var selected = (String(kecamatan.kode) === String(selectedKecamatan)) ? 'selected' : '';

                                    if (selected) kecamatanFound = true;

                                    $('#kecamatan_edit').append('<option value="' + kecamatan.kode + '" ' + selected + '>' + kecamatan.name + '</option>');
                                });

                                // Jika ada kecamatan yang cocok, baru trigger change
                                if (kecamatanFound) {
                                    $('#kecamatan_edit').trigger('change');
                                }
                            }
                        });
                    }



                    // Fungsi untuk memuat Desa berdasarkan Kecamatan
                    function loadDesaEdit(kodeKecamatan, selectedDesa = '') {
                        if (!kodeKecamatan) return;

                        $('#desa_edit').empty().append('<option value="" disabled selected>Desa</option>');

                        $.ajax({
                            url: '/api/get-desa',
                            type: 'GET',
                            data: { kode_kecamatan: kodeKecamatan },
                            success: function(response) {
                                $.each(response, function(index, desa) {
                                    var selected = desa.kode == selectedDesa ? 'selected' : '';
                                    $('#desa_edit').append('<option value="' + desa.kode + '" ' + selected + '>' + desa.name + '</option>');
                                });
                            }
                        });
                    }

                    // Saat Provinsi diubah, update Kabupaten/Kota
                    $('#provinsi_edit').on('change', function() {
                        var kodeProvinsi = $(this).val();
                        loadKabupatenEdit(kodeProvinsi);
                    });

                    // Saat Kabupaten diubah, update Kecamatan
                    $('#kota_kabupaten_edit').on('change', function() {
                        var kodeKabupaten = $(this).val();
                        loadKecamatanEdit(kodeKabupaten);
                    });

                    // Saat Kecamatan diubah, update Desa
                    $('#kecamatan_edit').on('change', function() {
                        var kodeKecamatan = $(this).val();
                        loadDesaEdit(kodeKecamatan);
                    });

                   // Ambil gambar profil dari API
                    var profileImage = pasien.profile || 'default.png'; // Jika tidak ada, gunakan default.png

                    // Pastikan path gambar benar
                    var imagePath = '/uploads/doctor_photos/' + profileImage; // Sesuaikan dengan lokasi penyimpanan gambar

                    // Tampilkan gambar profil di form edit
                    $('#previewImage_edit').attr('src', imagePath);

                },
                error: function() {
                    alert('Data pasien tidak ditemukan.');
                }
            });
        });

        // Fungsi untuk preview gambar setelah upload
        window.previewImage = function(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage_edit').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]); // Convert ke base64
            }
        };

    });

</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Seleksi tombol yang memicu modal
        const deleteButtons = document.querySelectorAll('button[data-target="#deletdockter"]');
        const modal = document.getElementById('deletdockter');
        const idInput = modal.querySelector('#iddokter');
        const message = modal.querySelector('#deleteDoctorMessage');
        const form = modal.querySelector('#deleteDoctorForm');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const doctorId = this.getAttribute('data-id');
                const doctorName = this.getAttribute('data-name');

                // Update modal dengan data dokter
                idInput.value = doctorId;
                message.textContent = `Apakah Anda yakin ingin menghapus data dokter ${doctorName}?`;
                form.action = `{{ route('dokter.index.delete', '') }}/${doctorId}`;
            });
        });
    });
</script>


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
    // Fungsi untuk memuat data dokter
    function loadDokterData() {
        $.ajax({
            url: '/get-dokter-bpjs',
            method: 'GET',
            success: function(data) {
                if (data.status === 'error') {
                    alert(data.message);
                    return;
                }

                const select = $('#nama_dokter');
                select.empty(); // Kosongkan opsi sebelumnya
                // Tambahkan opsi default
                const defaultOption = $('<option></option>')
                    .attr('value', '')
                    .attr('disabled', true)
                    .attr('selected', true)
                    .text('--- Pilih Dokter ---');
                select.append(defaultOption);

                data.data.forEach(dokter => {
                    const option = $('<option></option>')
                        .attr('value', dokter.nama_dokter)
                        .attr('data-kode-dokter', dokter.kode_dokter)
                        .text(dokter.nama_dokter);
                    select.append(option);
                });

                // Update kode dokter saat dokter dipilih
                select.on('change', function() {
                    const selectedOption = $(this).find('option:selected');
                    const kodeDokter = selectedOption.data('kode-dokter');
                    $('#kode_dokter').val(kodeDokter);
                });
            },
            error: function(error) {
                console.error('Error fetching dokter data:', error);
            }
        });
    }

    // Panggil fungsi untuk memuat data dokter
    loadDokterData();

    // Event listener untuk checkbox
    $('#manual_check').on('change', function() {
        console.log('Checkbox status:', this.checked);
        if (this.checked) {
            console.log('Hiding select2 and showing input');
            $('#nama_dokter').next('.select2-container').hide();
            $('#nama_dokter').hide();
            $('#nama_dokter_input').show().focus();
            $('#kode_dokter').prop('readonly', false).val(''); // Enable dan kosongkan input kode dokter

        } else {
            console.log('Showing select2 and hiding input');
            $('#nama_dokter').next('.select2-container').show();
            $('#nama_dokter').show();
            $('#nama_dokter_input').hide();
            $('#kode_dokter').prop('readonly', true);
        }
    });

    // Inisialisasi tampilan awal
    $('#nama_dokter').show(); // Tampilkan select
    $('#nama_dokter_input').hide(); // Sembunyikan input manual
    $('#kode_dokter').prop('readonly', true); // Disable input kode dokter
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
