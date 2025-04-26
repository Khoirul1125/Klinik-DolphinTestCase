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
                                <div class="col-md-12">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0 card-title">Transaksi Apotek / Farmasi</h5>
                                        <div class="text-right card-tools">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#adddoctor">
                                                <i class="fas fa-plus"></i> Cari Pasien
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row"> <!-- Tambahkan row di sini -->
                                                        <div class="col-md-6">
                                                            <!-- Form Input -->
                                                            <div class="form-group row d-flex align-items-center">
                                                                <label class="col-md-2 col-form-label">No. Reg</label>
                                                                <div class="col-md-1 text-center">:</div>
                                                                <div class="col-md-3">
                                                                    <input type="text" class="form-control" id="no_reg" name="no_reg">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row d-flex align-items-center">
                                                                <label class="col-md-2 col-form-label">No. RM</label>
                                                                <div class="col-md-1 text-center">:</div>
                                                                <div class="col-md-3">
                                                                    <input type="text" class="form-control" id="no_rm" name="no_rm">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <button type="button" class="btn btn-info" style="width: 100px" >Panggil</button>
                                                                    <button type="button" class="btn btn-info" style="width: 100px" id="generateButton">Auto</button>
                                                                    <span>*opsi Auto untuk penjualan obat langsung
                                                                </div>
                                                            </div>
                                                            <div class="form-group row d-flex align-items-center">
                                                                <label class="col-md-2 col-form-label">Nama</label>
                                                                <div class="col-md-1 text-center">:</div>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" id="nama" name="nama">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row d-flex align-items-center">
                                                                <label class="col-md-2 col-form-label">Alamat</label>
                                                                <div class="col-md-1 text-center">:</div>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" id="alamat" name="alamat">
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        {{-- <div class="col-md-6">
                                                            <!-- Form Input -->
                                                            <div class="form-group row d-flex align-items-center">
                                                                <div class="col-md-3">

                                                                </div>
                                                                <div class="col-md-3 d-flex align-items-center">
                                                                    <input type="checkbox" id="abnormal_ekstremitas_bawah" name="abnormal_ekstremitas_bawah" style="margin-right: 5px;">
                                                                    <label for="abnormal_ekstremitas_bawah" class="mb-0">Koreksi Invoice :</label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <input type="text" class="form-control" id="kode_ihs" name="kode_ihs">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <button type="button" class="btn btn-info" style="width: 100%">Koreksi</button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row d-flex align-items-center">
                                                                <div class="col-md-3">

                                                                </div>
                                                                <div class="col-md-3 d-flex align-items-center">
                                                                    <input type="checkbox" id="abnormal_ekstremitas_bawah" name="abnormal_ekstremitas_bawah" style="margin-right: 5px;">
                                                                    <label for="abnormal_ekstremitas_bawah" class="mb-0">Transaksi Mundur :</label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <input type="date" class="form-control" id="kode_ihs" name="kode_ihs">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="input-group date" id="timepicker" data-target-input="nearest">
                                                                        <input type="text" class="form-control timepicker-input" data-target="#timepicker" id="time" name="time">
                                                                        <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                                                            <div class="input-group-text">
                                                                                <i class="far fa-clock"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-md-6">
                                                            <!-- Form Input Kiri -->
                                                            <div class="form-group row d-flex align-items-center">
                                                                <label class="col-md-2 col-form-label">Resep</label>
                                                                <div class="col-md-1 text-center">:</div>
                                                                <div class="col-md-3">
                                                                    <select class="form-control select2bs4" style="width: 100%;" id="cara_resep" name="cara_resep">
                                                                        <option value="" disabled selected>-- Pilih --</option>
                                                                        <option value="Resep">RESEP</option>
                                                                        <option value="Beli_Bebas">BELI BEBAS</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control" id="resep_kode" name="resep_kode">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row d-flex align-items-center">
                                                                <label class="col-md-2 col-form-label">Rawat</label>
                                                                <div class="col-md-1 text-center">:</div>
                                                                <div class="col-md-3">
                                                                    <input type="text" class="form-control" value="RAWAT JALAN" id="rawat" name="rawat" readonly>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <select class="form-control select2bs4 mt-2" style="width: 100%;" id="nama_poli" name="nama_poli">
                                                                        <option value=" " disabled selected> -- Pilih Poli -- </option>
                                                                        <option value="APS">- APS -</option>
                                                                        @foreach ($poli as $data)
                                                                            <option value="{{$data->nama_poli}}"> {{$data->nama_poli}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row d-flex align-items-center">
                                                                <label class="col-md-2 col-form-label text-right">Dokter</label>
                                                                <div class="col-md-10">
                                                                    <div class="d-flex align-items-center">
                                                                        <!-- Checkbox -->
                                                                        <input type="checkbox" id="check_dokter" name="check_dokter" style="margin-right: 10px;">

                                                                        <!-- Input text (hidden by default) -->
                                                                        <input type="text" class="form-control" id="input_dokter" name="input_dokter" placeholder="Masukkan Nama Dokter" style="display: none;">

                                                                        <!-- Select dropdown (visible by default) -->
                                                                        <select class="form-control select2bs4 mt-2" style="width: 100%;" id="select_dokter" name="select_dokter">
                                                                            <option value=" " disabled selected> -- Pilih Dokter -- </option>
                                                                            @foreach ($doctor as $data)
                                                                                <option value="{{ $data->nama_dokter }}">{{ $data->nama_dokter }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <!-- Kolom Kanan -->
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <label class="col-md-4 col-form-label text-right">Jenis PX</label> <!-- Label -->
                                                                        <div class="col-md-8">
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="jenis_px" name="jenis_px">
                                                                                <option value="" disabled selected>-- Pilih --</option>
                                                                                <option value="UMUM">UMUM</option>
                                                                                <option value="ASURANSI">ASURANSI</option>
                                                                                <option value="BPJS">BPJS</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Kolom Kiri -->
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <label class="col-md-4 col-form-label text-right">Penjamin</label> <!-- Label -->
                                                                        <div class="col-md-8">
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="penjamin" name="penjamin">
                                                                                <option value="" disabled selected>-- Pilih --</option>
                                                                                @foreach ($penjab as $data)
                                                                                    <option value="{{ $data->kode }}">{{ $data->nama }}</option>
                                                                                @endforeach
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
                                    </div>
                                </div>
                                <div class="row"> <!-- Tambahkan row di sini -->
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
                                                                #isi-table {
                                                                    width: 100%;
                                                                    border-collapse: collapse; /* Menggabungkan border tabel dalam */
                                                                    border: none; /* Menghilangkan border */
                                                                }

                                                                /* Menghilangkan border pada tabel dalam dan memberikan padding */
                                                                #isi-table td, #isi-table th {
                                                                    border: none; /* Menghilangkan border */
                                                                    padding: 10px; /* Memberikan ruang di dalam sel tabel dalam */
                                                                    font-size: 16px; /* Ukuran font */
                                                                }

                                                                /* Gaya untuk tabel dalam */
                                                                #obat-table {
                                                                    width: 100%;
                                                                    border-collapse: collapse; /* Menggabungkan border tabel dalam */
                                                                    border: none; /* Menghilangkan border */
                                                                }

                                                                /* Menghilangkan border pada tabel dalam dan memberikan padding */
                                                                #obat-table td, #obat-table th {
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
                                                                .selected-row {
                                                                    background-color: #007bff; /* Menambahkan warna biru pada baris yang dipilih */
                                                                    color: white; /* Menyesuaikan warna teks dengan latar belakang */
                                                                }
                                                            </style>

                                                            {{-- <!-- Hidden inputs for the table data -->
                                                            <input type="hidden" id="tableData" name="tableData" value="[]"> --}}

                                                            <table class="outer-table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <!-- Tabel dalam dengan data -->
                                                                            <table id="isi-table" class="table table-bordered">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th class="text-center">No</th>
                                                                                        <th class="text-center">Nama Item</th>
                                                                                        <th class="text-center">Kode Item</th>
                                                                                        <th class="text-center">Harga</th>
                                                                                        <th class="text-center">Diskon</th>
                                                                                        <th class="text-center">Kuantitas</th>
                                                                                        <th class="text-center">Jumlah</th>
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
                                                    <div class="col-md-8">
                                                        <div class="form-group row d-flex align-items-center mb-2">
                                                            <div class="col-md-1">
                                                                <button type="button" class="btn btn-info">R/</button>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label>Barang :</label>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <select class="form-control select2bs4 mt-2" style="width: 100%;" id="bebas_barang" name="bebas_barang">
                                                                    <option value="" disabled selected> -- Pilih Obat -- </option>
                                                                    @foreach ($stok as $data)
                                                                        <option value="{{$data->kode_barang}}"> {{$data->nama_barang}} ({{$data->dabar->industri}})</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center mb-2">
                                                            <div class="col-md-1 text-center">
                                                                {{-- <button type="button" class="btn btn-info">R/</button> --}}
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label>Qty :</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control" id="qty_bebas" name="qty_bebas">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center mb-2">
                                                            <div class="col-md-1 text-center">
                                                                {{-- <button type="button" class="btn btn-info">R/</button> --}}
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label>Diskon :</label>
                                                            </div>
                                                            <div class="col-md-4" style="display: flex; align-items: center; gap: 10px;">
                                                                <input type="checkbox" id="formatToggle" onclick="toggleFormat()">
                                                                <input type="text" class="form-control" id="bebas_disc" name="bebas_disc" value="0">
                                                            </div>
                                                            <div class="col-md-5" style="display: flex; align-items: center; gap: 10px;">
                                                                <span> (button mengubah disc rupiah)</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center mb-2">
                                                            <div class="col-md-3 text-center">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center mb-2">
                                                            <div class="col-md-1 text-center">
                                                                {{-- <button type="button" class="btn btn-info">R/</button> --}}
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label>Harga :</label>
                                                            </div>
                                                            <div class="col-md-4" style="padding-right: 10px;">
                                                                <select class="form-control select2bs4 mt-2" style="width: 100%;" id="pil_harga" name="pil_harga">
                                                                    <option value="" disabled selected>-- Pilih --</option>
                                                                    <option value="harga_1">Harga 1</option>
                                                                    <option value="harga_2">Harga 2</option>
                                                                    <option value="harga_3">Harga 3</option>
                                                                    <option value="harga_4">Harga 4</option>
                                                                    <option value="harga_5">Harga 5</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3" style="padding-left: 0; display: flex; align-items: center;">
                                                                <input type="text" class="form-control" id="harga_bebas" name="harga_bebas" style="margin-left: 10px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center mb-2">
                                                            <div class="col-md-1 text-center">
                                                                {{-- <button type="button" class="btn btn-info">R/</button> --}}
                                                            </div>
                                                            <div class="col-md-2">

                                                            </div>
                                                            <div class="col-md-6 d-flex">
                                                                <button type="button" class="btn btn-info" style="width: 50%; margin-right: 5px;" id="btnTambahBebas">Tambah</button>
                                                                <button type="button" class="btn btn-info" style="width: 50%;" id="btnDeleteSelected">Hapus</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="form-group row d-flex align-items-center mb-2">
                                                        <div class="col-md-1 text-center">

                                                        </div>
                                                        <div class="col-md-2">
                                                            <label>Remark  :</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" id="kode_ihs" name="kode_ihs">
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-4">
                                                        <div class="form-group row d-flex align-items-center mb-2">
                                                            <div class="col-md-3">
                                                                <label>Barang :</label>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" id="embis" name="embis">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label>(Poin)</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center mb-2">
                                                            <div class="col-md-12">
                                                                <label class="h6" style="color: #800080;">[+Embis Rp.<label id="embisResult">0</label>]</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center mb-2">
                                                            <div class="col-md-4">
                                                                <label class="h6">Sub Total :</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                {{-- <label class="h6" id="sub_total" name="sub_total">Testing</label> --}}
                                                                <label class="h6" id="sub_total_label"></label>

                                                                <!-- Input tersembunyi untuk mengirimkan nilai -->
                                                                <input type="hidden" id="sub_total" name="sub_total">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <hr style="background-color: #000; margin: 0;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center mb-2">
                                                            <div class="col-md-3">
                                                                <label class="h6">Total :</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <label class="h6" id="total_label"></label>

                                                                <!-- Input tersembunyi untuk mengirimkan nilai -->
                                                                <input type="hidden" id="total" name="total">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center justify-content-end" style="margin-top: auto;">
                                                            <div class="col-md-12">
                                                                <button type="submit" class="btn btn-info" style="width: 92px; margin-right: 2px;" id="saveButton" name="saveButton">Simpan</button>
                                                                <button type="button" class="btn btn-info" style="width: 92px;" id="reloadButton">Reload</button>
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
                                                        <div class="form-group">
                                                            <table class="outer-table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <table id="obat-table" class="table table-bordered">
                                                                                <tbody>

                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center justify-content-between">
                                                            <div class="col-md-6 d-flex align-items-center" style="gap: 10px; flex-wrap: nowrap;">
                                                                <label for="id_R" class="mb-0">No R:</label>
                                                                <input type="text" class="form-control" id="id_R" name="id_R" style="flex: 1;">
                                                            </div>
                                                            <div class="col-md-6 d-flex align-items-center" style="gap: 10px; flex-wrap: nowrap;">
                                                                <label for="jumlah_R" class="mb-0">Jumlah:</label>
                                                                <input type="text" class="form-control" id="jumlah_R" name="jumlah_R" style="flex: 1;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center justify-content-between">
                                                            <div class="col-md-12 d-flex align-items-center" style="gap: 10px; flex-wrap: nowrap;">
                                                                <label for="notes" class="mb-0">Note:</label>
                                                                <input type="text" class="form-control" id="notes" name="notes" style="flex: 1;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center">
                                                            <div class="col-md-12 d-flex align-items-center gap-3">
                                                                <div class="ml-auto">
                                                                    <p> </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center">
                                                            <div class="col-md-12 d-flex align-items-center gap-3">
                                                                <div class="ml-auto">
                                                                    <p> </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center">
                                                            <div class="col-md-12 d-flex align-items-center gap-3">
                                                                <div class="ml-auto">
                                                                    <p> </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-flex align-items-center justify-content-between">
                                                            <div class="col-md-4 text-left">
                                                                <button type="button" class="btn btn-info" id="loadRButton">
                                                                    <i class="fas fa-pills"></i> Load Per R/
                                                                </button>
                                                            </div>
                                                            <div class="col-md-4 text-center">
                                                                <button type="button" class="btn btn-info" id="loadFullButton">
                                                                    <i class="fas fa-pills"></i> Load R/ Full
                                                                </button>
                                                            </div>
                                                            <div class="col-md-4 text-right">
                                                                <button id="download-pdf" class="btn btn-danger">
                                                                    <i class="fas fa-file-pdf"></i> Download
                                                                </button>
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
                    </div>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <div class="modal fade" id="adddoctor" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Pilih Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="kunjungan-table" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th class="text-center">Poli/Kamar</th>
                                <th class="text-center">No. RM</th>
                                <th class="text-center">No. Rawat</th>
                                <th class="text-center">Nama Pasien</th>
                                <th class="text-center">Tgl. Lahir</th>
                                <th class="text-center">Dokter</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Perawatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rawatjalan as $data)
                                <tr data-alamat="{{ $data->pasien->Alamat }}" data-kec="{{$data->pasien->kecamatan->name}}" data-kab="{{$data->pasien->kabupaten->name}}" data-prov="{{$data->pasien->provinsi->name}}" data-kelurahan="{{$data->pasien->desa->name}}" >
                                    <td>{{ $data->poli->nama_poli }}</td>
                                    <td>{{ $data->no_rm }}</td>
                                    <td>{{ $data->no_rawat }}</td>
                                    <td>{{ $data->nama_pasien }}</td>
                                    <td>{{ $data->tgl_lahir }}</td>
                                    <td>{{ $data->doctor->nama_dokter }}</td>
                                    <td>{{ $data->tgl_kunjungan }}</td>
                                    <td>{{ $data->batchNo }}</td>
                                </tr>
                            @endforeach
                            <!-- Example static data for testing -->
                            {{-- @php
                                dd($rawatjalan);
                            @endphp --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal edit --}}
    <div class="modal fade" id="editQty" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Rubah kuantitas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Kode Obat</label>
                            <input type="text" class="form-control" id="kode_obat_edit" name="kode_obat_edit" readonly>
                        </div>
                        <div class="col-md-8">
                            <label>Nama Obat</label>
                            <input type="text" class="form-control" id="nama_obat_edit" name="nama_obat_edit" readonly>
                        </div>
                        <div class="col-md-12">
                            <label>Kuantitas</label>
                            <input type="number" class="form-control" id="qty_edit" name="qty_edit">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="UpdateButton">Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Konfirmasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBodyText">
                    <!-- Pesan konfirmasi akan diisi dinamis -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modalProceedButton">Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- /.content-wrapper -->

    <script>
        $(document).ready(function () {
            $('#generateButton').click(function () {
                // Lakukan AJAX request ke server
                $.ajax({
                    url: '/api/generate-no-rm',  // Rute untuk memanggil controller
                    method: 'GET',  // Menggunakan GET
                    success: function (response) {
                        // Update field dengan nomor RM dan nama dari response
                        $('#no_rm').val(response.no_rm);
                        $('#nama').val(response.nama);
                    },
                    error: function (xhr, status, error) {
                        console.error("Terjadi kesalahan:", error);
                        alert("Terjadi kesalahan saat menggenerate nomor RM.");
                    }
                });
            });

            $('#bebas_barang, #pil_harga').on('change', function () {
                const kodeBarang = $('#bebas_barang').val();
                const pilHarga = $('#pil_harga').val();

                if (kodeBarang && pilHarga) {
                    $.ajax({
                        url: '/api/transaksi/get-harga-bebas', // Ganti dengan nama route Anda
                        type: "POST",
                        data: {
                            kode_barang: kodeBarang,
                            pil_harga: pilHarga,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            $('#harga_bebas').val(response.harga);
                        },
                        error: function () {
                            $('#harga_bebas').val('Error');
                        }
                    });
                }
            });

            const inputField = $('#bebas_disc');
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

            document.getElementById('reloadButton').addEventListener('click', function() {
                location.reload();  // Memuat ulang halaman
            });

        });

        function toggleFormat() {
            const isChecked = document.getElementById("formatToggle").checked;
            const inputField = $('#bebas_disc'); // Get the input field by id

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
    </script>

    {{-- SCRIPT UNTUK MEMBEDAKAN RESEP DAN BELI BEBAS --}}
    <script>
        $(document).ready(function() {
            // Monitor perubahan pada elemen select
            $('#cara_resep').change(function() {
                // Ambil tanggal sekarang
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                const dateString = `${year}${month}${day}`;

                // Tentukan tipe faktur berdasarkan pilihan
                let invoicePrefix = '';
                if ($(this).val() === 'Beli_Bebas') {
                    invoicePrefix = 'BBS';
                    // Set embis menjadi readonly
                    $('#embis').prop('readonly', true);
                } else {
                    invoicePrefix = 'RSP';
                    // Set embis menjadi editable
                    $('#embis').prop('readonly', false);
                }

                // Panggil AJAX untuk mendapatkan nomor faktur terbaru
                $.ajax({
                    url: '/api/generate-invoice-code',  // Endpoint untuk mendapatkan nomor faktur terbaru
                    method: 'GET',
                    data: {
                        prefix: invoicePrefix,  // Kirimkan prefix (RSP atau BBS)
                        _token: $('meta[name="csrf-token"]').attr('content')  // CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            // Ambil nomor faktur yang dihasilkan dan set ke input
                            const invoiceNumber = `${invoicePrefix}-${dateString}-${response.invoiceNumber}`;
                            $('#resep_kode').val(invoiceNumber);
                        } else {
                            alert("Terjadi kesalahan saat mendapatkan nomor faktur.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error saat mendapatkan nomor faktur:", error);
                        alert("Terjadi kesalahan saat mendapatkan nomor faktur.");
                    }
                });
            });
        });
    </script>

    {{-- SCRIPT DATA PASIEN NYA --}}
    <script>
        $(document).ready(function () {
            function debounce(func, wait) {
                let timeout;
                return function (...args) {
                    const context = this;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }

            var table = $('#kunjungan-table').DataTable({
                responsive: true,
                autoWidth: true,
                paging: false,
                info: false,
                scrollCollapse: true,
                scrollX: true,
                scrollY: '30vh',
                searching: true,
                ordering: true,
                lengthChange: true,
                createdRow: function (row, data, dataIndex) {
                    // Tambahkan atribut `data-alamat` ke dataset DataTables
                    var alamat = $(row).data('alamat');
                    if (alamat) {
                        data.push(alamat); // Tambahkan "Alamat" ke dataset
                    }
                    var kelurahan = $(row).data('kelurahan');
                    if (kelurahan) {
                        data.push(kelurahan); // Tambahkan "Kelurahan" ke dataset
                    }
                    var kec = $(row).data('kec');
                    if (kec) {
                        data.push(kec); // Tambahkan "Kecamatan" ke dataset
                    }
                    var kab = $(row).data('kab');
                    if (kab) {
                        data.push(kab); // Tambahkan "Kabupaten" ke dataset
                    }
                    var prov = $(row).data('prov');
                    if (prov) {
                        data.push(prov); // Tambahkan "Provinsi" ke dataset
                    }
                },
                language: {
                    zeroRecords: "No data available",
                    infoEmpty: "No entries available",
                    search: "Search:",
                },
            });

            $('#adddoctor').on('shown.bs.modal', function () {
                requestAnimationFrame(function () {
                    table.columns.adjust();
                });
            });

            // Filter hari ini jika tidak ada pencarian
            var today = new Date();
            today.setHours(0, 0, 0, 0);

            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var searchInput = $('.dataTables_filter input').val();
                if (searchInput && searchInput.trim() !== '') {
                    return true; // Abaikan filter tanggal jika pencarian aktif
                }

                var tglRawat = data[6];
                if (!tglRawat) return false;

                var tglRawatDate = new Date(tglRawat);
                return tglRawatDate >= today;
            });

            table.draw();

             // Debounced search handling
            table.on('search.dt', debounce(function () {
                var searchTerm = $('.dataTables_filter input').val();
                if (searchTerm.trim() !== '') {
                    console.log('Search event triggered');

                    // Pastikan hanya menggambar tabel ketika ada perubahan pencarian
                    if (table.rows({ filter: 'applied' }).count() === 0) {
                        console.log('No results found, continuing search');
                        table.draw();
                    } else {
                        console.log('Search completed with results');
                        // Tidak perlu lagi melakukan table.draw() karena hasil sudah ditemukan
                    }
                }
            }, 300));

            // Event: Handle row selection
            $('#kunjungan-table tbody').on('click', 'tr', function () {
                // Toggle row selection
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected'); // Deselect others
                    $(this).addClass('selected'); // Select current row
                }

                // Get data of the selected row
                var selectedData = table.rows('.selected').data();
                console.log('Selected Row Data:', selectedData.toArray());

                if (selectedData.length > 0) {
                    var data = selectedData[0]; // Data dari baris yang dipilih

                    // Ambil data alamat lengkap
                    var alamatLengkap = `${data[8]}, ${data[9]}, ${data[10]}, ${data[11]}, ${data[12]}`;

                    // Assign the data to respective input fields
                    $('#no_rm').val(data[1]); // No RM (index 1)
                    $('#no_reg').val(data[2]); // No Reg (index 2)
                    $('#no_reg').trigger('input'); // Memicu event input secara manual
                    $('#nama').val(data[3]); // Nama (index 3)
                    $('#alamat').val(alamatLengkap); // Alamat lengkap
                    $('#tgl_kunjungan').val(data[6]); // Tanggal Kunjungan (index 6)

                    // Update select_dokter
                    var dokterValue = data[5]; // Dokter (index 5)
                    $('#select_dokter').val(dokterValue).trigger('change'); // Set value & update Select2 UI

                    // Update select_dokter
                    var poliValue = data[0]; // Dokter (index 5)
                    $('#nama_poli').val(poliValue).trigger('change'); // Set value & update Select2 UI

                    // Close the modal
                    $('#adddoctor').modal('hide');
                }
            });
        });
    </script>

    {{-- SCRIPT TABEL OBAT KE TABEL ISI --}}
    <script>
        $(document).ready(function () {
            console.log("Script initialized.");
            // Variabel untuk menyimpan subtotal dan total sementara
            let lastSubTotal = 0;
            let lastTotal = 0;
            let selectedRow = null;

            // Fungsi untuk update total
            function updateTotal() {
                // Ambil nilai embisResult (potongan) dan konversi ke rupiah
                var embisRupiah = parseFloat($('#embisResult').text().replace(/\./g, '').replace(',', '.').replace('Rp', '').trim()) || 0;
                // Ambil nilai sub_total
                var subTotal = parseFloat($('#sub_total').val()) || 0;

                // Hitung total setelah mengurangi embis dari subtotal
                var total = subTotal - embisRupiah;

                // Format total dengan dua digit desimal
                const formattedTotal = total.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

                // Update label dan input tersembunyi Total
                $('#total_label').text('Rp. ' + formattedTotal); // Format ke Rupiah
                $('#total').val(total); // Simpan ke input tersembunyi
            }

            // Fungsi untuk menghitung dan menampilkan subtotal
            function updateSubTotal() {
                let subTotal = 0;

                // Ambil setiap baris di tabel dan hitung total harga
                $('#isi-table tbody tr').each(function() {
                    const totalHargaText = $(this).find('td:nth-child(7)').text().trim(); // Ambil kolom total harga
                    const totalHarga = parseFloat(totalHargaText.replace("Rp", "").replace(/\./g, "").trim());
                    if (!isNaN(totalHarga)) {
                        subTotal += totalHarga; // Tambah total harga ke subtotal
                    }
                });

                // Format subtotal dalam Rupiah
                const subTotalFormatted = `Rp. ${subTotal.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                $('#sub_total_label').text(subTotalFormatted); // Tampilkan subtotal
                $('#sub_total').val(subTotal); // Simpan subtotal dalam input tersembunyi

                // Simpan subtotal terakhir untuk digunakan jika embis dikosongkan
                lastSubTotal = subTotal;
            }

            // Ambil harga embalase dari database
            function getEmbalaseValue() {
                return $.ajax({
                    url: '/api/transaksi/harga',  // URL untuk mengambil data harga embalase
                    method: 'GET',
                    success: function (response) {
                        return response.embalase || 0; // Mengambil value embalase
                    },
                    error: function () {
                        console.error('Gagal mengambil data embalase');
                        return 0;
                    }
                });
            }

            $('#embis').on('input', async function () {
                // Ambil nilai embis dan pastikan ini adalah angka
                const embisValue = parseInt($(this).val()) || 0;  // Jika tidak valid, set ke 0
                console.log("Embis value: ", embisValue);

                // Ambil harga embalase dari server menggunakan async/await
                const embalaseValue = await getEmbalaseValue();
                console.log("Embalase value: ", embalaseValue);

                // Pastikan embalaseValue adalah angka
                const embalaseNumeric = parseInt(embalaseValue.embalase) || 0; // Konversi string ke angka
                console.log("Embalase Numeric: ", embalaseNumeric);

                // Cek apakah embalaseValue adalah angka valid
                if (isNaN(embalaseNumeric)) {
                    console.error("Embalase value is not a valid number");
                    return;  // Jika embalase tidak valid, hentikan proses
                }

                // Hitung hasil embis
                const embisResult = embisValue * embalaseNumeric;
                console.log("Embis Result: ", embisResult);

                // Tampilkan hasil embis di label
                $('#embisResult').text(embisResult.toLocaleString('id-ID'));

                updateTotal();
            });

            // Menambahkan event click untuk memilih baris
            $('#isi-table tbody').on('click', 'tr', function () {
                // Jika baris sudah dipilih, hapus kelas 'selected-row' dari baris sebelumnya
                if (selectedRow) {
                    selectedRow.removeClass('selected-row');
                }

                // Tandai baris yang baru dipilih
                selectedRow = $(this);

                // Tambahkan kelas 'selected-row' untuk menunjukkan baris yang dipilih
                selectedRow.addClass('selected-row');

                // Tampilkan tombol Hapus
                $('#btnDeleteSelected').show();
            });

            // Event untuk double click (dblclick) menampilkan modal
            $('#isi-table tbody').on('dblclick', 'tr', function () {
                selectedRow = $(this); // Simpan baris yang dipilih

                // Ambil data dari kolom dalam baris yang diklik
                let kodeObatEdit = selectedRow.find('td:eq(2)').text().trim();  // Kode Obat
                let namaObatEdit = selectedRow.find('td:eq(1)').text().trim();  // Nama Obat
                let kuantitasEdit = selectedRow.find('td:eq(5)').text().trim(); // Kuantitas
                // let hargaSatuanEdit = selectedRow.find('td:eq(3)').text().replace(/[^\d]/g, '').trim(); // Harga satuan (hilangkan "Rp" dan koma)
                // let totalJumlahEdit = selectedRow.find('td:eq(6)').text().replace(/[^\d]/g, '').trim(); // Total jumlah (hilangkan "Rp" dan koma)

                // Set nilai input dalam modal
                $('#kode_obat_edit').val(kodeObatEdit);
                $('#nama_obat_edit').val(namaObatEdit);
                $('#qty_edit').val(kuantitasEdit);

                // Tampilkan modal
                $('#editQty').modal('show');
            });

            // Event ketika tombol "Lanjutkan" diklik (update kuantitas dan total jumlah)
            $('#UpdateButton').on('click', function () {
                if (selectedRow) {
                    let updatedQtyEdit = $('#qty_edit').val().trim(); // Ambil nilai baru dari input modal

                    if (updatedQtyEdit !== "") { // Pastikan tidak kosong
                        selectedRow.find('td:eq(5)').text(updatedQtyEdit); // Update kuantitas pada tabel

                        // Ambil harga satuan (dengan membersihkan karakter selain angka)
                        let hargaSatuan = selectedRow.find('td:eq(3)').text().replace(/[^\d]/g, '').trim();

                        // Hitung total jumlah (Harga Satuan * Kuantitas)
                        let totalJumlah = parseInt(hargaSatuan) * parseInt(updatedQtyEdit);

                        // Format totalJumlah ke dalam format mata uang (Rp)
                        let formattedTotal = "Rp " + totalJumlah.toLocaleString('id-ID');

                        // Update total jumlah pada tabel
                        selectedRow.find('td:eq(6)').text(formattedTotal);
                    }
                }

                // Update subtotal setelah menambahkan item ke tabel
                updateSubTotal();

                updateTotal();

                // Tutup modal setelah update
                $('#editQty').modal('hide');
            });

            // Event untuk menghapus baris yang dipilih
            $('#btnDeleteSelected').on('click', function () {
                if (selectedRow) {
                    // Hapus baris yang dipilih
                    selectedRow.remove();

                    // Update nomor urut setelah penghapusan
                    updateRowNumbers();

                    // Update subtotal dan total setelah penghapusan
                    updateSubTotal();
                    updateTotal();

                    // Reset selectedRow setelah penghapusan
                    selectedRow = null;
                }
            });

            // Fungsi untuk memperbarui nomor urut pada setiap baris
            function updateRowNumbers() {
                $('#isi-table tbody tr').each(function(index) {
                    $(this).find('td:first').text(index + 1); // Set nomor urut berdasarkan urutan baris
                });
            }

            // Fungsi untuk mengambil data dan menampilkan item di tabel
            $('#no_reg').on('input', function () {
                var noReg = $(this).val(); // Ambil nilai input
                console.log("Input no_reg changed: ", noReg); // Log no_reg input

                // Kirim nilai ke server menggunakan AJAX
                $.ajax({
                    url: '/api/transaksi/obat', // URL controller Laravel
                    method: 'GET', // Gunakan GET
                    data: { no_reg: noReg }, // Kirim no_reg sebagai parameter
                    success: function (response) {
                        console.log("Data Murni: ", response); // Log response dari server

                        // Clear previous table data and button container
                        $('#obat-table tbody').empty();
                        $('#buttons-container').empty();

                        // Variabel untuk menyimpan kelompok data berdasarkan R
                        var kelompokData = [];
                        var currentGroup = null;

                        // Mengelompokkan data
                        response.forEach((item) => {
                            if (item.header && (item.header.startsWith("R/") || item.header.startsWith("R: /"))) {
                                // Buat grup baru
                                currentGroup = { id: kelompokData.length + 1, header: item.header, items: [] };
                                kelompokData.push(currentGroup);
                                console.log("New group created: ", currentGroup); // Log grup baru
                            } else if (currentGroup) {
                                // Tambahkan item ke grup saat ini
                                currentGroup.items.push(item);
                                console.log("Item added to group: ", item); // Log item yang ditambahkan
                            }
                        });

                        // Tampilkan data ke dalam tabel `#obat-table`
                        kelompokData.forEach(function (group) {
                            console.log("Rendering group: ", group); // Log grup yang sedang dirender

                            // Tambahkan baris header ke tabel
                            $('#obat-table tbody').append(`
                                <tr style="font-weight: bold;">
                                    <td colspan="5">${group.header} (${group.id})</td>
                                </tr>
                            `);

                            // Tambahkan item ke tabel
                            group.items.forEach(function (item) {
                                $('#obat-table tbody').append(`
                                    <tr>
                                        <td style="padding-left: 30px;">${item.obats.nama || "N/A"} >> ${item.dosis || "N/A"} @ ${item.dosis_satuan || "N/A"} (${item.signa_keterangan || "N/A"})</td>
                                    </tr>
                                `);
                            });
                        });

                        // Event Listener untuk Download PDF
                        $('#download-pdf').on("click", function () {
                            let csrfToken = "{{ csrf_token() }}";
                            let notes = $('#notes').val();
                            let data = response;
                            console.log("notes : ", data);

                            fetch("/barang/transaksi/resep/download-pdf", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": csrfToken
                                },
                                body: JSON.stringify({ data: data, no_reg: noReg, notes: notes })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.pdf_url) {
                                    setTimeout(() => {
                                        $(document).Toasts('create', {
                                            class: 'bg-maroon',
                                            title: 'Berhasil',
                                            body: 'Unduh PDF: <a href="' + data.pdf_url + '" target="_blank">Klik di sini untuk mengunduh</a>'
                                        });
                                    }, 2000);
                                } else {
                                    alert("Gagal membuat PDF.");
                                }
                            })
                            .catch(error => console.error("Error:", error));
                        });

                        // Event handler untuk tombol Load Per R/
                        $('#loadRButton').on('click', function () {
                            console.log("Load Per R/ button clicked."); // Log tombol klik

                            // Ambil nilai dari input ID R dan Jumlah
                            var idRValue = $('#id_R').val().trim();
                            var jumlahValue = $('#jumlah_R').val().trim();
                            console.log("ID R: ", idRValue); // Log input ID R
                            console.log("Jumlah: ", jumlahValue); // Log input jumlah

                            if (!idRValue) {
                                alert("Harap masukkan ID R.");
                                console.warn("ID R is empty.");
                                return;
                            }

                            if (!jumlahValue) {
                                alert("Harap masukkan jumlah.");
                                console.warn("Jumlah is empty.");
                                return;
                            }

                            // Parse jumlah sebagai angka
                            var jumlahValueParsed = parseInt(jumlahValue);

                            // Temukan grup berdasarkan ID R yang dimasukkan
                            var selectedGroup = kelompokData.find(group => group.id == idRValue);
                            console.log("Selected group: ", selectedGroup); // Log grup yang dipilih

                            if (selectedGroup) {
                                // Kosongkan tabel `#isi-table`
                                $('#isi-table tbody').empty();

                                // Pindahkan data grup ke tabel `#isi-table`
                                selectedGroup.items.forEach(function (item, index) {
                                    const hargaBeliRaw = item.harga.harga_2 || "Rp 0";
                                    const hargaBeli = parseFloat(hargaBeliRaw.replace("Rp", "").replace(/\./g, "").trim());
                                    const hargaBeliFormatted = `Rp ${hargaBeli.toLocaleString('id-ID')}`;
                                    const dosis = item.dosis || 0;
                                    const totalKuantitas = jumlahValueParsed * dosis; // Perhitungan kuantitas total
                                    const totalHarga = totalKuantitas * hargaBeli; // Perhitungan total harga
                                    const totalHargaFormatted = `Rp ${totalHarga.toLocaleString('id-ID')}`;

                                    console.log("Harga beli: ", hargaBeli, "Dosis: ", dosis, "Total Kuantitas: ", totalKuantitas, "Total Harga: ", totalHargaFormatted);

                                    // <td class="text-center">${item.harga.disc || "N/A"}</td>
                                    $('#isi-table tbody').append(`
                                        <tr>
                                            <td class="text-center"></td>
                                            <td style="width: 25%;">${item.obats.nama || "N/A"}</td>
                                            <td class="text-center">${item.obats.kode || "N/A"}</td>
                                            <td class="text-center">${hargaBeliFormatted}</td>
                                            <td class="text-center">0</td>
                                            <td class="text-center">${totalKuantitas}</td>
                                            <td class="text-center">${totalHargaFormatted}</td> <!-- Menampilkan Total Harga -->
                                        </tr>
                                    `);
                                });

                                // Update nomor urut
                                updateRowNumbers();

                                // Update subtotal setelah menambahkan item ke tabel
                                updateSubTotal();

                                updateTotal();
                            } else {
                                alert("ID R tidak ditemukan.");
                                console.error("Group with ID R not found."); // Log kesalahan ID R tidak ditemukan
                            }
                        });

                        // Event handler untuk tombol Load R/ Full
                        $('#loadFullButton').on('click', function() {
                            console.log("Load R/ Full button clicked."); // Log tombol klik

                            // Kosongkan tabel isi-table
                            $('#isi-table tbody').empty();

                            let totalHarga = 0; // Untuk menghitung total harga

                            // Pindahkan semua item dari semua grup R ke tabel #isi-table
                            kelompokData.forEach(function (group) {
                                console.log("Rendering full group: ", group); // Log grup yang dirender
                                group.items.forEach(function (item, index) {
                                    const hargaBeliRaw = item.harga.harga_2 || "Rp 0";
                                    const hargaBeli = parseFloat(hargaBeliRaw.replace("Rp", "").replace(/\./g, "").trim());
                                    const hargaBeliFormatted = `Rp ${hargaBeli.toLocaleString('id-ID')}`;
                                    const dosis = item.dosis || 0;
                                    const totalKuantitas = dosis;
                                    const totalHargaItem = totalKuantitas * hargaBeli;
                                    totalHarga += totalHargaItem;
                                    const totalHargaFormatted = `Rp ${totalHargaItem.toLocaleString('id-ID')}`;

                                    // <td class="text-center">${item.harga.disc || "N/A"}</td>
                                    $('#isi-table tbody').append(`
                                        <tr>
                                            <td class="text-center"></td>
                                            <td style="width: 25%;">${item.obats.nama || "N/A"}</td>
                                            <td class="text-center">${item.obats.kode || "N/A"}</td>
                                            <td class="text-center">${hargaBeliFormatted}</td>
                                            <td class="text-center">0</td>
                                            <td class="text-center">${totalKuantitas}</td>
                                            <td class="text-center">${totalHargaFormatted}</td>
                                        </tr>
                                    `);
                                });
                            });

                            // Update nomor urut
                            updateRowNumbers();

                            // Update subtotal setelah menambahkan item ke tabel
                            updateSubTotal();

                            updateTotal();
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error: ", error);
                        alert("Error fetching data.");
                    }
                });
            });

            $('#btnTambahBebas').on('click', function () {
                // Ambil data dari form
                const namaItem = $('#bebas_barang option:selected').text();
                const kodeItem = $('#bebas_barang').val();
                let harga = $('#harga_bebas').val();
                const qty = $('#qty_bebas').val();
                const diskon = $('#bebas_disc').val();
                let hargaNumber = Number(harga);

                const noRm = $('#no_rm').val();
                const nama = $('#nama').val();
                const caraResep = $('#cara_resep').val();
                const resepKode = $('#resep_kode').val();
                const poli = $('#nama_poli').val();
                const jenisPx = $('#jenis_px').val();

                // Validasi input
                // if (!kodeItem || !qty || !harga || !diskon || !noRm || !nama || !caraResep || !resepKode || !poli || !jenisPx) {
                //     alert("Harap isi semua data yang diperlukan!");
                //     return;
                // }

                let message = '';
                if (!noRm || !nama) {
                    message = "Mohon di isi No RM !";
                } else if (!caraResep || !resepKode) {
                    message = "Mohon dipilih Resep !";
                } else if (!poli) {
                    message = "Mohon dipilih Poli APS !";
                } else if (!jenisPx) {
                    message = "Mohon dipilih Jenis PX !";
                } else if (!kodeItem) {
                    message = "Mohon dipilih Obatnya !";
                } else if (!qty) {
                    message = "Mohon dipilih Jumlahnya !";
                } else if (!harga) {
                    message = "Mohon dipilih Harga yang digunakannya !";
                } else if (!harga) {
                    message = "Mohon dipilih Diskon yang diberikan !";
                }

                if (message) {
                    document.getElementById('modalBodyText').innerText = message;
                    $('#confirmationModal').modal('show');

                    // Tombol "Lanjutkan"
                    document.getElementById('modalProceedButton').onclick = function () {
                        $('#confirmationModal').modal('hide');
                    };
                    return; // Tidak melanjutkan ke bagian penambahan data jika ada pesan
                }

                let cleanedDiskon;
                if (diskon.includes('%')) {
                    cleanedDiskon = parseFloat(diskon.replace('%', '').trim()) / 100;
                } else {
                    cleanedDiskon = parseFloat(diskon.replace(/[^\d,-]/g, '').replace(',', '.').trim());
                }

                let totalBeforeDiscount = harga * qty;
                // let diskonRupiah = cleanedDiskon * qty;
                let total;

                if (diskon.includes('%')) {
                    // Apply percentage discount
                    total = totalBeforeDiscount * (1 - cleanedDiskon);
                } else {
                    // Apply direct amount discount (just subtract it)
                    total = totalBeforeDiscount - cleanedDiskon; //kalau diskon rupiah seabreg
                    // total = totalBeforeDiscount - diskonRupiah; //kalau diskon rupiah per 1 obat
                }

                // let diskonItem = totalBeforeDiscount - total;

                let diskonSatuan;

                if (diskon.includes('%')) {
                    // Apply percentage discount
                    diskonSatuan = (harga * cleanedDiskon) * qty;
                } else {
                    // Apply direct amount discount (just subtract it)
                    diskonSatuan = cleanedDiskon;
                }

                // Format total dengan pemisah ribuan
                let formattedTotal = total.toLocaleString('id-ID');
                let formattedDiskon = diskonSatuan.toLocaleString('id-ID');
                let formattedHarga = hargaNumber.toLocaleString('id-ID');

                // Tambahkan data ke tabel
                $('#isi-table tbody').append(`
                    <tr>
                        <td class="text-center"></td>
                        <td style="width: 25%;">${namaItem}</td>
                        <td class="text-center">${kodeItem}</td>
                        <td class="text-center">Rp ${formattedHarga}</td>
                        <td class="text-center">${formattedDiskon || 0}</td>
                        <td class="text-center">${qty}</td>
                        <td class="text-center">Rp ${formattedTotal}</td>
                    </tr>
                `);

                // Update nomor urut
                updateRowNumbers();

                // Update subtotal setelah menambahkan item ke tabel
                updateSubTotal();

                updateTotal();

               // Reset input setelah menambahkan data
                $('#bebas_barang').val(null).trigger('change'); // Reset ke opsi pertama
                $('#pil_harga').val(null).trigger('change'); // Reset ke opsi pertama
                $('#qty_bebas').val(''); // Kosongkan input jumlah
                $('#bebas_disc').val(''); // Kosongkan input diskon
                $('#harga_bebas').val(''); // Kosongkan input harga
            });

            // Event handler untuk tombol Simpan Data
            $('#saveButton').on('click', function () {
                // Buat array untuk menyimpan data dari isi tabel
                let tableData = [];
                let noReg = $('#no_reg').val();
                let noRm = $('#no_rm').val();
                let nama = $('#nama').val();
                let alamat = $('#alamat').val();
                let resep = $('#cara_resep').val();
                let resepKode = $('#resep_kode').val();
                let rawat = $('#rawat').val();
                let poli = $('#nama_poli').val();
                let dokter = $('#select_dokter').val() ? $('#select_dokter').val() : $('#input_dokter').val();
                let jenisPx = $('#jenis_px').val();
                let penjamin = $('#penjamin').val();

                // Iterasi setiap baris pada #isi-table tbody untuk mengumpulkan data
                $('#isi-table tbody tr').each(function () {
                    const rowData = {
                        namaObat: $(this).find('td:nth-child(2)').text().trim().replace(/\s?\(.*?\)$/, ''),
                        kode: $(this).find('td:nth-child(3)').text().trim(),
                        harga: parseFloat($(this).find('td:nth-child(4)').text().replace("Rp", "").replace(/\./g, "").replace(",", ".")) || 0,
                        diskon: $(this).find('td:nth-child(5)').text().trim(),
                        kuantitas: parseInt($(this).find('td:nth-child(6)').text().trim()) || 0,
                        total_harga: parseFloat($(this).find('td:nth-child(7)').text().replace("Rp", "").replace(/\./g, "").replace(",", ".")) || 0,
                    };
                    tableData.push(rowData);
                });

                // Ambil data dari elemen lain di halaman
                const embis = parseFloat($('#embisResult').text().replace(/\./g, '').replace(',', '.').replace('Rp', '').trim()) || 0;
                const subTotal = parseFloat($('#sub_total').val()) || 0;
                const total = parseFloat($('#total').val()) || 0;

                // Buat data payload untuk dikirim ke server
                const payload = {
                    tableData: tableData,
                    embis: embis,
                    sub_total: subTotal,
                    total: total,
                    noReg: noReg,
                    noRm: noRm,
                    nama: nama,
                    alamat: alamat,
                    resep: resep,
                    resepKode: resepKode,
                    rawat: rawat,
                    poli: poli,
                    dokter: dokter,
                    jenisPx: jenisPx,
                    penjamin: penjamin,
                };

                console.log("Data yang akan dikirim:", payload); // Log data untuk debugging

                // Make the AJAX request
                $.ajax({
                    url: '{{ route("barang.transaksi.add") }}', // Use Laravel's route helper to generate the URL
                    method: 'POST',
                    data: JSON.stringify(payload), // Send data as JSON
                    contentType: 'application/json', // Ensure content type is JSON
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            // Tampilkan popup alert
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                title: 'Berhasil',
                                autohide: true,
                                delay: 10000,
                                body: "{{ 'Data Transaksi Barang berhasil ditambahkan.' }}"
                            });
                            // window.location.href = response.redirect;
                            location.reload(); // Refresh halaman
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            // Tampilkan pesan kesalahan validasi
                            const errors = xhr.responseJSON.errors;
                            let errorMessages = '';
                            for (let key in errors) {
                                errorMessages += errors[key].join('\n') + '\n';
                            }
                            alert('Validation errors:\n' + errorMessages);
                        } else {
                            // Kesalahan lain
                            alert('Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
                        }
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // Event listener untuk checkbox
            $('#check_dokter').change(function () {
                const isChecked = $(this).is(':checked'); // Cek apakah checkbox dicentang
                const selectDokter = $('#select_dokter');
                const inputDokter = $('#input_dokter');

                if (isChecked) {
                    // Jika checkbox dicentang, sembunyikan select dan tampilkan input text
                    selectDokter.select2('destroy').hide(); // Hapus Select2 dan sembunyikan select
                    inputDokter.show(); // Tampilkan input text
                } else {
                    // Jika checkbox tidak dicentang, tampilkan select dan sembunyikan input text
                    inputDokter.hide().val(''); // Sembunyikan input text dan kosongkan nilainya
                    selectDokter.show().each(function () {
                        $(this).select2({
                            theme: "bootstrap4",
                            dropdownParent: $(this).parent(), // Perbaiki dropdown jika di dalam modal
                        });
                    });
                }
            });
        });
    </script>

    {{-- SCRIPT BELI BEBAS --}}




@endsection
