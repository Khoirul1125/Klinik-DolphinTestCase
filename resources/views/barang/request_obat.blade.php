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
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0 card-title">Kelola Data Barang</h3>
                                <div class="text-right card-tools">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#adddoctor">
                                        <i class="fas fa-plus"></i> Tambah Baru
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h1>Approve Data Obat</h1>
                                        @if (session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif
                                        @if (session('error'))
                                            <div class="alert alert-danger">{{ session('error') }}</div>
                                        @endif
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">ID</th>
                                                    <th style="width: 60%;">Nama Obat</th>
                                                    <th style="width: 10%;">Jumlah</th>
                                                    <th style="width: 25%;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($dataObatSementara as $obat)
                                                    <tr>
                                                        <td style="width: 5%;">{{ $obat->id }}</td>
                                                        <td style="width: 60%;">{{ $obat->nama_obat }}</td>
                                                        <td style="width: 15%;">{{ $obat->qty }}</td>
                                                        <td style="width: 25%;">
                                                            <div class="d-flex" style="gap: 10px;">
                                                                {{-- Tombol Approve --}}
                                                                <form action="/gudang/request/approve/{{ $obat->id }}" method="POST">
                                                                    @csrf
                                                                    <button class="btn btn-flat btn-success d-flex align-items-center justify-content-center shadow-sm"
                                                                    style="border-radius: 50px; padding: 5px 15px; font-size: 14px; text-decoration: none; width: auto; height: auto;">
                                                                    Approve
                                                                </button>
                                                            </form>
                                                            <!-- Tombol Reject -->
                                                                <form action="/gudang/request/reject/{{ $obat->id }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-flat btn-danger d-flex align-items-center justify-content-center shadow-sm"
                                                                            style="border-radius: 50px; padding: 5px 15px; font-size: 14px; text-decoration: none; width: auto; height: auto;">
                                                                        Reject
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">Tidak ada data obat sementara</td>
                                                    </tr>
                                                @endforelse
                                                {{-- @php
                                                    dd($dataObatSementara);
                                                @endphp --}}
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h1>Request Obat</h1>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>kode</th>
                                                    <th>Nama Obat</th>
                                                    <th>Jumlah</th>
                                                    <th>Tanggal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($dataRequestObat as $obat)
                                                    @foreach ($obat->details as $detail)
                                                        <tr>
                                                            <td>{{ $obat->kode }}</td>
                                                            <td>{{ $detail->nama_obat }}</td>
                                                            <td>{{ $detail->qty }}</td>
                                                            <td>{{ $obat->created_at->format('Y-m-d') }}</td>
                                                        </tr>
                                                    @endforeach
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">Tidak ada data obat sementara</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1>Stok Obat Klinik Omega Balaraja</h1>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>kode</th>
                                                    <th>Nama Obat</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($stok as $data)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $data->kode_barang }}</td>
                                                        <td>{{ $data->nama_barang }}</td>
                                                        <td>{{ $data->total_qty }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
    <!-- /.content-wrapper -->

    <div class="modal fade" id="adddoctor" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Request Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addFormpermesion" action="{{ route('gudang.request.add') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Kode Request :</label>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center">
                                            <input type="text" class="form-control" id="kode" name="kode" placeholder="Click Generate">
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center">
                                            <button type="button" class="btn btn-primary" onclick="generateBatchCode()">Generate</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Request Obat :</label>
                                    <div class="row">
                                        <div class="col-md-5">
                                            {{-- <input type="text" class="form-control" id="nama_obat" name="nama_obat" placeholde="Masukan Nama Obat"> --}}
                                            <select class="form-control select2bs4" style="width: 100%;" id="nama_obat" name="nama_obat">
                                                <option value="" disabled selected>-- Pilih Nama Obat --</option>
                                                @foreach ($dabar as $data)
                                                    <option value="{{$data->kode}}"> {{$data->nama}} ({{$data->industri}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5 d-flex align-items-center">
                                            <label class="mr-3 mb-0">Sebanyak</label>
                                            <input type="number" class="form-control mr-2" id="qty" name="qty" placeholder="Masukkan Kuantiti nya ">
                                        </div>
                                        <div class="col-md-2 d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary" onclick="addData()">Tambahkan</button>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" id="tableData" name="tableData" value="[]">

                               <!-- Tabel -->
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered" id="SubTabel">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%; text-align: center;">No</th>
                                                    <th style="width: 80%">Subyektif</th>
                                                    <th style="width: 15%; text-align: center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data akan diisi secara dinamis -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button> <!-- Submit button -->
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let dataArray = []; // Array untuk menyimpan data sementara
        let counter = 1; // Counter untuk nomor urut

        // Fungsi untuk mendapatkan kode terakhir dari database
        async function getLastBatchCode() {
            try {
                const response = await fetch('/api/get-last-batch-code'); // Endpoint API untuk mendapatkan kode terakhir
                const data = await response.json();
                if (data.success && data.last_code) {
                    const lastNumber = parseInt(data.last_code.split('-')[2]); // Ambil bagian angka terakhir
                    counter = lastNumber + 1; // Increment untuk kode berikutnya
                }
                console.log("Kode terakhir:", data.last_code || "Belum ada");
            } catch (error) {
                console.error("Gagal mendapatkan kode terakhir:", error);
            }
        }

        // Fungsi untuk generate kode batch
        function generateBatchCode() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const date = String(today.getDate()).padStart(2, '0');
            const formattedDate = `${year}${month}${date}`;
            const batchKode = `BLRJ-${formattedDate}-${String(counter).padStart(4, '0')}`;

            // Set nilai kode batch ke input
            document.getElementById("kode").value = batchKode;
            counter++; // Increment untuk kode berikutnya
            console.log("Kode batch dihasilkan:", batchKode);
        }

        // Fungsi untuk menambahkan data ke array dan tabel
        function addData() {
            const kode = document.getElementById("kode").value;
            const kode_obat = document.getElementById("nama_obat").value;
            const nama_obat = $('#nama_obat option:selected').text().trim();
            const qty = document.getElementById("qty").value;

            if (!kode) {
                alert("Kode batch belum di-generate!");
                return;
            }

            if (!kode_obat || !qty) {
                alert("Semua kolom harus diisi!");
                console.log("Input tidak lengkap");
                return;
            }

            // Tambahkan data ke array
            dataArray.push({ kode, kode_obat,nama_obat, qty });
            console.log("Data ditambahkan:", { kode, kode_obat, nama_obat, qty });

            // Render ulang tabel
            renderTable();

            // Reset input fields setelah data ditambahkan
            $('#nama_obat').val('').trigger('change');  // Gunakan select2 val() untuk mereset dan trigger 'change' untuk memperbarui UI
            document.getElementById("qty").value = '';  // Reset qty field

            // Simpan data array ke input hidden
            const tableData = document.getElementById("tableData");
            tableData.value = JSON.stringify(dataArray); // Mengubah array menjadi string JSON
        }

        // Fungsi untuk merender tabel
        function renderTable() {
            const tableBody = document.getElementById("SubTabel").querySelector("tbody");
            tableBody.innerHTML = ""; // Kosongkan tabel

            dataArray.forEach((data, index) => {
                const row = `
                    <tr>
                        <td style="text-align: center;">${index + 1}</td>
                        <td>${data.nama_obat} Sebanyak ${data.qty} buah</td>
                        <td style="text-align: center;">
                            <button class="btn btn-danger btn-sm" onclick="removeData(${index})">Hapus</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        }

        // Fungsi untuk menghapus data dari array
        function removeData(index) {
            dataArray.splice(index, 1); // Hapus data berdasarkan index
            renderTable(); // Render ulang tabel
        }

        // Panggil fungsi untuk mendapatkan kode terakhir saat halaman dimuat
        getLastBatchCode();
    </script>


@endsection

