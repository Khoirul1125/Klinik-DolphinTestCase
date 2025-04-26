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
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>

body {
            background-color: #0c3c70; /* Latar belakang biru */
        }
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
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #0056b3;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 1.5rem;
            z-index: 1030;
            border-top: 4px solid #ffc107;
        }
        .footer span {
            display: block;
            margin-top: 5px;
            color: #ffc107;
        }
        .header-title {
            background-color: #0056b3;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
    <style>
        .queue-box {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .queue-number {
            font-size: 5rem;
            font-weight: bold;
            color: black;
        }
        .loket-text {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .btn-box {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        .btn-box .equal-button {
            flex: 1; /* Membuat setiap tombol memiliki lebar yang sama */
            margin: 0 5px; /* Memberikan jarak antar tombol */
            height: 60px; /* Menentukan tinggi tombol agar seragam */
            font-size: 1.5rem; /* Mengatur ukuran font untuk konsistensi */
        }
        .input-group {
            margin-top: 20px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        .instructions {
            font-size: 0.9rem;
            color: white;
            margin-top: 20px;
        }
    </style>
    <style>
        .custom-dropdown .btn {
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 1.1rem;
            border-radius: 5px;
        }

        .dropdown-options {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            z-index: 10;
        }

        .dropdown-option:hover {
            background-color: #f1f1f1;
        }

        .queue-box {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-box .btn {
            font-size: 1.5rem;
        }

        .btn-info {
            background-color: #17a2b8;
        }

        .btn-warning {
            background-color: #ffc107;
        }

        .btn-lg {
            padding: 15px;
        }
    </style>
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Header section -->
                <div class="row">
                    <div class="container d-flex justify-content-center align-items-center" style="height: 100px;">
                        <a href="#" class="navbar-brand d-flex align-items-center">
                            <img src="{{ asset('webset/' . $setweb->logo_app) }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8; width: 50px; height: 50px; margin-right: 10px;">
                            <span class="brand-text font-weight-light">{{ $setweb->name_app }} Dolphi</span>
                        </a>
                    </div>
                </div>

                <!-- Title Section -->
                <div class="header-title">
                    Sistem Antrian Loket
                </div>



                <div class="container">
                    <div class="row justify-content-center">

                    </div>
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 mt-5">
                            <div class="queue-box shadow-lg p-4 rounded">

                                <!-- Menampilkan Loket yang dipilih -->
                                <div class="mt-3 text-center">
                                    <h1 id="selected-loket" data-nama-loket="" class="text-muted">Loket belum dipilih</h1>
                                </div>

                                <!-- Menampilkan Nomor Antrian -->
                                <div class="text-center mt-4">
                                    <h2 id="current-queue-number" class="display-4 text-primary" data-antrian-id="">Tidak Ada Antrian</h2>
                                    <p class="text-muted">Nomor Antrian</p>
                                </div>


                                <!-- Tombol Pemanggilan -->
                                <div class="d-flex justify-content-between mt-4">
                                    <button class="btn btn-warning btn-lg" onclick="panggilQueue()"  style="width: 32%;">
                                        <i class="fa-solid fa-volume-high" style="color: white;"></i> Panggil
                                    </button>

                                    <div class="custom-dropdown position-relative">
                                        <!-- Tombol yang akan menampilkan pilihan loket -->
                                        <button id="loket-button" class="btn btn-primary w-100 text-left d-flex justify-content-between align-items-center py-3 px-4" style="width: 32%;">
                                            <span id="loket-name">Pilih Loket</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </button>

                                        <!-- Daftar loket yang akan ditampilkan saat tombol diklik -->
                                        <div id="loket-options" class="dropdown-options position-absolute w-100 mt-2 shadow-lg rounded" style="display: none; background-color: white;">
                                            @foreach($lokets as $loket)
                                                <div class="dropdown-option py-2 px-4" data-value="{{ $loket->id }}" style="cursor: pointer; border-bottom: 1px solid #ddd;">
                                                    {{ $loket->nama }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <button class="btn btn-info btn-lg" onclick="nextQueue()" style="width: 32%;">
                                        Cari Nomor Antri <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Input Nomor Antrian -->
                <div class="row justify-content-center mt-4">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Input Nomor Antrian" id="input-antrian">
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="button" onclick="callQueue()">Panggil</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div><!-- /.container-fluid -->
        </section> <!-- /.content -->
    </div> <!-- ./wrapper -->


<!-- Modal untuk Panggilan Antrian -->
<div class="modal fade" id="queueModal" tabindex="-1" aria-labelledby="queueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="queueModalLabel">Panggilan Antrian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h2 id="queueNumber" class="text-primary"></h2>
                <audio id="queueAudio" src=""></audio>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


    <!-- Footer -->
    <footer class="footer">
        <div class="time-container">
            <!-- Time will be displayed here -->
        </div>
    </footer>


    <!-- Scripts -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>



    <script>
        // Menangani klik pada tombol pilihan loket
        document.getElementById('loket-button').addEventListener('click', function() {
            var options = document.getElementById('loket-options');
            options.style.display = options.style.display === 'block' ? 'none' : 'block'; // Toggle visibilitas dropdown
        });

        // Menangani klik pada setiap pilihan loket
        document.querySelectorAll('.dropdown-option').forEach(function(option) {
            option.addEventListener('click', function() {
                var loketName = this.textContent;  // Ambil nama loket yang dipilih
                var loketId = this.getAttribute('data-value');  // Ambil ID loket yang dipilih
                document.getElementById('loket-name').textContent = 'Loket' + loketName;  // Update tombol dengan nama loket yang dipilih
                document.getElementById('selected-loket').textContent = loketName;  // Menampilkan nama loket yang dipilih
                document.getElementById('selected-loket').setAttribute('data-nama-loket', loketId); // Store antrian ID in data attribute
                document.getElementById('loket-options').style.display = 'none';  // Sembunyikan daftar loket setelah memilih

                // Kirim ID loket untuk mengambil nomor antrian dari server (AJAX atau form submit)
                updateQueueNumber(loketId);
            });
        });

        // Fungsi untuk mengambil nomor antrian berdasarkan loket yang dipilih
        function updateQueueNumber(loketId) {
            // AJAX request untuk mendapatkan nomor antrian dari server berdasarkan loket
            fetch(`/get-antrian/${loketId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.antrian) {
                        document.getElementById('current-queue-number').textContent = data.antrian.no_antri;
                        document.getElementById('current-queue-number').setAttribute('data-antrian-id', data.antrian.id); // Store antrian ID in data attribute
                    } else {
                        document.getElementById('current-queue-number').textContent = 'Tidak Ada Antrian';
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

    <script>
        function showQueueModal(queueNumber) {


            var loketName = document.getElementById('selected-loket').textContent;
            const queueNumberElement = document.getElementById('queueNumber');
            queueNumberElement.textContent = `Nomor Antrian: ${queueNumber}`;


            // Tampilkan modal
            const queueModal = new bootstrap.Modal(document.getElementById('queueModal'), {
                keyboard: false
            });
            queueModal.show();
            // Gunakan Web Speech API untuk Text-to-Speech
            const utterance = new SpeechSynthesisUtterance(`Nomor Antrian: ${queueNumber} ke loket ${loketName}`);
            utterance.lang = 'id-ID'; // Bahasa Indonesia
            speechSynthesis.speak(utterance);
        }

        function panggilQueue() {
            const queueElement = document.getElementById('current-queue-number');
            const antrianId = queueElement.getAttribute('data-antrian-id');

            if (!antrianId) {
                alert('Tidak ada nomor antrian yang dapat dipanggil.');
                return;
            }

            // Ubah status antrian yang sedang dipanggil menjadi 2
            fetch(`/update-status/${antrianId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ status: 2 })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Tampilkan modal dan putar suara
                    showQueueModal(data.queue_number);

                    console.log('Mengirim permintaan untuk memperbarui status: ', antrianId);

                    fetch(`/update-all-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ currentId: antrianId })
                    })
                    .then(response => response.json())
                    .then(updateData => {
                        if (updateData.success) {
                            console.log('Semua nomor antrian dengan status 2 berhasil diubah menjadi 3.');
                        } else {
                            console.error('Gagal memperbarui status antrian lainnya:', updateData.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error during fetch:', error);
                    });

                    // Kosongkan antrian yang sedang ditampilkan
                    queueElement.textContent = "Tidak Ada Antrian";
                    queueElement.setAttribute('data-antrian-id', "");
                } else {
                    alert('Gagal memanggil nomor antrian: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memanggil nomor antrian.');
            });
        }

        function nextQueue() {
            // Logika untuk memanggil antrian berikutnya
            console.log("Fungsi Next Queue belum diimplementasikan.");
        }
    </script>

    <script>
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour12: false });
            const dateString = now.toLocaleDateString('id-ID', {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
            });
            document.querySelector('.time-container').innerHTML = timeString + ' <span>' + dateString + '</span>';
        }
        setInterval(updateTime, 1000);
        updateTime();  // Initialize immediately
    </script>

</body>
</html>
