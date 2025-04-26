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

                    <div class="mt-3 col-12">
                        <!-- Main Queue Display -->
                        <div class="row">
                            <div class="col-md-8">
                                @if($currentQueue)
                            <div class="queue-main">
                                {{ $currentQueue->nomorantrean }}  <!-- Menampilkan nomor antrian -->
                            </div>
                            <div class="queue-sub">
                                {{ strtoupper($currentQueue->poli->nama_poli) }}  <!-- Menampilkan nama poli -->
                            </div>
                        @else
                            <p>Tidak ada antrian yang sedang dipanggil.</p>  <!-- Menampilkan jika tidak ada antrian -->
                        @endif
                            </div>


                            <!-- Video Display -->
                            <div class="col-md-4">
                                <div class="video-container">
                                    <iframe src="https://www.youtube.com/embed/9FynEUYtJlE?si=aLJJC_KMLGRgZbXb" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>

                        <!-- Small Queue Sections -->
                        <div class="row">
                            @foreach($queues as $queue)
                                <div class="col-md-2 mb-4">
                                    <button class="btn btn-primary small-queue" style="width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                        <h1>{{ $queue->nomorantrean }}</h1> <!-- Menampilkan nomor antrian -->
                                        <span>{{ strtoupper($queue->poli->nama_poli) }}</span>  <!-- Menampilkan nama poli -->
                                        <p>Loket: {{ $queue->loket->nama ?? 'Tidak Ada Loket' }}</p>  <!-- Menampilkan nama loket -->
                                    </button>
                                </div>
                            @endforeach

                        </div>


                        <!-- Time Section -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="time-container">
                                    <!-- Time will be displayed here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
                <br>
            </section> <!-- /.content -->
        </div> <!-- ./wrapper -->

        <!-- Include your scripts as needed -->
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- JavaScript to update time -->
        <script>
            function checkQueue() {
                $.ajax({
                    url: "/get-antrian-terbaru",
                    type: "GET",
                    success: function (response) {
                        if (response && response.nomor_antrean) { // Pastikan data valid
                            console.log("Memutar suara antrian:", response);

                            // Gunakan Web Speech API untuk mengucapkan
                            const utterance = new SpeechSynthesisUtterance(
                                `Nomor Antrian: ${response.nomor_antrean}, pasien ${response.nama_pasien}, silakan menuju poli ${response.poli}`
                            );
                            utterance.lang = 'id-ID';
                            speechSynthesis.speak(utterance);

                            // Tandai antrian sebagai sudah dipanggil
                            markAsCalled(response.id);
                        } else {
                            console.log("Tidak ada antrian baru.");
                        }
                    },
                    error: function () {
                        console.error("Gagal mengambil data antrian!");
                    }
                });
            }

            // Fungsi untuk menandai antrian sebagai dipanggil agar tidak berulang
            function markAsCalled(id) {
                $.ajax({
                    url: "/mark-antrian-called/" + id,
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}"  },
                    success: function () {
                        console.log("Antrian ditandai sebagai dipanggil.");
                    }
                });
            }

            // Jalankan polling setiap 3 detik
            setInterval(checkQueue, 3000);
        </script>
        <script>
            function updateTime() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('en-US', { hour12: false });
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
