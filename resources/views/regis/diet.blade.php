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
                    <h1 class="m-0">DIET</h1>
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
                                        <h5><i class="fa fa-stethoscope"></i> DIDIETAN</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="form-section">
                                                <div class="row">
                                                    <!-- Pilihan Jenis Diet -->
                                                    <div class="col-md-4 mb-3">
                                                        <label>Jenis Diet</label>
                                                        <select class="form-control select2bs4" id="jenis_diet">
                                                            <option value="" disabled selected>-- Silahkan Pilih --</option>
                                                            @foreach ($jenisdiet as $data)
                                                                <option value="{{ $data->kode }}">{{ $data->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="btn btn-primary btn-sm mt-2" onclick="addDietToTable()">Tambah Jenis Diet</button>
                                                    </div>

                                                    <!-- Pilihan Jenis Makanan -->
                                                    <div class="col-md-4 mb-3">
                                                        <label>Jenis Makanan</label>
                                                        <select class="form-control select2bs4" id="jenis_makanan">
                                                            <option value="" disabled selected>-- Silahkan Pilih --</option>
                                                            @foreach ($maknana as $data)
                                                                <option value="{{ $data->kode }}">{{ $data->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="btn btn-success btn-sm mt-2" onclick="addToDietList('jenis_makanan')">Tambah ke Diet</button>
                                                    </div>

                                                    <!-- Pilihan Jenis Tidak Boleh Dimakan -->
                                                    <div class="col-md-4 mb-3">
                                                        <label>Jenis Tidak Boleh Dimakan</label>
                                                        <select class="form-control select2bs4" id="jenis_tidak_boleh">
                                                            <option value="" disabled selected>-- Silahkan Pilih --</option>
                                                            @foreach ($maknana as $data)
                                                                <option value="{{ $data->kode }}">{{ $data->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="btn btn-danger btn-sm mt-2" onclick="addToDietList('jenis_tidak_boleh')">Tambah ke Diet</button>
                                                    </div>
                                                </div>

                                                <!-- Tabel -->
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered" id="data_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Jenis Diet</th>
                                                                    <th>Jenis Makanan</th>
                                                                    <th>Jenis Tidak Boleh Dimakan</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <!-- Tombol Simpan Semua -->
                                                <div class="text-center mt-4">
                                                    <button type="button" class="btn btn-success" onclick="saveAllData()">Simpan Semua</button>
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

<script>
    function loadDietData() {
        $.ajax({
            url: "/api/diets",
            type: "GET",
            success: function (response) {
                console.log("Data diet terbaru dari server:", response);

                var tableBody = document.querySelector("#data_table tbody");
                tableBody.innerHTML = ""; // Kosongkan tabel sebelum menampilkan data baru

                response.forEach((diet, index) => {
                    var jenisMakananList = Array.isArray(diet.jenis_makanan) ? diet.jenis_makanan : [];
                    var jenisTidakBolehList = Array.isArray(diet.jenis_tidak_boleh_dimakan) ? diet.jenis_tidak_boleh_dimakan : [];

                    var newRow = document.createElement("tr");
                    newRow.dataset.kode = diet.id;
                    newRow.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${diet.jenis_diet}</td>
                        <td><ul class="makanan-list">${jenisMakananList.map(item => `<li>${item} <button class="btn btn-danger btn-sm ml-2" onclick="removeDietItem('${item}', 'makanan', ${diet.id}, this)">Hapus</button></li>`).join("")}</ul></td>
                        <td><ul class="tidak-boleh-list">${jenisTidakBolehList.map(item => `<li>${item} <button class="btn btn-danger btn-sm ml-2" onclick="removeDietItem('${item}', 'tidak_boleh', ${diet.id}, this)">Hapus</button></li>`).join("")}</ul></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="deleteDiet(${diet.id}, this)">Hapus Diet</button>
                        </td>
                    `;

                    tableBody.appendChild(newRow);
                });
            },
            error: function (error) {
                console.error("Error memuat data:", error);
                alert("Terjadi kesalahan saat memuat data.");
            }
        });
    }

    // Panggil fungsi ini saat halaman dimuat
    document.addEventListener("DOMContentLoaded", loadDietData);
</script>
<script>
    function addDietToTable() {
        var dietSelect = document.getElementById("jenis_diet");
        var selectedDiet = dietSelect.options[dietSelect.selectedIndex];

        if (!selectedDiet.value) {
            alert("Silakan pilih Jenis Diet terlebih dahulu.");
            return;
        }

        var dietName = selectedDiet.text;
        var dietKode = selectedDiet.value;

        var tableBody = document.querySelector("#data_table tbody");

        // Cek apakah jenis diet sudah ada di tabel
        var existingRow = document.querySelector(`tr[data-kode="${dietKode}"]`);
        if (existingRow) {
            alert("Jenis diet ini sudah ada dalam tabel.");
            return;
        }

        var newRow = document.createElement("tr");
        newRow.dataset.kode = dietKode;
        newRow.dataset.id = ""; // Belum tersimpan ke database

        newRow.innerHTML = `
            <td>${tableBody.rows.length + 1}</td>
            <td>${dietName}</td>
            <td><ul class="makanan-list"></ul></td>
            <td><ul class="tidak-boleh-list"></ul></td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="deleteDiet(this)">Hapus Diet</button>
            </td>
        `;

        tableBody.appendChild(newRow);
    }

    function addToDietList(type) {
        var selectElement = document.getElementById(type);
        var selectedOption = selectElement.options[selectElement.selectedIndex];

        if (!selectedOption.value) {
            alert("Silakan pilih opsi terlebih dahulu.");
            return;
        }

        var dietSelect = document.getElementById("jenis_diet");
        var selectedDiet = dietSelect.options[dietSelect.selectedIndex];

        if (!selectedDiet.value) {
            alert("Silakan pilih Jenis Diet terlebih dahulu sebelum menambahkan.");
            return;
        }

        var dietKode = selectedDiet.value;
        var row = document.querySelector(`tr[data-kode="${dietKode}"]`);

        if (!row) {
            alert("Tambahkan Jenis Diet terlebih dahulu ke tabel sebelum menambahkan makanan.");
            return;
        }

        var targetList = type === "jenis_makanan" ? row.querySelector(".makanan-list") : row.querySelector(".tidak-boleh-list");

        // Cek apakah item sudah ada dalam list
        var allItems = targetList.querySelectorAll("li");
        for (var i = 0; i < allItems.length; i++) {
            if (allItems[i].dataset.kode === selectedOption.value) {
                alert("Data ini sudah ada dalam daftar!");
                return;
            }
        }

        var listItem = document.createElement("li");
        listItem.dataset.kode = selectedOption.value;
        listItem.innerHTML = `
            ${selectedOption.text}
            <button class="btn btn-danger btn-sm ml-2" onclick="removeDietItem('${selectedOption.value}', '${type}', '${row.dataset.id}', this)">Hapus</button>
        `;

        targetList.appendChild(listItem);
    }

    function removeDietItem(item, type, dietId, button) {

        var row = button.closest("tr"); // Pastikan row didefinisikan dengan benar

        if (!dietId || dietId === "") {
            // Jika diet belum tersimpan ke database, hapus langsung dari UI
            if (!confirm("Apakah Anda yakin ingin menghapus item ini dari tabel?")) {
                return;
            }
            button.closest("li").remove();
        } else {
            // Jika diet sudah tersimpan, hapus dari database
            if (!confirm("Apakah Anda yakin ingin menghapus item ini dari database?")) {
                return;
            }

            $.ajax({
                url: `/api/diets/${dietId}/remove-item`,
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify({ item: item, type: type }),
                success: function (response) {
                    alert("Item berhasil dihapus.");
                    button.closest("li").remove();
                },
                error: function (error) {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan saat menghapus item.");
                }
            });
        }
    }

    function updateRowNumbers() {
        var tableBody = document.querySelector("#data_table tbody");
        var rows = tableBody.querySelectorAll("tr");
        rows.forEach((row, index) => {
            row.querySelector("td:first-child").innerText = index + 1;
        });
    }

    function saveAllData() {
        var patientId = document.getElementById("no_rm").value;
        var rawattId = document.getElementById("no_rawat").value;

        if (!patientId || !rawattId) {
            alert("Silakan isi Patient ID dan Rawat ID terlebih dahulu.");
            return;
        }

        var tableRows = document.querySelectorAll("#data_table tbody tr");
        var dietData = [];

        tableRows.forEach(row => {
            var diet = {
                patient_id: patientId,
                rawatt_id: rawattId,
                jenis_diet: row.cells[1].innerText,
                jenis_makanan: Array.from(row.querySelector(".makanan-list").children).map(li => li.innerText.replace("Hapus", "").trim()),
                jenis_tidak_boleh_dimakan: Array.from(row.querySelector(".tidak-boleh-list").children).map(li => li.innerText.replace("Hapus", "").trim())
            };

            dietData.push(diet);
        });

        if (dietData.length === 0) {
            alert("Tidak ada data untuk disimpan.");
            return;
        }

        $.ajax({
            url: "/api/diets",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({ diets: dietData }),
            success: function (response) {
                alert("Data berhasil disimpan!");
                location.reload(); // Reload halaman untuk mendapatkan data terbaru dari database
            },
            error: function (error) {
                alert("Terjadi kesalahan saat menyimpan data.");
                console.log(error);
            }
        });
    }
</script>

<script>
    function deleteDiet( dietId,button) {
        var row = button.closest("tr"); // Pastikan row diambil dengan benar


        if (!dietId || dietId === "") {
            // Jika diet belum tersimpan ke database, hapus langsung dari UI
            if (!confirm("Apakah Anda yakin ingin menghapus item ini dari tabel?")) {
                return;
            }
            row.remove(); // Hapus dari UI
            updateRowNumbers();
        } else {
            // Jika diet sudah tersimpan, hapus dari database
            if (!confirm("Apakah Anda yakin ingin menghapus item ini dari database?")) {
                return;
            }

            $.ajax({
                url: `/api/diets/${dietId}`,
                type: "DELETE",
                success: function () {
                    alert("Diet berhasil dihapus.");
                    row.remove(); // Hapus dari UI setelah dihapus dari database
                    updateRowNumbers(); // Perbarui nomor urut
                },
                error: function (error) {
                    console.error("Terjadi kesalahan saat menghapus diet:", error);
                    alert("Terjadi kesalahan saat menghapus diet.");
                }
            });
        }
    }

    function updateRowNumbers() {
        var tableBody = document.querySelector("#data_table tbody");
        var rows = tableBody.querySelectorAll("tr");
        rows.forEach((row, index) => {
            row.querySelector("td:first-child").innerText = index + 1;
        });
    }

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
    };
</script>

</body>
</html>
