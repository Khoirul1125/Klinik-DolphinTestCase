@extends('template.app')

@section('content')

<style>

    #qrCode {

        object-fit: contain; /* Maintain aspect ratio */
        text-align: center; /* Center the image and status text */
    }

    #status {
        margin-top: 10px; /* Add some space between image and status */
        font-size: 16px; /* Adjust font size */
        color: #333; /* Text color */
    }
            /* Style for QR code container */
</style>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-body text-center">
                                <h2 class="mb-4">WhatsApp Gateway</h2>

                                <!-- Status WhatsApp -->
                                <div id="status">Status: Checking connection...</div>

                                <!-- Tempat QR Code -->
                                <div id="qrCode" style="display: flex; justify-content: center; align-items: center;">
                                    <img id="statusImage"
                                         src="https://media1.giphy.com/media/EZnSvdWR2k5jYljjp4/giphy.gif"
                                         alt="Waiting QR Code" width="128" height="128"/>
                                </div>

                                <!-- Tombol Start WhatsApp -->
                                <div class="mt-4">
                                    <button id="startWhatsAppBtn" class="btn btn-primary">Start WhatsApp</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            const licenseKey = "{{ $licenseKey ?? '' }}"; // Ambil lisensi dari Laravel jika tersedia

            // ✅ Cek status WhatsApp sebelum memulai
            checkWhatsAppStatus();

            // ✅ Event klik tombol Start WhatsApp
            $('#startWhatsAppBtn').on('click', function() {
                if (!licenseKey) {
                    $('#status').text('License key is missing!').css('color', 'red');
                    return;
                }
                fetchQrCode();
            });

            // ✅ Fungsi untuk Mengecek Status WhatsApp
            function checkWhatsAppStatus() {
                $.get(`/api/whatsapp/check-status`, function(response) {
                    if (response.status === 'connected') {
                        $('#status').text('WhatsApp Connected').css('color', 'green');
                        $('#statusImage').attr("src", "https://cdn-icons-png.flaticon.com/512/190/190411.png");
                    } else {
                        $('#status').text('WhatsApp Not Connected').css('color', 'orange');
                    }
                }).fail(function() {
                    $('#status').text('Error checking WhatsApp status').css('color', 'red');
                });
            }

            // ✅ Fungsi untuk Memperbarui QR Code Hingga WhatsApp Terhubung
            function fetchQrCode() {
                $.get(`/api/whatsapp/get-qr`, function(response) {
                    if (response.status === 'ready') {
                        $('#status').text('WhatsApp Connected').css('color', 'green');
                        $('#statusImage').attr("src", "https://cdn-icons-png.flaticon.com/512/190/190411.png");

                        // ✅ Simpan status ke database
                        saveWhatsAppSession();
                    } else if (response.status === 'pending') {
                        $('#status').text('Scan the QR Code.').css('color', 'orange');
                        $('#qrCode').html('');
                        new QRCode(document.getElementById('qrCode'), { text: response.qrCode });

                        // Coba lagi setelah 5 detik jika belum login
                        setTimeout(fetchQrCode, 5000);
                    } else {
                        $('#status').text('Waiting for QR Code...').css('color', 'orange');
                    }
                }).fail(function() {
                    $('#status').text('Error fetching QR Code!').css('color', 'red');
                });
            }

            // ✅ Simpan Status WhatsApp ke Database Laravel
            function saveWhatsAppSession() {
                $.post(`/api/whatsapp/save-login`, { whatsapp_number: "UNKNOWN" })
                .done(function(response) {
                    console.log("WhatsApp session saved:", response);
                })
                .fail(function() {
                    console.log("Failed to save WhatsApp session.");
                });
            }
        });
    </script>



@endsection
