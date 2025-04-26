@extends('template.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-center text-center">
                    <div class="col-sm-12">
                        <h1 class="m-0">Setting Aplikasi</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                {{-- <!-- Main row -->
                <div class="row">

                    <!-- /.col -->
                </div> --}}

                <div class="row">
                    <!-- Kolom kiri (Profile Image) -->
                    <div class="col-md-3">
                        <style>
                            .profile-user-img {
                                width: 100px; /* Ukuran lebar gambar */
                                height: 100px; /* Ukuran tinggi gambar */
                                border-radius: 50%; /* Membuat gambar berbentuk bulat */
                                border: 2px solid #ddd; /* Menambahkan border */
                            }
                        </style>

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                @foreach ($webset as $webset)
                                <div class="text-center">
                                    <img class="profile-user-img img-circle"
                                        src="{{ asset('webset/' . $webset->logo_app) }}" alt="User profile picture">
                                </div>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item text-center">
                                        <b>Name Web: </b> <a class="float">{{ $webset->name_app }}</a>
                                    </li>
                                </ul>
                                    <li class="list-group-item text-center">
                                        <b>Aplikasi ini dijalankan sejak: </b>
                                        <br>
                                        <a class="float">
                                            {{ \Carbon\Carbon::parse($webset->created_at)->translatedFormat('d F Y') }}
                                        </a>
                                    </li>
                                @endforeach
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <!-- Kolom kanan (Form untuk mengupdate Name App dan Logo) -->
                    <div class="col-md-9">
                        <div class="card card-primary card-outline">
                            <form action="{{ route('setweb.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nameApp">Name APP</label>
                                        <input type="text" name="name_app" class="form-control" id="nameApp"
                                            value="{{ $webset->name_app }}" placeholder="Enter app name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="logoApp">File Logo APP</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="logo_app" class="custom-file-input" id="logoApp">
                                                <label class="custom-file-label" for="logoApp">{{ $webset->logo_app }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="{{ $webset->id }}">
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>


                    <div class="row col-md-6">
                        <!-- SATUSEHAT Form -->
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header d-flex justify-content-center align-items-center">
                                    <h3 class="card-title">Satu Sehat</h3>
                                </div>
                                <form action="{{ route('setweb.setsatusehat') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        @foreach ($setsatusehat as $setsatusehat)
                                            <div class="row">
                                                @foreach ([
                                                    'org_id' => 'ID',
                                                    'client_id' => 'Client ID',
                                                    'client_secret' => 'Client Secret',
                                                    'SATUSEHAT_BASE_URL' => 'SATUSEHAT BASE URL'
                                                ] as $name => $label)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="{{ $name }}">{{ $label }}</label>
                                                            <input type="text" value="{{ $setsatusehat->$name }}" name="{{ $name }}" class="form-control" id="{{ $name }}" placeholder="Enter {{ $label }}" required>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Lisensi Form (Moved Up) -->
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header d-flex justify-content-center align-items-center">
                                    <h3 class="card-title">Lisensi Aplikasi</h3>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        @foreach ([
                                            'lisensi' => ['label' => 'Lisensi Aplikasi', 'value' => $licenseKey],
                                            'lisensi_wa' => ['label' => 'Lisensi WhatsApp Token', 'value' => $licensewa->key]
                                        ] as $name => $data)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="{{ $name }}">{{ $data['label'] }}</label>
                                                    <div class="input-group">
                                                        <input type="password" name="{{ $name }}" class="form-control" id="{{ $name }}" placeholder="Masukkan {{ $data['label'] }}" required value="{{ $data['value'] }}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="{{ $name }}">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary" id="saveLicense">Simpan Lisensi</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-6">
                        <!-- BPJS Form -->
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header d-flex justify-content-center align-items-center">
                                    <h3 class="card-title">BPJS</h3>
                                </div>

                                <form action="{{ route('setweb.setbpjs') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        @foreach ($setbpjs as $setbpjs)
                                            <div class="row">
                                                @foreach ([
                                                    'CONSID' => 'CONSID',
                                                    'KPFK' => 'Kode Faskes',
                                                    'USERNAME' => 'Username',
                                                    'PASSWORD' => 'Password',
                                                    'SCREET_KEY' => 'Secret Key',
                                                    'USER_KEY' => 'User Key',
                                                    'SERVICE_ANTREAN' => 'Service Antrean',
                                                    'SERVICE' => 'Service',
                                                    'APP_CODE' => 'App Code',
                                                    'BASE_URL' => 'Base URL'
                                                ] as $name => $label)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="{{ $name }}">{{ $label }}</label>
                                                            <input type="text" value="{{ $setbpjs->$name }}" name="{{ $name }}" class="form-control" id="{{ $name }}" placeholder="Enter {{ $label }}" required>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header d-flex justify-content-center align-items-center">
                                <h3 class="card-title">Bank</h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    @php
                                        $totalBanks = count($bank);
                                        $half = ceil($totalBanks / 2);
                                    @endphp

                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6">
                                        @foreach ($bank->slice(0, $half) as $banks)
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <input type="text" value="{{ $banks->nama }}" name="{{ $banks->id }}" class="form-control" id="{{ $banks->name }}" readonly>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" id="rekening_{{ $banks->id }}" name="rekening[{{ $banks->id }}]" class="form-control" placeholder="Masukkan nomor rekening" oninput="this.value = this.value.replace(/[^0-9]/g, '');" inputmode="numeric" autocomplete="off" style="-moz-appearance: textfield; appearance: textfield;">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Kolom Kanan -->
                                    <div class="col-md-6">
                                        @foreach ($bank->slice($half) as $banks)
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <input type="text" value="{{ $banks->nama }}" name="{{ $banks->id }}" class="form-control" id="{{ $banks->name }}" readonly>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" id="rekening_{{ $banks->id }}" name="rekening[{{ $banks->id }}]" class="form-control" placeholder="Masukkan nomor rekening" oninput="this.value = this.value.replace(/[^0-9]/g, '');" inputmode="numeric" autocomplete="off" style="-moz-appearance: textfield; appearance: textfield;">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-center">
                                <button type="button" class="btn btn-primary" id="saveLicense">Simpan Bank</button>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Toggle password visibility
            document.querySelectorAll(".toggle-password").forEach(button => {
                button.addEventListener("click", function() {
                    let target = document.getElementById(this.getAttribute("data-target"));
                    if (target.type === "password") {
                        target.type = "text";
                        this.innerHTML = '<i class="fa fa-eye-slash"></i>';
                    } else {
                        target.type = "password";
                        this.innerHTML = '<i class="fa fa-eye"></i>';
                    }
                });
            });

            // AJAX untuk menyimpan lisensi
            document.getElementById("saveLicense").addEventListener("click", function() {
                let lisensiApp = document.getElementById("lisensi").value;
                let lisensiWa = document.getElementById("lisensi_wa").value;

                if (!lisensiApp || !lisensiWa) {
                    showMessage("Harap isi kedua lisensi!", "danger");
                    return;
                }

                // Update Lisensi APP (ID = 1)
                updateLicense(1, lisensiApp);

                // Update Lisensi WA (ID = 2)
                updateLicense(2, lisensiWa);
            });

            // Fungsi untuk mengupdate lisensi via AJAX
            function updateLicense(id, key) {
                fetch(`/api/setweb/save-license-key/${id}`, {
                    method: "PATCH",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ key: key })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        showMessage(data.message, "success");
                    } else {
                        showMessage("Gagal memperbarui lisensi!", "danger");
                    }
                })
                .catch(error => showMessage("Error: " + error.message, "danger"));
            }

            // Fungsi untuk menampilkan pesan status
            function showMessage(message, type) {
                let statusDiv = document.getElementById("statusMessage");
                statusDiv.className = `alert alert-${type}`;
                statusDiv.innerHTML = message;
                statusDiv.classList.remove("d-none");

                // Hilangkan pesan setelah 3 detik
                setTimeout(() => statusDiv.classList.add("d-none"), 3000);
            }
        });
    </script>
@endsection
