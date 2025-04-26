<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @php
    $setweb = App\Models\setweb::first();
  @endphp
  <title>{{  $setweb->name_app }}</title>

  <link rel="icon" sizes="180x180" type="image/x-icon" href="{{ asset('webset/' . $setweb->logo_app) }}">
  <!-- Jquery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- chartjs -->
  <script src="{{ asset('plugins/chart.js/Chart.js') }}"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
      href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <!-- Select2 Bootstrap 4-->
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.css') }}">
  <script src="https://cdn.socket.io/4.7.4/socket.io.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.js"></script>
  <style>
    html, body {
      height: 100%; /* Set full height */
      margin: 0; /* Remove default margin */
    }

    .wrapper {
      min-height: 100vh; /* Set minimum height for the wrapper */
    }

    .content-wrapper {
      min-height: calc(100vh - 56px); /* Adjust height for navbar and footer */
    }

    .content {
      padding: 20px; /* Add padding to content */
    }
  </style>
  <!-- CSS tambahan untuk penataan -->
<style>
    .profil-perusahaan, .visi-misi, .tim-manajemen,  {
        padding: 15px;

        margin-bottom: 20px;
    }

    h3 {
        color: #333;
        margin-bottom: 15px;
    }

    h5 {
        margin-top: 15px;
    }

    p {
        line-height: 1.5;
    }
</style>
<!-- CSS tambahan untuk penataan -->
<style>
    .profil-perusahaan {
        padding: 15px;
        margin-bottom: 20px;
    }

    .profil-perusahaan h5 {
        text-align: center; /* Menyelaraskan judul ke tengah */
    }

    .profil-perusahaan p {
        line-height: 1.5;
    }
</style>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mt-2">
                    <div class="col-md-12 d-flex justify-content-center align-items-center">
                        <h1 class="m-0">Odontogram</h1>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="mt-3 col-12">
                        <div class="row">
                            <!-- Identitas Pasien -->
                            <div class="col-md-3 d-flex align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-header bg-light">
                                        <h5><i class="fa fa-user"></i> Data Pasien</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="tgl_kunjungan">Tanggal</label>
                                                <input type="checkbox" id="toggle-edit-date" name="toggle-edit-date">
                                                <input type="date" class="form-control" id="tgl_kunjungan" name="tgl_kunjungan" readonly>
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
                                            <div class="col-md-12">
                                                <label for="tgl_lahir">Tanggal Lahir</label>
                                                <input type="text" class="form-control" value="{{$rajaldata->tgl_lahir}}" id="tgl_lahir" name="tgl_lahir" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="umur">Umur</label>
                                                <input type="text" class="form-control" value="{{$umur}}" id="umur" name="umur" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pemeriksaan -->
                            <div class="col-md-9 d-flex align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-header bg-light">
                                        <h5><i class="fa fa-stethoscope"></i>otonogam</h5>
                                    </div>
                                    <div class="card-body">
                                        <style>
                                            .svg-container {
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;
                                                width: 100%;
                                            }
                                            .clickable-box {
                                                cursor: pointer;
                                            }
                                        </style>
                                        <div class="container svg-container">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" viewBox="0 0 980 300" preserveAspectRatio="xMidYMin meet">
                                                @php
                                                    $leftNumbers = [18, 17, 16, 15, 14, 13, 12, 11, 55, 54, 53, 52, 51, 85, 84, 83, 82, 81, 48, 47, 46, 45, 44, 43, 42, 41];
                                                    $rightNumbers = [21, 22, 23, 24, 25, 26, 27, 28, 61, 62, 63, 64, 65, 71, 72, 73, 74, 75, 31, 32, 33, 34, 35, 36, 37, 38];
                                                @endphp
                                                <!-- Kotak Kiri -->
                                                @foreach ($leftNumbers as $index => $number)
                                                    @php
                                                        $row = $index < 8 ? 0 : ($index < 13 ? 1 : ($index < 18 ? 2 : 3));
                                                        $col = $index < 8 ? $index : ($index < 13 ? $index - 8 + 1.5 : ($index < 18 ? $index - 13 + 1.5 : $index - 18));
                                                        $x = $col * 60;
                                                        $y = $row * 60;
                                                        $isDiagonal = in_array($number, [14, 15, 16, 17, 18, 44, 45, 46, 47, 48, 54, 55, 84, 85]);
                                                        $isMiddleLine = in_array($number, [11, 12, 13, 51, 52, 53, 81, 82, 83, 41, 42, 43]);
                                                        $imagePath = $isDiagonal ? "/images/geraham.png" : ($isMiddleLine ? "/images/seri.png" : "/images/geraham.png");
                                                    @endphp

                                                    <g class="clickable-box" data-number="{{ $number }}">
                                                        <image
                                                            x="{{ $x + 10 }}"
                                                            y="{{ $y + 10 }}"
                                                            width="40"
                                                            height="40"
                                                            href="{{ $imagePath }}"
                                                            pointer-events="all"
                                                        />
                                                        <text
                                                            x="{{ $x + 30 }}"
                                                            y="{{ $y + 65 }}"
                                                            font-size="12"
                                                            text-anchor="middle"
                                                            pointer-events="none"
                                                        >
                                                            {{ $number }}
                                                        </text>
                                                    </g>
                                                @endforeach

                                                <!-- Divider -->
                                                <rect x="490" y="0" width="5" height="255" fill="red" />

                                                  <!-- Kotak Kanan -->
                                                  @foreach ($rightNumbers as $index => $number)
                                                  @php
                                                      $row = $index < 8 ? 0 : ($index < 13 ? 1 : ($index < 18 ? 2 : 3));
                                                      $col = $index < 8 ? $index : ($index < 13 ? $index - 8 + 1.5 : ($index < 18 ? $index - 13 + 1.5 : $index - 18));
                                                      $x = $col * 60 + 500;
                                                      $y = $row * 60;
                                                      $isDiagonal = in_array($number, [24, 25, 26, 27, 28, 34, 35, 36, 37, 38, 64, 65, 74, 75]);
                                                      $isMiddleLine = in_array($number, [21, 22, 23, 61, 62, 63, 71, 72, 73, 31, 32, 33]);
                                                      $imagePath = $isDiagonal ? "/images/geraham.png" : ($isMiddleLine ? "/images/seri.png" : "/images/geraham.png");
                                                  @endphp

                                                  <g class="clickable-box" data-number="{{ $number }}">
                                                      <image
                                                          x="{{ $x + 10 }}"
                                                          y="{{ $y + 10 }}"
                                                          width="40"
                                                          height="40"
                                                          href="{{ $imagePath }}"
                                                          pointer-events="all"
                                                      />
                                                      <text
                                                          x="{{ $x + 30 }}"
                                                          y="{{ $y + 65 }}"
                                                          font-size="12"
                                                          text-anchor="middle"
                                                          pointer-events="none"
                                                      >
                                                          {{ $number }}
                                                      </text>
                                                  </g>
                                                  @endforeach
                                            </svg>
                                        </div>
                                        <hr>
                                        <label for="">Kondisi Gigi : </label>
                                        <div class="container" style="display: flex; justify-content: center; gap: 20px;  text-align: center;">
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/AMF.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>AMF</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/COF.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>COF</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/FIS.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>FIS</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/NVT.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>NVT</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/RCT.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>RCT</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/CAR.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>CAR</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/AMF-CRT.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>AMF-CRT</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/FMC.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>FMC</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/FMC-RCT.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>FMC-RCT</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/POC.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>POC</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/POC-RCT.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>POC-RCT</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/RRX.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>RRX</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/MIS.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>MIS</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/COF_.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>COF_</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/CRF.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>CFR</span>
                                            </div>
                                            <div style="text-align: center;">
                                                <div style="width: 30px; height: 30px; background: url('/images/COF-RCT.png') no-repeat center center; background-size: cover; margin: 0 auto;"></div>
                                                <span>COF-RCT</span>
                                            </div>

                                        </div>
                                            <br>
                                        <div class="container">
                                            <form action="{{ route('layanan.rawat-jalan.soap-dokter.index.odontogram.add.details') }}" method="POST">
                                                @csrf
                                            <div class="row">
                                                    <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Decayed</label>
                                                                <input type="text" class="form-control" id="Decayed" name="Decayed" value="{{ old('Decayed', $gigiDetails->Decayed ?? '') }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Missing</label>
                                                                <input type="text" class="form-control" id="Missing" name="Missing" value="{{ old('Missing', $gigiDetails->Missing ?? '') }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Filled</label>
                                                                <input type="text" class="form-control" id="Filled" name="Filled" value="{{ old('Filled', $gigiDetails->Filled ?? '') }}">
                                                            </div>
                                                        <div class="col-md-2">
                                                            <button type="submit" class="btn btn-info" >Simpan</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">

                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Jumlah Foto</label>
                                                            <input type="number" class="form-control" id="Foto" name="Foto" min="0" value="{{ old('Foto', $gigiDetails->Foto ?? 0) }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Jumlah Rontgen Foto</label>
                                                            <input type="number" class="form-control" id="Rontgen" name="Rontgen" min="0"  value="{{ old('Rontgen', $gigiDetails->Rontgen ?? 0) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="col-sm-12">
                                                            <div class="form-group" style="display: flex; align-items: center;">
                                                                <label for="Oclusi" style="margin-right: 10px; width: 150px;">Oclusi</label>
                                                                <select class="form-control" id="Oclusi" name="Oclusi" style="flex: 1;">
                                                                    <option value="">Pilih</option>
                                                                    <option value="Normal Bite" {{ (isset($gigiDetails) && $gigiDetails->Oclusi == 'Normal Bite') ? 'selected' : '' }}>Normal Bite</option>
                                                                    <option value="Cross Bite" {{ (isset($gigiDetails) && $gigiDetails->Oclusi == 'Cross Bite') ? 'selected' : '' }}>Cross Bite</option>
                                                                    <option value="deep Bite" {{ (isset($gigiDetails) && $gigiDetails->Oclusi == 'deep Bite') ? 'selected' : '' }}>Deep Bite</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group" style="display: flex; align-items: center;">
                                                                <label for="Palatinus" style="margin-right: 10px; width: 150px;">Torus Palatinus</label>
                                                                <select class="form-control" id="Palatinus" name="Palatinus" style="flex: 1;">
                                                                    <option value="">Pilih</option>
                                                                    <option value="Tidak Ada" {{ (isset($gigiDetails) && $gigiDetails->Palatinus == 'Tidak Ada') ? 'selected' : '' }}>Tidak Ada</option>
                                                                    <option value="Kecil" {{ (isset($gigiDetails) && $gigiDetails->Palatinus == 'Kecil') ? 'selected' : '' }}>Kecil</option>
                                                                    <option value="Sedang" {{ (isset($gigiDetails) && $gigiDetails->Palatinus == 'Sedang') ? 'selected' : '' }}>Sedang</option>
                                                                    <option value="Besar" {{ (isset($gigiDetails) && $gigiDetails->Palatinus == 'Besar') ? 'selected' : '' }}>Besar</option>
                                                                    <option value="Multiple" {{ (isset($gigiDetails) && $gigiDetails->Palatinus == 'Multiple') ? 'selected' : '' }}>Multiple</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group" style="display: flex; align-items: center;">
                                                                <label for="Mandibularis" style="margin-right: 10px; width: 150px;">Torus Mandibularis</label>
                                                                <select class="form-control" id="Mandibularis" name="Mandibularis" style="flex: 1;">
                                                                    <option value="">Pilih</option>
                                                                    <option value="Sisi Kiri" {{ (isset($gigiDetails) && $gigiDetails->Mandibularis == 'Sisi Kiri') ? 'selected' : '' }}>Sisi Kiri</option>
                                                                    <option value="Sisi Kanan" {{ (isset($gigiDetails) && $gigiDetails->Mandibularis == 'Sisi Kanan') ? 'selected' : '' }}>Sisi Kanan</option>
                                                                    <option value="Kedua Sisi" {{ (isset($gigiDetails) && $gigiDetails->Mandibularis == 'Kedua Sisi') ? 'selected' : '' }}>Kedua Sisi</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group" style="display: flex; align-items: center;">
                                                                <label for="Platum" style="margin-right: 10px; width: 150px;">Platum</label>
                                                                <select class="form-control" id="Platum" name="Platum" style="flex: 1;">
                                                                    <option value="">Pilih</option>
                                                                    <option value="Dalam" {{ (isset($gigiDetails) && $gigiDetails->Platum == 'Dalam') ? 'selected' : '' }}>Dalam</option>
                                                                    <option value="Sedang" {{ (isset($gigiDetails) && $gigiDetails->Platum == 'Sedang') ? 'selected' : '' }}>Sedang</option>
                                                                    <option value="Rendah" {{ (isset($gigiDetails) && $gigiDetails->Platum == 'Rendah') ? 'selected' : '' }}>Rendah</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group" style="display: flex; align-items: center;">
                                                                <label for="Diastema" style="margin-right: 10px; width: 150px;">Diastema</label>
                                                                <select class="form-control" id="Diastema" name="Diastema" style="flex: 1;">
                                                                    <option value="">Pilih</option>
                                                                    <option value="Ada" {{ (isset($gigiDetails) && $gigiDetails->Diastema == 'Ada') ? 'selected' : '' }}>Ada</option>
                                                                    <option value="Tidak Ada" {{ (isset($gigiDetails) && $gigiDetails->Diastema == 'Tidak Ada') ? 'selected' : '' }}>Tidak Ada</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group" style="display: flex; align-items: center;">
                                                                <label for="Anomali" style="margin-right: 10px; width: 150px;">Gigi Anomali</label>
                                                                <select class="form-control" id="Anomali" name="Anomali" style="flex: 1;">
                                                                    <option value="">Pilih</option>
                                                                    <option value="Ada" {{ (isset($gigiDetails) && $gigiDetails->Anomali == 'Ada') ? 'selected' : '' }}>Ada</option>
                                                                    <option value="Tidak Ada" {{ (isset($gigiDetails) && $gigiDetails->Anomali == 'Tidak Ada') ? 'selected' : '' }}>Tidak Ada</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="rawatt_id" value="{{$rajaldata->no_rawat}}">
                                                        <input type="hidden" name="patient_id" value="{{$rajaldata->no_rm}}">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- Modal Bootstrap -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="infoModalLabel">Pilih Kondisi Gigi</h5>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="kondisiGigi">Pilih Kondisi:</label>
            <select class="form-control select2bs4" style="width: 100%;" id="kondisiGigi" name="kondisiGigi">
                <option value="AMF" data-color="AMF">AMF</option>
                <option value="COF" data-color="COF">COF</option>
                <option value="FIS" data-color="FIS">FIS</option>
                <option value="NVT" data-color="NVT">NVT</option>
                <option value="RCT" data-color="RCT">RCT</option>
                <option value="CAR" data-color="CAR">CAR</option>
                <option value="AMF-CRT" data-color="AMF-CRT">AMF-CRT</option>
                <option value="FMC" data-color="FMC">FMC</option>
                <option value="FMC-RCT" data-color="FMC-RCT">FMC-RCT</option>
                <option value="POC" data-color="POC">POC</option>
                <option value="POC-RCT" data-color="POC-RCT">POC-RCT</option>
                <option value="RRX" data-color="RRX">RRX</option>
                <option value="MIS" data-color="MIS">MIS</option>
                <option value="COF_" data-color="COF_">COF_</option>
                <option value="CRF" data-color="CRF">CRF</option>
                <option value="COF-RCT" data-color="COF-RCT">COF-RCT</option>

              </select>
          </div>
          <!-- Input for Note -->
            <div class="form-group">
                <label for="noteGigi">Catatan:</label>
                <textarea class="form-control" id="noteGigi" name="noteGigi" rows="3" placeholder="Masukkan catatan terkait kondisi gigi di sini..."></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="saveButton">Simpan</button>
        </div>
      </div>
    </div>
</div>


<script>

    let selectedBox = null;

    // Get the patient ID from PHP
    const patientId = '<?php echo $rajaldata->no_rm; ?>'; // Get patient ID from PHP
    const treatmentId = '<?php echo $rajaldata->no_rawat; ?>'; // Get patient ID from PHP

    // Buat satu instance modal untuk digunakan di seluruh skrip


    // Klik kotak SVG
    document.querySelectorAll('.clickable-box').forEach(box => {
        box.addEventListener('click', function (event) {
            // Pastikan elemen induk dengan data-number dipilih
            selectedBox = event.target.closest('.clickable-box');
            if (!selectedBox) return;

            const number = selectedBox.getAttribute('data-number'); // Ambil nomor kotak
            if (!number) {
                console.error('Nomor gigi tidak ditemukan!');
                return;
            }

            document.getElementById('infoModalLabel').textContent = `Pilih Kondisi Gigi (${number})`;

            // Tampilkan modal
            $('#infoModal').modal('show');

        });
    });

    // Simpan perubahan
    document.getElementById('saveButton').addEventListener('click', function () {
        if (!selectedBox) {
            console.error('No tooth box selected!');
            return;
        }

        // Get selected options and note
        const selectedOption = document.getElementById('kondisiGigi').selectedOptions[0];
        const condition = selectedOption.getAttribute('data-color');
        const note = document.getElementById('noteGigi').value;
        const toothNumber = selectedBox.getAttribute('data-number');

        // Update SVG visually
        updateToothBox(toothNumber, condition, note);

        // Prepare form data
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('patient_id', patientId);
        formData.append('treatment_id', treatmentId);
        formData.append('tooth_number', toothNumber);
        formData.append('condition', condition);
        formData.append('note', note);

        // Send data to the server
        fetch('/layanan/rawat-jalan/soap-dokter/odontogram/add', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            $('#infoModal').modal('hide');
        })
        .catch(error => {
            console.error('Error saving data:', error);
        });
    });

    // Helper function to update a tooth box with image and tooltip
    function updateToothBox(toothNumber, condition, note) {
        const toothBox = document.querySelector(`.clickable-box[data-number="${toothNumber}"]`);
        if (!toothBox) {
            console.error(`Tooth box with number ${toothNumber} not found.`);
            return;
        }

        // Create a new <image> element

        const imagePath = `/images/${condition}.png`;

        // Set attributes for the new <image>
            const imageElement = toothBox.querySelector('image');
                        if (imageElement) {
                            imageElement.setAttribute('href', imagePath);
                        }



        // Add tooltip or update note
        toothBox.setAttribute('title', note);
    }

</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
    const patientId = '<?php echo $rajaldata->no_rm; ?>'; // Patient ID from PHP
    const treatmentId = '<?php echo $rajaldata->no_rawat; ?>'; // Treatment ID from PHP
    const encodedTreatmentId = encodeURIComponent(treatmentId);


    // Fetch the tooth data from the server
    fetch(`/api/regis/gigi/load/${patientId}/${encodedTreatmentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.toothData && data.toothData.length > 0) {
                // Loop through each tooth data and update the SVG
                data.toothData.forEach(tooth => {
                    const toothNumber = tooth.tooth_number;
                    const condition = tooth.condition;  // Condition received from the server
                    const imagePath = getImagePath(condition);  // Use the condition to get the image path

                    // Find the corresponding SVG element based on tooth number
                    const toothBox = document.querySelector(`.clickable-box[data-number="${toothNumber}"]`);

                    if (toothBox) {
                        // Update the image source for the tooth
                        const imageElement = toothBox.querySelector('image');
                        if (imageElement) {
                            imageElement.setAttribute('href', imagePath);
                        }

                        // Optionally, add or update the note as a tooltip or text on the tooth box
                        toothBox.setAttribute('title', tooth.note); // Tooltip with note
                    }
                });
            } else {
                console.error('No tooth data found.');
            }
        })
        .catch(error => {
            console.error('Error loading tooth data:', error);
        });

    // Helper function to get image path based on condition
    function getImagePath(condition) {
        // Dynamically create the image path based on the condition
        return `/images/${condition}.png`;  // Condition from the server, e.g., 'normal', 'decayed', etc.
    }
});

</script>




<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)

    $(function() {
        bsCustomFileInput.init();
    });
</script>


<!-- qr -->
<script src="{{ asset('plugins/js/qrcode.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- {{-- ChartJS --}} -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

<script>
    function toggleContent(contentId) {
        // Get all elements with the class 'toggle-content'
        const allContents = document.querySelectorAll('.toggle-content');

        // Hide all contents except the one clicked
        allContents.forEach(content => {
            if (content.id === contentId) {
                // Toggle the display style for the clicked content
                content.style.display = content.style.display === 'none' ? '' : 'none';
            } else {
                content.style.display = 'none';
            }
        });

        // Scroll the page to the selected content
        document.getElementById(contentId).scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
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

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 10000,
        timerProgressBar: true
    });

    // Saat halaman dimuat, cek apakah ada pesan sukses atau error dari server dan tampilkan SweetAlert sesuai.
    document.addEventListener('DOMContentLoaded', function() {
        // Cek pesan sukses
        @if (session('Success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('Success') }}"
            });
        @endif

        // Cek pesan error
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                Toast.fire({
                    icon: 'error',
                    title: "{{ $error }}"
                });
            @endforeach
        @endif

        // Cek status untuk profil yang diperbarui
        @if (session('status') === 'profile-updated')
            Toast.fire({
                icon: 'success',
                title: "{{ session('Success') }}"
            });
        @endif
    });


    $(function() {
        $('#tahunBuat, #tanggalPajak, #tanggalStnk').datetimepicker({
            format: 'L'
        });
    });

    // Menerapkan preferensi dark mode saat halaman dimuat
    $(document).ready(function() {

        // Memeriksa apakah ada preferensi tema yang disimpan di local storage
        var darkMode = localStorage.getItem('darkMode');

        // Jika tidak ada preferensi tema yang disimpan, menggunakan tema terang sebagai default
        if (!darkMode) {
            $('body').removeClass('dark-mode');
            $('.navbar').removeClass('bg-gray-dark'); // Menghapus tema gelap dari navbar
            $('.main-sidebar').removeClass(
                'sidebar-dark-info'); // Menghapus tema gelap dari sidebar
            $('.main-sidebar').addClass(
                'sidebar-light-info'); // Menambahkan tema gelap ke sidebar
        } else if (darkMode === 'enabled') {
            // Jika preferensi tema adalah mode gelap, aktifkan mode gelap
            $('body').addClass('dark-mode');
            $('.navbar').addClass('bg-gray-dark'); // Menambahkan tema gelap ke navbar
            $('.main-sidebar').addClass(
                'sidebar-dark-info'); // Menambahkan tema gelap ke sidebar
            $('.main-sidebar').removeClass(
                'sidebar-light-info');
            $('#checkbox').prop('checked', true);
        }

        // Event listener untuk perubahan mode
        $('.theme-switch input').on('change', function() {
            // Menghapus kelas 'active' dari semua label
            $('.theme-switch input').removeClass('active');

            // Menambahkan kelas 'active' ke label yang diklik
            $(this).addClass('active');

            // Memeriksa apakah label yang diklik adalah label pertama (mode terang)
            if ($(this).is(':checked')) {
                $('body').addClass('dark-mode');
                $('.navbar').addClass('bg-gray-dark'); // Menambahkan tema gelap ke navbar
                $('.main-sidebar').addClass(
                    'sidebar-dark-info'); // Menambahkan tema gelap ke sidebar
                $('.main-sidebar').removeClass(
                    'sidebar-light-info');
                localStorage.setItem('darkMode',
                    'enabled'); // Menyimpan preferensi dark mode pada local storage
            } else {
                $('body').removeClass('dark-mode');
                $('.navbar').removeClass('bg-gray-dark'); // Menghapus tema gelap dari navbar
                $('.main-sidebar').removeClass(
                    'sidebar-dark-info'); // Menghapus tema gelap dari sidebar
                $('.main-sidebar').addClass(
                    'sidebar-light-info');
                localStorage.setItem('darkMode',
                    'disabled'); // Menyimpan preferensi light mode pada local storage
            }
        });
    });

</script>

<script>
    $(document).ready(function() {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
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

        // Add an event listener to the checkbox
        document.getElementById("toggle-edit-date").addEventListener("change", function() {
            var dateInput = document.getElementById("tgl_kunjungan");
            if (this.checked) {
                // Remove the readonly attribute if the checkbox is checked
                dateInput.removeAttribute("readonly");
            } else {
                // Add the readonly attribute if the checkbox is unchecked
                dateInput.setAttribute("readonly", true);
            }
        });
    };
</script>




</body>
</html>
