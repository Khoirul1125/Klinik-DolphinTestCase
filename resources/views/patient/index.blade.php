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
                                <h3 class="mb-0 card-title">Master Pasien</h3>
                                <div class="text-right card-tools">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#addpasien">
                                        <i class="fas fa-plus"></i> Tambah Baru
                                    </button>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="patienttbl" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomor RM</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Golongan Darah</th>
                                            <th>Telepon</th>
                                            <th width="20%">Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            use Carbon\Carbon;
                                        @endphp
                                        @foreach ($pasien as $index => $pasien)
                                            <tr
                                                @if(Carbon::parse($pasien->created_at)->diffInDays(now()) > 30)
                                                    style="background-color: #cce5ff;"
                                                @elseif($pasien->statusdata === 2)
                                                    style="background-color: #d4edda;"
                                                @elseif($pasien->statusdata === 1)
                                                    style="background-color: #f8d7da;"
                                                @endif
                                            >
                                                <td>{{ $index + 1 }}</td> <!-- Menampilkan urutan nomor mulai dari 1 -->
                                                <td>{{ $pasien->no_rm }}</td>
                                                <td>{{ $pasien->nama }}</td>
                                                <td>{{ $pasien->Alamat }}</td>
                                                <td>{{ $pasien->goldar ? $pasien->goldar->nama . $pasien->goldar->resus : '-' }}</td>
                                                <td>{{ $pasien->telepon }}</td>
                                                <td class="text-center">
                                                    <div class="d-inline-flex gap-3">
                                                        @if($pasien->statusdata !== 2)
                                                            <button type="button" class="btn btn-flat btn-primary d-flex align-items-center justify-content-center shadow-sm lkpBtn"
                                                                style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;"
                                                                 data-toggle="modal" data-target="#lengkapipasien" data-id="{{ $pasien->id }}">
                                                                <i class="fa fa-edit" style="margin-right: 5px;"></i> Lengkapi Data
                                                            </button>
                                                        @else
                                                        <button
                                                            class="btn btn-flat btn-success d-flex align-items-center justify-content-center shadow-sm"
                                                            style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;"
                                                            disabled>
                                                            <i class="fas fa-check" style="margin-right: 5px;"></i> Sudah Lengkap
                                                        </button>
                                                        @endif
                                                        @if($pasien->statusdata == 2)
                                                        <span>
                                                            <button type="button" class="btn btn-flat btn-warning d-flex align-items-center justify-content-center shadow-sm editBtn"
                                                                style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;"
                                                                 data-toggle="modal" data-target="#editpasien" data-id="{{ $pasien->id }}">
                                                                <i class="fa fa-edit" style="margin-right: 5px;"></i> Edit
                                                            </button>
                                                        </span>
                                                        @endif
                                                        <span>
                                                            <button type="button" class="btn btn-flat btn-danger d-flex align-items-center justify-content-center shadow-sm "
                                                                style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;"
                                                                data-toggle="modal" data-target="#deletdockter" data-id="{{ $pasien->id }}" data-name="{{ $pasien->nama }}">
                                                                <i class="fa fa-edit" style="margin-right: 5px;"></i> Hapus
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
                                <div class="p-2 mb-2" style="background-color: #cce5ff; border-left: 5px solid #004085; padding: 10px;">
                                    <strong>Biru:</strong> Pasien Yang sudah lebih dari 30 hari.
                                </div>
                                <div class="p-2 mb-2" style="background-color: #d4edda; border-left: 5px solid #155724; padding: 10px;">
                                    <strong>Hijau:</strong> Pasien Sudah Lengkap Data Dan Baru Mendaftar.
                                </div>
                                <div class="p-2 mb-2" style="background-color: #f8d7da; border-left: 5px solid #721c24; padding: 10px;">
                                    <strong>Merah:</strong> Pasien Masih belum lengkap Dan Daftar melalu Antrian Loket.
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


    <!-- Modal Tambah Pasien -->
    <div class="modal fade" id="addpasien" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span >&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addFormpermesion" action="{{ route('pasien.index.add') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="row">
                                <!-- Tempat untuk menampilkan pesan kesalahan -->
                                <style>
                                    .alert {
                                        padding: 15px;
                                        margin-bottom: 20px;
                                        border: 1px solid transparent;
                                        border-radius: 4px;
                                    }
                                    .alert-danger {
                                        color: #721c24;
                                        background-color: #f8d7da;
                                        border-color: #f5c6cb;
                                    }
                                </style>
                                <div class="text-center col-sm-6">
                                    <div class="form-group">
                                        <div id="bpjs_error1" class="alert alert-warning" style="display: none;"></div>
                                    </div>
                                </div>
                                <div class="text-center col-sm-6">
                                    <div class="form-group">
                                        <div id="bpjs_error" class="alert alert-danger" style="display: none;"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Pencarian NIK atau No BPJS</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="nomber" name="nomber">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary" onclick="NIkdanNOKA()">Cari</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Nomor RM</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="nomor_rm" name="nomor_rm" value="{{ old('nomor_rm') }}" placeholder="Nomor RM" readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary" onclick="generateNomorRM()">Generate</button>
                                            </span>
                                        </div>
                                        @error('nomor_rm')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}" onblur="handleNikInput()">
                                        </div>
                                        @error('nik')
                                                <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>IHS Pasien</label>
                                        <input type="text" class="form-control" id="kode_ihs" name="kode_ihs" readonly>
                                    </div>
                                    @error('kode_ihs')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Nama </label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" >
                                    </div>
                                    @error('nama')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Tempat Lahir</label>
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                    </div>
                                    @error('tempat_lahir')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                        </div>
                                        @error('tanggal_lahir')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Username </label>
                                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" readonly>
                                    </div>
                                    @error('username')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Password </label>
                                        <input type="password" class="form-control" id="password" name="password" autocomplete value="{{ old('password') }}" readonly>
                                    </div>
                                    @error('password')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Email </label>
                                        <input type="Email" class="form-control" id="email" name="email" value="{{ old('email') }}" >
                                    </div>
                                    @error('email')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Nomor BPJS</label>
                                        <input type="text" class="form-control" id="no_bpjs" name="no_bpjs" value="{{ old('no_bpjs') }}" readonly>
                                    </div>
                                    @error('no_bpjs')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Kelas BPJS</label>
                                        <input type="text" class="form-control" id="kelbpjs" name="kelbpjs" value="{{ old('kelbpjs') }}" readonly>
                                        @error('kelbpjs')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Jenis Peserta</label>
                                        <input type="text" class="form-control" id="jenper" name="jenper" value="{{ old('jenper') }}" readonly>
                                        @error('jenper')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Tanggal Akhir Berlaku</label>
                                        <input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir" value="{{ old('tgl_akhir') }}" readonly>
                                    </div>
                                    @error('tgl_akhir')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Provider</label>
                                        <input type="text" class="form-control" id="provide" name="provide" value="{{ old('provide') }}" readonly>
                                    </div>
                                    @error('provide')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Hubungan Keluarga</label>
                                        <input type="text" class="form-control" id="hubka" name="hubka" value="{{ old('hubka') }}">
                                        @error('hubka')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
                                <div class="col-sm-1">
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
                                        <label>Provinsi</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="provinsi" name="provinsi">
                                            <option value="" disabled selected >Provinsi</option>
                                            @foreach ($provinsi as $item)
                                                <option value="{{ $item->kode }}"  {{ old('provinsi') == $item->kode ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Kota/Kabupaten</label>
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="kota_kabupaten" name="kota_kabupaten" >
                                            <option value="" disabled selected>Kota/Kabupaten</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Kecamatan</label>
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}">
                                            <option value="" disabled selected>Kecamatan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Desa/Kelurahan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="desa" name="desa" value="{{ old('desa') }}">
                                            <option value="" disabled selected>Desa/Kelurahan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="seks" name="seks">
                                            <option value="" disabled selected>--- pilih ---</option>
                                            @foreach ($sex as $data)
                                                <option value="{{ $data->id }}" {{ old('seks') == $data->id ? 'selected' : '' }}>
                                                    {{ $data->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('seks')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
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

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Pekerjaan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="pekerjaan" name="pekerjaan">
                                            <option value="" disabled selected>--- pilih ---</option>
                                            <option value="wirausaha" {{ old('pekerjaan') == 'wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                                            <option value="tidak_bekerja" {{ old('pekerjaan') == 'tidak_bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                                            <option value="pns" {{ old('pekerjaan') == 'pns' ? 'selected' : '' }}>PNS</option>
                                            <option value="tni_polri" {{ old('pekerjaan') == 'tni_polri' ? 'selected' : '' }}>TNI/Polri</option>
                                            <option value="bumn" {{ old('pekerjaan') == 'bumn' ? 'selected' : '' }}>BUMN</option>
                                            <option value="swasta" {{ old('pekerjaan') == 'swasta' ? 'selected' : '' }}>Pegawai Swasta</option>
                                            <option value="lain_lain" {{ old('pekerjaan') == 'lain_lain' ? 'selected' : '' }}>Lain - lain</option>
                                        </select>
                                        @error('pekerjaan')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Telepon</label>
                                        <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon') }}">
                                        @error('telepon')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="profile-container text-center">
                                        <!-- Bingkai Gambar dengan Rasio 3:4 -->
                                        <div id="imageFrame" style="display: flex; justify-content: center; align-items: center; width: 75%; height: 0; padding-bottom: 80%; position: relative; overflow: hidden; background-color: #f0f0f0; cursor: pointer;" onclick="document.getElementById('foto').click();">
                                            <!-- Gambar Profil Pengguna -->
                                            <img class="profile-user-img img-fluid" alt="Foto profile" id="previewImage" name="previewImage" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <!-- Input file disembunyikan, akan di-trigger oleh klik pada imageFrame -->
                                        <input type="file" class="form-control d-none" id="foto" name="foto" accept="image/*">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Suku</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="suku" name="suku">
                                            <option value="" disabled selected>--- pilih ---</option>
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
                                            <option value="" disabled selected>--- pilih ---</option>
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
                                            <option value="" disabled selected>--- pilih ---</option>
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
                                <input type="hidden" id="kodeprovide" name="kodeprovide" >
                                <input type="hidden" id="userinput" name="userinput" value="{{ auth()->user()->name }}">
                                <input type="hidden" id="userinputid" name="userinputid" value="{{ auth()->user()->id }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-secondary" id="clearModalButton">Clear</button>
                        <button type="submit" class="btn btn-primary">Tambah</button> <!-- Submit button -->
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit lengkapi -->
    <div class="modal fade" id="lengkapipasien" tabindex="-1" role="dialog" aria-labelledby="lengkapipasienModalLabel"
        >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lengkapipasienModalLabel">Edit Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span >&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  action="{{ route('pasien.index.lengkapi') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="row">
                                <!-- Tempat untuk menampilkan pesan kesalahan -->
                                <style>
                                    .alert {
                                        padding: 15px;
                                        margin-bottom: 20px;
                                        border: 1px solid transparent;
                                        border-radius: 4px;
                                    }
                                    .alert-danger {
                                        color: #721c24;
                                        background-color: #f8d7da;
                                        border-color: #f5c6cb;
                                    }
                                </style>


                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Nomor RM</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="nomor_rm_lengkapi" name="nomor_rm_lengkapi" value="{{ old('nomor_rm') }}" placeholder="Nomor RM" readonly>
                                        </div>
                                        @error('nomor_rm')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="nik_lengkapi" name="nik_lengkapi" value="{{ old('nik') }}"  onblur="handleNikInputs()" >
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary" onclick="NIkdanNOKAnew()">Cari</button>
                                            </span>
                                        </div>
                                        @error('nik')
                                                <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>IHS Pasien</label>
                                        <input type="text" class="form-control" id="kode_ihs_lengkapi" name="kode_ihs_lengkapi" readonly>
                                    </div>
                                    @error('kode_ihs')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Nama </label>
                                        <input type="text" class="form-control" id="nama_lengkapi" name="nama_lengkapi" value="{{ old('nama') }}" >
                                    </div>
                                    @error('nama')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Tempat Lahir</label>
                                        <input type="text" class="form-control" id="tempat_lahir_lengkapi" name="tempat_lahir_lengkapi" value="{{ old('tempat_lahir') }}">
                                    </div>
                                    @error('tempat_lahir')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask id="tanggal_lahir_lengkapi" name="tanggal_lahir_lengkapi" value="{{ old('tanggal_lahir') }}">
                                        </div>
                                        @error('tanggal_lahir')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Username </label>
                                        <input type="text" class="form-control" id="username_lengkapi" name="username_lengkapi" value="{{ old('username') }}" readonly>
                                    </div>
                                    @error('username')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Password </label>
                                        <input type="password" class="form-control" id="password_lengkapi" name="password_lengkapi" autocomplete value="{{ old('password') }}" readonly>
                                    </div>
                                    @error('password')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Email </label>
                                        <input type="Email" class="form-control" id="email_lengkapi" name="email_lengkapi" value="{{ old('email') }}" >
                                    </div>
                                    @error('email')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Nomor BPJS</label>
                                        <input type="text" class="form-control" id="no_bpjs_lengkapi" name="no_bpjs_lengkapi" value="{{ old('no_bpjs') }}" readonly>
                                    </div>
                                    @error('no_bpjs')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Kelas BPJS</label>
                                        <input type="text" class="form-control" id="kelbpjs_lengkapi" name="kelbpjs_lengkapi" value="{{ old('kelbpjs') }}" readonly>
                                        @error('kelbpjs')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Jenis Peserta</label>
                                        <input type="text" class="form-control" id="jenper_lengkapi" name="jenper_lengkapi" value="{{ old('jenper') }}" readonly>
                                        @error('jenper')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Tanggal Akhir Berlaku</label>
                                        <input type="text" class="form-control" id="tgl_akhir_lengkapi" name="tgl_akhir_lengkapi" value="{{ old('tgl_akhir') }}" readonly>
                                    </div>
                                    @error('tgl_akhir')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Provider</label>
                                        <input type="text" class="form-control" id="provide_lengkapi" name="provide_lengkapi" value="{{ old('provide') }}" readonly>
                                    </div>
                                    @error('provide')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Hubungan Keluarga</label>
                                        <input type="text" class="form-control" id="hubka_lengkapi" name="hubka_lengkapi" value="{{ old('hubka') }}">
                                        @error('hubka')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Alamat </label>
                                        <input type="text" class="form-control" placeholder="Alamat" id="Alamat_lengkapi" name="Alamat_lengkapi" value="{{ old('Alamat') }}" >
                                    </div>
                                    @error('Alamat')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label>RT </label>
                                        <input type="text" class="form-control" placeholder="001" id="rt_lengkapi" name="rt_lengkapi" value="{{ old('rt') }}" >
                                    </div>
                                    @error('rt')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label>RW </label>
                                        <input type="text" class="form-control" placeholder="002" id="rw_lengkapi" name="rw_lengkapi" value="{{ old('rw') }}" >
                                    </div>
                                    @error('rw')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label>Kode Pos </label>
                                        <input type="text" class="form-control" id="kode_pos_lengkapi" name="kode_pos_lengkapi" value="{{ old('kode_pos') }}" >
                                    </div>
                                    @error('kode_pos')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Kewarganegaraan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="kewarganegaraan_lengkapi" name="kewarganegaraan_lengkapi">
                                            <option value="" {{ old('kewarganegaraan') == '' ? 'selected' : '' }}>--- pilih ---</option>
                                            <option value="wni" {{ old('kewarganegaraan') == 'wni' ? 'selected' : '' }}>Warga Negara Indonesia</option>
                                            <option value="wna" {{ old('kewarganegaraan') == 'wna' ? 'selected' : '' }}>Warga Negara Asing</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Provinsi</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="provinsi_lengkapi" name="provinsi_lengkapi">
                                            <option value="" disabled selected >Provinsi</option>
                                            @foreach ($provinsi as $item)
                                                <option value="{{ $item->kode }}"  {{ old('provinsi') == $item->kode ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Kota/Kabupaten</label>
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="kota_kabupaten_lengkapi" name="kota_kabupaten_lengkapi" >
                                            <option value="" disabled selected>Kota/Kabupaten</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Kecamatan</label>
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="kecamatan_lengkapi" name="kecamatan_lengkapi" value="{{ old('kecamatan') }}">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Desa/Kelurahan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="desa_lengkapi" name="desa_lengkapi" value="{{ old('desa') }}">
                                            <option value="" disabled selected>Desa/Kelurahan</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="seks_lengkapi" name="seks_lengkapi">
                                            <option value="" disabled selected>--- pilih ---</option>
                                            @foreach ($sex as $data)
                                                <option value="{{ $data->id }}" {{ old('seks') == $data->id ? 'selected' : '' }}>
                                                    {{ $data->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('seks')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Agama</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="agama_lengkapi" name="agama_lengkapi">
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


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Pendidikan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="pendidikan_lengkapi" name="pendidikan_lengkapi">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Golongan Darah</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="goldar_lengkapi" name="goldar_lengkapi">
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
                                        <label>Status Pernikahan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="pernikahan_lengkapi" name="pernikahan_lengkapi">
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

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Pekerjaan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="pekerjaan_lengkapi" name="pekerjaan_lengkapi">
                                            <option value="" disabled selected>--- pilih ---</option>
                                            <option value="wirausaha" {{ old('pekerjaan') == 'wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                                            <option value="tidak_bekerja" {{ old('pekerjaan') == 'tidak_bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                                            <option value="pns" {{ old('pekerjaan') == 'pns' ? 'selected' : '' }}>PNS</option>
                                            <option value="tni_polri" {{ old('pekerjaan') == 'tni_polri' ? 'selected' : '' }}>TNI/Polri</option>
                                            <option value="bumn" {{ old('pekerjaan') == 'bumn' ? 'selected' : '' }}>BUMN</option>
                                            <option value="swasta" {{ old('pekerjaan') == 'swasta' ? 'selected' : '' }}>Pegawai Swasta</option>
                                            <option value="lain_lain" {{ old('pekerjaan') == 'lain_lain' ? 'selected' : '' }}>Lain - lain</option>
                                        </select>
                                        @error('pekerjaan')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Telepon</label>
                                        <input type="text" class="form-control" id="telepon_lengkapi" name="telepon_lengkapi" value="{{ old('telepon') }}">
                                        @error('telepon')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="profile-container text-center">
                                        <!-- Bingkai Gambar dengan Rasio 3:4 -->
                                        <div id="imageFramel" style="display: flex; justify-content: center; align-items: center; width: 75%; height: 0; padding-bottom: 80%; position: relative; overflow: hidden; background-color: #f0f0f0; cursor: pointer;" onclick="document.getElementById('foto_lengkapi').click();">
                                            <!-- Gambar Profil Pengguna -->
                                            <img class="profile-user-img img-fluid" alt="Foto profile" id="previewImage_lengkapi" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <!-- Input file disembunyikan, akan di-trigger oleh klik pada imageFrame -->
                                        <input type="file" class="form-control d-none" id="foto_lengkapi" name="foto_lengkapi" accept="image/*">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Suku</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="suku_lengkapi" name="suku_lengkapi">
                                            <option value="" disabled selected>--- pilih ---</option>
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
                                        <select class="form-control select2bs4" style="width: 100%;" id="bangsa_lengkapi" name="bangsa_lengkapi">
                                            <option value="" disabled selected>--- pilih ---</option>
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
                                        <select class="form-control select2bs4" style="width: 100%;" id="bahasa_lengkapi" name="bahasa_lengkapi">
                                            <option value="" disabled selected>--- pilih ---</option>
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

                                <input type="hidden" id="kodeprovide_lengkapi" name="kodeprovide_lengkapi" >
                                <input type="hidden" id="userinput_lengkapi" name="userinput_lengkapi" value="{{ auth()->user()->name }}">
                                <input type="hidden" id="userinputid_lengkapi" name="userinputid_lengkapi" value="{{ auth()->user()->id }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button> <!-- Submit button -->
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pasien -->
    <div class="modal fade" id="editpasien" tabindex="-1" role="dialog" aria-labelledby="editpasienModalLabel"
        >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editpasienModalLabel">Edit Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span >&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  action="{{ route('pasien.index.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="row">
                                <!-- Tempat untuk menampilkan pesan kesalahan -->
                                <style>
                                    .alert {
                                        padding: 15px;
                                        margin-bottom: 20px;
                                        border: 1px solid transparent;
                                        border-radius: 4px;
                                    }
                                    .alert-danger {
                                        color: #721c24;
                                        background-color: #f8d7da;
                                        border-color: #f5c6cb;
                                    }
                                </style>


                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Nomor RM</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="nomor_rm_edit" name="nomor_rm_edit" value="{{ old('nomor_rm') }}" placeholder="Nomor RM" readonly>
                                        </div>
                                        @error('nomor_rm')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="nik_edit" name="nik_edit" value="{{ old('nik') }}"  >
                                        </div>
                                        @error('nik')
                                                <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>IHS Pasien</label>
                                        <input type="text" class="form-control" id="kode_ihs_edit" name="kode_ihs_edit" readonly>
                                    </div>
                                    @error('kode_ihs')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Nama </label>
                                        <input type="text" class="form-control" id="nama_edit" name="nama_edit" value="{{ old('nama') }}" >
                                    </div>
                                    @error('nama')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Tempat Lahir</label>
                                        <input type="text" class="form-control" id="tempat_lahir_edit" name="tempat_lahir_edit" value="{{ old('tempat_lahir') }}">
                                    </div>
                                    @error('tempat_lahir')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask id="tanggal_lahir_edit" name="tanggal_lahir_edit" value="{{ old('tanggal_lahir') }}">
                                        </div>
                                        @error('tanggal_lahir')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Username </label>
                                        <input type="text" class="form-control" id="username_edit" name="username_edit" value="{{ old('username') }}" readonly>
                                    </div>
                                    @error('username')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Password </label>
                                        <input type="password" class="form-control" id="password_edit" name="password_edit" autocomplete value="{{ old('password') }}"readonly>
                                    </div>
                                    @error('password')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Email </label>
                                        <input type="Email" class="form-control" id="email_edit" name="email_edit" value="{{ old('email') }}" >
                                    </div>
                                    @error('email')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Nomor BPJS</label>
                                        <input type="text" class="form-control" id="no_bpjs_edit" name="no_bpjs_edit" value="{{ old('no_bpjs') }}" readonly>
                                    </div>
                                    @error('no_bpjs')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Kelas BPJS</label>
                                        <input type="text" class="form-control" id="kelbpjs_edit" name="kelbpjs_edit" value="{{ old('kelbpjs') }}" readonly>
                                        @error('kelbpjs')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Jenis Peserta</label>
                                        <input type="text" class="form-control" id="jenper_edit" name="jenper_edit" value="{{ old('jenper') }}" readonly>
                                        @error('jenper')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Tanggal Akhir Berlaku</label>
                                        <input type="text" class="form-control" id="tgl_akhir_edit" name="tgl_akhir_edit" value="{{ old('tgl_akhir') }}" readonly>
                                    </div>
                                    @error('tgl_akhir')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Provider</label>
                                        <input type="text" class="form-control" id="provide_edit" name="provide_edit" value="{{ old('provide') }}" readonly>
                                    </div>
                                    @error('provide')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Hubungan Keluarga</label>
                                        <input type="text" class="form-control" id="hubka_edit" name="hubka_edit" value="{{ old('hubka') }}">
                                        @error('hubka')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Alamat </label>
                                        <input type="text" class="form-control" placeholder="Alamat" id="Alamat_edit" name="Alamat_edit" value="{{ old('Alamat') }}" >
                                    </div>
                                    @error('Alamat')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
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
                                <div class="col-sm-1">
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
                                        <label>Provinsi</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="provinsi_edit" name="provinsi_edit">
                                            <option value="" disabled selected >Provinsi</option>
                                            @foreach ($provinsi as $item)
                                                <option value="{{ $item->kode }}"  {{ old('provinsi') == $item->kode ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Kota/Kabupaten</label>
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="kota_kabupaten_edit" name="kota_kabupaten_edit" >
                                            <option value="" disabled selected>Kota/Kabupaten</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Kecamatan</label>
                                        <select class="form-control select2bs4"  style="width: 100%;"  id="kecamatan_edit" name="kecamatan_edit" value="{{ old('kecamatan') }}">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Desa/Kelurahan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="desa_edit" name="desa_edit" value="{{ old('desa') }}">
                                            <option value="" disabled selected>Desa/Kelurahan</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="seks_edit" name="seks_edit">
                                            <option value="" disabled selected>--- pilih ---</option>
                                            @foreach ($sex as $data)
                                                <option value="{{ $data->id }}" {{ old('seks') == $data->id ? 'selected' : '' }}>
                                                    {{ $data->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('seks')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
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


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Pendidikan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="pendidikan_edit" name="pendidikan_edit">
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

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Pekerjaan</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="pekerjaan_edit" name="pekerjaan_edit">
                                            <option value="" disabled selected>--- pilih ---</option>
                                            <option value="wirausaha" {{ old('pekerjaan') == 'wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                                            <option value="tidak_bekerja" {{ old('pekerjaan') == 'tidak_bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                                            <option value="pns" {{ old('pekerjaan') == 'pns' ? 'selected' : '' }}>PNS</option>
                                            <option value="tni_polri" {{ old('pekerjaan') == 'tni_polri' ? 'selected' : '' }}>TNI/Polri</option>
                                            <option value="bumn" {{ old('pekerjaan') == 'bumn' ? 'selected' : '' }}>BUMN</option>
                                            <option value="swasta" {{ old('pekerjaan') == 'swasta' ? 'selected' : '' }}>Pegawai Swasta</option>
                                            <option value="lain_lain" {{ old('pekerjaan') == 'lain_lain' ? 'selected' : '' }}>Lain - lain</option>
                                        </select>
                                        @error('pekerjaan')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Telepon</label>
                                        <input type="text" class="form-control" id="telepon_edit" name="telepon_edit" value="{{ old('telepon') }}">
                                        @error('telepon')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="profile-container text-center">
                                        <!-- Bingkai Gambar dengan Rasio 3:4 -->
                                        <div id="imageFrame" style="display: flex; justify-content: center; align-items: center; width: 75%; height: 0; padding-bottom: 80%; position: relative; overflow: hidden; background-color: #f0f0f0; cursor: pointer;" onclick="document.getElementById('foto_edit').click();">
                                            <!-- Gambar Profil Pengguna -->
                                            <img class="profile-user-img img-fluid" alt="Foto profile" id="previewImage_edit" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <!-- Input file disembunyikan, akan di-trigger oleh klik pada imageFrame -->
                                        <input type="file" class="form-control d-none" id="foto_edit" name="foto_edit" accept="image/*">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Suku</label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="suku_edit" name="suku_edit">
                                            <option value="" disabled selected>--- pilih ---</option>
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
                                            <option value="" disabled selected>--- pilih ---</option>
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
                                            <option value="" disabled selected>--- pilih ---</option>
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

                                <input type="hidden" id="kodeprovide_edit" name="kodeprovide_edit" >
                                <input type="hidden" id="userinput_edit" name="userinput_edit" value="{{ auth()->user()->name }}">
                                <input type="hidden" id="userinputid_edit" name="userinputid_edit" value="{{ auth()->user()->id }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button> <!-- Submit button -->
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletdockter" tabindex="-1" role="dialog" aria-labelledby="deletdockterModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletdockterModalLabel">Hapus Dokter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span >&times;</span>
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

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span >&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBodyText">
                    <!-- Pesan konfirmasi akan diisi dinamis -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalCancelButton">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#lengkapipasien').on('shown.bs.modal', function () {
                var nikField = $('#nik_lengkapi'); // Ambil elemen
                var nikValue = nikField.val(); // Ambil nilai dari input

                if (!nikValue) {
                    console.log("{{ $pasien->nik }}");

                    var nikFromDb = "{{ $pasien->nik ?? '' }}"; // Ambil dari database jika ada

                    console.log("NIK kosong, diisi dari database:", nikFromDb);
                    nikField.val(nikFromDb);
                }

                $('#username_lengkapi').val($('#nik_lengkapi').val());
            });
        });
    </script>

    <script>
        function handleNikInputs() {
            var nik = $('#nik_lengkapi').val(); // Ambil nilai NIK dari input
            if (nik) { // Periksa apakah input tidak kosong
                // $('#username_lengkapi').val(nik); // Isi nilai username dengan NIK
                fetchSatuSehat(nik, function(patientId) {
                    if (patientId) {
                        $('#kode_ihs_lengkapi').val(patientId || 'Tidak ditemukan');
                        // Anda bisa mengisi data lain di form jika diperlukan
                    } else {
                        console.log('Patient ID tidak ditemukan.');
                    }
                });
            } else {
                console.log('NIK kosong, tidak ada permintaan API yang dilakukan.');
            }
        }

        function fetchSatuSehat(identifier, callback) {
            $.ajax({
                url: '/api/get-nik-satusehat/' + identifier,
                method: 'GET',
                success: function(response) {
                    if (response && response.patient_data.entry.length > 0) {
                        var patient = response.patient_data.entry[0].resource;
                        callback(patient.id); // Panggil callback dengan ID pasien
                    } else {
                        callback(null); // Tidak ada data, kirim null
                    }
                },
                error: function() {
                    showErrorModal('Koneksi ke SatuSehat tidak stabil, silakan coba kembali.');
                    callback(null); // Kirim null jika ada error
                }
            });
        }

        function showErrorModal(message) {
            alert(message); // Anda bisa mengganti ini dengan modal Bootstrap atau lainnya
        }
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
                    message.textContent = `Apakah Anda yakin ingin menghapus data Pasien  ${doctorName}?`;
                    form.action = `{{ route('pasien.index.delete', '') }}/${doctorId}`;
                });
            });
        });
    </script>

    <script>
        function NIkdanNOKAnew() {
            var jenisKartu = document.getElementById('nik_lengkapi').value.trim();

            if (jenisKartu.length !== 16 || isNaN(jenisKartu)) {
                showErrorModal('Nomor NIK harus 16 digit angka.');
                return;
            }

            // Ambil nilai NIK sebelum callback dipanggil
            var nikadd = $('#nik_lengkapi').val();

            fetchSatuSehatl(jenisKartu, function(patientId) {
                if (!patientId) {
                    showErrorModal('Data tidak ditemukan, silakan periksa kembali.');
                    return;
                }
                // Set nilai input dengan NIK
                $('#username_lengkapi').val(nikadd);
                $('#kode_ihs_lengkapi').val(patientId || 'Tidak ditemukan');

                // Jika data ditemukan, lanjutkan pencarian berdasarkan jenis kartu
                fetchJenisKartuNikl(jenisKartu);
            });
        }


        function fetchSatuSehatl(identifier, callback) {
            if (identifier.length !== 16) return; // Validasi panjang nomor
            $.ajax({
                url: '/api/get-nik-satusehat/' + identifier,
                method: 'GET',
                success: function(response) {
                    if (response && response.patient_data && response.patient_data.entry && response.patient_data.entry.length > 0) {
                        var patient = response.patient_data.entry[0].resource;
                        callback(patient.id);
                    } else {
                        callback(null);
                    }
                },
                error: function() {
                    showErrorModal('Koneksi ke SatuSehat tidak stabil, silakan coba kembali.');
                    callback(null);
                }
            });
        }

        function fetchJenisKartuNikl(jenisKartu) {
            if (jenisKartu.length !== 16) return; // Validasi panjang nomor
            $.ajax({
                url: '/api/get-nik-bpjs/' + jenisKartu,
                method: 'GET',
                success: function(response) {
                    handleResponsel(response);
                },
                error: function() {
                    showErrorModal('Koneksi ke BPJS tidak stabil, silakan coba kembali.');
                }
            });
        }

        function handleResponsel(response) {
            if (!response || !response.data) {
                showErrorModal('Data tidak ditemukan, silakan periksa kembali.');
                return;
            }

            var datas = response.data;
            var name = datas.nama || '';
            var tglLahir = datas.tglLahir || '';
            var noBPJS = datas.noKartu || '';
            var Kadaluarsa = datas.tglAkhirBerlaku || '';
            var noktp = datas.noKTP || '';
            var ket = datas.aktif || false;
            var hubunganKeluarga = datas.hubunganKeluarga || '';
            var jnsKelas = datas.jnsKelas?.nama || '';
            var jnsPeserta = datas.jnsPeserta?.nama || '';
            var sex = datas.sex || '';
            var kdProvider = datas.kdProvider || '';
            var nmProvider = datas.nmProvider || '';

            $('#nama_lengkapi').val(name);
            $('#username_lengkapi').val(name);

            if (tglLahir) {
                var formattedDate = tglLahir.split('-').reverse().join('');
                $('#password_lengkapi').val(formattedDate);

                var parts = tglLahir.split("-");
                var formattedDates = parts[2] + "-" + parts[1] + "-" + parts[0]; // Format YYYY-MM-DD
                $('#tanggal_lahir_lengkapi').val(formattedDates);
            }

            $('#no_bpjs_lengkapi').val(noBPJS).trigger('keyup');
            $('#tgl_akhir_lengkapi').val(Kadaluarsa);
            $('#hubka_lengkapi').val(hubunganKeluarga);
            $('#kelbpjs_lengkapi').val(jnsKelas);
            $('#jenper_lengkapi').val(jnsPeserta);
            $('#seks').val(sex).trigger('change');

            var providerValue = nmProvider && kdProvider ? nmProvider + ' - ' + kdProvider : nmProvider || kdProvider || '';
            $('#provide_lengkapi').val(providerValue);
            $('#kodeprovide_lengkapi').val(kdProvider);
        }

        function showErrorModal(message) {
            $('#modalBodyText').text(message);
            $('#confirmationModal').modal('show');
        }
    </script>

<script>
    $(document).ready(function () {
        $('#tanggal_lahir_lengkapi').on('input change', function () {
            let inputDate = $(this).val(); // Ambil nilai dari input (YYYY-MM-DD)

            if (!inputDate) return; // Jika input kosong, hentikan proses

            // Ubah format dari YYYY-MM-DD menjadi YYYYMMDD (tanpa tanda -)
            let formattedPassword = inputDate.split('-').join('');

            // Set nilai password otomatis
            $('#password_lengkapi').val(formattedPassword);
        });
    });
</script>


    <script>
        $(document).ready(function() {
            // Ketika tombol Edit diklik
            $('.lkpBtn').on('click', function() {
                // Ambil ID dari tombol yang diklik
                var idPasien = $(this).data('id');

                // Panggil API untuk mendapatkan data pasien berdasarkan ID
                $.ajax({
                    url: '/api/pasien/cari-data-new/' + idPasien,  // URL ke API
                    method: 'GET',
                    success: function(pasien) {
                        // Isi modal dengan data pasien yang diterima dari API
                        $('#lengkapipasien #nomor_rm_lengkapi').val(pasien.no_rm);
                        $('#lengkapipasien #nik_lengkapi').val(pasien.nik ? pasien.nik : null);
                        $('#lengkapipasien #nama_lengkapi').val(pasien.nama ? pasien.nama : null);
                        $('#lengkapipasien #no_bpjs_lengkapi').val(pasien.no_bpjs ? pasien.no_bpjs : null);
                        $('#lengkapipasien #telepon_lengkapi').val(pasien.telepon).trigger('change');
                        // Set Kabupaten/Kota setelah Provinsi terpilih
                        if (pasien.kabupaten_kode) {
                            loadKabupatenEdit(pasien.provinsi_kode, pasien.kabupaten_kode);
                        }

                        // Set Kecamatan setelah Kabupaten terpilih
                        if (pasien.kecamatan_kode) {
                            loadKecamatanEdit(pasien.kabupaten_kode, pasien.kecamatan_kode);
                        }

                        // Set Desa setelah Kecamatan terpilih
                        if (pasien.desa_kode) {
                            loadDesaEdit(pasien.kecamatan_kode, pasien.desa_kode);
                        }

                        function loadKabupatenEdit(kodeProvinsi, selectedKabupaten = '') {
                            if (!kodeProvinsi) return;

                            $('#kota_kabupaten_lengkapi').empty().append('<option value="" disabled selected>Kota/Kabupaten</option>');

                            $.ajax({
                                url: '/api/get-kabupaten',
                                type: 'GET',
                                data: { kode_provinsi: kodeProvinsi },
                                success: function(response) {
                                    $.each(response, function(index, kabupaten) {
                                        var selected = kabupaten.kode == selectedKabupaten ? 'selected' : '';
                                        $('#kota_kabupaten_lengkapi').append('<option value="' + kabupaten.kode + '" ' + selected + '>' + kabupaten.name + '</option>');
                                    });

                                    if (selectedKabupaten) {
                                        $('#kota_kabupaten_lengkapi').trigger('change');
                                    }
                                }
                            });
                        }
                        function loadKecamatanEdit(kodeKabupaten, selectedKecamatan = '') {
                            if (!kodeKabupaten) return;

                            $('#kecamatan_lengkapi').empty().append('<option value="" disabled selected>Kecamatan</option>');

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

                                        $('#kecamatan_lengkapi').append('<option value="' + kecamatan.kode + '" ' + selected + '>' + kecamatan.name + '</option>');
                                    });

                                    // Jika ada kecamatan yang cocok, baru trigger change
                                    if (kecamatanFound) {
                                        $('#kecamatan_lengkapi').trigger('change');
                                    }
                                }
                            });
                        }



                        // Fungsi untuk memuat Desa berdasarkan Kecamatan
                        function loadDesaEdit(kodeKecamatan, selectedDesa = '') {
                            if (!kodeKecamatan) return;

                            $('#desa_lengkapi').empty().append('<option value="" disabled selected>Desa</option>');

                            $.ajax({
                                url: '/api/get-desa',
                                type: 'GET',
                                data: { kode_kecamatan: kodeKecamatan },
                                success: function(response) {
                                    $.each(response, function(index, desa) {
                                        var selected = desa.kode == selectedDesa ? 'selected' : '';
                                        $('#desa_lengkapi').append('<option value="' + desa.kode + '" ' + selected + '>' + desa.name + '</option>');
                                    });
                                }
                            });
                        }

                        // Saat Provinsi diubah, update Kabupaten/Kota
                        $('#provinsi_lengkapi').on('change', function() {
                            var kodeProvinsi = $(this).val();
                            loadKabupatenEdit(kodeProvinsi);
                        });

                        // Saat Kabupaten diubah, update Kecamatan
                        $('#kota_kabupaten_lengkapi').on('change', function() {
                            var kodeKabupaten = $(this).val();
                            loadKecamatanEdit(kodeKabupaten);
                        });

                        // Saat Kecamatan diubah, update Desa
                        $('#kecamatan_lengkapi').on('change', function() {
                            var kodeKecamatan = $(this).val();
                            loadDesaEdit(kodeKecamatan);
                        });

                       // Ambil gambar profil dari API
                        var profileImage = pasien.profile || 'default.png'; // Jika tidak ada, gunakan default.png

                        // Pastikan path gambar benar
                        var imagePath = '/uploads/patient_photos/' + profileImage; // Sesuaikan dengan lokasi penyimpanan gambar

                        // Tampilkan gambar profil di form edit
                        $('#previewImage_lengkapi').attr('src', imagePath);

                    },
                    error: function() {
                        alert('Data pasien tidak ditemukan.');
                    }
                });
            });
        });

    </script>
    {{-- Script untuk edit --}}
    <script>
        $(document).ready(function() {
            // Ketika tombol Edit diklik
            $('.editBtn').on('click', function() {
                // Ambil ID dari tombol yang diklik
                var idPasien = $(this).data('id');

                // Panggil API untuk mendapatkan data pasien berdasarkan ID
                $.ajax({
                    url: '/api/pasien/cari-data/' + idPasien,  // URL ke API
                    method: 'GET',
                    success: function(pasien) {
                        // Isi modal dengan data pasien yang diterima dari API
                        $('#editpasien #nomor_rm_edit').val(pasien.no_rm);
                        $('#editpasien #nik_edit').val(pasien.nik);
                        $('#editpasien #kode_ihs_edit').val(pasien.kode_ihs);
                        $('#editpasien #nama_edit').val(pasien.nama);
                        $('#editpasien #tempat_lahir_edit').val(pasien.tempat_lahir);
                        $('#editpasien #tanggal_lahir_edit').val(pasien.tanggal_lahir);
                        $('#editpasien #username_edit').val(pasien.username);
                        $('#editpasien #password_edit').val('*********');
                        $('#editpasien #email_edit').val(pasien.email);
                        $('#editpasien #no_bpjs_edit').val(pasien.no_bpjs);
                        $('#editpasien #kelbpjs_edit').val(pasien.kelas_bpjs);
                        $('#editpasien #jenper_edit').val(pasien.jenis_bpjs);
                        $('#editpasien #tgl_akhir_edit').val(pasien.tgl_akhir);
                        $('#editpasien #provide_edit').val(pasien.provide);
                        $('#editpasien #hubka_edit').val(pasien.hubungan_keluarga);
                        $('#editpasien #Alamat_edit').val(pasien.Alamat);
                        $('#editpasien #rt_edit').val(pasien.rt);
                        $('#editpasien #rw_edit').val(pasien.rw);
                        $('#editpasien #kode_pos_edit').val(pasien.kode_pos);
                        $('#editpasien #kewarganegaraan_edit').val(pasien.kewarganegaraan).trigger('change');
                        $('#editpasien #provinsi_edit').val(pasien.provinsi_kode).trigger('change');
                        $('#editpasien #seks_edit').val(pasien.seks).trigger('change');
                        $('#editpasien #agama_edit').val(pasien.agama).trigger('change');
                        $('#editpasien #pendidikan_edit').val(pasien.pendidikan).trigger('change');
                        $('#editpasien #goldar_edit').val(pasien.goldar_id).trigger('change');
                        $('#editpasien #pernikahan_edit').val(pasien.pernikahan).trigger('change');
                        $('#editpasien #pekerjaan_edit').val(pasien.pekerjaan).trigger('change');
                        $('#editpasien #telepon_edit').val(pasien.telepon).trigger('change');
                        $('#editpasien #suku_edit').val(pasien.suku).trigger('change');
                        $('#editpasien #bangsa_edit').val(pasien.bahasa).trigger('change');
                        $('#editpasien #bahasa_edit').val(pasien.bangsa).trigger('change');
                        $('#editpasien #kodeprovide_edit').val(pasien.bangsa).trigger('change');

                        // Set Kabupaten/Kota setelah Provinsi terpilih
                        if (pasien.kabupaten_kode) {
                            loadKabupatenEdit(pasien.provinsi_kode, pasien.kabupaten_kode);
                        }

                        // Set Kecamatan setelah Kabupaten terpilih
                        if (pasien.kecamatan_kode) {
                            loadKecamatanEdit(pasien.kabupaten_kode, pasien.kecamatan_kode);
                        }

                        // Set Desa setelah Kecamatan terpilih
                        if (pasien.desa_kode) {
                            loadDesaEdit(pasien.kecamatan_kode, pasien.desa_kode);
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
                        var imagePath = '/uploads/patient_photos/' + profileImage; // Sesuaikan dengan lokasi penyimpanan gambar

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

    {{-- Script untuk pratinjau gambar --}}
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

    {{-- Script untuk pratinjau gambar 1 --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('foto_lengkapi').addEventListener('change', function(event) {
                var reader = new FileReader();

                reader.onload = function() {
                    var output = document.getElementById('previewImage_lengkapi');
                    output.src = reader.result; // Menampilkan gambar pratinjau
                };

                if (event.target.files[0]) {
                    reader.readAsDataURL(event.target.files[0]);
                }
            });
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('foto_edit').addEventListener('change', function(event) {
                var reader = new FileReader();

                reader.onload = function() {
                    var output = document.getElementById('previewImage_edit');
                    output.src = reader.result; // Menampilkan gambar pratinjau
                };

                if (event.target.files[0]) {
                    reader.readAsDataURL(event.target.files[0]);
                }
            });
        });

    </script>

    {{-- script untuk button clear #1 --}}
    <script>
        document.getElementById('clearModalButton').addEventListener('click', function() {
        // Dapatkan modal berdasarkan ID
        var modal = document.getElementById('addpasien');

        // Hapus nilai semua input di dalam modal
        modal.querySelectorAll('input').forEach(function(input) {
            input.value = ''; // Kosongkan nilai
            input.classList.remove('is-invalid'); // Hapus kelas error
        });

        // Hapus pesan error
        modal.querySelectorAll('.alert').forEach(function(alert) {
            alert.style.display = 'none';
        });

        // Reset semua elemen select jika ada
        modal.querySelectorAll('select').forEach(function(select) {
            select.selectedIndex = 0; // Pilih opsi pertama
        });

        // Reset gambar profil
        var previewImage = document.getElementById('previewImage');
        previewImage.src = ''; // Kosongkan gambar preview

        $('button[type="submit"]').prop('disabled', false);
    });
    </script>

    {{-- script untuk button clear #2 --}}
    <script>
        @if ($errors->any())
            $(document).ready(function() {
                $('#addpasien').modal('show'); // Membuka modal jika ada error
            });
        @endif
    </script>

    {{-- script untuk cek nomor  NIK  yang sudah terdaftar di Database --}}
    <script>
        $(document).ready(function() {
            $('#nik').on('keyup', function() { // Trigger the check when the user leaves the field
                var nik = $(this).val();

                if (nik) {
                    $.ajax({
                        url: '/api/check-nik', // Route to check NIK uniqueness
                        method: 'POST',
                        data: {
                            nik: nik,
                            _token: '{{ csrf_token() }}' // CSRF token for security
                        },
                        success: function(response) {
                            if (response.exists) {
                                // Display an error message if NIK exists
                                $('#nik').addClass('is-invalid');
                                $('#bpjs_error1').text('Pasien Sudah terdaftar').show();
                                $('button[type="submit"]').prop('disabled', true);
                            } else {
                                $('#nik').removeClass('is-invalid');
                                $('#bpjs_error1').hide();
                                $('button[type="submit"]').prop('disabled', false);
                                generateNomorRM();

                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('Error:', error);
                        }
                    });
                }
            });
        });

    </script>

    {{-- script untuk cek nomor kartu BPJS yang sudah terdaftar di Database --}}
    <script>
        $(document).ready(function() {
            $('#no_bpjs').on('keyup', function() {
                var no_bpjs = $(this).val();

                if (no_bpjs) {
                    $.ajax({
                        url: '/api/check-noka', // Route to check NIK uniqueness
                        method: 'POST',
                        data: {
                            no_bpjs: no_bpjs,
                            _token: '{{ csrf_token() }}' // CSRF token for security
                        },
                        success: function(response) {
                            if (response.exists) {
                                // Display an error message if NIK exists
                                $('#no_bpjs').addClass('is-invalid');
                                $('#bpjs_error1').text('Pasien Sudah terdaftar').show();
                                $('button[type="submit"]').prop('disabled', true);
                            } else {
                                $('#no_bpjs').removeClass('is-invalid');
                                $('#bpjs_error1').hide();
                                $('button[type="submit"]').prop('disabled', false);

                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('Error:', error);
                        }
                    });
                }
            });
        });

    </script>

    {{-- script untuk get data ke satusehat --}}
    <script>
        function handleNikInput() {
            var nik = $('#nik').val(); // Ambil nilai NIK dari input
            if (nik) { // Periksa apakah input tidak kosong
                fetchSatuSehat(nik, function(patientId) {
                    if (patientId) {
                        $('#kode_ihs').val(patientId || 'Tidak ditemukan');
                        // Anda bisa mengisi data lain di form jika diperlukan
                    } else {
                        console.log('Patient ID tidak ditemukan.');
                    }
                });
            } else {
                console.log('NIK kosong, tidak ada permintaan API yang dilakukan.');
            }
        }

        function fetchSatuSehat(identifier, callback) {
            $.ajax({
                url: '/api/get-nik-satusehat/' + identifier,
                method: 'GET',
                success: function(response) {
                    if (response && response.patient_data.entry.length > 0) {
                        var patient = response.patient_data.entry[0].resource;
                        callback(patient.id); // Panggil callback dengan ID pasien
                    } else {
                        callback(null); // Tidak ada data, kirim null
                    }
                },
                error: function() {
                    showErrorModal('Koneksi ke SatuSehat tidak stabil, silakan coba kembali.');
                    callback(null); // Kirim null jika ada error
                }
            });
        }

        function showErrorModal(message) {
            alert(message); // Anda bisa mengganti ini dengan modal Bootstrap atau lainnya
        }
    </script>

    {{-- script untuk get data ke bpjs dan satusehat --}}
    <script>
        function NIkdanNOKA() {
            var jenisKartu = document.getElementById('nomber').value;

            if (jenisKartu.length === 16) {
                fetchSatuSehat(jenisKartu, function(patientId) {
                    $('#kode_ihs').val(patientId || 'Tidak ditemukan');
                    if (!patientId) {
                        showErrorModal('Data tidak ditemukan, silakan periksa kembali.');
                        return;
                    }
                    fetchJenisKartuNik(jenisKartu);
                });
            } else if (jenisKartu.length === 13) {
                fetchJenisKartu(jenisKartu, function(response) {
                    if (!response || !response.data) {
                        showErrorModal('Data tidak ditemukan, silakan periksa kembali.');
                        return;
                    }
                    handleResponse(response);

                    var noktp = response.data.noKTP;
                    if (noktp) {
                        fetchSatuSehat(noktp, function(patientId) {
                            $('#kode_ihs').val(patientId || 'Tidak ditemukan');
                            if (!patientId) {
                                showErrorModal('Data tidak ditemukan, silakan periksa kembali.');
                            }
                        });
                    } else {
                        showErrorModal('No KTP tidak tersedia, silakan periksa kembali.');
                    }
                });
            }
        }

        function fetchSatuSehat(identifier, callback) {
            $.ajax({
                url: '/api/get-nik-satusehat/' + identifier,
                method: 'GET',
                success: function(response) {
                    if (response && response.patient_data.entry.length > 0) {
                        var patient = response.patient_data.entry[0].resource;
                        callback(patient.id);
                    } else {
                        callback(null);
                    }
                },
                error: function() {
                    showErrorModal('Koneksi ke SatuSehat tidak stabil, silakan coba kembali.');
                    callback(null);
                }
            });
        }

        function fetchJenisKartu(jenisKartu, callback) {
            $.ajax({
                url: '/api/get-noka-bpjs/' + jenisKartu,
                method: 'GET',
                success: function(response) {
                    callback(response);
                    generateNomorRM();
                },
                error: function() {
                    showErrorModal('Koneksi ke BPJS tidak stabil, silakan coba kembali.');
                    callback(null);
                }
            });
        }

        function fetchJenisKartuNik(jenisKartu) {
            $.ajax({
                url: '/api/get-nik-bpjs/' + jenisKartu,
                method: 'GET',
                success: function(response) {
                    handleResponse(response);
                    generateNomorRM();
                },
                error: function() {
                    showErrorModal('Koneksi ke BPJS tidak stabil, silakan coba kembali.');
                }
            });
        }

        function handleResponse(response) {
            if (!response || !response.data) {
                showErrorModal('Data tidak ditemukan, silakan periksa kembali.');
                return;
            }

            var datas = response.data;
            var name = datas.nama || null;
            var tglLahir = datas.tglLahir || null;
            var noBPJS = datas.noKartu || null;
            var Kadaluarsa = datas.tglAkhirBerlaku || null;
            var noktp = datas.noKTP || null;
            var ket = datas.aktif || false;
            var hubunganKeluarga = datas.hubunganKeluarga || null;
            var jnsKelas = datas.jnsKelas.nama || null;
            var jnsPeserta = datas.jnsPeserta.nama || null;
            var sex = datas.sex || null;
            var kdProvider = datas.kdProviderPst.kdProvider || null;
            var nmProvider = datas.kdProviderPst.nmProvider || null;

            $('#nik').val(noktp).trigger('keyup');
            $('#nama').val(name);
            $('#username').val(name);

            var formattedDate = tglLahir.split('-').reverse().join('');
            $('#password').val(formattedDate);
            var parts = tglLahir.split("-");
            var formattedDates = parts[2] + "-" + parts[1] + "-" + parts[0]; // Susun ulang menjadi YYYY-MM-DD
            $('#tanggal_lahir').val(formattedDates);
            $('#no_bpjs').val(noBPJS).trigger('keyup');
            $('#tgl_akhir').val(Kadaluarsa);
            $('#hubka').val(hubunganKeluarga);
            $('#kelbpjs').val(jnsKelas);
            $('#jenper').val(jnsPeserta);
            $('#seks').val(sex).trigger('change');
            var providerValue = '';
            if (nmProvider || kdProvider) {
                providerValue = (nmProvider || '') + ((nmProvider && kdProvider) ? ' - ' : '') + (kdProvider || '');
            }
            $('#provide').val(providerValue);
            $('#kodeprovide').val(kdProvider);
            if (ket === true) {
                $('#bpjs_error').hide();
            } else {
                $('#bpjs_error').text(datas.ketAktif || 'Status tidak aktif').show();
            }
        }

        function showErrorModal(message) {
            $('#modalBodyText').text(message);
            $('#confirmationModal').modal('show');
        }
    </script>

    {{-- scipt untuk Username  --}}
    <script>
        $(document).ready(function () {
            $('#nik').on('blur', function () {
                var nik = $(this).val();
                $('#username').val(nik);
            });
        });
    </script>

    {{-- scipt untuk password  --}}
    <script>
        $(document).on('change', '#tanggal_lahir', function () {
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

    {{-- script untuk Wilayah --}}
    <script>
        $(document).ready(function() {
            // Simpan old value dari server
            var oldKabupaten = "{{ old('kota_kabupaten') }}";
            var oldKecamatan = "{{ old('kecamatan') }}";
            var oldDesa = "{{ old('desa') }}";

            // Trigger change event untuk memuat data lama berdasarkan provinsi yang dipilih
            $('#provinsi').on('change', function() {
                var kodeProvinsi = $(this).val();

                $('#kota_kabupaten').empty().append('<option value="" disabled selected>Kota/Kabupaten</option>');
                $('#kecamatan').empty().append('<option value="" disabled selected>Kecamatan</option>');
                $('#desa').empty().append('<option value="" disabled selected>Desa</option>');

                if (kodeProvinsi) {
                    $.ajax({
                        url: '/api',
                        type: 'GET',
                        data: { kode_provinsi: kodeProvinsi },
                        success: function(response) {
                            $.each(response, function(index, kabupaten) {
                                var selected = kabupaten.kode == oldKabupaten ? 'selected' : '';
                                $('#kota_kabupaten').append('<option value="' + kabupaten.kode + '" ' + selected + '>' + kabupaten.name + '</option>');
                            });

                            // Jika ada old value kabupaten, trigger change untuk memuat kecamatan
                            if (oldKabupaten) {
                                $('#kota_kabupaten').trigger('change');
                            }
                        }
                    });
                }
            });

            $('#kota_kabupaten').on('change', function() {
                var kodeKabupaten = $(this).val();

                $('#kecamatan').empty().append('<option value="" disabled selected>Kecamatan</option>');
                $('#desa').empty().append('<option value="" disabled selected>Desa</option>');

                if (kodeKabupaten) {
                    $.ajax({
                        url: '/api/get-kecamatan',
                        type: 'GET',
                        data: { kode_kabupaten: kodeKabupaten },
                        success: function(response) {
                            $.each(response, function(index, kecamatan) {
                                var selected = kecamatan.kode == oldKecamatan ? 'selected' : '';
                                $('#kecamatan').append('<option value="' + kecamatan.kode + '" ' + selected + '>' + kecamatan.name + '</option>');
                            });

                            // Jika ada old value kecamatan, trigger change untuk memuat desa
                            if (oldKecamatan) {
                                $('#kecamatan').trigger('change');
                            }
                        }
                    });
                }
            });

            $('#kecamatan').on('change', function() {
                var kodeKecamatan = $(this).val();

                $('#desa').empty().append('<option value="" disabled selected>Desa</option>');

                if (kodeKecamatan) {
                    $.ajax({
                        url: '/api/get-desa',
                        type: 'GET',
                        data: { kode_kecamatan: kodeKecamatan },
                        success: function(response) {
                            $.each(response, function(index, desa) {
                                var selected = desa.kode == oldDesa ? 'selected' : '';
                                $('#desa').append('<option value="' + desa.kode + '" ' + selected + '>' + desa.name + '</option>');
                            });
                        }
                    });
                }
            });

            // Trigger initial load jika ada old value provinsi
            var oldProvinsi = "{{ old('provinsi') }}";
            if (oldProvinsi) {
                $('#provinsi').val(oldProvinsi).trigger('change');
            }
        });

    </script>

    {{-- script untuk membuat nomor rm --}}
    <script>
        function generateNomorRM() {
            fetch('/api/patient/generate-nomor-rm')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('nomor_rm').value = data.nomor_rm;
                })
            .catch(error => console.error('Error:', error));
        }
    </script>

    {{-- script untuk Tabel --}}
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
