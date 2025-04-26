@extends('template.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

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
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="mt-3 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 card-title">Histori Pelayanan Rawat Jalan</h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body" id="kunjungan-section">
                            <table id="kunjungan-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>ID. Kunjungan</th>
                                        <th>No Antrian</th>
                                        <th>Poliklinik</th>
                                        <th>Dokter</th>
                                        <th>Penjamin</th>
                                        <th>No. Asuransi</th>
                                        <th>Tgl. Kunjungan</th>
                                        <th>Status info</th>
                                        <th>Status</th>
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
                                            <td>{{ $data->pasien->no_bpjs ?? '-'}}</td>
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
                                                <div class="btn-container d-flex justify-content-center align-items-center">
                                                    <button type="button" class="btn btn-flat btn-primary d-flex align-items-center justify-content-center shadow-sm"
                                                        style="border-radius: 50px; padding: 5px 15px; font-size: 12px; text-decoration: none; width: auto; height: auto;"
                                                        data-toggle="modal" data-target="#editDoctorModal"
                                                        onclick="setEditDoctor('{{ $data->id }}', '{{ $data->doctor_id }}')">
                                                        <i class="fa fa-user-md" style="margin-right: 5px;"></i> Edit Dokter
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm mr-2 panggil-btn" data-regis="{{ $data->no_reg }}" data-rm="{{ $data->no_rm }}" data-poli="{{ $data->poli->kode_poli }}" title="Hapus Data">
                                                        Panggil
                                                    </button>

                                                    <!-- Form Hapus -->
                                                    <form action="{{ route('rajal.delete', $data->id) }}" method="POST" style="display: inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm mr-2" title="Hapus Data">
                                                            Hapus
                                                        </button>
                                                    </form>

                                                    <!-- Dropdown Menu -->
                                                    @if ($data->stts_soap == 0)
                                                    <div class="btn-group">
                                                        <a class="btn btn-default btn-sm" href="{{ route('layanan.rawat-jalan.soap-perawat.index', ['norm' => base64_encode($data->no_rawat)]) }}">
                                                            {{-- FA UNTUK PANAH KANAN --}}
                                                                {{-- <i class="fas fa-file-medical-alt"></i> --}}
                                                                {{-- <i class="fa-solid fa-caret-right"></i> --}}
                                                                {{-- <i class="fa-solid fa-circle-right"></i> --}}
                                                                {{-- <i class="fa-solid fa-square-caret-right"></i> --}}
                                                            <i class="fa-solid fa-file-pen"></i>
                                                        </a>
                                                    </div>
                                                    @endif
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusLanjutModalLabel">Status Lanjut</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="step active" id="step1">
                    <p>Apakah Pasien Ingin Dimasukkan Dalam Kamar Inap?</p>
                </div>
                <div class="step" id="step2">
                    <form id="statusLanjutForm">
                        @csrf <!-- CSRF token -->
                            <input type="hidden"" class="form-control" id="statno_rm" name="statno_rm" readonly>
                            <input type="hidden"" class="form-control" id="stanama" name="stanama" readonly>
                            <input type="hidden"" class="form-control" id="poliid" name="poliid" readonly>
                            <input type="hidden"" class="form-control" id="doctorid" name="doctorid" readonly>
                            <input type="hidden"" class="form-control" id="penjabid" name="penjabid" readonly>
                            <input type="hidden"" class="form-control" id="alamat" name="alamat" readonly>
                            <input type="hidden"" class="form-control" id="statelepon" name="statelepon" readonly>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <select id="status_ljt" name="status_ljt" class="form-control">
                                    <option value="-">-- Pilih --</option>
                                    <option value="Rajal"> Rawat Jalan </option>
                                    <option value="Ranap"> Rawat Inap </option>
                                    <option value="RJRS"> Rujukan Ke RS </option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" id="prevButton">Previous</button>
                <button type="button" class="btn btn-primary" id="nextButton">Next</button>
                <button type="button" class="btn btn-primary" id="clearButton">Clear</button>
                <button type="button" class="btn btn-primary" id="saveButton">Save</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editDoctorModal" tabindex="-1" role="dialog" aria-labelledby="editDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDoctorModalLabel">Edit Dokter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editDoctorForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editPatientId" name="patient_id">

                    <div class="form-group">
                        <label for="doctorSelect">Pilih Dokter</label>
                        <select class="form-control" id="doctorSelect" name="doctor_id">
                            <option value="">-- Pilih Dokter --</option>
                            @foreach ($dokter as $doctors)
                                <option value="{{ $doctors->id }}">{{ $doctors->nama_dokter }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Menggunakan event delegation agar tetap bekerja meskipun tombol dalam loop
        $(document).on("click", ".panggil-btn", function () {
            let nomor_rm = $(this).data("rm");
            let nomor_regis = $(this).data("regis");
            let kode_poli = $(this).data("poli");

            console.log("Nomor RM:", nomor_rm);
            console.log("Kode Poli:", kode_poli);
            console.log("Kode regis:", nomor_regis);

            $.ajax({
                url: "/panggil-pasien",
                type: "POST",
                data: {
                    nomor_rm: nomor_rm,
                    nomor_regis: nomor_regis,
                    kode_poli: kode_poli,
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
    function setEditDoctor(patientId, doctorId) {
document.getElementById("editPatientId").value = patientId;
document.getElementById("doctorSelect").value = doctorId; // Set nilai default dokter
document.getElementById("editDoctorForm").action = `/rajal/update-doctor/${patientId}`;
}

</script>

<script>
    $(document).ready(function() {
        // Set up the CSRF token in the headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#statusLanjutModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var no_rm = button.data('norm'); // Extract info from data-* attributes
            var nama = button.data('nama'); // Extract info from data-* attributes
            var poliid = button.data('poliid'); // Extract info from data-* attributes
            var doctorid = button.data('doctorid'); // Extract info from data-* attributes
            var penjabid = button.data('penjabid'); // Extract info from data-* attributes
            var alamat = button.data('alamat'); // Extract info from data-* attributes
            var telepon = button.data('telepon'); // Extract info from data-* attributes

            // Update the modal's content.
            var modal = $(this);
            modal.find('.modal-body #statno_rm').val(no_rm);
            modal.find('.modal-body #stanama').val(nama);
            modal.find('.modal-body #poliid').val(poliid);
            modal.find('.modal-body #doctorid').val(doctorid);
            modal.find('.modal-body #penjabid').val(penjabid);
            modal.find('.modal-body #alamat').val(alamat);
            modal.find('.modal-body #statelepon').val(telepon);
        });

        var currentStep = 1;
        var totalSteps = $('.step').length;

        function showStep(step) {
            $('.step').hide();
            $('#step' + step).show();

            if (step === 1) {
                $('#prevButton').hide();
                $('#nextButton').show();
                $('#clearButton').hide();
                $('#saveButton').hide();
            } else if (step === totalSteps) {
                $('#prevButton').show();
                $('#nextButton').hide();
                $('#clearButton').hide();
                $('#saveButton').show();
            } else {
                $('#prevButton').show();
                $('#nextButton').show();
                $('#clearButton').show();
                $('#saveButton').hide();
            }
        }

        $('#nextButton').click(function() {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        });

        $('#prevButton').click(function() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        showStep(currentStep);

        // Tambahan: Reset form dan kembali ke langkah pertama
        $('#clearButton').click(function() {
            $('#statusLanjutForm')[0].reset(); // Reset form
            currentStep = 1; // Reset ke langkah pertama
            showStep(currentStep); // Tampilkan langkah pertama
        });

        $('#saveButton').on('click', function() {
            var modal = $('#statusLanjutModal');
            var formData = {
                _token: '{{ csrf_token() }}', // Include CSRF token
                no_rm: $('#statno_rm').val(),
                nama: $('#stanama').val(),
                poliid: $('#poliid').val(),
                doctorid: $('#doctorid').val(),
                penjabid: $('#penjabid').val(),
                alamat: $('#alamat').val(),
                telepon: $('#statelepon').val(),
                status_ljt: $('#status_ljt').val(),
            };

            modal.modal('hide');

            $.ajax({
                url: '/regis/status-lanjut', // URL endpoint for saving data
                method: 'POST',
                data: $.param(formData), // Convert array to URL-encoded string
                success: function(response) {

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
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 10000,
                        timerProgressBar: true
                    });

                    Toast.fire({
                        title: 'Gagal menyimpan data. Silakan coba lagi. isi semua data',
                        icon: 'error',
                    });
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
        window.onload = function() {
            // Mengambil tanggal dan waktu saat ini
            var now = new Date();

            // Mengatur nilai input tanggal (YYYY-MM-DD)
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear() + "-" + month + "-" + day;
            document.getElementById("tgl_kunjungan").value = today;

            // Mengatur nilai input waktu (HH:MM)
            var hours = ("0" + now.getHours()).slice(-2);
            var minutes = ("0" + now.getMinutes()).slice(-2);
            var currentTime = hours + ":" + minutes;
            document.getElementById("time").value = currentTime;
        };
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
