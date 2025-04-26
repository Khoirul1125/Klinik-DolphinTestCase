@extends('template.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <div class="col-md-3">
                    <style>
                        .profile-user-img {
                            width: 100px; /* Ukuran lebar gambar, ubah sesuai kebutuhan */
                            height: 100px; /* Ukuran tinggi gambar, ubah sesuai kebutuhan */
                            border-radius: 50%; /* Membuat gambar berbentuk bulat */
                            border: 2px solid #ddd; /* Menambahkan border pada gambar */
                        }
                    </style>
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-circle"
                                    src="{{ asset('uploads/doctor_photos/'. $karyawan->user->profile) }}" alt="User profile picture">
                            </div>


                            <br>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item text-center">
                                    <a class="float">{{  $karyawan->nama_karyawan }}</a>
                                </li>
                                <li class="list-group-item text-center">
                                    <b>Jabatan : </b> <a class="float">{{  $karyawan->jabatans->nama }}</a>
                                </li>
                                <li class="list-group-item text-center">
                                    <b>Poli : </b><a class="float">{{  $karyawan->polis->nama_poli }}</a> <br>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-9">
                    <form action="{{ route('staff.index.detail.add', ['id' => $karyawan->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title">Informasi Jenjang Pendidikan</h5>
                            </div>
                            <div class="card-body">
                                @foreach ($tingkatan as $tingkat)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="{{ $tingkat }}_nama_sekolah" class="form-label">Nama Sekolah {{ $tingkat }}</label>
                                            <input type="text" class="form-control" name="education[{{ strtolower($tingkat) }}][nama_sekolah]" id="{{ $tingkat }}_nama_sekolah">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="{{ $tingkat }}_bulan_lulus" class="form-label">Lulus Tahun</label>
                                            <input type="month" class="form-control" name="education[{{ strtolower($tingkat) }}][bulan_lulus]" id="{{ $tingkat }}_bulan_lulus">
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <label for="{{ $tingkat }}_ijasah" class="form-label">Unggah Ijazah</label>
                                            <input type="file" class="form-control" name="education[{{ strtolower($tingkat) }}][ijasah]" id="{{ $tingkat }}_ijasah" accept=".pdf,.jpg,.png">
                                        </div> --}}
                                        <div class="col-md-4">
                                            <label for="{{ $tingkat }}_ijasah" class="form-label">Keterangan Ijazah</label>
                                            <input type="text" class="form-control" name="education[{{ strtolower($tingkat) }}][ijasah]" id="{{ $tingkat }}_ijasah" placeholder="Contoh: No. Ijazah">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title">Informasi Sertifikasi</h5>
                            </div>
                            <div class="card-body">
                                <div id="sertifikasiContainer">
                                    <div class="sertifikasiRow row mb-3" data-index="1">
                                        <div class="col-md-4">
                                            <label for="sers1" class="form-label">Nama Sertifikasi</label>
                                            <input type="text" class="form-control" name="sertifikasi[1][nama]" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                                            <input type="date" class="form-control" name="sertifikasi[1][tanggal_pelaksanaan]">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sertifikat_digital" class="form-label">Sertifikat</label>
                                            <input type="file" class="form-control" name="sertifikasi[1][sertifikat_digital]" accept=".pdf,.jpg,.png">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-success" id="addSertifikasi">Tambah Sertifikasi</button>
                                    <button type="button" class="btn btn-danger" id="removeSertifikasi" disabled>Hapus Sertifikasi</button>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title">Informasi Bank</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="nama_bank" class="form-label">Nama Bank</label>
                                        <input type="text" class="form-control" name="nama_bank" id="nama_bank">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="nomor_bank" class="form-label">Nomor Bank</label>
                                        <input type="text" class="form-control" name="nomor_bank" id="nomor_bank">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="cabang_bank" class="form-label">Cabang Bank</label>
                                        <input type="text" class="form-control" name="cabang_bank" id="cabang_bank">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<script>
// Menambahkan sertifikasi baru
document.getElementById('addSertifikasi').addEventListener('click', function() {
    const sertifikasiRows = document.querySelectorAll('.sertifikasiRow');
    const nextIndex = sertifikasiRows.length + 1; // Menghitung indeks baru berdasarkan jumlah sertifikasi yang ada

    const newRow = document.createElement('div');
    newRow.classList.add('sertifikasiRow', 'row', 'mb-3');
    newRow.setAttribute('data-index', nextIndex); // Menambahkan atribut data-index

    newRow.innerHTML = `
        <div class="col-md-4">
            <label for="sers${nextIndex}" class="form-label">Nama Sertifikasi</label>
            <input type="text" class="form-control" name="sertifikasi[${nextIndex}][nama]" required>
        </div>
        <div class="col-md-4">
            <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
            <input type="date" class="form-control" name="sertifikasi[${nextIndex}][tanggal_pelaksanaan]" required>
        </div>
        <div class="col-md-4">
            <label for="sertifikat_digital" class="form-label">Sertifikat</label>
            <input type="file" class="form-control" name="sertifikasi[${nextIndex}][sertifikat_digital]" accept=".pdf,.jpg,.png">
        </div>
    `;

    document.getElementById('sertifikasiContainer').appendChild(newRow);
    document.getElementById('removeSertifikasi').disabled = false; // Enable remove button
});

// Menghapus sertifikasi terakhir
document.getElementById('removeSertifikasi').addEventListener('click', function() {
    const sertifikasiRows = document.querySelectorAll('.sertifikasiRow');
    const lastSertifikasi = sertifikasiRows[sertifikasiRows.length - 1];
    if (lastSertifikasi) {
        lastSertifikasi.remove();
    }

    // Menonaktifkan tombol Hapus jika hanya ada 1 sertifikasi yang tersisa
    if (sertifikasiRows.length <= 1) {
        document.getElementById('removeSertifikasi').disabled = true;
    }
});

</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('foto').addEventListener('change', function(event) {
            var reader = new FileReader();

            reader.onload = function() {
                var output = document.getElementById('previewImage');
                output.src = reader.result; // Menampilkan gambar pratinjau
            };

            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    });

</script>
<script>
   $(document).ready(function () {
    $('#nik').on('blur', function () {
        var nik = $(this).val();
        $('#username').val(nik);
    });
});

</script>
<script>
    $(document).ready(function() {
        // Trigger change event when user selects a provinsi
        $('#provinsi').on('change', function() {
            var kodeProvinsi = $(this).val();

            // Clear previous options in kota_kabupaten, kecamatan, and desa select boxes
            $('#kota_kabupaten').empty().append('<option value="" disabled selected>Kota/Kabupaten</option>');
            $('#kecamatan').empty().append('<option value="" disabled selected>Kecamatan</option>');
            $('#desa').empty().append('<option value="" disabled selected>Desa</option>');

            if (kodeProvinsi) {
                $.ajax({
                    url: '{{ route("wilayah.getKabupaten") }}', // Route to fetch kabupaten
                    type: 'GET',
                    data: { kode_provinsi: kodeProvinsi },
                    success: function(response) {
                        $.each(response, function(index, kabupaten) {
                            $('#kota_kabupaten').append('<option value="' + kabupaten.kode + '">' + kabupaten.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching kabupaten:', error);
                    }
                });
            }
        });

        // Trigger change event when user selects a kabupaten
        $('#kota_kabupaten').on('change', function() {
            var kodeKabupaten = $(this).val();

            // Clear previous options in kecamatan and desa select boxes
            $('#kecamatan').empty().append('<option value="" disabled selected>Kecamatan</option>');
            $('#desa').empty().append('<option value="" disabled selected>Desa</option>');

            if (kodeKabupaten) {
                $.ajax({
                    url: '{{ route("wilayah.getKecamatan") }}', // Route to fetch kecamatan
                    type: 'GET',
                    data: { kode_kabupaten: kodeKabupaten },
                    success: function(response) {
                        $.each(response, function(index, kecamatan) {
                            $('#kecamatan').append('<option value="' + kecamatan.kode + '">' + kecamatan.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching kecamatan:', error);
                    }
                });
            }
        });

        // Trigger change event when user selects a kecamatan
        $('#kecamatan').on('change', function() {
            var kodeKecamatan = $(this).val();

            // Clear previous options in desa select box
            $('#desa').empty().append('<option value="" disabled selected>Desa</option>');

            if (kodeKecamatan) {
                $.ajax({
                    url: '{{ route("wilayah.getDesa") }}', // Route to fetch desa
                    type: 'GET',
                    data: { kode_kecamatan: kodeKecamatan },
                    success: function(response) {
                        $.each(response, function(index, desa) {
                            $('#desa').append('<option value="' + desa.kode + '">' + desa.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching desa:', error);
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/get-dokter-bpjs',
            method: 'GET',
            success: function(data) {
                if (data.status === 'error') {
                    alert(data.message);
                    return;
                }

                const select = $('#nama_dokter');
                data.data.forEach(dokter => {
                    const option = $('<option></option>')
                        .attr('value', dokter.nama_dokter)
                        .attr('data-kode-dokter', dokter.kode_dokter)
                        .text(dokter.nama_dokter);
                    select.append(option);
                });

                // Initialize select2 for the new select element
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });

                // Update display input when a doctor is selected
                select.on('change', function() {
                    const selectedOption = $(this).find('option:selected');
                    const kodeDokter = selectedOption.data('kode-dokter');
                    const namaDokter = selectedOption.text();
                    console.log('Selected doctor:', namaDokter, kodeDokter);
                    $('#kode_dokter').val(kodeDokter);
                });

                // Debugging: Check if the event listener is attached
                console.log('Event listener attached to select element');
            },
            error: function(error) {
                console.error('Error fetching dokter data:', error);
            }
        });
    });
</script>
<script>
    $(document).on('change', '#tgllahir', function () {
        const tglLahir = $(this).val(); // Ambil nilai dari input tanggal lahir

        if (tglLahir) {
            // Format ulang tanggal lahir menjadi DDMMYYYY
            const formattedDate = tglLahir.split('-').reverse().join('');
            $('#password').val(formattedDate); // Set nilai elemen dengan ID #password
        } else {
            console.error('Tanggal lahir tidak valid.');
        }
    });
</script>
<script>
    function cekSatuSehat(attempts = 0) {
        var jenisKartu = $('#nik').val();
        if (jenisKartu.length === 16) {
            $.ajax({
                url: '/practitionejenisKartu/' + jenisKartu,
                method: 'GET',
                success: function(response) {
                    if (response && response.patient_data && response.patient_data.entry && response.patient_data.entry.length > 0) {
                        var data = response.patient_data.entry[0].resource; // Perbaikan di sini
                        var Nama = data.name[0] ? data.name[0].text : 'Nama Dokter tidak tersedia';
                        var TglLahir = data.birthDate || 'Tanggal Lahir tidak tersedia';
                        var Sex = data.gender || 'Jenis Kelamin tidak tersedia';
                        var Id = data.id || 'ID Satu Sehat tidak tersedia';

                        var Namas = $('#nama').val();
                        $.ajax({
                            url: '/search-matching-names/' + Namas , // Update this URL to match your route
                            type: 'GET',
                            success: function(response) {
                                if (response) {
                                    consol.log(response);
                                } else {
                                    $('#nama').val('Tidak ditemukan');
                                }
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                            }
                        });


                        $('#nama').val(Nama);
                        $('#tgllahir').val(TglLahir);
                        $('#kode').val(Id);
                    } else if (attempts < 3) {
                        cekSatuSehat(attempts + 1);
                    } else {
                        $('#nama').val('Tidak ditemukan');
                        $('#tgllahir').val('Tidak ditemukan');
                        $('#kode').val('Tidak ditemukan');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', status, error);
                    if (attempts < 3) {
                        cekSatuSehat(attempts + 1);
                    } else {
                        alert('Jaringan BPJS mungkin tidak stabil. Silahkan coba kembali.');
                    }
                }
            });
        }
    }
</script>

<script>
    $(document).ready(function() {
        $("#doctortbl").DataTable({
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
