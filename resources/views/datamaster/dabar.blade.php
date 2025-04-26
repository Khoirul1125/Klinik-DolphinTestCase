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
                                <h3 class="mb-0 card-title">Daftar Obat dan Alkes</h3>
                                <div class="text-right card-tools">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#adddoctor">
                                        <i class="fas fa-plus"></i> Tambah Baru
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                              <table id="janjitbl" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                  <th class="text-center">Kode Barang</th>
                                  <th class="text-center">Nama Barang</th>
                                  <th class="text-center">Kode KFA</th>
                                  <th class="text-center">Satuan</th>
                                  <th class="text-center">Penyimpanan</th>
                                  <th class="text-center">Barcode</th>
                                  <th class="text-center">Generik</th>
                                  <th class="text-center">Kode Industri</th>
                                  <th class="text-center">Kategori</th>
                                  <th class="text-center">Dosis</th>
                                  <th class="text-center">Pilihan</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $data)
                                            <tr>
                                                <td>{{ $data->kode}}</td>
                                                <td>{{ $data->nama }}</td>
                                                <td>{{ $data->kode_kfa }}</td>
                                                <td>{{ $data->satuan->nama_satuan}}</td>
                                                <td>{{ $data->penyimpanan}}</td>
                                                <td>{{ $data->barcode}}</td>
                                                <td>{{ $data->nama_generik}}</td>
                                                <td>{{ $data->industri}}</td>
                                                <td>{{ $data->jenbar->nama_jenbar}}</td>
                                                <td>{{ $data->dosis}} {{ $data->kode_dosis}}</td>
                                                <td></td>
                                            </tr>
                                    @endforeach
                                </tbody>
                                {{-- @php
                                    dd($data);
                                @endphp --}}
                              </table>
                            </div>
                            <!-- /.card-body -->
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
                    <h5 class="modal-title" id="addModalLabel">Input Obat dan Alkes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addFormpermesion" action="{{ route('datmas.dabar.oppssalah') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kode Barang</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Generate Kode Barang" readonly>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary" id="generateKodeButton">Generate</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Pilihan Formularium</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="formularium" name="formularium">
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="Formularium">Formularium</option>
                                        <option value="Non Formularium">Non Formularium</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" autocomplete="off">
                                    <div id="suggestions" class="list-group" style="position: absolute; z-index: 1000; display: none;"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Nama Barang (BPJS)</label>
                                    <input type="text" class="form-control" id="nama_dpho" name="nama_dpho" autocomplete="off">
                                    <div id="suggestionss" class="list-group" style="position: absolute; z-index: 1000; display: none; width: 100%;"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>DPHO CODE</label>
                                    <input type="text" class="form-control" id="dpho_kode" name="dpho_kode" readonly>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>KFA CODE</label>
                                    <input type="text" class="form-control" id="kfa_kode" name="kfa_kode" readonly>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Harga Dasar</label>
                                    <input type="text" class="form-control" id="h_dasar" name="h_dasar" readonly>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Satuan Kecil</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="kode_satkec" name="kode_satkec" onchange="updateLabel()">
                                        <option value="" disabled selected>-- Pilih Kode --</option>
                                        @foreach ($satuan as $data)
                                        <option value="{{$data->id}}">{{$data->nama_satuan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">

                                        <div class="d-flex align-items-center">

                                        <div class="mr-2" style="flex: 1; margin-top: 32px;">
                                            <!-- Input Jumlah -->
                                            <input type="number" class="form-control" id="satuan_sedang" name="satuan_sedang" min="1" >
                                        </div>

                                        <div class="mr-2">
                                            <!-- Label Box dalam 1 -->
                                            <label id="satLabel" style="margin-top: 35px;"> dalam 1</label>
                                        </div>

                                        <div style="flex: 2;">
                                            <label for="kode_satuan_sedang">Satuan Sedang</label>
                                            <!-- Pilihan Satuan -->
                                            <select class="form-control select2bs4" id="kode_satuan_sedang" name="kode_satuan_sedang" onchange="updateLabel1()">
                                                <option value="" disabled selected>-- Pilih Kode --</option>
                                                @foreach ($satuan as $data)
                                                    <option value="{{$data->id}}">{{$data->nama_satuan}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">

                                    <div class="d-flex align-items-center">


                                        <div class="mr-2" style="flex: 1; margin-top: 30px;">
                                            <!-- Input Jumlah -->
                                            <input type="number" class="form-control" id="satuan_besar" name="satuan_besar" min="1">
                                        </div>

                                        <div class="mr-2">
                                            <!-- Label Box dalam 1 -->
                                            <label id="satLabels" style="margin-top: 35px;"> dalam 1</label>
                                        </div>

                                        <div style="flex: 2;">
                                            <label for="satuan_besar">Satuan Besar</label>
                                            <!-- Pilihan Satuan -->
                                            <select class="form-control select2bs4" id="kode_satuan_besar" name="kode_satuan_besar">
                                                <option value="" disabled selected>-- Pilih Kode --</option>
                                                @foreach ($satuan as $data)
                                                    <option value="{{$data->id}}">{{$data->nama_satuan}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Penyimpanan</label>
                                    <input type="text" class="form-control" id="penyimpanan" name="penyimpanan">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Barcode</label>
                                    <input type="text" class="form-control" id="barcode" name="barcode">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Industri</label>
                                    <input type="text" class="form-control" id="kode_idn" name="kode_idn" readonly>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kategori Barang</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="kode_jenis" name="kode_jenis">
                                        <option value="" disabled selected>-- Pilih Kode --</option>
                                            @foreach ($jenis as $data)
                                            <option value="{{$data->id}}">{{$data->nama_jenbar}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <label>Nama Generik (apabila Bukan generik ceklis )</label>
                                <input type="checkbox" id="generik" name="generik" onclick="generic()">
                                <div class="form-group row d-flex align-items-center">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="nama_generik" name="nama_generik" value="Non Generic" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Bentuk Sediaan</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="bentuk_kesediaan" name="bentuk_kesediaan">
                                        <option value="" selected>-- Pilih Bentuk Sediaan --</option>
                                        <option value="Padat" >Padat</option>
                                        <option value="Cair" >Cair</option>
                                        <option value="Gas" >Gas<option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="dosis">dosis sedia</label>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2" style="flex: 1;">
                                            <!-- Input Jumlah -->
                                            <input type="number" class="form-control" id="dosis" name="dosis" min="1">
                                        </div>

                                        <div style="flex: 1; margin-right: 10px;">
                                            <!-- Pilihan Satuan -->
                                            <select class="form-control select2bs4" id="kode_dosis" name="kode_dosis">
                                                <option value="" disabled selected>-- Pilih Dosis Sedia --</option>
                                                <option value="mcg" >mcg</option>
                                                <option value="mg" >mg</option>
                                                <option value="gr" >GR</option>
                                                <option value="ml" >ml</option>
                                                <option value="cc" >cc</option>
                                                <option value="tetes" >tetes</option>
                                            </select>
                                        </div>

                                        <div style="flex: 1;">
                                            <!-- Label Box dalam 1 -->
                                            <label id="satLabel2"> dalam setiap</label>
                                        </div>
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
        $(document).ready(function () {
            $("#nama_dpho").on("keyup", function () {
                let query = $(this).val(); // Ambil nilai input

                if (query.length >= 2) { // Mulai mencari jika lebih dari 2 karakter
                    $.ajax({
                        url: "/api/get-dpho-obat",
                        type: "GET",
                        data: { query: query },
                        success: function (response) {
                            let suggestionsBox = $("#suggestionss");
                            suggestionsBox.empty().show();

                            if (response.status === "success") {
                                $.each(response.data, function (index, obat) {
                                    suggestionsBox.append(`
                                        <a href="#" class="list-group-item list-group-item-action suggestion-item" data-kode="${obat.kode_barang}" data-nama="${obat.nama_barang}">
                                            ${obat.nama_barang} (${obat.kode_barang})
                                        </a>
                                    `);
                                });
                            } else {
                                suggestionsBox.append('<a href="#" class="list-group-item list-group-item-action disabled">Obat tidak ditemukan</a>');
                            }
                        }
                    });
                } else {
                    $("#suggestionss").hide();
                }
            });

            // Saat user memilih salah satu hasil pencarian
            $(document).on("click", ".suggestion-item", function (e) {
                e.preventDefault();
                let selectedNama = $(this).data("nama");
                let selectedKode = $(this).data("kode");

                $("#nama_dpho").val(selectedNama); // Masukkan nama ke input
                $("#dpho_kode").val(selectedKode); // Masukkan nama ke input
                $("#suggestionss").hide(); // Sembunyikan dropdown
            });

            // Sembunyikan suggestions jika user klik di luar
            $(document).click(function (e) {
                if (!$(e.target).closest("#nama_dpho, #suggestionss").length) {
                    $("#suggestionss").hide();
                }
            });
        });
        </script>

<script>
    $(document).ready(function () {
        // Set a debounce timer to limit the number of AJAX calls
        let debounceTimer;

        $('#nama_barang').on('input', function () {
            const query = $(this).val().trim();

            // Clear debounce timer jika user terus mengetik
            clearTimeout(debounceTimer);

            if (query.length > 0) {
                // Set debounce time ke 300ms
                debounceTimer = setTimeout(function () {
                    // Gantilah __QUERY__ dengan variabel query
                    let url = "{{ url('api/get-kfa-satusehat', ['nama' => '__QUERY__']) }}".replace('__QUERY__', query);

                    // AJAX request untuk mengambil data
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function (response) {
                            const responseData = response; // Response JSON
                            displaySuggestions(responseData);
                        },
                        error: function (error) {
                            console.error("Error fetching data:", error);
                        }
                    });
                }, 300);
            } else {
                // Hide suggestions jika input kosong
                $('#suggestions').hide();
            }
        });

        // Function to display suggestions in a dropdown
        function displaySuggestions(responseData) {
            $('#suggestions').empty(); // Clear previous suggestions

            // If `data` is not already an array, handle it based on structure
            // const items = Array.isArray(data) ? data : (data.items || [data]);
            const items = responseData.data || []; // Use response.data safely



            if (items.length > 0) {
                items.forEach(item => {
                    console.log(item);
                    // Access `item.name` or adapt based on actual data structure
                    const fullName = item.name || "Unknown Item"; // Safely access name
                    const itemName = fullName.split(" (")[0]; // Get the part before the parentheses
                    const itemNamedisplay = item.product_template.display_name || "Unknown Item";
                    const itemKfaCode = item.kfa_code || ""; // Safely access kfa_code
                    const itemFixPrice = item.fix_price || "-"; // Safely access kfa_code
                    const itemManufacturer = item.manufacturer || ""; // Safely access kfa_code

                    const suggestionItem = $(`
                        <a href="#" class="list-group-item list-group-item-action" data-name="${itemNamedisplay}" data-kfa="${itemKfaCode}" data-harga="${itemFixPrice} "data-idn="${itemManufacturer}" >
                            ${itemName} - ${itemManufacturer}
                        </a>
                    `);

                    suggestionItem.on('click', function (e) {
                        e.preventDefault();
                        $('#nama_barang').val($(this).data('name'));
                        $('#kfa_kode').val($(this).data('kfa')); // Set the kfa_code in the KFA CODE field
                        $('#h_dasar').val($(this).data('harga')); // Set the kfa_code in the KFA CODE field
                        $('#kode_idn').val($(this).data('idn')); // Set the kfa_code in the KFA CODE field

                        $('#suggestions').hide();
                    });

                    $('#suggestions').append(suggestionItem);
                });
                $('#suggestions').show();
            } else {
                $('#suggestions').hide();
            }
        }




        // Hide suggestions if clicked outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#nama_barang, #suggestions').length) {
                $('#suggestions').hide();
            }
        });
    });
</script>

<style>
    /* Styling for the dropdown */
    .list-group-item {
        cursor: pointer;
    }
    #suggestions {
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
    }
</style>

    <script>
        function updateLabel() {
            // Ambil elemen select dan label
            var selectElement = document.getElementById("kode_satkec");
            var labelElement = document.getElementById("satLabel");
            var labelElement2 = document.getElementById("satLabel2");

            // Ambil nilai dari opsi yang dipilih
            var selectedText = selectElement.options[selectElement.selectedIndex].text;

            // Perbarui teks pada label
            labelElement.innerText = selectedText + " dalam 1 ";
            labelElement2.innerText = " dalam setiap 1 " + selectedText;
        }
        function updateLabel1() {
            // Ambil elemen select dan label
            var selectElements = document.getElementById("kode_satuan_sedang");
            var labelElement1 = document.getElementById("satLabels");

            var selectedTexts = selectElements.options[selectElements.selectedIndex].text;

            // Perbarui teks pada label
            labelElement1.innerText = selectedTexts + " dalam 1 ";
        }
    </script>
    <script>
        $(document).ready(function() {
            // Saat tombol "Generate" ditekan
            $('#generateKodeButton').click(function() {
                // Panggil route dengan AJAX
                $.ajax({
                    url: '/api/generate-kode-barang',
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
        // Fungsi untuk mengaktifkan atau menonaktifkan readonly pada input teks
        function generic() {
            var checkbox = document.getElementById("generik");
            var inputField = document.getElementById("nama_generik");

            if (checkbox.checked) {
                inputField.readOnly = false; // Hapus readonly saat checkbox dicentang
                inputField.value = ""; // Kosongkan input saat diaktifkan
            } else {
                inputField.readOnly = true; // Tambahkan readonly saat checkbox tidak dicentang
                inputField.value = "Non Generic"; // Set kembali nilai awal ke "Normal"
            }
        }
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
