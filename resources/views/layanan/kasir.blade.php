@extends('template.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <div class="mt-3 col-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12 mb-3">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h3 class="card-title">Pendataan Faktur Masuk Kasir</h3>
                                    </div>
                                </div>
                                {{-- <div class="card-header bg-light">
                                    <h5 class="mb-0 card-title">Pendataan Faktur Lunas Kasir</h5>
                                </div> --}}
                                <div class="row">
                                    <div class="mb-3 col-md-8">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table id="patienttbl" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>No RM</th>
                                                                    <th>Nama</th>
                                                                    <th>Alamat</th>
                                                                    <th>Poli</th>
                                                                    <th>Total (Rp.)</th>
                                                                    <th>Tanggal</th>
                                                                    <th>Pilihan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($data as $index => $data)
                                                                    <tr data-prebayars='@json($data->prebayar)'
                                                                        data-fakturs='@json($data)'>
                                                                        <td>{{ $loop->iteration }}</td> <!-- Menampilkan indeks mulai dari 1 -->
                                                                        <td>{{ $data->no_rm }}</td>
                                                                        <td>{{ $data->nama }}</td>
                                                                        <td>{{ $data->alamat ?? 'Beli Bebas'}}</td>
                                                                        <td>{{ $data->nama_poli }}</td>
                                                                        <td>{{ $data->total }}</td>
                                                                        <td>{{ $data->created_at->format('d-m-Y') }}</td>
                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                            <a href="{{ route('keuangan.kasir.bayar', ['nofaktur' => $data->kode_faktur]) }}">
                                                                                <button type="submit" class="btn btn-danger btn-sm">Bayar</button>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                                @foreach($data_tindakan_filtered as $tindakan)
                                                                    <tr data-tindakan_jenis="{{ $tindakan->tindakan_array }}">
                                                                        <td>{{ $loop->iteration + $data->count() }}</td>
                                                                        <td>{{ $tindakan->no_rm }}</td>
                                                                        <td>{{ $tindakan->nama_pasien }}</td>
                                                                        <td>{{ $tindakan->rajal->pasien->Alamat }}, {{ $tindakan->rajal->pasien->desa->name }}, {{ $tindakan->rajal->pasien->kabupaten->name }}, {{ $tindakan->rajal->pasien->provinsi->name }},
                                                                        </td>
                                                                        <td>{{ $tindakan->rajal->poli->nama_poli }}</td>
                                                                        <td>{{ $tindakan->total_penjumlahan }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($tindakan->tgl_kunjungan)->format('d-m-Y') }}</td>
                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                            <a href="{{ route('keuangan.kasir.bayar', ['nofaktur' => $tindakan->kode_faktur, 'no_rawat' => $tindakan->no_rawat]) }}">
                                                                                <button class="btn btn-danger btn-sm">Bayar</button>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach


                                                                {{-- @php
                                                                    // dd($data_tindakan_filtered);
                                                                    dd($data->pluck('no_reg'));
                                                                @endphp --}}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Preview UBL : <span id="preview-ubl"> </span></label>
                                                        <table class="outer-table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <table id="preview-table" class="table table-bordered">
                                                                            <thead>
                                                                                <th>Nama</th>
                                                                                <th>Harga</th>
                                                                                <th>Qty</th>
                                                                                <th>SubTot</th>
                                                                            </thead>
                                                                            <tbody>

                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
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
        </section>
        <!-- /.content -->
    </div>

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
        #preview-table {
            width: 100%;
            border-collapse: collapse; /* Menggabungkan border tabel dalam */
            border: none; /* Menghilangkan border */
        }

        /* Menghilangkan border pada tabel dalam dan memberikan padding */
        #preview-table td, #preview-table th {
            border: none; /* Menghilangkan border */
            padding: 10px; /* Memberikan ruang di dalam sel tabel dalam */
            font-size: 16px; /* Ukuran font */
        }

        /* Menambahkan gaya untuk membuat konten tabel dalam mengisi tabel luar secara penuh */
        .outer-table td {
            vertical-align: top; /* Menjaga konten tabel dalam berada di bagian atas tabel luar */
        }

        #preview-ubl {
            font-weight: normal;
        }
    </style>

    {{-- <script>
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
    </script> --}}

    <script>
    $(document).ready(function() {
    // Mengambil tanggal hari ini
    var today = new Date();
    today.setHours(0, 0, 0, 0); // Set waktu ke jam 00:00 agar hanya dibandingkan dengan tanggal

    // Inisialisasi DataTable
    var table = $("#patienttbl").DataTable({
        "responsive": true,
        "autoWidth": false,
        "lengthChange": true,
        "language": {
            "lengthMenu": "Tampil _MENU_",
            "info": "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
            "search": "Cari :",
            "paginate": {
                "previous": "Sebelumnya",
                "next": "Berikutnya"
            }
        },
        "stateSave": true, // Menyimpan status tabel (pencarian, pagination, dll.)
    });

    // Menambahkan filter tanggal kustom sebelum pencarian dilakukan
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        // Ambil input pencarian
        var searchInput = $('.dataTables_filter input').val().toLowerCase();
        var tglRawat = data[6]; // Misalnya: 25-12-2024

        // Cek jika ada pencarian
        if (searchInput && searchInput.trim() !== '') {
            return true; // Abaikan filter tanggal jika pencarian aktif
        }

        // Cek apakah tanggal lebih besar atau sama dengan hari ini
        if (!tglRawat) return false;

        var tglParts = tglRawat.split("-");
        var tglRawatDate = new Date(tglParts[2], tglParts[1] - 1, tglParts[0]);

        // Cek apakah tanggal lebih besar atau sama dengan hari ini
        return tglRawatDate >= today;
    });

    // Setelah DataTable dimuat, gambar ulang untuk menerapkan filter tanggal
    table.draw();

    // Menangani pencarian manual
    $('#patienttbl_filter input').on('keyup', function () {
        // Pencarian akan diterapkan ke seluruh tabel
        table.search(this.value).draw();
    });
});

</script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rows = document.querySelectorAll('#patienttbl tbody tr');
            const previewTableBody = document.querySelector('#preview-table tbody');
            const previewUblSpan = document.querySelector('#preview-ubl');

            rows.forEach(row => {
                row.addEventListener('click', function (event) {
                    // Periksa apakah klik terjadi pada kolom 1-7
                    const cellIndex = Array.from(row.children).indexOf(event.target);
                    if (cellIndex < 0 || cellIndex > 6) return; // Abaikan klik di luar kolom 1-7

                    // Periksa apakah baris sudah dipilih
                    const isActive = row.style.backgroundColor === 'rgb(0, 123, 255)'; // rgb untuk warna #007bff

                    // Reset semua baris
                    rows.forEach(r => {
                        r.style.backgroundColor = '';
                        r.style.color = '';
                    });

                    // Jika sudah aktif, hapus preview dan batalkan highlight
                    if (isActive) {
                        previewTableBody.innerHTML = ''; // Kosongkan tabel preview
                        previewUblSpan.textContent = ''; // Reset span
                        return; // Keluar dari fungsi
                    }

                    // Highlight baris dengan warna biru muda
                    row.style.backgroundColor = '#007bff'; // Biru muda
                    row.style.color = 'white';

                    // Kosongkan tabel preview
                    previewTableBody.innerHTML = '';

                    if (row.hasAttribute('data-tindakan_jenis')) {
                        // Ambil data tindakan dari atribut data
                        const tindakanJenis = JSON.parse(row.getAttribute('data-tindakan_jenis'));

                        // Tampilkan data lengkap di konsol
                        console.log('Tindakan:', tindakanJenis);

                        // Update span Preview UBL dengan no_rm - nama
                        previewUblSpan.textContent = `${tindakanJenis[0].no_rm} - ${tindakanJenis[0].nama_pasien}`;

                        // Isi tabel preview
                        tindakanJenis.forEach(tindakan => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${tindakan.nama_tindakan}</td>
                                <td>${tindakan.harga}</td>
                                <td>1</td>
                                <td>${(tindakan.harga)}</td>
                            `;
                            previewTableBody.appendChild(tr);
                        });
                        return; // Keluar dari fungsi
                    }

                    // Ambil data prebayar dari atribut data
                    const faktur = JSON.parse(row.getAttribute('data-fakturs'));
                    const prebayars = JSON.parse(row.getAttribute('data-prebayars'));

                    // Tampilkan data lengkap di konsol
                    console.log('Faktur:', faktur);
                    console.log('Prebayar:', prebayars);

                    // Update span Preview UBL dengan no_rm - nama
                    previewUblSpan.textContent = `${faktur.no_rm} - ${faktur.nama}`;

                    // Isi tabel preview
                    prebayars.forEach(prebayar => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${prebayar.nama_obat}</td>
                            <td>${prebayar.harga}</td>
                            <td>${prebayar.kuantitas}</td>
                            <td>${(prebayar.total_harga)}</td>
                        `;
                        previewTableBody.appendChild(tr);
                    });
                });
            });
        });
    </script>



@endsection
