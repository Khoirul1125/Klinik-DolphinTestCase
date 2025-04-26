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

  <!-- /.navbar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-12 d-flex justify-content-center align-items-center">
                    <h1 class="m-0">OBAT</h1>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                    @csrf
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
                                        <h5><i class="fa fa-stethoscope"></i> Resep Obat</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="form-section">
                                                <style>
                                                    /* Gaya untuk tabel luar dengan border besar dan tinggi tetap */
                                                    .outer-table {
                                                        width: 100%;
                                                        height: 500px; /* Menetapkan tinggi tabel luar menjadi 500px */
                                                        border: 1px solid #000; /* Garis tebal di sekitar tabel luar */
                                                        padding: 10px; /* Memberikan ruang di dalam tabel luar */
                                                        box-sizing: border-box; /* Menghindari padding mengganggu ukuran total */
                                                    }

                                                    /* Gaya untuk tabel dalam */
                                                    #kunjungan-table {
                                                        width: 100%;
                                                        border-collapse: collapse; /* Menggabungkan border tabel dalam */
                                                        border: none; /* Menghilangkan border */
                                                    }

                                                    /* Menghilangkan border pada tabel dalam dan memberikan padding */
                                                    #kunjungan-table td, #kunjungan-table th {
                                                        border: none; /* Menghilangkan border */
                                                        padding: 10px; /* Memberikan ruang di dalam sel tabel dalam */
                                                        font-size: 16px; /* Ukuran font */
                                                    }

                                                    /* Menambahkan gaya untuk membuat konten tabel dalam mengisi tabel luar secara penuh */
                                                    .outer-table td {
                                                        vertical-align: top; /* Menjaga konten tabel dalam berada di bagian atas tabel luar */
                                                    }

                                                    /* Gaya untuk tombol Naik dan Turun */
                                                    .move-buttons {
                                                        display: flex;
                                                    }

                                                    .move-buttons button {
                                                        padding: 5px 10px;
                                                        background-color: #007bff;
                                                        color: white;
                                                        border: none;
                                                        border-radius: 5px;
                                                        cursor: pointer;
                                                    }

                                                    .move-buttons button:hover {
                                                        background-color: #0056b3;
                                                    }

                                                    /* Gaya untuk baris yang dipilih */
                                                    .selected {
                                                        background-color: #007bff; /* Menambahkan warna biru pada baris yang dipilih */
                                                        color: white; /* Menyesuaikan warna teks dengan latar belakang */
                                                    }
                                                </style>

                                                <div class="form-group">
                                                    <table class="outer-table">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <!-- Tabel dalam dengan data -->
                                                                    <table id="kunjungan-table" class="table table-bordered">
                                                                        <tbody>
                                                                            @foreach ($obat_pasien as $obat)
                                                                                <tr onclick="selectRow(this)" data-id="{{ $obat->id }}">
                                                                                    <td style="{{ (Str::startsWith($obat->header, 'R/') || Str::startsWith($obat->header, 'R: /')) ? '' : 'padding-left: 30px;' }}">

                                                                                        <!-- Tampilkan Header (jika ada) -->
                                                                                        @if ($obat->header)
                                                                                            <strong>{{ $obat->header }}</strong><br>
                                                                                        @endif

                                                                                        <!-- Tampilkan Nama Obat, Dosis, dan Dosis Satuan (jika ada) -->
                                                                                        @if ($obat->kode_obat && $obat->dosis && $obat->dosis_satuan)
                                                                                            {{ $obat->obats->nama }} >> {{ $obat->dosis }} @ {{ $obat->dosis_satuan }}<br><br>
                                                                                        @endif

                                                                                        <!-- Tampilkan Instruksi (jika ada) -->
                                                                                        @if ($obat->instruksi)
                                                                                            {{ $obat->instruksi }}<br><br>
                                                                                        @endif

                                                                                        <!-- Tampilkan Signa (jika ada) -->
                                                                                        @if ($obat->signa_s || $obat->signa_x || $obat->signa_besaran || $obat->signa_keterangan)
                                                                                            @if ($obat->signa_s) {{ $obat->signa_s }} @endif
                                                                                            x
                                                                                            @if ($obat->signa_x) {{ $obat->signa_x }} @endif
                                                                                            @if ($obat->signa_besaran) {{ $obat->signa_besaran }} @endif
                                                                                            @if ($obat->signa_keterangan) ({{ $obat->signa_keterangan }}) @endif
                                                                                        @endif

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
                                            </div>


                                            <!-- Prescription Form Fields -->
                                            <div class="form-section">
                                                <div class="form-group row">
                                                    <label class="col-md-3 col-form-label">Header Etiket R/:</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" id="header_input" name="header_input" placeholder="Enter text">
                                                    </div>
                                                    <div class="col-md-2 action-buttons">
                                                        <button type="button" class="btn btn-outline-secondary" id="submit-btn">R/</button>
                                                        <button type="button" class="btn btn-outline-secondary" id="submit-btnr">R: /</button>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="moveUp(event)">
                                                            <i class="fas fa-arrow-up"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-secondary" onclick="moveDown(event)">
                                                            <i class="fas fa-arrow-down"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-danger" id="hapus_data" style="width: 95px; font-size: 14px;">Hapus Item</button>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 col-form-label">Obat / Alkes:</label>
                                                    <div class="col-md-5">
                                                        <select class="form-control select2bs4" style="width: 100%;" id="obat" name="obat">
                                                            <option value="" disabled selected>-- Pilih Nama Obat --</option>
                                                            @foreach ($stok as $data)
                                                                <option value="{{$data->kode_barang}}" data-nama="{{$data->nama_barang}}" data-industri="{{$data->dabar->industri}}" data-dosis="{{$data->dabar->satuan->nama_satuan}}">
                                                                    {{$data->nama_barang}} ({{$data->dabar->dosis}} {{$data->dabar->kode_dosis}})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 action-buttons">
                                                        <input type="text" class="form-control" value="" id="perusahaan" name="perusahaan" readonly>
                                                    </div>
                                                    <div class="col-md-1 action-buttons">
                                                        <button type="button" class="btn btn-secondary" id="add-obat-button" style="width: 95px; font-size: 14px;">+ Obat</button>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 col-form-label">Numero / Dosis:</label>
                                                    <div class="col-md-1">
                                                        <input type="text" class="form-control" id="numero" name="numero">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" id="satuan_numero" name="satuan_numero" readonly>
                                                        {{-- <select class="form-control select2bs4" style="width: 100%;" id="satuan_numero" name="satuan_numero">
                                                            <option value="" disabled selected>-- Pilih Dosis --</option>
                                                            @foreach ($satuan as $data)
                                                                <option value="{{$data->nama_satuan}}">
                                                                    {{$data->nama_satuan}}
                                                                </option>
                                                            @endforeach
                                                                <option disabled selected>~~~~~</option>
                                                                <option value="mcg" >mcg</option>
                                                                <option value="mg" >mg</option>
                                                                <option value="gr" >GR</option>
                                                                <option value="ml" >ml</option>
                                                                <option value="cc" >cc</option>
                                                                <option value="tetes" >tetes</option>
                                                        </select> --}}
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 col-form-label">Instruksi:</label>
                                                    <div class="col-md-7">
                                                        <select class="form-control select2bs4" style="width: 100%;" id="intruksi" name="intruksi">
                                                            <option value="" disabled selected>-- Pilih Instruksinya --</option>
                                                            <option value="CITO">CITO</option>
                                                            <option value="ITER">ITER</option>
                                                            <option value="Equal qs">Equal qs</option>
                                                            <option value="m.f pulv da in caps">m.f pulv da in caps</option>
                                                            <option value="s.u.e">s.u.e</option>
                                                            <option value="m.f pulv dtd no X">m.f pulv dtd no X</option>
                                                            <option value="m.f pulv dtd no XV">m.f pulv dtd no XV</option>
                                                            <option value="s.q.d.d.c">s.q.d.d.c</option>
                                                            <option value="haust">haust</option>
                                                            <option value="s.i.m.m">s.i.m.m</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Signa Section -->
                                                <div class="form-group row">
                                                    <label class="col-md-3 col-form-label">Signa:</label>
                                                    <div class="col-md-3 d-flex align-items-center" >
                                                        <label for="v" class="col-form-label" style="padding-right: 10px">S</label>
                                                        <input type="text" class="form-control" id="s" name="s">
                                                        <label for="x" class="col-form-label" style="padding-right: 10px; padding-left:5px">X</label>
                                                        <input type="text" class="form-control" id="x" name="x">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select class="form-control select2bs4" style="width: 100%;" id="satuan_signa" name="satuan_signa">
                                                            <option value="" disabled selected>-- Pilih --</option>
                                                            <option value="Tablet">Tablet</option>
                                                            <option value="Kapsul">Kapsul</option>
                                                            <option value="Sendok Makan">Sendok Makan</option>
                                                            <option value="Sendok Teh">Sendok Teh</option>
                                                            <option value="Sendok Takar">Sendok Takar</option>
                                                            <option value="Tetes">Tetes</option>
                                                            <option value="Tetes">Tetes</option>
                                                            <option value="Dioleskan">Dioleskan</option>
                                                            <option value="cc">cc</option>
                                                            <option value="1/2">1/2</option>
                                                            <option value="1/3">1/3</option>
                                                        </select>
                                                    </div>
                                                    {{-- <div style="width: 200px"> --}}
                                                    <div class="col-md-2">
                                                        <select class="form-control select2bs4" style="width: 100%;" id="signa" name="signa">
                                                            <option value="" disabled selected>-- Pilih --</option>
                                                            <option value="SEBELUM MAKAN">SEBELUM MAKAN</option>
                                                            <option value="SESUDAH MAKAN">SESUDAH MAKAN</option>
                                                            <option value="SEBELUM/SESUDAH MAKAN">SEBELUM/SESUDAH MAKAN</option>
                                                            <option value="JIKA MUAL-MUAL">JIKA MUAL-MUAL</option>
                                                            <option value="JIKA BUANG AIR BESAR">JIKA BUANG AIR BESAR</option>
                                                            <option value="JIKA MERASA NYERI">JIKA MERASA NYERI</option>
                                                            <option value="DIMINUM SETELAH SUAPAN PERTAMA">DIMINUM SETELAH SUAPAN PERTAMA</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
        <br>
    </section>

    <br>
    <!-- /.content -->
</div>
</div>
<!-- ./wrapper -->

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

{{-- UNTUK MENAIK DAN MENURUNKAN DATA PADA TABEL --}}
<script>
    let selectedRow = null; // To store the selected row

    // Function to select a row when clicked
    function selectRow(row) {
        // If there's already a selected row, remove the 'selected' class
        if (selectedRow) {
            selectedRow.classList.remove('selected');
        }
        // Mark the clicked row as selected
        selectedRow = row;
        selectedRow.classList.add('selected');

        // Retrieve the id from the data-id attribute of the row
        const rowId = selectedRow.getAttribute('data-id');
    }

    function moveUp() {
        if (selectedRow) {
            const previousRow = selectedRow.previousElementSibling;
            if (previousRow) {
                selectedRow.parentNode.insertBefore(selectedRow, previousRow);
            }
        }
    }

    function moveDown() {
        if (selectedRow) {
            const nextRow = selectedRow.nextElementSibling;
            if (nextRow) {
                selectedRow.parentNode.insertBefore(nextRow, selectedRow);
            }
        }
    }

    // Function to delete the selected row
    function deleteRow() {
        if (selectedRow) {
            // Get the id from the selected row
            const rowId = selectedRow.getAttribute('data-id');

            // Example: AJAX call to delete data on the server based on id
            fetch('/layanan/rawat-jalan/soap-dokter/resep-obat/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: rowId })  // Send id to the server
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Successfully deleted data from the database, now remove the row from the table
                    selectedRow.parentNode.removeChild(selectedRow);
                    selectedRow = null; // Reset selectedRow after deletion
                } else {
                    alert('Failed to delete the data. ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        } else {
            alert("Please select the item you want to delete.");
        }
    }

    // Attach the delete function to the "Hapus Item" button
    document.getElementById('hapus_data').addEventListener('click', deleteRow);
</script>

{{-- BAGIAN R:/ dan R/ --}}
<script>
    $(document).ready(function() {
        // Attach a click event to the 'R/' button
        $('#submit-btn').click(function () {
            let headerText = $('#header_input').val().trim();
            let newRowContent = headerText ? `R/ ${headerText}` : "R/";

            let data = {
                header_input: newRowContent,
                tgl_kunjungan: document.getElementById("tgl_kunjungan").value,
                time: document.getElementById("time").value,
                no_rawat: document.getElementById("no_rawat").value,
                no_rm: document.getElementById("no_rm").value,
                nama_pasien: document.getElementById("nama_pasien").value,
                penjab: document.getElementById("penjab").value,
                tgl_lahir: document.getElementById("tgl_lahir").value,
                umur: document.getElementById("umur").value,
                _token: '{{ csrf_token() }}'
            };

            fetch('/layanan/rawat-jalan/soap-dokter/resep-obat/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                // Refresh the page after the data has been processed
                window.location.reload(); // Refresh the page
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error occurred while adding data.');
            });
        });

        $('#submit-btnr').click(function() {
            let headerText = $('#header_input').val().trim();
            let newRowContent = headerText ? `R: / ${headerText}` : "R: /";

            let data = {
                header_input: newRowContent,
                tgl_kunjungan: document.getElementById("tgl_kunjungan").value,
                time: document.getElementById("time").value,
                no_rawat: document.getElementById("no_rawat").value,
                no_rm: document.getElementById("no_rm").value,
                nama_pasien: document.getElementById("nama_pasien").value,
                penjab: document.getElementById("penjab").value,
                tgl_lahir: document.getElementById("tgl_lahir").value,
                umur: document.getElementById("umur").value,
                _token: '{{ csrf_token() }}'
            };

            fetch('/layanan/rawat-jalan/soap-dokter/resep-obat/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                // Refresh the page after the data has been processed
                window.location.reload(); // Refresh the page
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error occurred while adding data.');
            });
        });
    });
</script>

{{-- SCRIPT OBAT --}}
<script>
    $(document).ready(function() {
        // Attach a click event to the 'Add Obat' button
        $('#add-obat-button').click(function() {
            // Get values from the form fields
            let obat = $('#obat').val();  // Get selected option text for "obat"
            let namaObat = $('#obat option:selected').text();
            let namaObatFinal = namaObat.replace(/\s*\(.*?\)/, '');
            let numero = $('#numero').val();               // Get value of "numero" input
            let satuanNumero = $('#satuan_numero').val();  // Get selected option value for "satuan_numero"
            let intruksi = $('#intruksi').val();  // Get selected option value for "satuan_numero"
            let S = $('#s').val();  // Get selected option value for "satuan_numero"
            let X = $('#x').val();  // Get selected option value for "satuan_numero"
            let satuanSigna = $('#satuan_signa option:selected').text(); // Get selected option value for "satuan_numero"
            let Signa = $('#signa option:selected').text(); // Get selected option value for "satuan_numero"

            // Check if 'numero' is empty
            if (!numero) {
                alert("Silahkan pilih dosis obat!");
                return;
            } else if (!obat) {
                alert("Silahkan pilih obat!");
                return;
            } else if (!satuanNumero) {
                alert("Lengkapi dosis obat!");
                return;
            } else if (!intruksi) {
                alert("ISI INSTRUKSINYA!");
                return; // Stop further execution if 'numero' is empty
            } else if (!S) {
                alert("ISI Bagian berapa kali nya!");
                return; // Stop further execution if 'numero' is empty
            } else if (!X) {
                alert("ISI Bagian hari nya !");
                return; // Stop further execution if 'numero' is empty
            } else if (!satuanSigna) {
                alert("ISI Bagian Satuan Signa nya !");
                return; // Stop further execution if 'numero' is empty
            } else if (!Signa) {
                alert("ISI Bagian cara pemakaiannya !");
                return; // Stop further execution if 'numero' is empty
            }

            // Prepare data to send to the backend
            let data = {
                obat: obat,
                namaObatFinal: namaObatFinal,
                numero: numero,
                satuan_numero: satuanNumero,
                intruksi: intruksi,
                s: S,
                x: X,
                satuan_signa: satuanSigna,
                signa: Signa,
                tgl_kunjungan: document.getElementById("tgl_kunjungan").value,
                time: document.getElementById("time").value,
                no_rawat: document.getElementById("no_rawat").value,
                no_rm: document.getElementById("no_rm").value,
                nama_pasien: document.getElementById("nama_pasien").value,
                penjab: document.getElementById("penjab").value,
                tgl_lahir: document.getElementById("tgl_lahir").value,
                umur: document.getElementById("umur").value
            };

            // Send data via AJAX to save to the database
            fetch('/layanan/rawat-jalan/soap-dokter/resep-obat/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                // Refresh the page after the data has been processed
                window.location.reload(); // Refresh the page
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>

{{-- SCRPT UNTUK AUTOMASI INDUSTRI --}}
<script>
    $(document).ready(function() {
        // Ketika pilihan dropdown berubah
        $('#obat').change(function() {
            // Ambil data yang terkait dengan option yang dipilih
            var selectedOption = $(this).find('option:selected');
            var industri = selectedOption.data('industri');

            // Isi input dengan value industri yang dipilih
            $('#perusahaan').val(industri);
        });
    });
</script>

{{-- SCRIPT UNTUK SATUAN_NUMERO NYA --}}
<script>
    $(document).ready(function() {
        // Ketika pengguna memilih obat di dropdown pertama
        $('#obat').change(function() {
            // Ambil nilai data-dosis dari option yang dipilih
            var dosis = $(this).find(':selected').data('dosis');

            // Set nilai dropdown kedua berdasarkan dosis yang dipilih
            // $('#satuan_numero').val(dosis).trigger('change');  // Men-trigger perubahan select2 jika menggunakan plugin select2
            $('#satuan_numero').val(dosis);  // Men-trigger perubahan select2 jika menggunakan plugin select2
        });
    });
</script>


</body>
</html>
