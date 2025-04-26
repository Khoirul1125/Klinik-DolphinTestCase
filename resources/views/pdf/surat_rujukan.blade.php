<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Rujukan FKTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px; /* Kurangi margin agar cukup di satu halaman */
            font-size: 11px; /* Kurangi ukuran font jika perlu */

        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }
        .box {
            border: 1px solid black;
            padding: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table td {
            padding: 5px;
            vertical-align: top;
        }
        .barcode {
            text-align: right;
        }
        .right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        .border-box {
            display: inline-block;
            border: 1px solid black;
            padding: 2px 5px;
            font-weight: bold;
            text-align: center;
            vertical-align: middle; /* Agar sejajar dengan teks di sebelahnya */
        }

    </style>

</head>
<body>
    <!-- Header -->

    <div style="width: 100%; display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding-bottom: 5px;">
        <!-- Logo BPJS di Kiri -->
        <div style="width: 50%; display: flex; align-items: center;">
            <img src="https://www.pngkey.com/png/detail/643-6432142_bpjs-logo-png-logo-bpjs-kesehatan-png.png"
                 alt="BPJS Logo"
                 style="height: 50px;">
        </div>

        <!-- Informasi Wilayah di Kanan, tetapi Teks Rata Kiri -->
        <div style="width: 30%; text-align: left; font-size: 12px; margin-left: auto;">
            <div style="display: grid; grid-template-columns: auto 1fr auto 1fr; gap: 10px; align-items: center;">
                <strong>Kedeputian Wilayah</strong>
                <span>:-</span>
                <br>
                <strong>Kantor Cabang</strong>
                <span>: -</span>
            </div>
        </div>
    </div>



    <div class="header">
        <p><strong>Surat Rujukan FKTP</strong></p>
    </div>
<!-- Kotak Besar -->
<div class="box" style="border: 1px solid black; padding: 5px; margin-top: 10px;">

    <div class="box" style="border: 1px solid black; padding: 5px;">
        <table class="table" style="width: 100%;">
            <tr>
                <!-- Kolom Informasi di Kiri -->
                <td style="width: 70%; vertical-align: top;">
                    <table style="width: 100%;">
                        <tr>
                            <td>No. Rujukan</td>
                            <td>: {{ $data->no_rujukan }}</td>
                        </tr>
                        <tr>
                            <td>FKTP</td>
                            <td>: {{ $data->fktp ?? 'Klinik Balaraja ' }} ({{ $setbpjs->KPFK ?? '-' }})</td>
                        </tr>
                        <tr>
                            <td>Kabupaten / Kota</td>
                            <td>: {{ $data->kab_kota ?? '-' }}</td>
                        </tr>
                    </table>
                </td>

                <!-- Kolom Barcode di Kanan -->
                <td style="width: 30%; text-align: right; vertical-align: top;">
                    @php
                        use \Picqer\Barcode\BarcodeGeneratorHTML;
                        $generator = new BarcodeGeneratorHTML();
                        $noRujukan = $data->no_rujukan ?? '000000000000';
                        $barcode = $generator->getBarcode($noRujukan, $generator::TYPE_CODE_128);
                    @endphp
                    <div style="display: inline-block;">
                        {!! $barcode !!}
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <!-- Informasi Tujuan -->
    <p><strong>Kepada Yth. TS Dokter</strong> : {{ $data->nama_subspesialis ?? $data->kd_khusus }}</p>
    <p><strong>Di</strong> : {{ $data->nama_rumahsakit }}</p>

    <p><strong>Mohon pemeriksaan dan penanganan lebih lanjut pasien :</strong></p>

    <!-- Informasi Pasien -->
        <table class="table" style="width: 100%;">
            <tr>
                @php
                    use Carbon\Carbon;
                    $tanggalLahir = $data->tanggal_lahir ?? '2000-01-01'; // Default jika null
                    $umur = Carbon::parse($tanggalLahir)->age;
                @endphp
                <td>Nama</td>
                <td>: <strong>{{ $data->nama_pasiens }}</strong></td>
                <td>Umur : {{ $umur }}</td>
                <td>Tahun: {{ date('d-M-Y', strtotime($data->tanggal_lahir)) }}</td>
            </tr>
            <tr>
                <td>No. Kartu BPJS</td>
                <td>: {{ $data->no_bpjs }}</td>
                <td>Status :
                    <span class="border-box" style="display: inline-block; vertical-align: middle; margin-right: 20px;">3</span>
                    <span style="vertical-align: middle;">Utama/Tanggungan</span>
                </td>
                <td>
                    <span class="border-box" style="display: inline-block; vertical-align: middle;">L</span>
                    <span style="margin-left: 10px; vertical-align: middle;">(L/P)</span>
                </td>
            </tr>
            <tr>
                <td>Diagnosa</td>
                <td colspan="2">: {{ $data->nama_diagnosa }} ({{ $data->kode_diagnosa }})</td>
            </tr>
            <tr>
                <td>Telah diberikan</td>
                <td colspan="2">: {{ $data->terapi ?? '-' }}</td>
            </tr>
            <tr>
                <td>Catatan</td>
                <td colspan="2">: {{ $data->catatan ?? '-' }}</td>
            </tr>
        </table>

    <!-- Tanggal Kunjungan -->
    <p><strong>Atas bantuannya, diucapkan terima kasih.</strong></p>
    <p><strong>Tgl. Rencana Berkunjung</strong> : {{ date('d-M-Y', strtotime($data->tgl_rujuk)) }}</p>

    <!-- Tanda Tangan -->
    <div style="width: 350%; display: flex; justify-content: space-between; margin-top: 10px;">
        <!-- Bagian Kiri (Kosong untuk keseimbangan) -->
        <div style="width: 50%;"></div>

        <!-- Bagian Kanan (Tanda Tangan) -->
        <div style="width: 50%; text-align: center;">
            <p style="margin-bottom: 5px;">Salam sejawat,</p>
            <p style="margin-bottom: 50px;">{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            <hr style="width: 5%; margin: 0 auto 10px; border: 1px solid black;">
            <p style="font-weight: bold;">{{ $data->nama_dokter ?? 'Tenaga Medis 450181' }}</p>

        </div>
    </div>

</div>

</div>






</body>
</html>
