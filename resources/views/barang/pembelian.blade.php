@extends('template.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <script>


                    </script>


                    <div class="mt-3 col-12">
                        <div class="row d-flex">
                            <!-- Start Form -->
                            <form action="{{ route('barang.pembelian.add') }}" method="POST" class="row w-100" >
                                @csrf
                                <!-- Kelola Data Pasien -->
                                <div class="col-md-12">
                                    <div class="card-header bg-light">
                                        <h5><center> Input Pembelian Obat / Alkes </center></h5>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="no_faktur">No Faktur</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="no_faktur" name="no_faktur">
                                                                    <span class="input-group-btn">
                                                                        <button type="button" class="btn btn-primary" onclick="generateNomorfaktur()">Generate</button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <div class="d-flex align-items-center">
                                                                    <label for="supplierCheck" class="mr-2 mb-0">Supplier</label>
                                                                    <input type="checkbox" id="supplierCheck" name="supplier_checkbox" onclick="toggleSupplierInput()" style="margin-left: 5px;">
                                                                </div>
                                                                <div class="d-flex align-items-center mt-2">
                                                                    <!-- Select dropdown (visible by default) -->
                                                                    <select class="form-control select2bs4 mt-2" style="width: 100%;" id="supplierSelect" name="supplierSelect">
                                                                        @foreach ($industri as $data)
                                                                            <option value="{{$data->nama_industri}}">{{$data->nama_industri}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <!-- Text input (hidden by default) -->
                                                                    <input type="text" class="form-control" id="supplierInput" name="supplierInput" style="display: none;">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="no_po_sp">No. PO atau SP</label>
                                                                <input type="text" class="form-control" id="no_po_sp" name="no_po_sp">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <div class="d-flex align-items-center">
                                                                    <label for="faktur_konsinyasi" class="mr-2 mb-0">No Faktur Supplier</label>
                                                                    <input type="checkbox" id="faktur_konsinyasi" name="faktur_konsinyasi" onclick="togglePOField()" class="mr-2">
                                                                    {{-- <label for="faktur_konsinyasi" class="mb-0">Konsinyasi</label> --}}
                                                                </div>

                                                                <div class="d-flex align-items-center mt-2">
                                                                    <!-- Input for No Faktur Konsinyasi -->
                                                                    <input type="text" class="form-control" id="no_faktur_suplier" name="no_faktur_suplier">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <div class="d-flex align-items-center">
                                                                    <label for="tgl_terima" class="mr-2 mb-0">Tanggal Terima</label>
                                                                    <input type="checkbox" id="toggle-edit-date" name="toggle-edit-date" style="margin-left: 5px;">
                                                                </div>
                                                                <div class="d-flex align-items-center mt-2">
                                                                    <input type="date" class="form-control" id="tgl_terima" name="tgl_terima" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <div class="d-flex align-items-center">
                                                                    <label for="tgl_faktur" class="mr-2 mb-0">Tanggal Faktur</label>
                                                                </div>
                                                                <div class="d-flex align-items-center mt-2">
                                                                    <input type="date" class="form-control" id="tgl_faktur" name="tgl_faktur">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <div class="d-flex align-items-center">
                                                                    <label for="tgl_jatuhtempo" class="mr-2 mb-0">Tanggal Jatuh tempo</label>
                                                                </div>
                                                                <div class="d-flex align-items-center mt-2">
                                                                    <div class="input-group">
                                                                        <!-- Tombol untuk Date Range Picker -->
                                                                        <div class="input-group-prepend">
                                                                            <button type="button" class="btn btn-default" id="daterange-btn" style="font-size: 0.9rem;">
                                                                                <i class="far fa-calendar-alt"></i> Date
                                                                                <i class="fas fa-caret-down"></i>
                                                                            </button>
                                                                        </div>

                                                                        <!-- Input untuk menampilkan rentang tanggal yang disabled, menempel pada tombol -->
                                                                        <input type="text" id="date-range-view" class="form-control" readonly style="font-size: 0.9rem;" name="date-range-view">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <div class="d-flex align-items-center">
                                                                    <label for="ppnpajak" class="mr-2 mb-0">Pajak / PPN</label>
                                                                </div>
                                                                <div class="d-flex align-items-center mt-2">
                                                                    <input type="text" class="form-control" id="ppnpajak" name="ppnpajak">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <div class="d-flex align-items-center">
                                                                    <label for="hj" class="mr-2 mb-0">Metode HNA</label>
                                                                </div>
                                                                <div class="d-flex align-items-center mt-2">
                                                                    <select class="form-control select2bs4" style="width: 100%;" id="hj" name="hj">
                                                                        <option value="1">Tanpa PPN Dan Diskon</option>
                                                                        <option value="2">Dengan PPN</option>
                                                                        <option value="3">Dengan Diskon</option>
                                                                        <option value="4">Dengan PPN Dan Diskon</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="d-flex align-items-center">
                                                                    <label for="namabarang" class="mr-2 mb-0">Nama Barang</label>
                                                                </div>
                                                                <div class="d-flex align-items-center mt-2">
                                                                    <select class="form-control select2bs4 mt-2" style="width: 100%;" id="namabarang" name="namabarang" onchange="updateFields()">
                                                                        <option value=" " disabled selected> -- Pilih Obat -- </option>
                                                                        @foreach ($dabar as $data)
                                                                            <option value="{{$data->kode}}" data-satuan_kecil="{{$data->satuan->nama_satuan}}" data-harga="{{$data->harga_dasar}}" data-satuan_sedang="{{$data->satuan_sedangs->nama_satuan}}" data-satuan="{{$data->satuan_sedang}}" data-kode="{{$data->kode}}">
                                                                                {{$data->nama}} - ({{$data->industri}})
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    {{-- @php
                                                                        dd($dabar);
                                                                    @endphp --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-12" id="kemasanGroup">
                                                            <div class="form-group">
                                                                <!-- Checkbox untuk Toggle Kemasan -->
                                                                <div class="form-row align-items-center mb-2">
                                                                    <div class="col-md-6 d-flex align-items-center">
                                                                        <input type="checkbox" id="toggleKemasan" style="margin-right: 5px;" onchange="toggleKemasanInput()">
                                                                        <label for="toggleKemasan" id="kemasanLabel" class="col-form-label mb-0">Kemasan Kecil</label>
                                                                    </div>
                                                                </div>

                                                                <!-- Fields untuk Kemasan Kecil -->
                                                                <div id="kemasanKecilGroup">
                                                                    <div class="form-row align-items-center mb-2">
                                                                        <label for="jumlahSatuanKecil" class="col-md-4 col-form-label" style="padding-left: 22px">Satuan Kecil</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" id="jumlahSatuanKecil" name="jumlahSatuanKecil" class="form-control">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <span id="satuanKecilSpan">Kems kecil</span> <!-- Target span for Satuan Kecil -->
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row align-items-center">
                                                                        <label for="hargaSatuanKecil" class="col-md-4 col-form-label" style="padding-left: 22px">Harga Satuan Rp</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" id="hargaSatuanKecil" name="hargaSatuanKecil" class="form-control">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <span id="hargaSatuanSpan">[Rp - ]</span> <!-- Target span for Harga Satuan -->
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Fields untuk Kemasan Besar -->
                                                                <div id="kemasanBesarGroup" style="display: none;">
                                                                    <div class="form-row align-items-center mb-2">
                                                                        <label for="jumlahSatuanBesar" class="col-md-4 col-form-label" style="padding-left: 22px">Jumlah Satuan Besar</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" id="jumlahSatuanBesar" name="jumlahSatuanBesar" class="form-control" oninput="calculateJumlahSatuanKecil()">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <span id="satuanBesarSpan">Kems Besar</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row align-items-center">
                                                                        <label for="hargaSatuanBesar" class="col-md-4 col-form-label" style="padding-left: 22px">Harga Satuan Besar Rp</label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" id="hargaSatuanBesar" name="hargaSatuanBesar" class="form-control" oninput="calculateJumlahHargaKecil()">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="d-flex align-items-center">
                                                                    <label for="diskon" class="mr-2 mb-0">Diskon</label>
                                                                    <input type="checkbox" id="formatToggle" style="margin-left: 5px;" onclick="toggleFormat()">
                                                                    <label class="ml-2 mb-0"> (click button untuk menjadi rupiah)</label>
                                                                </div>
                                                                <div class="d-flex align-items-center mt-2">
                                                                    <input type="text" class="form-control" id="diskon" name="diskon">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="d-flex align-items-center">
                                                                    <label for="tgl_jatuhtempo" class="mr-2 mb-0">Tanggal Expired</label>
                                                                </div>
                                                                <div class="d-flex align-items-center mt-2">
                                                                    <div class="input-group">
                                                                        <!-- Date Range Picker Button -->
                                                                        <div class="input-group-prepend">
                                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="font-size: 0.9rem;" id="date-picker-button">
                                                                                <i class="far fa-calendar-alt"></i> Pilih Opsi
                                                                            </button>
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item" href="#" id="select-month-year">Bulan & Tahun</a>
                                                                                <a class="dropdown-item" href="#" id="select-date">Tanggal</a>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Readonly datepicker input -->
                                                                        <input type="text" class="form-control datetimepicker-input" id="date-ranges" name="date-ranges" data-toggle="datetimepicker" data-target="#date-ranges" style="font-size: 0.9rem;" readonly />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="d-flex align-items-center">
                                                                    <label for="batchNo" class="mr-2 mb-0">Batch No.</label>
                                                                </div>
                                                                <div class="d-flex align-items-center mt-2">
                                                                    <input type="text" class="form-control" id="batchNo" name="batchNo">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- New Button Section for Save -->
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <button type="button" class="btn btn-primary btn-block" id="simpanData">Tambah Data Sementara</button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="button" class="btn btn-danger btn-block" id="hapusData">Hapus</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-8">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
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
                                                            #kunjungan-table {
                                                                width: 100%;
                                                                border-collapse: collapse; /* Menggabungkan border tabel dalam */
                                                                border: none; /* Menghilangkan border */
                                                            }

                                                            /* Menghilangkan border pada tabel dalam dan memberikan padding */
                                                            #kunjungan-table td, #kunjungan-table th {
                                                                border: none; /* Menghilangkan border */
                                                                padding: 10px; /* Memberikan ruang di dalam sel tabel dalam */
                                                                font-size: 16px; /* Ukuran font */
                                                            }

                                                            /* Menambahkan gaya untuk membuat konten tabel dalam mengisi tabel luar secara penuh */
                                                            .outer-table td {
                                                                vertical-align: top; /* Menjaga konten tabel dalam berada di bagian atas tabel luar */
                                                            }

                                                            /* Gaya untuk tombol Naik dan Turun */
                                                            .move-buttons {
                                                                display: flex;
                                                            }

                                                            .move-buttons button {
                                                                padding: 5px 10px;
                                                                background-color: #007bff;
                                                                color: white;
                                                                border: none;
                                                                border-radius: 5px;
                                                                cursor: pointer;
                                                            }

                                                            .move-buttons button:hover {
                                                                background-color: #0056b3;
                                                            }

                                                            /* Gaya untuk baris yang dipilih */
                                                            .selected {
                                                                background-color: #007bff; /* Menambahkan warna biru pada baris yang dipilih */
                                                                color: white; /* Menyesuaikan warna teks dengan latar belakang */
                                                            }
                                                        </style>

                                                        <!-- Hidden inputs for the table data -->
                                                        <input type="hidden" id="tableData" name="tableData" value="[]">

                                                        <table class="outer-table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <!-- Tabel dalam dengan data -->
                                                                        <table id="kunjungan-table" class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-center">No</th>
                                                                                    <th class="text-center">Nama Item</th>
                                                                                    <th class="text-center">Kode Item</th>
                                                                                    <th class="text-center">Qty</th>
                                                                                    <th class="text-center">Hrg Sat</th>
                                                                                    <th class="text-center">Expired</th>
                                                                                    <th class="text-center">Disc</th>
                                                                                    <th class="text-center">Batch No</th>
                                                                                    <th class="text-center">Sub Total</th>
                                                                                  </tr>
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
                                                <div class="col-md-6">
                                                    <div class="form-group row d-flex align-items-center mb-1">
                                                        <div class="col-md-3">
                                                            <label for="kulit" class="h5">Sub Total</label>
                                                        </div>
                                                        <div class="col-md-1 text-center">
                                                            <label class="h5">:</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            {{-- <label class="h5" id="sub_total" name="sub_total">Testing</label> --}}
                                                            <label class="h5" id="sub_total_label"></label>

                                                            <!-- Input tersembunyi untuk mengirimkan nilai -->
                                                            <input type="hidden" id="sub_total" name="sub_total">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row d-flex align-items-center mb-1">
                                                        <div class="col-md-3">
                                                            <label class="h5" style="color: red;">Total Diskon</label>
                                                        </div>
                                                        <div class="col-md-1 text-center">
                                                            <label class="h5" style="color: red;">:</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label class="h5" id="total_diskon_label" style="color: red;"></label>

                                                            <!-- Input tersembunyi untuk mengirimkan nilai -->
                                                            <input type="hidden" id="total_diskon" name="total_diskon" value="PPN">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row d-flex align-items-center mb-1">
                                                        <div class="col-md-3">
                                                            <label class="h5">PPN</label>
                                                        </div>
                                                        <div class="col-md-1 text-center">
                                                            <label class="h5">:</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label class="h5" id="ppn_bawah_label"></label>

                                                            <!-- Input tersembunyi untuk mengirimkan nilai -->
                                                            <input type="hidden" id="ppn_total" name="ppn_total" value="PPN">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row d-flex align-items-center mb-1">
                                                        <div class="col-md-3">
                                                            <label class="h5 text-success">Materai</label> <!-- Materai dengan warna primary -->
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select class="form-control select2bs4" style="width: 100%;" id="materai" name="materai">
                                                                <option value="0">0</option>
                                                                <option value="3000">3000</option>
                                                                <option value="6000">6000</option>
                                                                <option value="10000">10000</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="h5 text-info" style="padding-left: 10px">Koreksi :</label> <!-- Koreksi dengan warna danger -->
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control" id="koreksi" name="koreksi" value="0" maxlength="3">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row d-flex align-items-center mb-0">
                                                        <div class="col-12">
                                                            <hr style="background-color: #000;"> <!-- Garis horizontal sepanjang kolom -->
                                                        </div>
                                                    </div>
                                                    <div class="form-group row d-flex align-items-center mb-0">
                                                        <div class="col-md-3">
                                                            <label class="h4">Total</label> <!-- Ukuran lebih besar dengan kelas Bootstrap h4 -->
                                                        </div>
                                                        <div class="col-md-1 text-center">
                                                            <label class="h4">:</label> <!-- Ukuran lebih besar dengan kelas Bootstrap h4 -->
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label class="h4" id="total_harga_label" ></label> <!-- Ukuran lebih besar dengan kelas Bootstrap h4 -->

                                                            <!-- Input tersembunyi untuk mengirimkan nilai -->
                                                            <input type="hidden" id="harga_total" name="harga_total" value="harga">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 d-flex flex-column"  style="height: 23vh;">
                                                    <!-- Form Input -->
                                                    <div class="form-group row d-flex align-items-center mb-2">
                                                        <div class="col-md-12">
                                                            <label class="mr-2" style="white-space: nowrap;">User Penerima Barang:</label>
                                                            <select class="form-control select2bs4" id="penerima_barang" name="penerima_barang">
                                                                <option value=" " disabled selected>-- Isi Penerima Barang --</option>
                                                                @foreach ($user as $data)
                                                                    <option value="{{$data->id}}">{{$data->name}} ({{$data->username}})</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol yang diposisikan di bawah dengan flex -->
                                                    <div class="mt-auto"> <!-- mt-auto memastikan tombol berada di bawah -->
                                                        <div class="form-group row">
                                                            <div class="col-md-4 d-flex justify-content-end">
                                                                <!-- Button Simpan -->
                                                                <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                                                            </div>
                                                            <div class="col-md-4 d-flex justify-content-end">
                                                                <!-- Button Batal -->
                                                                <button type="button" class="btn btn-secondary btn-block">Batal</button>
                                                            </div>
                                                            <div class="col-md-4 d-flex justify-content-end">
                                                                <!-- Button Cetak -->
                                                                <button type="button" class="btn btn-success btn-block">Cetak</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- End Form -->
                        </div>
                    </div>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">WARNING !!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBodyText">
                    <!-- Pesan konfirmasi akan diisi dinamis -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modalProceedButton">Ok</button>
                </div>
            </div>
        </div>
    </div>



<script>
    $(document).ready(function() {
        // Cek apakah ada session flash dengan URL PDF
        let pdfUrl = "{{ session('pdf_url') }}";
        if (pdfUrl) {
            // Buka tab baru untuk download PDF
            window.open(pdfUrl, '_blank');
        }
    });
</script>

    <script>
        $(document).ready(function() {
            var barangSettingExists = {{ $barangSettingExists }}; // Ambil nilai dari PHP

            // Jika barangSettingExists bernilai 0, tampilkan modal
            if (barangSettingExists === 0) {
                $('#modalBodyText').text("Setting terlebih dahulu Harga Jual pada bagian Barang Setting");
                $('#confirmationModal').modal({ backdrop: 'static', keyboard: false }); // Modal tidak bisa ditutup dengan klik luar
                $('#confirmationModal').modal('show');
            }

            // Tombol "OK" untuk redirect ke halaman Barang Setting
            $('#modalProceedButton').click(function() {
                window.location.href = "{{ route('gudang.setting') }}"; // Redirect ke route yang ditentukan
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // Kunci Select2 setelah dipilih
            let sudahDipilih = false;

            $('#hj').on('select2:select', function () {
                if (!sudahDipilih) {
                    sudahDipilih = true;

                    // Matikan interaksi Select2
                    $(this).prop('readonly', true); // Tidak mengubah DOM, hanya efek
                    $(this).select2('destroy'); // Hapus Select2 dan kembalikan ke default

                    // Opsional: Ubah tampilan untuk feedback
                    $(this).css({
                        'pointer-events': 'none',
                        'background-color': '#e9ecef',
                        'cursor': 'not-allowed'
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            let tableData = []; // Array untuk menyimpan data tabel

            function updateSubTotal() {
                // Kalkulasi subtotal dari semua subTotalItem dalam tableData
                let subTotal = tableData.reduce((accumulator, item) => {
                    // Menambahkan subTotalItem yang ada di setiap item baru
                    return accumulator + item.subTotalItem; // Gunakan subTotalItem yang ada di newData
                }, 0);

                // Format subtotal ke dalam format Indonesia (IDR)
                let formattedSubTotal = subTotal.toLocaleString('id-ID', { minimumFractionDigits: 2 });

                // Tampilkan subtotal dalam label
                $('#sub_total_label').text(`Rp ${formattedSubTotal}`);

                // Masukkan subtotal ke dalam input hidden untuk dikirimkan melalui form
                $('#sub_total').val(subTotal);  // Gunakan nilai asli (bukan yang terformat)

                // Setelah subtotal diperbarui, hitung dan tampilkan PPN
                updatePPN(); // Perbarui PPN setelah subtotal berubah

                updateTotalDiskon(); // Update total diskon setelah subtotal diperbarui
            }

            function updateTotalDiskon() {
                // Kalkulasi total diskon dari seluruh item dalam tableData
                let totalDiskon = tableData.reduce((accumulator, item) => {
                    // Menambahkan nilai diskon barang (diskon per barang)
                    return accumulator + item.seluruhDiskon; // Seluruh diskon adalah angka, tidak perlu replace
                }, 0);

                // Format total diskon ke dalam format Indonesia (IDR)
                let formattedTotalDiskon = totalDiskon.toLocaleString('id-ID', { minimumFractionDigits: 2 });

                // Tampilkan total diskon dalam label
                $('#total_diskon_label').text(`Rp ${formattedTotalDiskon}`);

                // Masukkan total diskon ke dalam input hidden untuk dikirimkan melalui form
                $('#total_diskon').val(totalDiskon); // Gunakan nilai asli (bukan yang terformat)
            }

            // Fungsi untuk menghitung dan memperbarui PPN
            function updatePPN() {
                let ppn = $('#ppnpajak').val().trim(); // Ambil nilai PPN dari input

                let ppnDecimal = 0;  // Default nilai PPN adalah 0
                if (ppn.includes('%')) {
                    ppnDecimal = parseFloat(ppn.replace('%', '').trim()) / 100; // Jika PPN dalam format persentase
                } else {
                    ppnDecimal = parseFloat(ppn.trim()); // Jika PPN dalam format desimal
                }

                // Ambil subtotal yang telah dihitung
                let subTotal = parseFloat($('#sub_total').val());

                // Cek jika subTotal kosong atau tidak valid
                if (isNaN(subTotal) || subTotal <= 0) {
                    $('#ppn_bawah_label').text('');
                    $('#ppn_total').val('');
                    return;  // Keluar dari fungsi jika subTotal tidak valid
                }

                // Hitung PPN
                let ppnAmount = subTotal * ppnDecimal;

                // Format PPN ke dalam format IDR
                let formattedPpnAmount = ppnAmount.toLocaleString('id-ID', { minimumFractionDigits: 2 });

                // Tampilkan PPN yang sudah dihitung di label
                $('#ppn_bawah_label').text(`Rp ${formattedPpnAmount}`);

                // Masukkan nilai PPN dalam format desimal ke dalam input tersembunyi
                $('#ppn_total').val(ppnAmount);

                // Panggil updateTotalHarga setelah PPN dihitung
                updateTotalHarga();
            }

            // Fungsi untuk menghitung dan memperbarui Total Harga
            function updateTotalHarga() {
                // Ambil nilai dari input subtotal, ppn, dan materai
                let subTotal = parseFloat($('#sub_total').val());
                let ppnAmount = parseFloat($('#ppn_total').val());
                let materai = parseInt($('#materai').val());  // Materai yang dipilih

                // Cek jika subTotal atau ppnAmount tidak valid
                if (isNaN(subTotal) || isNaN(ppnAmount)) {
                    $('#total_harga_label').text('Rp 0');
                    $('#harga_total').val('0');
                    return;
                }

                // Hitung total harga (subtotal + ppn + materai)
                let totalHarga = subTotal + ppnAmount + materai;

                // Format total harga ke dalam format Indonesia (IDR)
                let formattedTotalHarga = totalHarga.toLocaleString('id-ID', { minimumFractionDigits: 2 });

                // Tampilkan total harga dalam label
                $('#total_harga_label').text(`Rp ${formattedTotalHarga}`);

                // Masukkan total harga ke dalam input hidden
                $('#harga_total').val(totalHarga);

                // Log untuk verifikasi
                console.log('Total Harga:', totalHarga);
            }

            function applyKoreksi() {
                // Ambil nilai dari input subtotal, ppn, materai, dan koreksi
                let subTotal = parseFloat($('#sub_total').val());
                let ppnAmount = parseFloat($('#ppn_total').val());
                let materai = parseInt($('#materai').val());  // Materai yang dipilih
                let koreksi = parseInt($('#koreksi').val()) || 0;  // Pastikan koreksi valid (default 0 jika tidak valid)

                // Cek jika subTotal atau ppnAmount tidak valid
                if (isNaN(subTotal) || isNaN(ppnAmount) || isNaN(materai)) {
                    $('#total_harga_label').text('Rp 0');
                    $('#harga_total').val('0');
                    return;
                }

                // Hitung total harga (subtotal + ppn + materai + koreksi)
                let totalHarga = subTotal + ppnAmount + materai + koreksi;

                // Format total harga ke dalam format Indonesia (IDR)
                let formattedTotalHarga = totalHarga.toLocaleString('id-ID', { minimumFractionDigits: 2 });

                // Tampilkan total harga dalam label
                $('#total_harga_label').text(`Rp ${formattedTotalHarga}`);

                // Masukkan total harga ke dalam input hidden
                $('#harga_total').val(totalHarga);

                // Log untuk verifikasi
                console.log('Total Harga:', totalHarga);
            }

            // Event listener untuk input PPN
            $('#ppnpajak').on('input', function() {
                // Setiap kali PPN diubah, update PPN dan total harga
                updatePPN();
            });

            // Event listener untuk pemilihan materai
            $('#materai').on('change', function() {
                // Setiap kali materai berubah, update total harga
                updateTotalHarga();
            });

            // Event listener untuk input koreksi
            $('#koreksi').on('input', function() {
                // Setiap kali koreksi diubah, update total harga dengan koreksi
                applyKoreksi();
            });

            // Event listener untuk menambahkan barang
            $('#simpanData').click(function() {
                let namaBarang = $('#namabarang option:selected').text().trim();
                let kodeBarang = $('#namabarang option:selected').data('kode');
                let Qty = $('#jumlahSatuanKecil').val();
                let Harga = $('#hargaSatuanKecil').val();
                let Exp = $('#date-ranges').val();
                let Diskon = $('#diskon').val();
                let KodeBatch = $('#batchNo').val();
                let noFaktur = $('#no_faktur').val();
                let Supplier = $('#supplierSelect').val() ? $('#supplierSelect').val() : $('#supplierInput').val();
                let noPoSp = $('#no_po_sp').val();
                let noFakturSup = $('#no_faktur_suplier').val();
                let tglTerima = $('#tgl_terima').val();
                let tglFaktur = $('#tgl_faktur').val();
                let tglJatuhTempoo = $('#date-range-view').val();
                let ppn = $('#ppnpajak').val();

                let namaBarangUpdate = namaBarang.replace(/\s*-\s*\(.*?\)$/, '');

                // Validasi jika Qty dan harga valid
                if (isNaN(Qty) || Qty === "") {
                    return; // Keluar jika Qty tidak valid
                }

                // Clean Harga, Diskon dan hitung total
                let cleanedHarga = Harga.replace(/[^\d,.-]/g, '').replace('.', '').replace(',', '.');
                cleanedHarga = parseFloat(cleanedHarga);

                let cleanedDiskon;
                if (Diskon.includes('%')) {
                    cleanedDiskon = parseFloat(Diskon.replace('%', '').trim()) / 100;
                } else {
                    cleanedDiskon = parseFloat(Diskon.replace(/[^\d,-]/g, '').replace(',', '.').trim());
                }

                let totalBeforeDiscount = cleanedHarga * Qty;
                let total;

                if (Diskon.includes('%')) {
                    // Apply percentage discount
                    total = totalBeforeDiscount * (1 - cleanedDiskon);
                } else {
                    // Apply direct amount discount (just subtract it)
                    total = totalBeforeDiscount - cleanedDiskon;
                }

                let diskonItem = totalBeforeDiscount - total;

                let diskonSatuan;

                if (Diskon.includes('%')) {
                    // Apply percentage discount
                    diskonSatuan = cleanedHarga * cleanedDiskon;
                } else {
                    // Apply direct amount discount (just subtract it)
                    diskonSatuan = cleanedDiskon;
                }

                // Check if total is a valid number
                if (isNaN(total)) {
                    return; // Exit if total is invalid
                }

                 // Hitung PPN (misalnya 10%)
                let ppnAmount = cleanedHarga * (parseFloat(ppn) / 100); // PPN dihitung dari total setelah diskon

                // Format total dengan pemisah ribuan
                let formattedTotal = total.toLocaleString('id-ID');
                let formattedPpn = ppnAmount.toLocaleString('id-ID');
                let formattedDiskon = diskonSatuan.toLocaleString('id-ID');

                // let hargaSatuanKotor = cleanedHarga - diskonSatuan + ppnAmount;
                // Ambil elemen dropdown
                const hjSelect = document.getElementById('hj');
                // Ambil nilai yang dipilih
                const hj = hjSelect.value;

                // Tentukan hargaSatuanKotor berdasarkan pilihan dropdown
                let hargaSatuanKotor;

                if (hj === '1') {
                    hargaSatuanKotor = cleanedHarga;
                } else if (hj === '2') {
                    hargaSatuanKotor = cleanedHarga + ppnAmount;
                } else if (hj === '3') {
                    hargaSatuanKotor = cleanedHarga - diskonSatuan;
                } else if (hj === '4') {
                    hargaSatuanKotor = (cleanedHarga - diskonSatuan) + ppnAmount;
                } else {
                    console.error('Nilai dropdown hj tidak valid:', hj);
                }

                // Format harga ke dalam format mata uang IDR
                let formattedHargaSatuan = `Rp ${hargaSatuanKotor.toLocaleString('id-ID')}`;



                let newData = {
                    namaBarang: namaBarangUpdate,
                    kodeBarang: kodeBarang,
                    qty: Qty,
                    harga: `Rp ${cleanedHarga.toLocaleString('id-ID')}`,
                    exp: Exp,
                    diskon: cleanedDiskon > 0 ? `${(cleanedDiskon * 100)} %` : '0 %',
                    kodeBatch: KodeBatch,
                    total: formattedTotal,
                    hargaSatuan: hargaSatuanKotor,
                    diskonBarang: formattedDiskon,
                    ppn: formattedPpn, // PPN per barang
                    ppnAwal: ppn,
                    seluruhDiskon: diskonItem,
                    subTotalItem: totalBeforeDiscount,
                };

                console.log(newData);

                    // Ambil jumlah baris yang sudah ada di tabel
                    let rowCount = $('#kunjungan-table tbody tr').length;

                    // Tambahkan nomor urut dan data ke dalam baris baru
                    rowCount++; // Increment nomor urut

                    tableData.push(newData);
                    $('#tableData').val(JSON.stringify(tableData)); // Update hidden input

                    // Tambahkan baris ke tabel
                    $('#kunjungan-table tbody').append(`
                        <tr onclick="selectRow(this)">
                            <td class="text-center">${rowCount}</td> <!-- Nomor urut -->
                            <td class="text-center">${namaBarang}</td>
                            <td class="text-center">${kodeBarang}</td>
                            <td class="text-center">${Qty}</td>
                            <td class="text-center">${Harga}</td>
                            <td class="text-center">${Exp}</td>
                            <td class="text-center">${Diskon}</td>
                            <td class="text-center">${KodeBatch}</td>
                            <td class="text-center">${totalBeforeDiscount}</td>
                        </tr>
                    `);

                // Update subtotal setelah data ditambahkan
                updateSubTotal();

                // Reset form fields setelah menambah data
                $('#namabarang').val('');
                $('#jumlahSatuanKecil').val('');
                $('#hargaSatuanKecil').val('');
                $('#jumlahSatuanBesar').val('');
                $('#hargaSatuanBesar').val('');
                $('#date-ranges').val('');
                $('#diskon').val('');
                $('#batchNo').val('');
            });
        });
    </script>


    {{-- SUPAYA BISA DI CLICK DAN HAPUS DATA DI TABEL NYA --}}
    <script>
       // Fungsi untuk menangani klik pada baris tabel
        function selectRow(row) {
            // Memeriksa apakah baris sudah dipilih
            if (row.classList.contains('selected')) {
                // Jika baris sudah dipilih, hapus kelas 'selected' (untuk meng-unselect)
                row.classList.remove('selected');
            } else {
                // Jika baris belum dipilih, tambahkan kelas 'selected'
                row.classList.add('selected');
            }

            // Opsional: Bisa menampilkan data baris yang dipilih atau melakukan tindakan lainnya
            let cells = row.querySelectorAll('td');
            let data = [];
            cells.forEach(function(cell) {
                data.push(cell.textContent); // Menyimpan data dari setiap kolom dalam baris
            });
            console.log('Data baris yang dipilih:', data); // Menampilkan data ke konsol (bisa digunakan untuk tujuan lain)
        }
        // Fungsi untuk menghapus baris yang dipilih
        document.getElementById('hapusData').addEventListener('click', function() {
            // Mendapatkan baris yang dipilih
            let selectedRow = document.querySelector('tr.selected');

            // Jika ada baris yang dipilih
            if (selectedRow) {
                // Menghapus baris tersebut dari tabel
                selectedRow.remove();
                console.log('Baris telah dihapus.');
            } else {
                alert('Pilih baris yang ingin dihapus terlebih dahulu!');
            }
        });
    </script>

    <!-- JavaScript for updating fields -->
    <script>
        function updateFields() {
            // Get the selected option
            const selectedOption = document.getElementById("namabarang").selectedOptions[0];

            // Retrieve the data attributes from the selected option
            const satuanKecil = selectedOption.getAttribute("data-satuan_kecil");
            const hargaDasar = selectedOption.getAttribute("data-harga");
            const satuanBesar = selectedOption.getAttribute("data-satuan_sedang");

            // Update the spans with the selected data
            document.getElementById("satuanKecilSpan").textContent = satuanKecil || "Kems kecil";
            document.getElementById("hargaSatuanSpan").textContent = hargaDasar ? `[Rp ${hargaDasar}]` : "[Rp - ]";
            document.getElementById("satuanBesarSpan").textContent = satuanBesar || "Kems besar";
            }
    </script>

    {{-- SCRIPT SATUAN KECIL DAN BESAR --}}
    <script>
        $(document).ready(function() {
            // Inisialisasi input mask untuk harga satuan besar dan kecil
            $('#hargaSatuanBesar').inputmask({
                alias: 'numeric',
                groupSeparator: '.',
                autoGroup: true,
                digits: 0,
                digitsOptional: false,
                prefix: 'Rp ', // Prefix mata uang
                rightAlign: false,
                removeMaskOnSubmit: true
            });

            $('#hargaSatuanKecil').inputmask({
                alias: 'numeric',
                groupSeparator: '.',
                autoGroup: true,
                digits: 0,
                digitsOptional: false,
                prefix: 'Rp ', // Prefix mata uang
                rightAlign: false,
                removeMaskOnSubmit: true
            });
        });

        // Fungsi untuk menghitung jumlah satuan kecil dari satuan besar
        function calculateJumlahSatuanKecil() {
            // Ambil nilai dari input Jumlah Satuan Besar
            let jumlahSatuanBesar = $('#jumlahSatuanBesar').inputmask('unmaskedvalue'); // Ambil nilai tanpa mask
            console.log("jumlahSatuanBesar (unmasked): ", jumlahSatuanBesar);

            // Ambil nilai data-satuan dari elemen yang dipilih di dropdown
            const selectedOption = document.getElementById("namabarang").selectedOptions[0];
            const satuanSedang = selectedOption.getAttribute("data-satuan");
            console.log("Satuan Sedang (data-satuan): ", satuanSedang);

            // Pastikan satuanSedang bisa dikonversi menjadi angka dan jumlahSatuanBesar juga
            let parsedValue = parseFloat(jumlahSatuanBesar); // Ubah ke angka
            let parsedSatuanSedang = parseFloat(satuanSedang); // Ubah satuanSedang menjadi angka

            // Periksa jika nilai valid (bukan NaN)
            if (!isNaN(parsedValue) && !isNaN(parsedSatuanSedang)) {
                let jumlahSatuanKecil = parsedValue * parsedSatuanSedang; // Kalikan jumlah satuan besar dengan satuan sedang
                $('#jumlahSatuanKecil').val(jumlahSatuanKecil); // Set ke input jumlah satuan kecil
            } else {
                $('#jumlahSatuanKecil').val(''); // Jika nilai tidak valid, kosongkan input jumlah satuan kecil
            }
        }

        // Fungsi untuk menghitung harga satuan kecil berdasarkan harga satuan besar dan satuan sedang
        function calculateJumlahHargaKecil() {
            let hargaSatuanBesar = $('#hargaSatuanBesar').inputmask('unmaskedvalue'); // Ambil harga satuan besar tanpa mask
            console.log("hargaSatuanBesar (unmasked): ", hargaSatuanBesar);

            let parsedHarga = parseFloat(hargaSatuanBesar); // Ubah harga menjadi angka
            if (!isNaN(parsedHarga)) {
                // Ambil nilai satuan sedang dari dropdown
                let satuanSedang = $('#jumlahSatuanKecil').inputmask('unmaskedvalue'); // Ambil harga satuan besar tanpa mask
                console.log("Satuan Sedang: ", satuanSedang);

                // Perhitungan harga satuan kecil, berdasarkan satuan sedang
                let hargaSatuanKecil = parsedHarga / parseFloat(satuanSedang); // Dibagi dengan satuan sedang yang dipilih
                $('#hargaSatuanKecil').val(hargaSatuanKecil); // Set ke input harga satuan kecil
            } else {
                $('#hargaSatuanKecil').val(''); // Jika harga tidak valid, kosongkan input harga satuan kecil
            }
        }

        // Fungsi untuk mengupdate satuan sedang saat memilih barang
        function updateSatuanSedang() {
            // Ambil nilai satuan sedang dari pilihan dropdown
            let satuanSedang = $('#namabarang option:selected').data('satuan');
            console.log("Satuan Sedang yang dipilih: ", satuanSedang);

            // Optional: Bisa menampilkan satuan sedang di elemen tertentu jika diperlukan
            // $('#someElement').text(satuanSedang);
        }


    </script>

    <script>
        $(function () {
            // Fungsi untuk menampilkan datepicker Bulan & Tahun
            $('#select-month-year').on('click', function () {
                $('#date-picker-button').html('<i class="far fa-calendar-alt"></i> Bulan & Tahun'); // Ubah teks tombol
                $('#date-ranges').prop('readonly', false); // Hapus readonly saat opsi dipilih
                $('#date-ranges').datetimepicker('destroy'); // Hapus datepicker sebelumnya
                $('#date-ranges').datetimepicker({
                    viewMode: 'years',   // Set viewMode to 'years' for month & year selection
                    format: 'MM/YYYY'    // Format for Month/Year
                });
            });

            // Fungsi untuk menampilkan datepicker Tanggal
            $('#select-date').on('click', function () {
                $('#date-picker-button').html('<i class="far fa-calendar-alt"></i> Tanggal'); // Ubah teks tombol
                $('#date-ranges').prop('readonly', false); // Hapus readonly saat opsi dipilih
                $('#date-ranges').datetimepicker('destroy'); // Hapus datepicker sebelumnya
                $('#date-ranges').datetimepicker({
                    format: 'L'  // Format for date selection
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // Inisialisasi daterangepicker
            $('#daterange-btn').daterangepicker(
                {
                    ranges   : {
                        'Today'       : [moment(), moment()],
                        'Tomorrow'    : [moment(), moment().add(1, 'days')],
                        'Next 7 Days' : [moment(), moment().add(6, 'days')],
                        'Next 30 Days': [moment(), moment().add(29, 'days')],
                        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                        'Next Month'  : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')]

                    },
                    // startDate: moment().subtract(29, 'days'),
                    // endDate  : moment()
                    startDate: moment(), // Set awal ke "Today"
                    endDate  : moment()   // Set akhir ke "Today"
                },
                function (start, end) {
                    // Format dan tampilkan tanggal di input `#date-range-view`
                    $('#date-range-view').val(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
                }
            );

            // Set nilai awal untuk date-range-view saat halaman dimuat
            $('#date-range-view').val(
                moment().format('D MMMM, YYYY') + ' - ' + moment().format('D MMMM, YYYY')
            );
        });
    </script>

    <script>
        function toggleKemasanInput() {
            const isChecked = $('#toggleKemasan').is(':checked');
            const kemasanKecilGroup = $('#kemasanKecilGroup');
            const kemasanBesarGroup = $('#kemasanBesarGroup');
            const kemasanLabel = $('#kemasanLabel');

            if (isChecked) {
                kemasanKecilGroup.hide();
                kemasanBesarGroup.show();
                kemasanLabel.text("Kemasan Besar"); // Ubah label ke "Kemasan Besar"
            } else {
                kemasanKecilGroup.show();
                kemasanBesarGroup.hide();
                kemasanLabel.text("Kemasan Kecil"); // Ubah label ke "Kemasan Kecil"
            }
        }
    </script>

    <script>
        function toggleSupplierInput() {
                const isChecked = document.getElementById("supplierCheck").checked;
                const supplierSelect = $('#supplierSelect');
                const supplierInput = document.getElementById("supplierInput");

                if (isChecked) {
                    // Destroy Select2 and hide original select
                    supplierSelect.select2('destroy').hide();
                    supplierInput.style.display = "block";

                } else {
                    // Show original select and reinitialize Select2
                    supplierInput.value = ""; // Clear the input value
                    supplierInput.style.display = "none";

                    supplierSelect.show().each(function() {
                        $(this).select2({
                        theme: "bootstrap4",
                        dropdownParent: $(this).parent(), // fix select2 search input focus bug
                        })
                    })
                }
            }
    </script>

    <script>
        $(document).ready(function(){
            // Inisialisasi Inputmask untuk persentase
            $('#ppnpajak').inputmask({
                alias: 'percentage',
                suffix: '%',
                rightAlign: false,
                min: 0,
                max: 100
            });
        });
    </script>

    <script>
        // Function to toggle the format between currency and percentage
        function toggleFormat() {
            const isChecked = document.getElementById("formatToggle").checked;
            const inputField = $('#diskon'); // Get the input field by id

            // Clear the input field value initially
            inputField.val('');

            // Apply different input masks based on checkbox state
            if (isChecked) {
                // Apply currency format (Rp format)
                inputField.inputmask({
                    alias: 'numeric',
                    groupSeparator: '.',
                    autoGroup: true,
                    digits: 0,
                    digitsOptional: false,
                    prefix: 'Rp ', // Currency prefix
                    rightAlign: false,
                    removeMaskOnSubmit: true
                });
            } else {
                // Apply percentage format
                inputField.inputmask({
                    alias: 'numeric',
                    suffix: ' %', // Percentage suffix
                    groupSeparator: '',
                    digits: 2,
                    digitsOptional: true,
                    rightAlign: false,
                    removeMaskOnSubmit: true
                });
            }
        }

        // Ensure the input field is initially cleared when the page loads (if necessary)
        $(document).ready(function () {
            const inputField = $('#diskon');
            inputField.inputmask({
                    alias: 'numeric',
                    suffix: ' %', // Percentage suffix
                    groupSeparator: '',
                    digits: 2,
                    digitsOptional: true,
                    rightAlign: false,
                    removeMaskOnSubmit: true
                });
            inputField.val(''); // Clear the field initially
        });
    </script>

    <script>
        function generateNomorfaktur() {
            // Get the current date in YYYYMMDD format
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const dateString = `${year}${month}${day}`;

            // Generate a random 4-digit number
            const randomFourDigit = Math.floor(1000 + Math.random() * 9000);

            // Combine into the final format
            const invoiceNumber = `INV-${dateString}-${randomFourDigit}`;

            // Set the generated invoice number in the input field
            document.getElementById("no_faktur").value = invoiceNumber;
        }
    </script>

    <script>
        window.onload = function() {
            // Mengambil tanggal dan waktu saat ini
            var now = new Date();

            // Mengatur nilai input tanggal (YYYY-MM-DD)
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear() + "-" + month + "-" + day;
            document.getElementById("tgl_terima").value = today;

            // Add an event listener to the checkbox
            document.getElementById("toggle-edit-date").addEventListener("change", function() {
                var dateInput = document.getElementById("tgl_terima");
                if (this.checked) {
                    // Remove the readonly attribute if the checkbox is checked
                    dateInput.removeAttribute("readonly");
                } else {
                    // Add the readonly attribute if the checkbox is unchecked
                    dateInput.setAttribute("readonly", true);
                }
            });
        };
    </script>

    <script>
        // Fungsi untuk mengontrol status kolom No. PO atau SP
        function togglePOField() {
            const checkbox = document.getElementById("faktur_konsinyasi");
            const poField = document.getElementById("no_po_sp");

            // Jika checkbox dicentang, isi kolom dengan teks dan buat readonly
            if (checkbox.checked) {
                poField.value = "KONSINYASI";  // Isi kolom
                poField.readOnly = true;             // Tidak bisa diubah
            } else {
                poField.value = "";                  // Kosongkan kolom
                poField.readOnly = false;            // Bisa diubah manual
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            // Saat tombol "Generate" ditekan
            $('#generateKodeButton').click(function() {
                // Panggil route dengan AJAX
                $.ajax({
                    url: '{{ route('generate.kode.barang') }}',
                    type: 'GET',
                    success: function(response) {
                        // Set nilai input kode barang dengan data dari response
                        $('#kode_barang').val(response.kode_barang);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            // Ketika user mengetikkan angka di input Harga Dasar
            $('#harga_dasar').on('input', function() {
                var hargaDasar = $(this).val(); // Mengambil nilai dari input Harga Dasar

                // Mengisi input Harga Beli dengan nilai yang sama
                $('#harga_beli').val(hargaDasar);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Summernote
            $('#template').summernote()

            $("#janjitbl").DataTable({
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


@endsection
