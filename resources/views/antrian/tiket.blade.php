<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $setweb = App\Models\setweb::first();
    @endphp
    <title>{{ $setweb->name_app }}</title>

    <link rel="icon" sizes="180x180" type="image/x-icon" href="{{ asset('webset/' . $setweb->logo_app) }}">
    <!-- Include styles and scripts as needed -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <style>
        .queue-main {
            background-color: #28a745;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            font-size: 5rem;
            text-align: center;
            margin-bottom: 20px;
        }
        .queue-sub {
            background-color: #ffc107;
            color: #fff;
            font-size: 2rem;
            padding: 10px;
            margin-top: -20px;
            text-align: center;
        }
        .small-queue {
            background-color: #0062cc;
            color: white;
            padding: 15px;
            text-align: center;
            margin: 10px;
            border-radius: 10px;
            font-size: 2rem;
        }
        .small-queue h1 {
            font-size: 3rem;
            color: #ffc107;
        }
        .small-queue span {
            font-size: 1.2rem;
        }
        .video-container {
            position: relative;
            padding-top: 56.25%;
            height: 0;
            overflow: hidden;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .time-container {
            background-color: #0056b3;
            color: white;
            text-align: left;
            padding: 10px;
            font-size: 1.5rem;
            border-radius: 10px;
            margin-top: 20px; /* Added margin to separate from above elements */
        }
        .time-container span {
            display: block;
            margin-top: 5px;
            color: #ffc107;
        }
        .header-title {
            background-color: #0056b3; /* Set background to black */
            color: white; /* Text color to white */
            padding: 15px;
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
    </head>
    <body class="hold-transition layout-top-nav">
        <div class="wrapper">
            <!-- Main content -->
            <section class="content">
                <br>
                <div class="container-fluid">
                    <!-- Header section -->
                    <div class="row">
                        <div class="container d-flex justify-content-center align-items-center header-title" style="height: 100px;" >
                            <a href="#" class="navbar-brand d-flex align-items-center">
                                <img src="{{ asset('webset/' . $setweb->logo_app) }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8; width: 50px; height: 50px; margin-right: 10px;">
                                <span class="brand-text font-weight-light">Antrian Online</span>
                            </a>
                        </div>
                    </div>
                    <!-- Centered Queue Buttons Section -->
                    <div class="row justify-content-center align-items-center" style="height: 75vh;">
                        <div class="col-md-5">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class=" text-success">Antrian BPJS</h5>
                                    <hr>
                                    <p class="card-text">Klik tombol di bawah untuk mengambil antrian BPJS dan mendapatkan pelayanan kesehatan terbaik.</p>
                                    <button class="btn btn-success btn-lg btn-block" style="font-size: 2rem; padding: 20px;" data-toggle="modal" data-target="#bpjsModal">
                                        Antrian BPJS
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class=" text-primary">Antrian Non-BPJS</h5>
                                    <hr>
                                    <p class="card-text">Klik tombol di bawah untuk mengambil antrian Non-BPJS dan mendapatkan pelayanan kesehatan terbaik.</p>
                                    <button class="btn btn-primary btn-lg btn-block" style="font-size: 2rem; padding: 20px;" data-toggle="modal" data-target="#nonBpjsModal">
                                        Antrian Non-BPJS
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h5 class="text-info">Daftar Pasien Baru</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">Klik tombol di bawah untuk mendaftar sebagai pasien baru dan mendapatkan pelayanan kesehatan terbaik.</p>
                                        <button class="btn btn-info btn-lg btn-block" style="font-size: 2rem; padding: 20px;" data-toggle="modal" data-target="#ddaftarModal">
                                            Daftar Pasien Baru
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
                <br>
            </section> <!-- /.content -->
        </div> <!-- ./wrapper -->


          <!-- Modal for Antrian BPJS -->
        <div class="modal fade" id="bpjsModal" tabindex="-1" role="dialog" aria-labelledby="bpjsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bpjsModalLabel">Antrian BPJS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="bpjsForm" action="{{ route('antrian.bpjs.add') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nikNokaInput">Masukkan NIK atau No. Kartu BPJS</label>
                                <input type="text" class="form-control" id="nikNokaInput" name="nikNokaInput" placeholder="Masukkan NIK atau No. Kartu BPJS" required>
                                <small id="nikNokaFeedback" class="form-text text-muted"></small>
                            </div>

                            <div class="form-group">
                                <label for="poliSelect">Pilih Poli</label>
                                <select class="form-control" id="poliSelect" name="poliSelect" required>
                                    <option value="">Pilih Poli</option>
                                    @foreach ($poli as $poline)
                                        <option value="{{ $poline->id }}">{{ $poline->nama_poli }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dokterSelect">Pilih Dokter</label>
                                <select class="form-control" id="dokterSelect" name="dokterSelect" required>
                                    <option value="">Pilih Dokter</option>

                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="sumbit" class="btn btn-primary">Lanjutkan</button>
                    </div>
                        </form>
                </div>


            </div>
        </div>

        <!-- Modal for Antrian Non-BPJS -->
        <div class="modal fade" id="nonBpjsModal" tabindex="-1" role="dialog" aria-labelledby="nonBpjsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nonBpjsModalLabel">Antrian Non-BPJS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="nonBpjsForm" action="{{ route('antrian.no.bpjs.add') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nikInputno">Masukkan NIK </label>
                                <input type="text" class="form-control" id="nikInputno" name="nikInputno" placeholder="Masukkan NIK" required>
                                <small id="nikNokaFeedbackno" class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="poliSelectNonBpjs">Pilih Poli</label>
                                <select class="form-control" id="poliSelectNonBpjs" name="poliSelectNonBpjs" required>
                                    <option value="">Pilih Poli</option>
                                    @foreach ($poli as $polis)
                                        <option value="{{ $polis->id }}">{{ $polis->nama_poli }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dokterSelectNonBpjs">Pilih Dokter</label>
                                <select class="form-control" id="dokterSelectNonBpjs" name="dokterSelectNonBpjs" required>
                                    <option value="">Pilih Dokter</option>
                                </select>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="sumbit" class="btn btn-primary">Lanjutkan</button>
                    </div>
                        </form>
                </div>
            </div>
        </div>

        <!-- Modal for Antrian daftar -->
        <div class="modal fade" id="ddaftarModal" tabindex="-1" role="dialog" aria-labelledby="ddaftarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ddaftarModalLabel">Antrian Pendaftaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form id="daftarForm" action="{{ route('antrian.pasien.baru') }}" method="POST">
                        @csrf
                        <div class="form-group text-center">
                            <label>Apakah Anda memiliki BPJS?</label>
                            <div class="d-flex justify-content-center">
                                <div class="form-check mr-3">
                                    <input class="form-check-input" type="radio" name="bpjsOption" id="bpjsYes" value="yes" required>
                                    <label class="form-check-label" for="bpjsYes">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="bpjsOption" id="bpjsNo" value="no" required checked>
                                    <label class="form-check-label" for="bpjsNo">Tidak</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nikInputDaftar">NIK</label>
                            <input type="text" class="form-control" id="nikInputDaftar" name="nikInputDaftar" placeholder="Masukkan NIK" required>
                        </div>
                        <div class="form-group" id="nokaBpjsGroup" style="display: none;">
                            <label for="nokaBpjsInput">No. Kartu BPJS</label>
                            <input type="text" class="form-control" id="nokaBpjsInput" name="nokaBpjsInput" placeholder="Masukkan No. Kartu BPJS">
                        </div>
                        <div class="form-group">
                            <label for="nomorhp">No. HP</label>
                            <input type="text" class="form-control" id="nomorhp" name="nomorhp" placeholder="Masukkan No. HP">
                        </div>
                    <script>
                        document.querySelectorAll('input[name="bpjsOption"]').forEach((elem) => {
                            elem.addEventListener('change', function() {
                                const nokaBpjsGroup = document.getElementById('nokaBpjsGroup');
                                if (this.value === 'yes') {
                                    nokaBpjsGroup.style.display = 'block';
                                    document.getElementById('nokaBpjsInput').required = true;
                                } else {
                                    nokaBpjsGroup.style.display = 'none';
                                    document.getElementById('nokaBpjsInput').required = false;
                                }
                            });
                        });
                    </script>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="sumbit" class="btn btn-primary">Lanjutkan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Include your scripts as needed -->
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- JavaScript to update time -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
        $(document).ready(function () {
            $('#nikInputDaftar').on('input', function () {
            var jenisKartu = $(this).val().trim();

            if (jenisKartu.length === 16) {
                $.ajax({
                    url: '/api/get-nik-bpjs/' + jenisKartu,
                    method: 'GET',
                    success: function(response) {
                        if (!response || !response.data) {
                                console.log("error");
                            return;
                        }

                        var noBPJS = response.data.noKartu || null; // Ambil data yang benar
                        $('#nokaBpjsInput').val(noBPJS).trigger('keyup');

                    },
                    error: function() {
                        console.log('Koneksi ke BPJS tidak stabil, silakan coba kembali.');
                    }
                });
            }
        });
        });
        </script>
        <script>
            $(document).ready(function () {
                $('#poliSelectNonBpjspasien').on('change', function () {
                    const poliId = $(this).val();
                    const dokterSelect = $('#dokterSelectNonBpjspasien');

                    dokterSelect.empty(); // Kosongkan dropdown dokter
                    dokterSelect.append('<option value="">Pilih Dokter</option>'); // Tambahkan opsi default

                    if (poliId) {
                        $.ajax({
                            url: `/doctors-by-poli/${poliId}`, // Endpoint untuk mengambil dokter berdasarkan poli
                            type: 'GET',
                            success: function (response) {
                                if (response.status === 'success') {
                                    response.data.forEach(doctor => {
                                        dokterSelect.append(`<option value="${doctor.id}">${doctor.nama_dokter}</option>`);
                                    });
                                } else {
                                    dokterSelect.append('<option value="">Tidak ada dokter tersedia</option>');
                                }
                            },
                            error: function () {
                                dokterSelect.append('<option value="">Tidak ada dokter tersedia</option>');
                            }
                        });
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#poliSelectNonBpjs').on('change', function () {
                    const poliId = $(this).val();
                    const dokterSelect = $('#dokterSelectNonBpjs');

                    dokterSelect.empty(); // Kosongkan dropdown dokter
                    dokterSelect.append('<option value="">Pilih Dokter</option>'); // Tambahkan opsi default

                    if (poliId) {
                        $.ajax({
                            url: `/doctors-by-poli/${poliId}`, // Endpoint untuk mengambil dokter berdasarkan poli
                            type: 'GET',
                            success: function (response) {
                                if (response.status === 'success') {
                                    response.data.forEach(doctor => {
                                        dokterSelect.append(`<option value="${doctor.id}">${doctor.nama_dokter}</option>`);
                                    });
                                } else {
                                    dokterSelect.append('<option value="">Tidak ada dokter tersedia</option>');
                                }
                            },
                            error: function () {
                                dokterSelect.append('<option value="">Tidak ada dokter tersedia</option>');
                            }
                        });
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#poliSelect').on('change', function () {
                    const poliId = $(this).val();
                    const dokterSelect = $('#dokterSelect');

                    dokterSelect.empty(); // Kosongkan dropdown dokter
                    dokterSelect.append('<option value="">Pilih Dokter</option>'); // Tambahkan opsi default

                    if (poliId) {
                        $.ajax({
                            url: `/doctors-by-poli/${poliId}`, // Endpoint untuk mengambil dokter berdasarkan poli
                            type: 'GET',
                            success: function (response) {
                                if (response.status === 'success') {
                                    response.data.forEach(doctor => {
                                        dokterSelect.append(`<option value="${doctor.id}">${doctor.nama_dokter}</option>`);
                                    });
                                } else {
                                    dokterSelect.append('<option value="">Tidak ada dokter tersedia</option>');
                                }
                            },
                            error: function () {
                                dokterSelect.append('<option value="">Tidak ada dokter tersedia</option>');
                            }
                        });
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#nikInputno').on('input', function () {
                    let nikNoka = $(this).val();
                    let feedback = $('#nikNokaFeedbackno');

                    if (nikNoka.length === 16) {
                        $.ajax({
                            url: "{{ route('checkNikNokaAjax') }}",
                            type: 'GET',
                            data: { nik_noka: nikNoka },
                            success: function (response) {
                                if (response.status === 'success') {
                                    feedback.text(response.message).css('color', 'green');
                                } else {
                                    feedback.text(response.message).css('color', 'red');
                                }
                            },
                            error: function () {
                                feedback.text('Terjadi kesalahan, coba lagi.').css('color', 'red');
                            }
                        });
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#nikNokaInput').on('input', function () {
                    let nikNoka = $(this).val();
                    let feedback = $('#nikNokaFeedback');

                    if (nikNoka.length === 13 || nikNoka.length === 16) {
                        $.ajax({
                            url: "{{ route('checkNikNokaAjax') }}",
                            type: 'GET',
                            data: { nik_noka: nikNoka },
                            success: function (response) {
                                if (response.status === 'success') {
                                    feedback.text(response.message).css('color', 'green');
                                } else {
                                    feedback.text(response.message).css('color', 'red');
                                }
                            },
                            error: function () {
                                feedback.text('Terjadi kesalahan, coba lagi.').css('color', 'red');
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>
