@extends('template.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="mt-3 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 card-title">Histori Pelayanan Rawat Jalan</h3>
                        </div>

                        <style>
                            .indicator {
                                display: inline-block;
                                width: 15px;
                                height: 15px;
                                border-radius: 50%;
                                background-color: transparent;
                                border: 1px solid #ccc;
                            }

                            .indicator.true {
                                background-color: green;
                                border: none;
                            }

                            .indicator.false {
                                background-color: transparent;
                                border: 1px solid #ccc;
                            }
                        </style>

                        <!-- /.card-header -->
                        <div class="card-body" id="kunjungan-section">
                            <table id="kunjungan-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>ID. Kunjungan</th>
                                        <th>Antrian</th>
                                        <th>Poliklinik</th>
                                        <th>Dokter</th>
                                        <th>Penjamin</th>
                                        <th>No. Asuransi</th>
                                        <th>Tgl. Kunjungan</th>
                                        <th>Status</th>
                                        <th>Status info</th>
                                        <th>Status Lanjutan</th>
                                        <th width="10%">Pilihan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        use Carbon\Carbon;
                                        $today = Carbon::today()->format('Y-m-d');
                                    @endphp

                                    @foreach ($rajal->where('tgl_kunjungan', $today) as $data)
                                        <tr>
                                            <td>{{ $data->no_rm }}</td>
                                            <td>{{ $data->nama_pasien }}</td>
                                            <td>{{ $data->no_rawat }}</td>
                                            <td>{{ $data->nomor_antrean }}</td>
                                            <td>{{ $data->poli->nama_poli }}</td>
                                            <td>{{ $data->doctor->nama_dokter }}</td>
                                            <td>{{ $data->penjab->pj }}</td>
                                            <td>{{ $data->pasien->no_bpjs ?? '' }}</td>
                                            <td>{{ $data->tgl_kunjungan }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="indicator {{ $data->regis ? 'true' : 'false' }}"
                                                    title="{{ $data->regis ? 'Data tersedia' : 'Data tidak tersedia' }}">
                                                </span>
                                                <span
                                                    class="indicator {{ $data->SOAP ? 'true' : 'false' }}"
                                                    title="{{ $data->SOAP ? 'SOAP tersedia' : 'SOAP tidak tersedia' }}">
                                                </span>
                                                <span
                                                    class="indicator {{ $data->obat ? 'true' : 'false' }}"
                                                    title="{{ $data->obat ? 'Obat tersedia' : 'Obat tidak tersedia' }}">
                                                </span>
                                            </td>

                                            <td>{{ $data->status }}</td>
                                            <td>{{ $data->status_lanjut }}</td>
                                            <td class="text-center align-middle">
                                                <div class="btn-container d-flex justify-content-center">
                                                    <button type="button" class="btn btn-danger btn-sm mr-2 panggil-btn" data-regis="{{ $data->no_reg }}" data-provied="{{ $data->pasien->kodeprovide ?? null }}" data-rm="{{ $data->no_rm }}" data-poli="{{ $data->poli->kode_poli }}" title="Hapus Data">
                                                        Panggil
                                                    </button>
                                                    <!-- Form Hapus -->
                                                    <form action="{{ route('rajal.delete', $data->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm mr-2" title="Hapus Data">
                                                            Hapus
                                                        </button>
                                                    </form>

                                                    <!-- Dropdown Menu -->
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Menu
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                            <a class="dropdown-item" href="{{ route('layanan.rawat-jalan.rme.index',['reg' => base64_encode($data->no_rawat) ]) }}">
                                                                <i class="fas fa-file-medical-alt"></i> Data RME
                                                            </a>
                                                            <a class="dropdown-item" href="{{ route('layanan.rawat-jalan.soap-dokter.index',['norm' => base64_encode($data->no_rawat) ]) }}">
                                                                <i class="fas fa-file-medical-alt"></i> SOAP & Pemeriksaan
                                                            </a>
                                                            <a class="dropdown-item" href="{{ route('layanan.rawat-jalan.soap-dokter.index.tindakan',['norm' => base64_encode($data->no_rawat) ]) }}">
                                                                <i class="fas fa-stethoscope"></i> Layanan & Tindakan
                                                            </a>
                                                            <a class="dropdown-item" href="{{ route('layanan.rawat-jalan.soap-dokter.index.berkas.digital',['norm' => $data->no_rm ]) }}">
                                                                <i class="fas fa-folder-open"></i> Berkas Digital
                                                            </a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#statusRawatModal" data-status="{{ $data->status }}" data-id="{{ $data->no_rm }}">
                                                                <i class="fas fa-hospital-user"></i> Status Rawat
                                                            </a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#statusLanjutModal"
                                                                data-norm="{{ $data->no_rm }}"
                                                                data-nama="{{ $data->nama_pasien }}"
                                                                data-poliid="{{ $data->poli_id }}"
                                                                data-doctorid="{{ $data->doctor_id }}"
                                                                data-penjabid="{{ $data->penjab_id }}"
                                                                data-alamat="{{ $data->pasien->Alamat ??  '-' }}"
                                                                data-telepon="{{ $data->telepon }}"
                                                                data-norawat="{{ $data->no_rawat }}"
                                                                data-rujuk="{{ $data->pasien->no_bpjs }}">
                                                                <i class="fas fa-arrow-right"></i> Status Lanjut
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <style>
                                                .btn-container {
                                                    gap: 10px; /* Spacing between buttons */
                                                }
                                                .btn-group .dropdown-menu {
                                                    min-width: 150px; /* Adjust the width of the dropdown */
                                                }
                                            </style>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<!-- /.content-wrapper -->

<div class="modal fade" id="statusRawatModal" tabindex="-1" role="dialog" aria-labelledby="statusRawatModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusRawatModalLabel">Status Rawat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="statusForm">
                    <input type="hidden" name="no_rm" id="no_rm">
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="berkasDikirim" value="Berkas Dikirim">
                            <label class="form-check-label" for="berkasDikirim">Berkas Dikirim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="berkasDiterima" value="Berkas Diterima">
                            <label class="form-check-label" for="berkasDiterima">Berkas Diterima</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="belumPeriksa" value="Belum Periksa">
                            <label class="form-check-label" for="belumPeriksa">Belum Periksa</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="sudahPeriksa" value="Sudah Periksa">
                            <label class="form-check-label" for="sudahPeriksa">Sudah Periksa</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="batalPeriksa" value="Batal Periksa">
                            <label class="form-check-label" for="batalPeriksa">Batal Periksa</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="pasienDirujuk" value="Pasien Dirujuk">
                            <label class="form-check-label" for="pasienDirujuk">Pasien Dirujuk</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="meninggal" value="Meninggal">
                            <label class="form-check-label" for="meninggal">Meninggal</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="dirawat" value="Dirawat">
                            <label class="form-check-label" for="dirawat">Dirawat</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="pulangPaksak" value="Pulang Paksa">
                            <label class="form-check-label" for="pulangPaksak">Pulang Paksa</label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="okButton">Ok</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="statusLanjutModal" tabindex="-1" role="dialog" aria-labelledby="statusLanjutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusLanjutModalLabel">Status Lanjut</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6 class="card-title">No RM</h6>
                                <p id="infoNoRM" class="card-text">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6 class="card-title">Nama Pasien</h6>
                                <p id="infoNama" class="card-text">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 1 -->
                <div class="step" id="step1">
                    <p>Apakah Pasien Ingin Dilakukan Rujukan?</p>
                </div>

                <!-- Step 2 -->
                <div class="step" id="step2" style="display: none;">
                    <div class="form-group">
                        <label>Jenis Rujukan</label>
                        <select id="jenis_rujukan" name="jenis_rujukan" class="form-control select2bs4 ">
                            <option value="">-- Pilih --</option>
                            <option value="SEHAT">Rujukan Sehat</option>
                            <option value="SAKIT">Rujukan Sakit</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tujukan</label>
                        <select id="tujukan" name="tujukan" class="form-control select2bs4 ">
                            <option value="">-- Pilih --</option>
                            <option value="VERTIKAL">Vertikal</option>
                            <option value="HORIZONTAL">Horizontal</option>
                        </select>
                    </div>
                </div>

                <!-- Step 3 - Kondisi Rujukan -->
                <div class="step" id="step3" style="display: none;">
                    <div class="form-group" id="pilihRujukanWrapper">
                        <label>Pilih Rujukan</label>
                        <select id="status_ljt" name="status_ljt" class="form-control select2bs4 ">
                            <option value="">-- Pilih --</option>
                            <option value="RJRS_KUHUS">Rujukan Khusus</option>
                            <option value="RJRS">Rujukan Spesialis</option>
                        </select>
                    </div>

                    <div class="form-group d-none" id="horizontalOptions">
                        <label>Pilih Opsi Horizontal</label>
                        <select id="horizontalSelection" name="horizontalSelection" class="form-control select2bs4">
                            <option value="">-- Pilih Opsi --</option>
                            <option value="NON_KAPITASI">Pelayanan Tindakan Non-Kapitasi</option>
                            <option value="LABORATORIUM">Pelayanan Laboratorium</option>
                            <option value="PROGRAM">Pelayanan Program</option>
                            <option value="KACAMATA">Rujukan Kacamata</option>
                        </select>
                    </div>
                </div>

                <!-- Step 4 -->
                <div id="step4" class="step" style="display: none;">
                    <div id="step4Khusus" class="step4-input d-none">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="husus">husus</label>
                                    <select id="husus" name="husus" class="form-control select2bs4 ">
                                        <option value="">-- Pilih Spesialis --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="subspesialisshususWrapper" style="display: none;">
                                    <label for="subspesialishusus">subspesialishusus</label>
                                    <select id="subspesialishusus" name="subspesialishusus" class="form-control select2bs4 ">
                                        <option value="">-- Pilih Subspesialis --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tglRujukan">Tanggal Rujukan</label>
                            <div class="input-group">
                                <input type="date" id="tglRujukan" name="tglRujukan" class="form-control">
                                <div class="input-group-append">
                                    <button type="button" id="cariProviderhusus" class="btn btn-primary">Cari Provider</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="ProviderWrapperhusus" style="display: none;">
                            <label for="Providerhusus">Provider Husus</label>
                            <select id="Providerhusus" name="Providerhusus" class="form-control select2bs4 ">
                                <option value="">-- Pilih Provider --</option>
                            </select>
                        </div>

                        <input type="hidden" id="DataProvidernamahusus" name="DataProvidernamahusus">
                        <input type="hidden" id="DataProvideralamathusus" name="DataProvideralamathusus">
                        <input type="hidden" id="DataProvidertelphusus" name="DataProvidertelphusus">
                    </div>

                    <div id="step4Spesialis" class="step4-input d-none">
                        <div class="form-group">
                            <input type="checkbox" id="enableSarana">
                            <label for="enableSarana">Aktifkan Pilihan Sarana</label>
                        </div>

                        <div class="form-group" id="saranaWrapper" style="display: none;">
                            <label for="sarana">Sarana</label>
                            <select id="sarana" name="sarana" class="form-control select2bs4 ">
                                <option value="">-- Pilih Sarana --</option>
                                <option value="null">Kosong</option>
                                @foreach ($sarana as $datasarana)
                                    <option value="{{ $datasarana->kode }}">{{ $datasarana->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="kdTacc">Kategori Rujukan</label>
                                <select id="kdTacc" name="kdTacc" class="form-control select2bs4 ">
                                    <option value="">-- Pilih --</option>
                                    <option value="-1">Tanpa Alasan</option>
                                    <option value="1">Time</option>
                                    <option value="2">Age</option>
                                    <option value="3">Complication</option>
                                    <option value="4">Comorbidity</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="nmTacc">Nama Kategori</label>
                                <input type="text" id="nmTacc" name="nmTacc" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alasanTacc">Alasan Rujukan</label>
                            <input type="text" id="alasanTacc" name="alasanTacc" class="form-control" placeholder="Masukkan alasan rujukan">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="spesialis">Spesialis</label>
                                    <select id="spesialis" name="spesialis" class="form-control select2bs4 ">
                                        <option value="">-- Pilih Spesialis --</option>
                                        @foreach ($spesialis as $dataspesialis)
                                            <option value="{{ $dataspesialis->kode }}">{{ $dataspesialis->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="subspesialisWrapper" style="display: none;">
                                    <label for="subspesialis">Subspesialis</label>
                                    <select id="subspesialis" name="subspesialis" class="form-control select2bs4 ">
                                        <option value="">-- Pilih Subspesialis --</option>
                                        @foreach ($subspesiali as $datasubspesiali)
                                            <option value="{{ $datasubspesiali->kode }}" data-kode-spesialis="{{ $datasubspesiali->kode_spesialis }}">
                                                {{ $datasubspesiali->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                        <!-- Input Tanggal & Tombol Cari -->
                        <div class="form-group">
                            <label for="tglRujukanspesial">Tanggal Rujukan</label>
                            <div class="input-group">
                                <input type="date" id="tglRujukanspesial" name="tglRujukanspesial" class="form-control">
                                <div class="input-group-append">
                                    <button type="button" id="cariProvider" class="btn btn-primary">Cari Provider</button>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown Provider -->
                        <div class="form-group" id="ProviderWrapper" style="display: none;">
                            <label for="Provider">Provider</label>
                            <select id="Provider" name="Provider" class="form-control select2bs4 ">
                                <option value="">-- Pilih Provider --</option>
                            </select>
                        </div>

                        <input type="hidden" id="DataProvidernama" name="DataProvidernama">
                        <input type="hidden" id="DataProvideralamat" name="DataProvideralamat">
                        <input type="hidden" id="DataProvidertelp" name="DataProvidertelp">
                    </div>

                    <div id="step4Horizontal" class="step4-input d-none">
                        <label for="jenisPelayanan">Jenis Pelayanan</label>
                        <select id="jenisPelayanan" class="form-control">
                            <option value="">-- Pilih Pelayanan --</option>
                            <option value="Non-Kapitasi">Pelayanan Non-Kapitasi</option>
                            <option value="Laboratorium">Pelayanan Laboratorium</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" id="prevButton">Previous</button>
                <button type="button" class="btn btn-primary" id="nextButton">Next</button>
                <button type="button" class="btn btn-primary" id="saveButton">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var currentStep = 1;
        var totalSteps = 4;

        const spesialisList = ["IGD", "HDL", "JIW", "KLT", "PAR", "KEM", "RAT", "HIV", "THA", "HEM"];
        const subSpesialisList = [
            { kdSubSpesialis: "3", nmSubSpesialis: "PENYAKIT DALAM" },
            { kdSubSpesialis: "8", nmSubSpesialis: "HEMATOLOGI - ONKOLOGI MEDIK" },
            { kdSubSpesialis: "26", nmSubSpesialis: "ANAK" },
            { kdSubSpesialis: "30", nmSubSpesialis: "ANAK HEMATOLOGI ONKOLOGI" }
        ];

        function populateSpesialis() {
            let spesialisDropdown = $('#husus');
            spesialisDropdown.empty().append('<option value="">-- Pilih Spesialis --</option>');
            spesialisList.forEach(spesialis => {
                spesialisDropdown.append(`<option value="${spesialis}">${spesialis}</option>`);
            });
        }

        function populateSubSpesialis() {
            let subspesialisDropdown = $('#subspesialishusus');
            subspesialisDropdown.empty().append('<option value="">-- Pilih Subspesialis --</option>');
            subSpesialisList.forEach(sub => {
                subspesialisDropdown.append(`<option value="${sub.kdSubSpesialis}">${sub.nmSubSpesialis}</option>`);
            });
        }

        $('#husus').change(function () {
            let selectedSpesialis = $(this).val();
            if (["THA", "HEM"].includes(selectedSpesialis)) {
                $('#subspesialisshususWrapper').show();
                populateSubSpesialis();
            } else {
                $('#subspesialisshususWrapper').hide();
                $('#subspesialishusus').empty().append('<option value="">-- Pilih Subspesialis --</option>');
            }
        });

          // Fungsi untuk mengubah format tanggal dari YYYY-MM-DD ke DD-MM-YYYY
          function formatTanggal(tanggal) {
                if (!tanggal) return ""; // Jika tanggal kosong, kembalikan string kosong
                var parts = tanggal.split("-");
                return parts[2] + "-" + parts[1] + "-" + parts[0]; // Ubah format ke DD-MM-YYYY
            }

        $('#cariProviderhusus').click(function () {
            let spesialis = $('#husus').val();
            let subspesialis = $('#subspesialishusus').val();
            let tanggal = $('#tglRujukan').val();
            var formattedTglRujukan = formatTanggal(tanggal);
            let nomorrujuk = $('#statusLanjutModal').attr('data-norujuk');
            let data1 = spesialis || "-";
            let data2 = nomorrujuk || "-";
            let data3 = formattedTglRujukan;
            let apiUrl;


            if (subspesialis) {
                apiUrl = `/api/get-rujukan-husus-spesialis-bpjs/${data1}/${subspesialis}/${data2}/${data3}`;
            } else {
                apiUrl = `/api/get-rujukan-husus-bpjs/${data1}/${data2}/${data3}`;
            }

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data && data.list && data.list.length > 0) {
                        let providerDropdown = $('#Providerhusus');
                        providerDropdown.empty().append('<option value="">-- Pilih Provider --</option>');

                        data.list.forEach(provider => {
                            let optionText = `${provider.nmppk} - ${provider.alamatPpk} (Telp: ${provider.telpPpk})`;
                            providerDropdown.append(`<option value="${provider.kdppk}" data-nama="${provider.nmppk}" data-alamat="${provider.alamatPpk}" data-telp="${provider.telpPpk}">${optionText}</option>`);
                        });

                        $('#ProviderWrapperhusus').show();
                    } else {
                        Swal.fire("Error!", "Data provider tidak ditemukan." , "error");
                        $('#ProviderWrapperhusus').hide();
                    }
                })
                .catch(error => {
                    Swal.fire("Error!", "Gagal mengambil data provider." , "error");
                });
        });

        $('#Providerhusus').change(function () {
            let selectedOption = $(this).find(':selected');
            $('#DataProvidernamahusus').val(selectedOption.data('nama'));
            $('#DataProvideralamathusus').val(selectedOption.data('alamat'));
            $('#DataProvidertelphusus').val(selectedOption.data('telp'));
        });

        populateSpesialis();
    });
</script>
<script>
    $(document).ready(function () {
        var currentStep = 1;
        var totalSteps = 4;

        function showStep(step) {
            $('.step').hide();
            $('#step' + step).show();

            $('#prevButton').toggle(step > 1 && step <= totalSteps);
            $('#nextButton').toggle(step < totalSteps);
            $('#clearButton').toggle(step > 1);
            $('#saveButton').toggle(step === totalSteps);
        }

        // Disable Tujukan initially but enable Next Button for Step 1
        $('#tujukan').prop('disabled', true);
        $('#nextButton').prop('disabled', currentStep !== 1);

        function validateStep() {
            let valid = false;

            if (currentStep === 2) {
                valid = $('#jenis_rujukan').val() !== "" && $('#tujukan').val() !== "";
            } else if (currentStep === 3) {
                valid = $('#status_ljt').val() !== "";
            } else {
                valid = true;
            }

            $('#nextButton').prop('disabled', !valid);
            $('#saveButton').prop('disabled', !valid).toggle(currentStep === totalSteps); // Pastikan Save Button aktif jika valid di step terakhir
        }


        $('#jenis_rujukan').change(function () {
            if ($(this).val() === "SEHAT") {
                Swal.fire("Info", "Rujukan Sehat masih dalam pengembangan", "info");
                $('#tujukan').prop('disabled', true);
            } else {
                $('#tujukan').prop('disabled', false);
            }
            validateStep();
        });

        $('#tujukan, #status_ljt, #spesialis, #tglRujukan').change(validateStep);

        $('#tujukan').change(function () {
            if ($(this).val() === "HORIZONTAL") {
                $('#horizontalOptions').removeClass('d-none');
                $('#pilihRujukanWrapper').addClass('d-none');
            } else {
                $('#horizontalOptions').addClass('d-none');
                $('#pilihRujukanWrapper').removeClass('d-none');
            }
        });

        $('#status_ljt').change(function () {
            var selectedOption = $(this).val();
            $('.step4-input').addClass('d-none'); // Sembunyikan semua input di Step 4

            if (selectedOption === "RJRS_KUHUS") {
                $('#step4Khusus').removeClass('d-none');
            } else if (selectedOption === "RJRS") {
                $('#step4Spesialis').removeClass('d-none');
            } else if ($(this).val() === "HORIZONTAL") {
                $('#step4Horizontal').removeClass('d-none');
            }
            validateStep();
        });

        $('#nextButton').click(function () {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
                validateStep();
                console.log("Current Step:", currentStep); // Debugging
            }
        });

        $('#prevButton').click(function () {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
                validateStep();
            }
        });

        $('#clearButton').click(function () {
            $('#statusLanjutForm')[0].reset();
            currentStep = 1;
            showStep(currentStep);
            $('#tujukan').prop('disabled', true);
            validateStep();
        });

        $('a[data-toggle="modal"][data-target="#statusLanjutModal"]').click(function() {
            var noRM = $(this).data('norm');
            var nama = $(this).data('nama');
            var nomorRawat = $(this).data('norawat'); // Ambil nomor rawat
            var nomoRujuk = $(this).data('rujuk'); // Ambil nomor rawat

            $('#infoNoRM').text(noRM ? noRM : "-");
            $('#infoNama').text(nama ? nama : "-");
            $('#statusLanjutModal').attr('data-norawat', nomorRawat);
            $('#statusLanjutModal').attr('data-norujuk', nomoRujuk);

        });

        $('#kdTacc').change(function () {
            var selectedVal = $(this).val();
            var kategoriMap = {
                "-1": "Tanpa Alasan",
                "1": "Time",
                "2": "Age",
                "3": "Complication",
                "4": "Comorbidity"
            };
            $('#nmTacc').val(kategoriMap[selectedVal] || "");
            $('#alasanTacc').prop('disabled', selectedVal === "-1").val(selectedVal === "-1" ? "" : $('#alasanTacc').val());
        });

        $('#spesialis').change(function () {
            var selectedSpesialis = $(this).val(); // Ambil kode spesialis yang dipilih

            if (selectedSpesialis) {
                // Sembunyikan dan reset dropdown subspesialis
                $('#subspesialis').val("").trigger('change');

                $('#subspesialis option').each(function () {
                    var kodeSpesialis = $(this).data('kode-spesialis'); // Ambil kode_spesialis dari subspesialis
                    if (kodeSpesialis == selectedSpesialis) {
                        $(this).show(); // Tampilkan subspesialis yang cocok
                    } else if (kodeSpesialis) {
                        $(this).hide(); // Sembunyikan yang tidak sesuai
                    }
                });

                // Tampilkan dropdown subspesialis hanya jika ada opsi yang sesuai
                $('#subspesialisWrapper').toggle($(this).val() !== "");
            } else {
                // Jika spesialis tidak dipilih, sembunyikan dropdown subspesialis
                $('#subspesialisWrapper').hide();
            }
        });
        $('#enableSarana').change(function () {
            $('#saranaWrapper').toggle(this.checked);
            if (!this.checked) $('#sarana').val("0").trigger('change');
        });

        function formatTanggal(tanggal) {
            if (!tanggal) return ""; // Jika tanggal kosong, kembalikan string kosong
            var parts = tanggal.split("-");
            return parts[2] + "-" + parts[1] + "-" + parts[0]; // Ubah format ke DD-MM-YYYY
        }

        $('#cariProvider').click(function () {
            var spesialis = $('#subspesialis').val();
            var sarana = $('#sarana').val() || "0"; // Jika tidak dipilih, default ke 0
            var tglRujukan = $('#tglRujukanspesial').val();

            if (!spesialis || !tglRujukan) {
                Swal.fire("Error!", "Silakan pilih Spesialis dan Tanggal Rujukan terlebih dahulu" , "error");
                return;
            }

            // Ubah format tanggal sebelum dikirim ke API
            var formattedTglRujukan = formatTanggal(tglRujukan);

            // Gunakan route Laravel yang baru dengan format tanggal yang benar
            var apiUrl = `/api/get-rujukan-spesialis-bpjs/${spesialis}/${sarana}/${formattedTglRujukan}`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data && data.list && data.list.length > 0) {
                        $('#Provider').empty().append('<option value="">-- Pilih Provider --</option>');

                        data.list.forEach(function (provider) {
                            var optionText = `${provider.nmppk} - ${provider.alamatPpk} (Telp: ${provider.telpPpk})`;
                            var providerJson = JSON.stringify(provider).replace(/"/g, "&quot;"); // Escape double quotes
                            $('#Provider').append(`<option value="${provider.kdppk}" data-info="${providerJson}">${optionText}</option>`);
                        });

                        $('#ProviderWrapper').show();
                        $('#Provider').trigger('change');
                    } else {
                        Swal.fire("Error!", "Data provider tidak ditemukan." , "error");
                        $('#ProviderWrapper').hide();
                    }
                })
                .catch(error => {
                    Swal.fire("Error!", "Gagal mengambil data provider." , "error");
                    console.error("Error fetching provider data:", error);
                });
        });

        // FIX: Mengambil data provider yang dipilih
        $('#Provider').on('change', function () {
            var selectedOption = $(this).find(':selected'); // Ambil opsi yang dipilih
            var providerData = selectedOption.attr('data-info'); // Ambil data-info sebagai string

            if (providerData) {
                try {
                    var providerInfo = JSON.parse(providerData); // Konversi dari string JSON ke objek

                    // Masukkan data ke masing-masing field
                    $('#DataProvidernama').val(providerInfo.nmppk); // Nama Provider
                    $('#DataProvideralamat').val(providerInfo.alamatPpk); // Alamat Provider
                    $('#DataProvidertelp').val(providerInfo.telpPpk); // Telepon Provider

                } catch (e) {
                    console.error("Error parsing provider data:", e);
                    $('#DataProvidernama').val('');
                    $('#DataProvideralamat').val('');
                    $('#DataProvidertelp').val('');
                }
            } else {
                $('#DataProvidernama').val('');
                $('#DataProvideralamat').val('');
                $('#DataProvidertelp').val('');
            }
        });

        $('#saveButton').on('click', function () {
            let isHusus = $('#status_ljt').val() === "RJRS_KUHUS";

            var formData = {
                jenis_rujukan: $('#jenis_rujukan').val(),
                tujukan: $('#tujukan').val(),
                status_ljt: $('#status_ljt').val(),
                spesialis: isHusus ? $('#husus').val() : $('#spesialis').val(),
                subspesialis: isHusus ? $('#subspesialishusus').val() : $('#subspesialis').val(),
                sarana: isHusus ? null : $('#enableSarana').is(':checked') ? $('#sarana').val() : "0",
                provider: isHusus ? $('#Providerhusus').val() : $('#Provider').val(),
                providernama: isHusus ? $('#DataProvidernamahusus').val() : $('#DataProvidernama').val(),
                provideralamat: isHusus ? $('#DataProvideralamathusus').val() : $('#DataProvideralamat').val(),
                provideratelepon: isHusus ? $('#DataProvidertelphusus').val() : $('#DataProvidertelp').val(),
                tglRujukan: formatTanggal(isHusus ? $('#tglRujukan').val() : $('#tglRujukanspesial').val()),
                nomor_rawat: $('#statusLanjutModal').attr('data-norawat'),
                kdTacc:isHusus ?  "0" : $('#kdTacc').val() ,
            };

            console.log("Data yang dikirim:", formData);
            $.ajax({
                url: "/api/rujuk_lanjut",
                method: 'POST',
                contentType: "application/json",
                data: JSON.stringify(formData),
                success: function (response) {
                    Swal.fire({
                        title: "Sukses!",
                        text: response.message,
                        icon: "success",
                        showCancelButton: false,
                        confirmButtonText: "Lihat Surat Rujukan"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Buka tab baru dengan PDF Surat Rujukan
                            var nomorRawatBase64 = btoa(formData.nomor_rawat);
                            var pdfUrl = `/api/cetak-rujukan/${nomorRawatBase64}`; // Sesuaikan dengan endpoint yang mengembalikan PDF
                            window.open(pdfUrl, '_blank');

                            // Reload halaman setelah membuka PDF
                            setTimeout(() => {
                                location.reload();
                            }, 2000); // Tunggu 2 detik sebelum reload
                        }
                    });
                },
                error: function () {
                    Swal.fire("Error!", "Gagal menyimpan data. Silakan coba lagi.", "error");
                }
            });
        });


        showStep(currentStep);
        validateStep();
    });
</script>







<script>
    $(document).ready(function () {
        // Menggunakan event delegation agar tetap bekerja meskipun tombol dalam loop
        $(document).on("click", ".panggil-btn", function () {
            let nomor_rm = $(this).data("rm");
            let nomor_regis = $(this).data("regis");
            let kode_poli = $(this).data("poli");
            let kode_provide = $(this).data("provied");


            console.log("Nomor RM:", nomor_rm);
            console.log("Kode Poli:", kode_poli);

            $.ajax({
                url: "/panggil-pasien-dokter",
                type: "POST",
                data: {
                    nomor_rm: nomor_rm,
                    nomor_regis: nomor_regis,
                    kode_poli: kode_poli,
                    kode_provide: kode_provide,
                    _token: "{{ csrf_token() }}" // Ambil CSRF dari meta tag
                },
                success: function (response) {
                    console.log("Sukses:", response);
                    alert("Panggilan berhasil dikirim!");
                },
                error: function (xhr, status, error) {
                    console.error("Error:", status, error);
                    alert("Terjadi kesalahan!");
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
      $('#statusRawatModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var status = button.data('status'); // Extract info from data-* attributes
        var id = button.data('id');

        // Update the modal's content.
        var modal = $(this);
        modal.find('.modal-body #no_rm').val(id);

        // Set the radio button based on the status
        modal.find('.modal-body input[name="status"]').each(function () {
          if ($(this).val() === status) {
            $(this).prop('checked', true);
          } else {
            $(this).prop('checked', false);
          }
        });
      });

      // Handle the Ok button click event
      $('#okButton').on('click', function () {
        var modal = $('#statusRawatModal');
        var id = modal.find('.modal-body #no_rm').val();
        var status = modal.find('.modal-body input[name="status"]:checked').val();

            // Hide the modal immediately
        modal.modal('hide');
        // Send AJAX request to update the status
        $.ajax({
          url: '/regis/update-status', // Replace with your actual update URL
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}', // Include CSRF token
            id: id,
            status: status
          },
          success: function (response) {
            // Handle success response using SweetAlert
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 10000,
            timerProgressBar: true
            });

            Toast.fire({
              title: response.message,
              icon: 'success',
            });
            location.reload(); // Reload the page to reflect changes

          },
          error: function (xhr, status, error) {
            // Handle error response
            alert('Failed to update status. Please try again.');
          }
        });
      });
    });
</script>

    <script>
        $(document).ready(function() {
            const searchButton = document.getElementById('search-button');
            const kecelakanSection = document.getElementById('kecelakan-section');
            const kecelakanHeader = document.getElementById('kecelakan-header');
            const kecelakanCard = document.getElementById('kecelakan-card');
            const kecelakanCol = document.getElementById('kecelakan-col');

            // Event listener ketika tombol search diklik
            $('#search-button').click(function() {
                // Ambil nilai dari input nama
                var namaPasien = $('#nama').val();

                // Panggil AJAX ke server untuk mencari pasien
                $.ajax({
                    url: '/search-pasien-rajal', // URL untuk request pencarian
                    method: 'GET',
                    data: { nama: namaPasien },
                    success: function(response) {
                        // Kosongkan tabel sebelum mengisi data baru
                        $('#patienttbl tbody').empty();

                        // Periksa apakah ada hasil
                        if (response.length > 0) {
                            // Looping melalui hasil dan tambahkan ke tabel
                            $.each(response, function(index, pasien) {
                                var row = '<tr>' +
                                    '<td>' + pasien.no_rm + '</td>' +
                                    '<td>' + pasien.nama + '</td>' +
                                    '<td>' + pasien.tanggal_lahir + '</td>' +
                                    '<td>' + (pasien.seks ? pasien.seks.nama : 'Tidak Diketahui') + '</td>' +  // Menampilkan nama seks, jika tersedia
                                    '<td>' + pasien.Alamat + '</td>' +
                                    '<td>' + pasien.telepon + '</td>' +
                                    '<td>' +
                                        '<button class="btn btn-primary select-patient" data-id="' + pasien.no_rm + '" data-nama="' + pasien.nama + '" data-tgl="' + pasien.tanggal_lahir + '" data-seks="' + (pasien.seks ? pasien.seks.nama : '') + '" data-telepon="' + pasien.telepon + '">Pilih</button>' +
                                    '</td>' +
                                    '</tr>';
                                $('#patienttbl tbody').append(row);
                            });
                        } else {
                            // Jika tidak ada hasil, tampilkan pesan kosong
                            $('#patienttbl tbody').append('<tr><td colspan="7">Pasien tidak ditemukan</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error searching pasien:', error);
                    }
                });

                // Tampilkan atau sembunyikan kecelakanSection
                const isCurrentlyVisible = kecelakanSection.style.display === 'block';

                if (isCurrentlyVisible) {
                    // Sembunyikan jika sedang terlihat
                    kecelakanSection.style.display = 'none';
                    kecelakanHeader.style.display = 'none';
                    kecelakanCard.style.display = 'none';
                    kecelakanCol.style.display = 'none';
                } else {
                    // Tampilkan jika sedang tersembunyi
                    kecelakanSection.style.display = 'block';
                    kecelakanHeader.style.display = 'block';
                    kecelakanCard.style.display = 'block';
                    kecelakanCol.style.display = 'block';
                }
            });

            // Event listener untuk tombol "Pilih"
            $(document).on('click', '.select-patient', function() {
                // Ambil data dari atribut tombol
                var noRm = $(this).data('id');
                var nama = $(this).data('nama');
                var tglLahir = $(this).data('tgl');
                var seks = $(this).data('seks');
                var telepon = $(this).data('telepon');

                // Isi field input di card dengan data pasien yang dipilih
                $('#no_rm').val(noRm);
                $('#nama_pasien').val(nama);
                $('#tgl_lahir').val(tglLahir);
                $('#seks').val(seks);
                $('#telepon').val(telepon);

                // Sembunyikan kecelakanSection dan elemen terkait
                kecelakanSection.style.display = 'none';
                kecelakanHeader.style.display = 'none';
                kecelakanCard.style.display = 'none';
                kecelakanCol.style.display = 'none';
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Menjalankan AJAX saat input No. Reg difokuskan (diklik)
            $('#no_reg').focus(function() {
                $.ajax({
                    url: '/generate-no-reg-rajal', // URL ke controller yang menangani nomor registrasi
                    type: 'GET',
                    success: function(response) {
                        // Menampilkan nomor registrasi di input field
                        $('#no_reg').val(response.no_reg);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Gagal menghasilkan nomor registrasi.');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Menjalankan AJAX saat input No. Rawat difokuskan (diklik)
            $('#no_rawat').focus(function() {
                $.ajax({
                    url: '/generate-no-rawat-rajal', // URL ke route yang menggenerate nomor rawat
                    method: 'GET',
                    success: function(response) {
                        // Set nilai input dengan nomor rawat yang dihasilkan
                        $('#no_rawat').val(response.no_rawat);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error generating No. Rawat:', error);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#generate-no-rawat-button').click(function() {
                $.ajax({
                    url: '/generate-no-rawat', // URL yang mengarah ke route untuk generate nomor rawat
                    method: 'GET',
                    success: function(response) {
                        // Set nilai input dengan nomor rawat yang dihasilkan
                        $('#no_rawat').val(response.no_rawat);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error generating No. Rawat:', error);
                    }
                });
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $("#kunjungan-table").DataTable({
                "responsive": true,
                "autoWidth": false,
                "paging": true,
                "lengthChange": true,
                "buttons": ["csv", "excel", "pdf", "print"],
                "language": {
                    "lengthMenu": "Tampil  _MENU_",
                    "info": "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
                    "search": "Cari :",
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Berikutnya"
                    }
                }
            }).buttons().container().appendTo('#doctortbl_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
