@extends('template.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('keuangan.kasir.bayar.add') }}" method="POST">
                    @csrf
                <!-- Main row -->
                <div class="row">
                    <div class="mt-3 col-12">
                        <div class="row">
                            <div class="col-md-12">
                                {{-- <div class="col-md-12">
                                    <h4><center>- KASIR -</center></h4>
                                </div> --}}
                                <div class="row">
                                    <div class="mb-3 col-md-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="hidden" id="data_faktur" name="data_faktur" value="[]">
                                                        <input type="hidden" id="kode_faktur_inti" name="kode_faktur_inti">

                                                        <div class="form-group row d-flex align-items-center">
                                                            <span class="col-md-3 col-form-span">No. RM</span>
                                                            <div class="col-md-1 text-center">:</div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" id="no_rm" name="no_rm" value="{{$data->no_rm ?? $data_layanan_mandiri->no_rm}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row d-flex align-items-center">
                                                            <span class="col-md-3 col-form-span">Nama</span>
                                                            <div class="col-md-1 text-center">:</div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" id="nama" name="nama" value="{{$data->nama ?? $data_layanan_mandiri->nama_pasien}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row d-flex align-items-center">
                                                            <span class="col-md-3 col-form-span">Sex</span>
                                                            <div class="col-md-1 text-center">:</div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" id="sex" name="sex" value="{{$data->rajal->seks ?? $data_layanan_mandiri->rajal->seks}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row d-flex align-items-center">
                                                            <span class="col-md-3">Usia</span>
                                                            <div class="col-md-1 text-center">:</div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" id="usia" name="usia" value="{{$umur}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row d-flex align-items-center">
                                                            <span class="col-md-3 col-form-span">Alamat</span>
                                                            <div class="col-md-1 text-center">:</div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" id="alamat" name="alamat" value="{{$data->alamat ?? $data_layanan_mandiri->rajal->pasien->Alamat . ', ' . $data_layanan_mandiri->rajal->pasien->desa->name . ', ' . $data_layanan_mandiri->rajal->pasien->kabupaten->name . ', ' . $data_layanan_mandiri->rajal->pasien->provinsi->name }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">

                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row d-flex align-items-center">
                                                            <span class="col-md-3 col-form-span">Poli</span>
                                                            <div class="col-md-1 text-center">:</div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" id="poli" name="poli" value="{{$data->nama_poli ?? $data_layanan_mandiri->rajal->poli->nama_poli}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row d-flex align-items-center">
                                                            <span class="col-md-3 col-form-span">Dokter</span>
                                                            <div class="col-md-1 text-center">:</div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" id="dokter" name="dokter" value="{{$data->dokter ?? $data_layanan_mandiri->rajal->doctor->nama_dokter}}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <hr style="border: 2px solid rgb(80, 75, 75); margin: 20px 0;">
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group row d-flex align-items-center">
                                                            <label class="col-md-4 col-form-label">Jenis Perawatan</label>
                                                            <div class="col-md-1 text-center">:</div>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" id="jenis_perawatan" name="jenis_perawatan" value="{{ $data->rawat  ?? $data_layanan_mandiri->rajal->status_lanjut}}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row d-flex align-items-center">
                                                            <label class="col-md-4 col-form-label">Jenis Pasien</label>
                                                            <div class="col-md-1 text-center">:</div>
                                                            <div class="col-md-7">
                                                                <select class="form-control select2bs4" style="width: 100%;" id="jenis_pasien" name="jenis_pasien">
                                                                    <option value="" disabled
                                                                        {{ (isset($data) && empty($data->jenis_px)) && (isset($data_layanan_mandiri) && empty($data_layanan_mandiri->rajal->penjab->pj)) ? 'selected' : '' }}>
                                                                        -- Pilih --
                                                                    </option>

                                                                    <option value="UMUM"
                                                                        {{ (isset($data) && strtoupper($data->jenis_px) === 'UMUM') ||
                                                                        (isset($data_layanan_mandiri->rajal->penjab) && strtoupper($data_layanan_mandiri->rajal->penjab->pj ?? '') === 'UMUM') ? 'selected' : '' }}>
                                                                        UMUM
                                                                    </option>

                                                                    <option value="ASURANSI"
                                                                        {{ (isset($data) && strtoupper($data->jenis_px) === 'ASURANSI') ||
                                                                        (isset($data_layanan_mandiri->rajal->penjab) && strtoupper($data_layanan_mandiri->rajal->penjab->pj ?? '') === 'ASURANSI') ? 'selected' : '' }}>
                                                                        ASURANSI
                                                                    </option>

                                                                    <option value="BPJS"
                                                                        {{ (isset($data) && strtoupper($data->jenis_px) === 'BPJS') ||
                                                                        (isset($data_layanan_mandiri->rajal->penjab) && strtoupper($data_layanan_mandiri->rajal->penjab->pj ?? '') === 'BPJS') ? 'selected' : '' }}>
                                                                        BPJS
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row d-flex align-items-center">
                                                            <label class="col-md-4 col-form-label">Penjamin</label>
                                                            <div class="col-md-1 text-center">:</div>
                                                            <div class="col-md-7">
                                                                <select class="form-control select2bs4" style="width: 100%;" id="penjamin" name="penjamin">
                                                                    <option value="" disabled
                                                                        {{ (isset($data) && empty($data->penjamin)) && (isset($data_layanan_mandiri) && empty($data_layanan_mandiri->rajal->penjab->kode)) ? 'selected' : '' }}>
                                                                        -- Pilih --
                                                                    </option>

                                                                    @foreach ($penjab as $penjamin)
                                                                        <option value="{{ $penjamin->kode }}"
                                                                            {{ (isset($data) && $data->penjamin === $penjamin->kode) ||
                                                                               (isset($data_layanan_mandiri->rajal->penjab) && $data_layanan_mandiri->rajal->penjab->kode === $penjamin->kode) ? 'selected' : '' }}>
                                                                            {{ $penjamin->nama }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 row">
                                                        <div class="col-md-8">
                                                            <label>Tambahan Tindakan : </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="perjal" name="perjal">
                                                                <option value="-" disabled selected>-- Pilih --</option>
                                                                @foreach ($perjal as $perjal)
                                                                    <option value="{{ $perjal->nama }}" data-tarifdok="{{ $perjal->tarifdok }}" data-tarifper="{{ $perjal->tarifper }}">
                                                                        {{ $perjal->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>&nbsp;</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="provider" name="provider">
                                                                <option value="" disabled selected>-- Pilih --</option>
                                                                <option value="Dokter">Dokter</option>
                                                                <option value="Perawat">Perawat</option>
                                                                <option value="Dokter & Perawat">Dokter & Perawat</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 row mt-2" id="dokter-row" style="display: none;">
                                                        <div class="col-md-6">
                                                            <label for="dokter_tindakan">Dokter</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="dokter_tindakan" name="dokter_tindakan">
                                                                <option value="" disabled selected>-- Pilih --</option>
                                                                @foreach ($doctor as $doctorTindakan)
                                                                <option value="{{ $doctorTindakan->nama_dokter }}">{{ $doctorTindakan->nama_dokter }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="biaya_dokter">Biaya Dokter</label>
                                                            <input type="text" class="form-control" id="biaya_dokter" name="biaya_dokter" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 row mt-2" id="perawat-row" style="display: none;">
                                                        <div class="col-md-6">
                                                            <label for="perawat_tindakan">Perawat</label>
                                                            {{-- <select class="form-control select2bs4" style="width: 100%;" id="perawat_tindakan" name="perawat_tindakan">
                                                                <option value="" disabled selected>-- Pilih --</option>
                                                                @foreach ($perawat as $perawatTindakan)
                                                                    <option value="{{ $perawatTindakan->id }}">{{ $perawatTindakan->nama }}</option>
                                                                @endforeach
                                                            </select> --}}
                                                            <input type="text" class="form-control" id="perawat_tindakan" name="perawat_tindakan">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="biaya_perawat">Biaya Perawat</label>
                                                            <input type="text" class="form-control" id="biaya_perawat" name="biaya_perawat" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 row mt-2">
                                                        <div class="col-md-4">
                                                            <label>Tarif :</label>
                                                            <input type="text" class="form-control" id="tarif_perjal" name="tarif_perjal">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Qty :</label>
                                                            <input type="number" class="form-control" id="qty_perjal" name="qty_perjal">
                                                        </div>
                                                        <div class="col-md-4 text-end">
                                                            <label>&nbsp;</label> <!-- Untuk menjaga jarak label dengan tombol -->
                                                            <button type="button" class="btn btn-info w-100" onclick="tambahanTindakan()">
                                                                Tambah
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-9">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="outer-table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <!-- Tabel dalam dengan data -->
                                                                        <table id="kunjungan-table" class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 5%">No</th>
                                                                                    <th style="width: 20%">Nama</th>
                                                                                    <th style="width: 15%">Harga</th>
                                                                                    <th style="width: 7%">Qty</th>
                                                                                    <th style="width: 15%">Total</th>
                                                                                    <th style="width: 15%">Dokter</th>
                                                                                    <th style="width: 15%">Date</th>
                                                                                    <th style="width: 10%">Disc</th>
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
                                                    <div class="col-md-12 mt-3">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group row d-flex align-items-center mt-2 ml-1 mb-1">
                                                                    <div class="col-md-4">
                                                                        <label>Sub Total</label>
                                                                    </div>
                                                                    <div class="col-md-1 text-center">
                                                                        <label>:</label>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <label id="sub_total_label" class="h5"></label>

                                                                        <!-- Input tersembunyi untuk mengirimkan nilai -->
                                                                        <input type="hidden" id="sub_total" name="sub_total">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row d-flex align-items-center ml-1 mb-1">
                                                                    <div class="col-md-4">
                                                                        <label>Potongan</label>
                                                                    </div>
                                                                    <div class="col-md-1 text-center">
                                                                        <label>:</label>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <label class="h5" id="potongan_label"></label>

                                                                        <!-- Input tersembunyi untuk mengirimkan nilai -->
                                                                        <input type="hidden" id="potongan" name="potongan">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row d-flex align-items-center ml-1 mb-1">
                                                                    <div class="col-md-12" style="display: flex; align-items: center;">
                                                                        <span style="flex-grow: 1; border-bottom: 1px solid #000; margin-right: 10px;"></span>
                                                                        <span style="font-size: 24px; font-weight: bold;">+</span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row d-flex align-items-center ml-1 mb-1" style="background-color: #737373; color: white;">
                                                                    <div class="col-md-4">
                                                                        <label class="h5">Total</label>
                                                                    </div>
                                                                    <div class="col-md-1 text-center">
                                                                        <label>:</label>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <label class="h5" id="total_sementara_label"></label>

                                                                        <!-- Input tersembunyi untuk mengirimkan nilai -->
                                                                        <input type="hidden" id="total_sementara" name="total_sementara">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row d-flex align-items-center ml-1 mb-1">
                                                                    <div class="col-md-12" style="display: flex; align-items: center;">
                                                                        <span style="flex-grow: 1; border-bottom: 1px solid #000; margin-right: 10px;"></span>
                                                                        <span style="font-size: 24px; font-weight: bold;">+</span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row d-flex align-items-center ml-1 mb-1">
                                                                    <div class="col-md-4">
                                                                        <label>Administrasi</label>
                                                                    </div>
                                                                    <div class="col-md-1 text-center">
                                                                        <label>:</label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input type="text" class="form-control" id="administrasi" name="administrasi" oninput="fungsiTagihan()" >
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row d-flex align-items-center ml-1 mb-1">
                                                                    <div class="col-md-4">
                                                                        <label>Materai</label> <!-- Materai dengan warna primary -->
                                                                    </div>
                                                                    <div class="col-md-1 text-center">
                                                                        <label>:</label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <select class="form-control select2bs4" style="width: 100%;" id="materai" name="materai" onchange="fungsiTagihan()">
                                                                            <option value="0">0</option>
                                                                            <option value="3000">3000</option>
                                                                            <option value="6000">6000</option>
                                                                            <option value="12000">6000 (2x)</option>
                                                                            <option value="18000">6000 (3x)</option>
                                                                            <option value="24000">6000 (4x)</option>
                                                                            <option value="10000">10000</option>
                                                                            <option value="20000">10000 (2x)</option>
                                                                            <option value="30000">10000 (3x)</option>
                                                                            <option value="40000">10000 (4x)</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row d-flex align-items-center ml-1 mb-1">
                                                                    <div class="col-md-12" style="display: flex; align-items: center;">
                                                                        <span style="flex-grow: 1; border-bottom: 1px solid #000; margin-right: 10px;"></span>
                                                                        <span style="font-size: 24px; font-weight: bold;">+</span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row d-flex align-items-center ml-1 mb-1" style="background-color: #000000; color: white;">
                                                                    <div class="col-md-4">
                                                                        <label class="h5">Tagihan</label>
                                                                    </div>
                                                                    <div class="col-md-1 text-center">
                                                                        <label>:</label>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <label class="h5" id="tagihan_label"></label>

                                                                        <!-- Input tersembunyi untuk mengirimkan nilai -->
                                                                        <input type="hidden" id="tagihan" name="tagihan">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="col-md-12 mt-2">
                                                                    <div class="form-group row d-flex align-items-center mb-1 ml-4">
                                                                        <div class="col-md-2">
                                                                            <label>Tagihan : </label>
                                                                        </div>
                                                                        <div class="col-md-4" style="background-color: black">
                                                                            <label id="tagihan_label_kecil" style="color: white"></label>
                                                                        </div>
                                                                        <div class="col-md-6 d-flex justify-content-end">
                                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#adddoctor">
                                                                                <i class="fas fa-plus"></i> Discount
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row d-flex align-items-center mb-1 ml-4">
                                                                        {{-- <div class="col-md-2 d-flex align-items-center justify-content-end">
                                                                            <input type="checkbox" id="flexCheckDefault">
                                                                        </div>
                                                                        <div class="col-md-4" style="background-color: rgb(57, 170, 68)">
                                                                            <label id="ppn_bawah_label" style="color: white">
                                                                                Rp 10.000
                                                                            </label>

                                                                            <!-- Input tersembunyi untuk mengirimkan nilai -->
                                                                            <input type="hidden" id="ppn_total" name="ppn_total" value="PPN">
                                                                        </div> --}}
                                                                        <div class="col-md-6">
                                                                            <label></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row d-flex align-items-center mb-1 ml-4">
                                                                        <div class="col-md-6" style="display: flex; align-items: center;">
                                                                            <span style="flex-grow: 1; border-bottom: 1px solid #000; margin-right: 10px;"></span>
                                                                            <span style="font-size: 24px; font-weight: bold;">+</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row d-flex align-items-center mb-1 ml-4">
                                                                        {{-- <div class="col-md-6 d-flex justify-content-center align-items-center" style="background-color: rgb(100, 176, 114);">
                                                                            <div style="color: white; display: flex; align-items: center; gap: 10px;">
                                                                                <label>Sisa Dibayar</label>
                                                                                <label id="test">10.000.000</label>
                                                                            </div>

                                                                            <!-- Input tersembunyi untuk mengirimkan nilai -->
                                                                            <input type="hidden" id="sub_total" name="sub_total">
                                                                        </div> --}}
                                                                        <div class="col-md-6 d-flex justify-content-center align-items-center" id="container_kurang_dibayar">
                                                                            <div style="color: white; display: flex; align-items: center; gap: 10px; height: 100%; justify-content: center;">
                                                                                <label id="kurang_dibayar_label"></label>
                                                                            </div>

                                                                            <!-- Input tersembunyi untuk mengirimkan nilai -->
                                                                            <input type="hidden" id="kurang_dibayar" name="kurang_dibayar">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row d-flex align-items-center mb-1 ml-4">
                                                                        <div class="col-md-6" style="display: flex; align-items: center;">
                                                                            <span style="flex-grow: 1; border-bottom: 1px solid #000; margin-right: 10px;"></span>
                                                                            <span style="font-size: 24px; font-weight: bold;">+</span>
                                                                        </div>
                                                                        <div class="col-md-3" style="display: flex; align-items: center;">
                                                                            <input type="checkbox" id="CheckMultiPayment" class="mr-2" onchange="toggleMultiPayment()">
                                                                            <span>Multi Payment</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row d-flex align-items-center mb-2">
                                                                        <div class="col-md-2" style="flex: 0 0 12.5%; max-width: 12.5%;">
                                                                            <label>Bayar (1) : </label>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="bayar1" name="bayar1" onchange="updateBankOptions('bayar1', 'bankBayar1'); updateBayar1();">
                                                                                <option value="-" disabled selected>-- Pilih --</option>
                                                                                <option value="Cash">Cash</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Debit Card">Debit Card</option>
                                                                                <option value="Credit">Credit</option>
                                                                                <option value="Transfer">Transfer</option>
                                                                                <option value="Qris">Qris</option>
                                                                                <option value="Penjamin">Penjamin</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <input type="text" class="form-control" id="uangBayar1" name="uangBayar1" placeholder="Nominal Rupiah" oninput="validateUangBayar('bayar1', 'uangBayar1'); sisaDibayar();">
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="bankBayar1" name="bankBayar1" disabled>
                                                                                <option value="-" disabled selected> </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md d-flex align-items-center">
                                                                            <label class="mr-2">Ref:</label>
                                                                            <input type="text" class="form-control" id="refInput1" name="refInput1" style="flex-grow: 1;" value="0" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row d-flex align-items-center mb-2">
                                                                        <div class="col-md-2" style="flex: 0 0 12.5%; max-width: 12.5%;" id="label_bayar2">
                                                                            <label>Bayar (2) : </label>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="bayar2" name="bayar2" disabled onchange="updateBankOptions('bayar2', 'bankBayar2'); updateBayar2();">
                                                                                <option value="-" disabled selected>-- Pilih --</option>
                                                                                <option value="Cash">Cash</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Debit Card">Debit Card</option>
                                                                                <option value="Credit">Credit</option>
                                                                                <option value="Transfer">Transfer</option>
                                                                                <option value="Qris">Qris</option>
                                                                                <option value="Penjamin">Penjamin</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <input type="text" class="form-control" id="uangBayar2" name="uangBayar2" placeholder="Nominal Rupiah" disabled oninput="validateUangBayar('bayar2', 'uangBayar2'); sisaDibayar();">
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="bankBayar2" name="bankBayar2" disabled>
                                                                                <option value="-" disabled selected> </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md d-flex align-items-center">
                                                                            <label class="mr-2">Ref:</label>
                                                                            <input type="text" class="form-control" id="refInput2" name="refInput" style="flex-grow: 1;" value="0" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row d-flex align-items-center mb-2">
                                                                        <div class="col-md-2" style="flex: 0 0 12.5%; max-width: 12.5%;" id="label_bayar3">
                                                                            <label>Bayar (3) : </label>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="bayar3" name="bayar3" disabled onchange="updateBankOptions('bayar3', 'bankBayar3'); updateBayar3(); ">
                                                                                <option value="-" disabled selected>-- Pilih --</option>
                                                                                <option value="Cash">Cash</option>
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Debit Card">Debit Card</option>
                                                                                <option value="Credit">Credit</option>
                                                                                <option value="Transfer">Transfer</option>
                                                                                <option value="Qris">Qris</option>
                                                                                <option value="Penjamin">Penjamin</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <input type="text" class="form-control" id="uangBayar3" name="uangBayar3" placeholder="Nominal Rupiah" disabled oninput="validateUangBayar('bayar3', 'uangBayar3'); sisaDibayar();">
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <select class="form-control select2bs4" style="width: 100%;" id="bankBayar3" name="bankBayar3" disabled>
                                                                                <option value="-" disabled selected> </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md d-flex align-items-center">
                                                                            <label class="mr-2">Ref:</label>
                                                                            <input type="text" class="form-control" id="refInput3" name="refInput3" style="flex-grow: 1;" value="0" disabled>
                                                                        </div>
                                                                    </div>
                                                                    {{-- <div class="form-group row d-flex align-items-center mb-1">
                                                                        <div class="col-md-12" style="display: flex; align-items: center;">
                                                                            <span style="flex-grow: 1; border-bottom: 1px solid #000; margin-right: 10px;"></span>
                                                                            <span style="font-size: 24px; font-weight: bold;">+</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row d-flex align-items-center mb-1 ml-4">
                                                                        <div class="col-md-6 d-flex justify-content-center align-items-center" id="container_kurang_dibayar">
                                                                            <div style="color: white; display: flex; align-items: center; gap: 10px; height: 100%; justify-content: center;">
                                                                                <label id="kurang_dibayar_label"></label>
                                                                            </div>

                                                                            <!-- Input tersembunyi untuk mengirimkan nilai -->
                                                                            <input type="hidden" id="kurang_dibayar" name="kurang_dibayar">
                                                                        </div>
                                                                    </div> --}}
                                                                    <div class="form-group row d-flex align-items-center mb-1 ml-4 mt-3">
                                                                        <div class="col-md-12 d-flex justify-content-end">
                                                                            <button type="button" class="btn btn-secondary mr-2" id="backButton">
                                                                                <i class="fas fa-arrow-left"></i> Kembali
                                                                            </button>
                                                                            <button type="button" class="btn btn-danger mr-2" id="deleteButton">
                                                                                <i class="fas fa-trash-alt"></i> Delete
                                                                            </button>
                                                                            <button type="submit" class="btn btn-success" id="saveButton">
                                                                                <i class="fas fa-save"></i> Simpan
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
                        </div>
                    </div>

                </div>
                <!-- /.row (main row) -->
            </form>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <div class="modal fade" id="adddoctor" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Potongan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addFormpermesion">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Jenis Potongan</label>
                                    <select class="form-control select2bs4" id="jenis" name="jenis">
                                        <option value=" " disabled selected>-- Silahkan Pilih --</option>
                                        <option value="disc">Discount</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Besar Potongan</label>
                                    <input type="text" class="form-control" id="besar_potongan" name="besar_potongan">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Uraian Potongan</label>
                                    <input type="text" class="form-control" id="uraian_potongan" name="uraian_potongan">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Poli</label>
                                    <select class="form-control select2bs4 mt-2" style="width: 100%;" id="poli_modal" name="poli_modal">
                                        <option value=" " disabled selected> -- Pilih Poli -- </option>
                                        <option value="APS">- APS -</option>
                                        @foreach ($poli as $poli)
                                            <option value="{{$poli->nama_poli}}"> {{$poli->nama_poli}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            // Apply Inputmask
            $('#besar_potongan').inputmask({
                alias: 'numeric',
                groupSeparator: '.',
                autoGroup: true,
                digits: 0,
                digitsOptional: false,
                prefix: 'Rp ',
                rightAlign: false,
                removeMaskOnSubmit: true
            });
            $('#administrasi').inputmask({
                alias: 'numeric',
                groupSeparator: '.',
                autoGroup: true,
                digits: 0,
                digitsOptional: false,
                prefix: 'Rp ',
                rightAlign: false,
                removeMaskOnSubmit: true
            });
        });
    </script>


    <style>
        /* Gaya untuk tabel luar dengan border besar dan tinggi tetap */
        .outer-table {
            width: 100%;
            height: 400px; /* Menetapkan tinggi tabel luar menjadi 400px */
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

        /* Gaya untuk header tabel agar tetap di atas */
        #kunjungan-table thead {
            background-color: #f4f4f4; /* Menambahkan latar belakang yang lebih terang untuk header */
            position: sticky; /* Membuat header tetap di atas saat menggulir */
            top: 0; /* Menjaga header tetap di atas */
            z-index: 2; /* Memberikan prioritas z-index agar tetap di atas konten */
            display: table; /* Menjaga header tetap berjajar dengan konten */
            width: calc(100% - 20px); /* Menyesuaikan lebar header dengan konten */
        }

        /* Menghilangkan border pada tabel dalam dan memberikan padding */
        #kunjungan-table td, #kunjungan-table th {
            /* border: 1px solid #ddd; Memberikan border ringan untuk sel tabel */
            border: none; /* Memberikan border ringan untuk sel tabel */
            padding: 10px; /* Memberikan ruang di dalam sel tabel dalam */
            font-size: 16px; /* Ukuran font */
        }

        /* Membatasi tinggi tabel kunjungan dan memberikan kemampuan untuk scroll */
        #kunjungan-table tbody {
            display: block; /* Membuat tbody bisa dipisah untuk scroll */
            max-height: 300px; /* Membatasi tinggi konten tabel menjadi 300px */
            overflow-y: auto; /* Menambahkan scroll vertikal jika konten melebihi max-height */
            width: 100%;
        }

        /* Menambahkan gaya untuk membuat konten tabel dalam mengisi tabel luar secara penuh */
        .outer-table td {
            vertical-align: top; /* Menjaga konten tabel dalam berada di bagian atas tabel luar */
        }

        /* Menjaga kolom tbody tetap berjajar dengan thead */
        #kunjungan-table tbody tr {
            display: table; /* Menjaga baris tbody tetap berjajar dengan header */
            width: 100%;
            table-layout: fixed; /* Menjaga lebar kolom tetap */
        }

        /* Mengatur lebar setiap kolom dalam header */ /* Kolom No */
        #kunjungan-table td:nth-child(1) {
            width: 5%;
        }
 /* Kolom Nama */
        #kunjungan-table td:nth-child(2) {
            width: 20%;
        }
 /* Kolom Harga */
        #kunjungan-table td:nth-child(3) {
            width: 15%;
        }
 /* Kolom Qty */
        #kunjungan-table td:nth-child(4) {
            width: 7%;
        }
 /* Kolom Total */
        #kunjungan-table td:nth-child(5) {
            width: 15%;
        }
 /* Kolom Dokter */
        #kunjungan-table td:nth-child(6) {
            width: 15%;
        }
 /* Kolom Date */
        #kunjungan-table td:nth-child(7) {
            width: 15%;
        }
 /* Kolom Disc */
        #kunjungan-table td:nth-child(8) {
            width: 10%;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Event klik pada baris tabel
            $('#preview-table tbody').on('click', 'tr', function() {
                // Hilangkan kelas .selected-row dari semua baris terlebih dahulu
                $('#preview-table tbody tr').removeClass('selected-row');

                // Tambahkan kelas .selected-row pada baris yang diklik
                $(this).addClass('selected-row');
            });
        });
    </script>

<script>
    $(document).ready(function() {
        // Ketika ada perubahan pada pilihan di select #perjal
        $('#perjal').change(function() {
            var selectedOption = $('#perjal option:selected'); // Ambil elemen option yang dipilih
            var tarifDokter = parseFloat(selectedOption.data('tarifdok')) || 0; // Pastikan nilai ada, default ke 0
            var tarifPerawat = parseFloat(selectedOption.data('tarifper')) || 0; // Pastikan nilai ada, default ke 0

            $('#biaya_dokter').val(tarifDokter); // Set nilai biaya dokter
            $('#biaya_perawat').val(tarifPerawat); // Set nilai biaya perawat
        });

        // Event listener untuk dropdown provider
        $('#provider').change(function() {
            var providerValue = $(this).val();
            var tarifDokter = parseFloat($('#biaya_dokter').val()) || 0; // Ambil nilai dari input biaya dokter
            var tarifPerawat = parseFloat($('#biaya_perawat').val()) || 0; // Ambil nilai dari input biaya perawat

            // Tampilkan baris sesuai provider yang dipilih
            if (providerValue === 'Dokter') {
                $('#dokter-row').show();
                $('#perawat-row').hide();
                $('#tarif_perjal').val(tarifDokter); // Total biaya hanya untuk dokter
            } else if (providerValue === 'Perawat') {
                $('#dokter-row').hide();
                $('#perawat-row').show();
                $('#tarif_perjal').val(tarifPerawat); // Total biaya hanya untuk perawat
            } else if (providerValue === 'Dokter & Perawat') {
                $('#dokter-row').show();
                $('#perawat-row').show();
                $('#tarif_perjal').val(tarifDokter + tarifPerawat); // Total biaya untuk dokter dan perawat
            } else {
                $('#dokter-row').hide();
                $('#perawat-row').hide();
                $('#tarif_perjal').val(''); // Kosongkan jika tidak ada pilihan
            }
        });

        const faktur_inti = @json($data);
        const layananMandiri = @json($noFakturLayananMandiri);

        const kodeFakturInti = faktur_inti?.kode_faktur ?? layananMandiri ?? "TIDAK ADA DATA";
        console.log("Kode Faktur Inti:", kodeFakturInti);

        document.getElementById("kode_faktur_inti").value = kodeFakturInti;
    });

    // Data dari Laravel yang di-encode sebagai JSON
    const prebayarTemp = [];
    const layananTemp = [];

    const faktur = @json($data);  // Data faktur utama
    const layananMandiri = @json($noFakturLayananMandiri); // Data layanan mandiri
    const layanan = @json($dataLayanan); // Data layanan terkait faktur

    console.log("Faktur Inti:", faktur);
    console.log("Layanan Mandiri:", layananMandiri);
    console.log("Data Layanan:", layanan);

    // Cek apakah faktur memiliki data atau tidak
    if (faktur && faktur.kode_faktur) {
        console.log("Menggunakan data faktur utama.");

        // Pastikan faktur.prebayar ada sebelum diproses
        if (faktur.prebayar) {
            dataOtomatis(faktur.prebayar, faktur.dokter);
        } else {
            console.warn("Faktur tidak memiliki data prebayar.");
        }

        // Pastikan layanan ada sebelum diproses
        if (layanan) {
            dataOtomatisLayanan(layanan);
        } else {
            console.warn("Faktur tidak memiliki data layanan.");
        }

    } else if (layananMandiri) {
        console.log("Menggunakan data layanan mandiri.");

        // Pastikan layananMandiri dan layanan tidak kosong
        if (layananMandiri || layanan) {
            dataOtomatisLayanan(layananMandiri, layanan);
        } else {
            console.warn("Layanan Mandiri tidak ditemukan.");
        }

    } else {
        console.warn("Tidak ada data faktur atau layanan mandiri yang ditemukan.");
    }

    // Fungsi untuk mengisi tabel dan menyimpan data sementara
    function dataOtomatisLayanan(layananMandiri, layanan) {
        const tableBody = document.querySelector("#kunjungan-table tbody");
        const nomorFakturLayanan = faktur?.kode_faktur ?? layananMandiri;  // Gantilah dengan nomor faktur yang sesuai

        console.log("Data layanan sebelum iterasi:", layanan);

        // Cek apakah layanan adalah array
        if (!Array.isArray(layanan)) {
            console.warn("Layanan bukan array, cek kembali data yang diterima:", layanan);
            return;
        }

        // Validasi jika layanan kosong atau undefined
        if (!layanan || layanan.length === 0) {
            console.warn("Layanan tidak ditemukan atau kosong.");
            return; // Berhenti jika data kosong
        }

        // Iterasi data prebayar
        layanan.forEach((item, index) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${index + 1}</td>
                <td>${item.jenis_tindakan || "-"}</td>
                <td>${item.total_biaya || 0}</td>
                <td>1</td>
                <td>${item.total_biaya || 0}</td>
                <td>-</td>
                <td>${new Date().toISOString().split('T')[0]}</td>
                <td></td>
            `;
            tableBody.appendChild(tr);
            const newLayanan = {
                kodeFaktur: nomorFakturLayanan,
                nama_tambahan: item.jenis_tindakan,
                nama_dokter: item.id_dokter || "-",
                harga_dokter: item.b_dokter,
                nama_perawat: item.id_perawat || "-",
                harga_perawat: item.b_perawat,
                provide: item.provider,
                harga: item.total_biaya,
                kuantitas: "1",
                total_harga: item.total_biaya,
                tanggal: new Date().toISOString().split('T')[0],
            };
            layananTemp.push(newLayanan);
            console.log(layananTemp);
        });

        console.log("Tabel berhasil diperbarui.");

        // Memperbarui subtotal, potongan, total sementara dan tagihan
        updateSubTotalHarga();
        updateRowNumbers();
        updatePotongan();
        updateTotalSementara();
        fungsiTagihan();
        sisaDibayar()

        // Gabungkan layananTemp dan prebayarTemp
        const dataUtuhTemp = [...layananTemp, ...prebayarTemp];  // Menggunakan spread operator untuk menggabungkan

        // Simpan data gabungan ke dalam elemen hidden #data_faktur
        const dataFakturElement = document.getElementById("data_faktur");
        if (dataFakturElement) {
            const jsonData = JSON.stringify(dataUtuhTemp);
            dataFakturElement.value = jsonData;
            console.log("Data gabungan berhasil disimpan ke data_faktur:", jsonData);
        } else {
            console.warn("Elemen #data_faktur tidak ditemukan.");
        }
    }

    // Fungsi untuk mengisi tabel dan menyimpan data sementara
    function dataOtomatis(prebayarData, dokter) {
        const tableBody = document.querySelector("#kunjungan-table tbody");

        // Iterasi data prebayar
        prebayarData.forEach((item, index) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${index + 1}</td>
                <td>${item.nama_obat}</td>
                <td>${item.harga}</td>
                <td>${item.kuantitas}</td>
                <td>${item.total_harga}</td>
                <td>${dokter}</td>
                <td>${item.tanggal}</td>
                <td></td>
            `;
            tableBody.appendChild(tr);

            // Menambahkan item ke array sementara
            prebayarTemp.push(item);
            console.log(prebayarTemp);
        });

        // Memperbarui subtotal, potongan, total sementara dan tagihan
        updateSubTotalHarga();
        updateRowNumbers();
        updatePotongan();
        updateTotalSementara();
        fungsiTagihan();
        sisaDibayar()

        // Gabungkan prebayarTemp dan layananTemp
        const dataUtuhTemp = [...layananTemp, ...prebayarTemp];  // Menggunakan spread operator untuk menggabungkan

        // Simpan data gabungan ke dalam elemen hidden #data_faktur
        document.getElementById("data_faktur").value = JSON.stringify(dataUtuhTemp);
    }

    // // Panggil fungsi untuk mengisi tabel dengan data dari Laravel
    // dataOtomatis(faktur.prebayar, faktur.dokter);
    // dataOtomatisLayanan(layanan);

    // Fungsi untuk menambahkan data manual ke dalam tabel dan data_faktur
    function dataManual(jenis, besarPotongan, uraianPotongan, poli, nomorFaktur) {
        const tableBody = document.querySelector("#kunjungan-table tbody");

        // Membuat row baru untuk data
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td></td> <!-- Kolom No akan diisi otomatis -->
            <td>${uraianPotongan}</td>
            <td>${besarPotongan}</td>
            <td>1</td>
            <td>${besarPotongan}</td>
            <td>-</td>
            <td>${new Date().toISOString().split('T')[0]}</td>
            <td>Disc</td>
        `;

        // Menambahkan row baru ke dalam tabel
        tableBody.appendChild(tr);

        // Mengupdate nomor urut pada kolom pertama
        updateRowNumbers();

        // Mengupdate subtotal, potongan, total sementara dan tagihan
        updatePotongan();
        updateTotalSementara();
        fungsiTagihan();
        sisaDibayar()

        // Menambahkan data yang dimasukkan ke dalam data_faktur
        const dataFaktur = JSON.parse(document.getElementById("data_faktur").value);
        const newData = {
            kodeFaktur: nomorFaktur,
            nama_tambahan: uraianPotongan,
            harga: besarPotongan,
            total_harga: besarPotongan,
            diskon: "Disc",
            tanggal: new Date().toISOString().split('T')[0], // Tanggal saat ini
        };
        dataFaktur.push(newData);
        console.log(dataFaktur);

        // Menyimpan kembali ke elemen #data_faktur
        document.getElementById("data_faktur").value = JSON.stringify(dataFaktur);
    }

    // Event listener untuk form submission
    document.getElementById("addFormpermesion").addEventListener("submit", function(event) {
        event.preventDefault();

        // Ambil nilai dari form modal
        const jenis = document.getElementById("jenis").value;
        const RawbesarPotongan = document.getElementById("besar_potongan").value;
        const besarPotongan = RawbesarPotongan.replace('Rp ', '').replace(/\./g, ''); // Remove "Rp" and "."
        const uraianPotongan = document.getElementById("uraian_potongan").value;
        const poli = document.getElementById("poli_modal").value;

        const nomorFaktur = faktur?.kode_faktur ?? layananMandiri;  // Gantilah dengan nomor faktur yang sesuai

        // Validasi input
        if (!jenis || !besarPotongan || !uraianPotongan || !poli) {
            alert("Semua kolom harus diisi.");
            return;
        }

        // Menambahkan data ke dalam tabel dan menyimpan ke data_faktur
        dataManual(jenis, besarPotongan, uraianPotongan, poli, nomorFaktur);

        // Menutup modal setelah data ditambahkan
        $('#adddoctor').modal('hide');
    });

    function tambahanTindakan() {
        const tableBody = document.querySelector("#kunjungan-table tbody");
        const nomorFakturPerjal = faktur?.kode_faktur ?? layananMandiri;  // Gantilah dengan nomor faktur yang sesuai
        const tindakanPerjal = document.getElementById("perjal").value;
        const tarifPerjal = document.getElementById("tarif_perjal").value;
        const qtyPerjal = document.getElementById("qty_perjal").value;
        const provider = document.getElementById("provider").value;
        const doctor = document.getElementById("dokter_tindakan").value;
        const biayaDok = document.getElementById("biaya_dokter").value;
        const perawat = document.getElementById("perawat_tindakan").value;
        const biayaPer = document.getElementById("biaya_perawat").value;

        let totalTarif = (tarifPerjal * qtyPerjal).toString();

        // Membuat row baru untuk data
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td></td> <!-- Kolom No akan diisi otomatis -->
            <td>${tindakanPerjal}</td>
            <td>${tarifPerjal}</td>
            <td>${qtyPerjal}</td>
            <td>${totalTarif}</td>
            <td>-</td>
            <td>${new Date().toISOString().split('T')[0]}</td>
            <td></td>
        `;

        // Menambahkan row baru ke dalam tabel
        tableBody.appendChild(tr);

        // Mengupdate nomor urut pada kolom pertama
        updateRowNumbers();

        // Mengupdate subtotal, potongan, total sementara dan tagihan
        updateSubTotalHarga();
        updatePotongan();
        updateTotalSementara();
        fungsiTagihan();
        sisaDibayar()

        // Menambahkan data yang dimasukkan ke dalam data_faktur
        const dataFakturPerjal = JSON.parse(document.getElementById("data_faktur").value);
        const newDataPerjal = {
            kodeFaktur: nomorFakturPerjal,
            nama_tambahan: tindakanPerjal,
            nama_dokter: doctor || "-",
            harga_dokter: biayaDok || "-",
            nama_perawat: perawat || "-",
            harga_perawat: biayaPer || "-",
            provide: provider,
            harga: tarifPerjal,
            kuantitas: qtyPerjal,
            total_harga: totalTarif,
            tanggal: new Date().toISOString().split('T')[0], // Tanggal saat ini
        };
        dataFakturPerjal.push(newDataPerjal);
        console.log(dataFakturPerjal);

        // Menyimpan kembali ke elemen #data_faktur
        document.getElementById("data_faktur").value = JSON.stringify(dataFakturPerjal);

        // Reset nilai elemen input dan select
        $('#perjal').val("").trigger("change"); // Reset dropdown ke default
        $('#tarif_perjal').val(""); // Kosongkan input tarif
        $('#qty_perjal').val(""); // Kosongkan input qty
    }

    // Fungsi untuk mengupdate nomor urut pada tabel
    function updateRowNumbers() {
        const rows = document.querySelectorAll("#kunjungan-table tbody tr");
        rows.forEach((row, index) => {
            row.cells[0].textContent = index + 1; // Kolom pertama diisi dengan nomor urut
        });
    }

    // Fungsi untuk menghitung ulang total harga (Subtotal)
    function updateSubTotalHarga() {
        let totalHarga = 0;

        // Ambil semua baris dalam tabel
        const rows = document.querySelectorAll("#kunjungan-table tbody tr");

        rows.forEach(row => {
            const discount = row.cells[7].textContent.trim();  // Mengambil nilai dari kolom diskon (kolom ke-7)

            // Jika ada nilai pada kolom diskon, abaikan perhitungan total harga untuk baris tersebut
            if (discount !== '-' && discount !== '') {
                return;
            }

            // Mengambil total harga dari kolom 4 (td ke-4)
            const totalHargaItem = parseFloat(row.cells[4].textContent.replace('Rp ', '').replace(/\./g, '')) || 0;

            // Menambahkan nilai total harga item ke totalHarga
            totalHarga += totalHargaItem;
        });

        // Perbarui label total harga
        document.getElementById("sub_total_label").textContent = `Rp ${totalHarga.toLocaleString()}`;
        document.getElementById("sub_total").value = totalHarga;
    }

    // Fungsi untuk menghitung total potongan
    function updatePotongan() {
        let totalPotongan = 0;

        // Ambil semua baris dalam tabel
        const rows = document.querySelectorAll("#kunjungan-table tbody tr");

        rows.forEach(row => {
            const discount = row.cells[7].textContent.trim();  // Mengambil nilai dari kolom diskon (kolom ke-7)

            // Jika ada nilai pada kolom diskon, tambahkan ke total potongan
            if (discount !== '-' && discount !== '') {
                const totalPotonganSementara = parseFloat(row.cells[4].textContent.replace('Rp ', '').replace(/\./g, '')) || 0;
                totalPotongan += totalPotonganSementara;
            }
        });

        // Jika tidak ada potongan, set 0
        if (totalPotongan === 0) {
            document.getElementById("potongan_label").textContent = `Rp 0`;
            document.getElementById("potongan").value = 0;
        } else {
            // Perbarui label total potongan
            document.getElementById("potongan_label").textContent = `Rp ${totalPotongan.toLocaleString()}`;
            document.getElementById("potongan").value = totalPotongan;
        }
    }

    // Fungsi untuk menghitung total sementara
    function updateTotalSementara() {
        const subTotal = parseFloat(document.getElementById("sub_total").value) || 0;
        const potongan = parseFloat(document.getElementById("potongan").value) || 0;

        const totalSementara = subTotal - potongan;

        // Perbarui label total sementara
        document.getElementById("total_sementara_label").textContent = `Rp ${totalSementara.toLocaleString()}`;
        document.getElementById("total_sementara").value = totalSementara;
    }

    // Fungsi untuk menghitung tagihan total
    function fungsiTagihan() {
        let tagihan_isi = 0;

        // Ambil nilai dari input dan hapus format mata uang
        let administrasi = parseInt(document.getElementById("administrasi")?.value.replace('Rp ', '').replace(/\./g, '')) || 0;
        let materai = parseInt(document.getElementById("materai")?.value) || 0;
        let totalSementara = parseInt(document.getElementById("total_sementara")?.value) || 0;

        // Hitung total tagihan
        tagihan_isi = totalSementara + administrasi + materai;

        // Perbarui input dan label
        if (document.getElementById("tagihan")) {
            document.getElementById("tagihan").value = tagihan_isi;
        }
        if (document.getElementById("tagihan_label")) {
            document.getElementById("tagihan_label").textContent = `Rp ${tagihan_isi.toLocaleString()}`;
        }
        if (document.getElementById("tagihan_label_kecil")) {
            document.getElementById("tagihan_label_kecil").textContent = `Rp ${tagihan_isi.toLocaleString()}`;
        }
    }

    // Ambil elemen checkbox dan elemen pembayaran
    const multiPaymentCheckbox = document.getElementById("CheckMultiPayment");
    let bayar1 = document.getElementById('bayar1');
    let bayar2 = document.getElementById("bayar2");
    let bayar3 = document.getElementById("bayar3");
    const uangBayar1 = document.getElementById('uangBayar1');
    const uangBayar2 = document.getElementById("uangBayar2");
    const uangBayar3 = document.getElementById('uangBayar3');
    const labelBayar2 = document.getElementById("label_bayar2");
    const labelBayar3 = document.getElementById("label_bayar3");
    const refInput1 = document.getElementById('refInput1');
    const refInput2 = document.getElementById('refInput2');
    const refInput3 = document.getElementById('refInput3');
    const bankBayar1 = document.getElementById('bankBayar1');
    const bankBayar2 = document.getElementById('bankBayar2');
    const bankBayar3 = document.getElementById('bankBayar3');

    labelBayar2.style.color = "gray";
    labelBayar3.style.color = "gray";

    function toggleMultiPayment() {
        if (multiPaymentCheckbox.checked) {
            // Jika checkbox di-check, aktifkan Bayar 2 dan Bayar 3, ubah warna label
            bayar2.disabled = false;
            bayar3.disabled = false;
            uangBayar2.disabled = false;
            uangBayar3.disabled = false;
            labelBayar2.style.color = "black";
            labelBayar3.style.color = "black";
        } else {
            // Jika checkbox tidak di-check, nonaktifkan Bayar 2 dan Bayar 3, ubah warna label
            bayar2.disabled = true;
            bayar3.disabled = true;
            $(bayar2).val("-").trigger("change");
            $(bayar3).val("-").trigger("change");
            uangBayar2.disabled = true;
            uangBayar3.disabled = true;
            bankBayar2.disabled = true;
            bankBayar3.disabled = true;
            refInput2.disabled = true;
            refInput3.disabled = true;
            labelBayar2.style.color = "gray";
            labelBayar3.style.color = "gray";
            $(uangBayar2).val(""); // Set nilai uangBayar2 ke
            $(uangBayar3).val(""); // Set nilai uangBayar3 ke
        }

        sisaDibayar();
    };

    function validateUangBayar(bayarId, uangBayarId) {
        const bayarElement = document.getElementById(bayarId);
        const uangBayarElement = document.getElementById(uangBayarId);

        if (bayarElement.value === "-") {
            alert("Silakan pilih metode pembayaran terlebih dahulu.");
            uangBayarElement.value = ""; // Kosongkan input uangBayar terkait
        }
    }


    function updateBayar1() {
        const selectedValue = bayar1.value;

        if (selectedValue === 'Cash') {
            $(bankBayar1).val("-").trigger("change");
            bankBayar1.disabled = true;
            refInput1.disabled = true;
        } else {
            bankBayar1.disabled = false;
            refInput1.disabled = false;
        }
    }

    function updateBayar2() {
        const selectedValue = bayar2.value;

        if (selectedValue === 'Cash') {
            $(bankBayar2).val("-").trigger("change");
            bankBayar2.disabled = true;
            refInput2.disabled = true;
        } else {
            bankBayar2.disabled = false;
            refInput2.disabled = false;
        }
    }

    function updateBayar3() {
        const selectedValue = bayar3.value;

        if (selectedValue === 'Cash') {
            $(bankBayar3).val("-").trigger("change");
            bankBayar3.disabled = true;
            refInput3.disabled = true;
        } else {
            bankBayar3.disabled = false;
            refInput3.disabled = false;
        }
    }

    function sisaDibayar() {
        let sisaDibayar = 0;

        // Ambil nilai tagihan dan pembayaran
        let tagihan = parseInt(document.getElementById("tagihan")?.value.replace('Rp ', '').replace(/\./g, '')) || 0;
        let pembayaran1 = parseInt(document.getElementById("uangBayar1")?.value.replace('Rp ', '').replace(/\./g, '')) || 0;
        let pembayaran2 = parseInt(document.getElementById("uangBayar2")?.value.replace('Rp ', '').replace(/\./g, '')) || 0;
        let pembayaran3 = parseInt(document.getElementById("uangBayar3")?.value.replace('Rp ', '').replace(/\./g, '')) || 0;

        // Hitung sisa pembayaran
        sisaDibayar = tagihan - (pembayaran1 + pembayaran2 + pembayaran3);

        // Debug log untuk memastikan nilai
        console.log("Tagihan:", tagihan);
        console.log("Pembayaran 1:", pembayaran1);
        console.log("Pembayaran 2:", pembayaran2);
        console.log("Pembayaran 3:", pembayaran3);
        console.log("Sisa Dibayar:", sisaDibayar);

        // Ambil elemen untuk label dan container
        const kurangDibayarLabel = document.getElementById("kurang_dibayar_label");
        const kurangDibayarContainer = document.getElementById("container_kurang_dibayar");

        if (kurangDibayarLabel && kurangDibayarContainer) {
            if (sisaDibayar === 0) {
                // Lunas
                kurangDibayarLabel.textContent = "Lunas Sayangku <3";
                kurangDibayarContainer.style.backgroundColor = "green"; // Ubah warna latar ke hijau
            } else if (sisaDibayar < 0) {
                // Kembalian
                kurangDibayarLabel.textContent = `Kembalian Rp ${(Math.abs(sisaDibayar)).toLocaleString()}`;
                kurangDibayarContainer.style.backgroundColor = "blue"; // Ubah warna latar ke biru
            } else {
                // Kurang dibayar
                kurangDibayarLabel.textContent = `Kurang Dibayar Rp ${sisaDibayar.toLocaleString()}`;
                kurangDibayarContainer.style.backgroundColor = "red"; // Ubah warna latar ke merah
            }
        }

        // Set nilai tersembunyi untuk pengiriman data
        const kurangDibayarInput = document.getElementById("kurang_dibayar");
        if (kurangDibayarInput) {
            kurangDibayarInput.value = sisaDibayar;
        }
    }

    const bankOptions = [
        @foreach ($bank as $bank1)
        { value: "{{ $bank1->nama }}", label: "{{ $bank1->nama }}", type: "bank" },
        @endforeach
    ];

    const penjaminOptions = [
        @foreach ($penjab as $penjab1)
        { value: "{{ $penjab1->nama }}", label: "{{ $penjab1->nama }}", type: "penjamin" },
        @endforeach
    ];

    // Fungsi dinamis untuk mengupdate dropdown
    function updateBankOptions(bayarId, bankBayarId) {
        const bayar = document.getElementById(bayarId).value;
        const bankBayar = document.getElementById(bankBayarId);
        bankBayar.innerHTML = ""; // Reset isi dropdown
        bankBayar.disabled = false; // Aktifkan dropdown

        let options = [];
        if (bayar === "Penjamin") {
            options = penjaminOptions;
        } else {
            options = bankOptions;
        }

        // Tambahkan opsi ke dropdown
        options.forEach(option => {
            const opt = document.createElement("option");
            opt.value = option.value;
            opt.textContent = option.label;
            bankBayar.appendChild(opt);
        });

        // Tambahkan placeholder
        const placeholder = document.createElement("option");
        placeholder.value = "-";
        placeholder.textContent = " ";
        placeholder.disabled = true;
        placeholder.selected = true;
        bankBayar.insertBefore(placeholder, bankBayar.firstChild);

        // Jika tidak ada opsi, matikan dropdown
        if (options.length === 0) {
            bankBayar.disabled = true;
        }
    }


</script>









@endsection
