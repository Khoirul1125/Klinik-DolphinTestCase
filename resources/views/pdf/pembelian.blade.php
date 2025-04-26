<!DOCTYPE html>
<html>
<head>
    <title>Data Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div style="width: 100%; display: table;">
        <!-- Gambar (Logo Klinik) -->
        <div style="display: table-cell; vertical-align: middle; width: 80px; text-align: center;">
            <img src="{{ asset('dist/img/avatar.png') }}" alt="Logo Klinik"
                 style="width: 80px; height: 80px; border-radius: 50%;" />
        </div>
        <!-- Teks di sebelah gambar -->
        <div style="display: table-cell; vertical-align: middle; padding-left: 15px; text-align: center;">
            <div style="font-weight: bold; font-size: 16px;">KLINIK OMEGA CITRA RAYA</div>
            <div style="font-size: 14px;">Ruko Danau Citra, Jl. Citra Raya Boulevard No.10, Kec. Cikupa, Kabupaten Tangerang, Banten 15131</div>
            <div style="font-size: 14px;">0813-1089-4294</div>
        </div>
    </div>

    <hr style="border: 1px solid #000; margin: 10px 0;" />

    <!-- BODY DATA -->
    <div style="width: 100%; display: flex; justify-content: space-between;">
        <div style="width: 45%; float: left; font-size: 12px;">
            <table style="width: 100%; border-collapse: collapse; table-layout: fixed; border: none;">
                <tr style="height: 24px; border: none;"> <!-- Tentukan height untuk keseragaman -->
                    <td colspan="3" style="height: 16px; border: none; font-weight: bold; font-size: 14px;">
                        Tanda Terima Apotek (TT. APOTEK)
                    </td>
                </tr>
                <tr style="height: 24px; border: none;">
                    <td style="width: 40%; text-align: left; border: none;"><strong>No. Faktur</strong></td>
                    <td style="width: 5%; text-align: center; border: none;">:</td>
                    <td style="text-align: left; border: none;">{{ $data['no_faktur'] }}</td>
                </tr>
                <tr style="height: 24px; border: none;">
                    <td style="border: none;"><strong>No. SP/PO</strong></td>
                    <td style="text-align: center; border: none;">:</td>
                    <td style="border: none;">{{ $data['po_sp'] }}</td>
                </tr>
                <tr style="height: 24px; border: none;">
                    <td style="border: none;"><strong>Faktur Supplier</strong></td>
                    <td style="text-align: center; border: none;">:</td>
                    <td style="border: none;">{{ $data['faktur_sup'] }}</td>
                </tr>
                <tr style="height: 24px; border: none;">
                    <td style="border: none;"><strong>Supplier</strong></td>
                    <td style="text-align: center; border: none;">:</td>
                    <td style="border: none;">{{ $data['supplier'] }}</td>
                </tr>
            </table>
        </div>
        <div style="width: 55%; float: right; font-size: 12px;">
            <table style="width: 100%; border-collapse: collapse; table-layout: fixed; border: none;">
                <tr style="height: 24px; border: none;">
                    <td style="height: 16px; border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                </tr>
                <tr style="height: 24px; border: none;">
                    <td style="width: 30%; text-align: left; border: none;"><strong>Tanggal Faktur</strong></td>
                    <td style="width: 5%; text-align: center; border: none;">:</td>
                    <td style="text-align: left; border: none;">{{ $data['tgl_faktur'] }}</td>
                </tr>
                <tr style="height: 24px; border: none;">
                    <td style="border: none;"><strong>Jatuh Tempo</strong></td>
                    <td style="text-align: center; border: none;">:</td>
                    <td style="border: none;">{{ $data['jatuh_tempo'] }}</td>
                </tr>
                <tr style="height: 24px; border: none;">
                    <td style="border: none;"><strong>PPN</strong></td>
                    <td style="text-align: center; border: none;">:</td>
                    <td style="border: none;">{{ $data['ppn'] }}</td>
                </tr>
                <tr style="height: 24px; border: none;">
                    <td style="border: none;"><strong>Tanggal Terima</strong></td>
                    <td style="text-align: center; border: none;">:</td>
                    <td style="border: none;">{{ $data['tgl_terima'] }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Bersihkan float -->
    <div style="clear: both;"></div>

    <!-- Tabel Data Barang -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="font-size: 12px; border-bottom: 1px solid black;">
                <th style="width: 35%">Nama Barang</th>
                <th>Qty</th>
                <th>Harga.Sat</th>
                <th>Expired</th>
                <th>Disc</th>
                <th>Batch No</th>
                <th style="width: 17%">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['items'] as $item)
            <tr style="font-size: 12px; border-bottom: 1px solid #ddd;">
                <td>{{ $item['namaBarang'] }}</td>
                <td>{{ $item['qty'] }}</td>
                <td>{{ $item['harga'] }}</td>
                <td>{{ $item['exp'] }}</td>
                <td>{{ $item['diskon'] }}</td>
                <td>{{ $item['kodeBatch'] }}</td>
                <td>Rp {{ $item['total'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <!-- Konten utama -->
    <div style="flex: 1; font-size: 12px;">
        <!-- Tabel data lainnya, seperti Sub Total, PPN, dll -->
        <table style="width: 45%; border-collapse: collapse; table-layout: fixed; border: none;">
            <tr>
                <td style="width: 30%; text-align: left; border: none;"><strong>Sub Total</strong></td>
                <td style="width: 5%; text-align: center; border: none;">:</td>
                <td style="text-align: left; border: none;">Rp. {{ $data['sub_total'] }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>PPN</strong></td>
                <td style="text-align: center; border: none;">:</td>
                <td style="border: none;">Rp. {{ $data['ppn_total'] }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Materai</strong></td>
                <td style="text-align: center; border: none;">:</td>
                <td style="border: none;">Rp. {{ $data['materai'] }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Koreksi</strong></td>
                <td style="text-align: center; border: none;">:</td>
                <td style="border: none;">Rp. {{ $data['koreksi'] }}</td>
            </tr>
            <tr>
                <td colspan="3" style="border: none; text-align: center; padding-top: 10px;">
                    <div style="border-top: 1px solid #000; width: 100%;"></div>
                </td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Total</strong></td>
                <td style="text-align: center; border: none;">:</td>
                <td style="border: none;">Rp. {{ $data['harga_total'] }}</td>
            </tr>
        </table>
    </div>

    <!-- Tabel TTD yang akan berada di bawah halaman -->
    <div style="position: absolute; bottom: 0; width: 95%; font-size: 12px;">
        <table style="width: 100%; border-collapse: collapse; text-align: center; border: none;">
            <tr>
                <td style="width: 50%; text-align: center; vertical-align: top; border: none;">
                    <strong>Petugas Entry Apotik</strong><br><br>
                    <div style="height: 50px; width: 100%; margin: 0 auto;"></div>
                    <br><strong>____________________  </strong>
                </td>
                <td style="width: 50%; text-align: center; vertical-align: top; border: none;">
                    <strong>Petugas Penerima Apotik</strong><br><br>
                    <div style="height: 50px; width: 100%; margin: 0 auto;"></div>
                    <br><strong>____________________  </strong>
                </td>
                <td style="width: 50%; text-align: center; vertical-align: top; border: none;">
                    <strong>Penanggung Jawab Apotek</strong><br><br>
                    <div style="height: 50px; width: 100%; margin: 0 auto;"></div>
                    <br><strong>____________________  </strong>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
