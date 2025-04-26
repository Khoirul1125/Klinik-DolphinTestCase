@extends('template.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mt-2">
                    <div class="col-md-12 d-flex justify-content-center align-items-center">
                        <h1 class="m-0">SOAP</h1>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <form action="{{ route('layanan.rawat-jalan.soap-dokter.index.add') }}" method="POST" class="row w-100">
                    @csrf
                    <div class="mt-3 col-12">
                        <div class="row">
                            <!-- Identitas Pasien -->
                            <div class="col-md-3 align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-header bg-light">
                                        <h5><i class="fa fa-user"></i> Data Pasien</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle"
                                                 src="{{ asset('uploads/patient_photos/' . $profile->user->profile) }}"
                                                 alt="User profile picture">
                                        </div>
                                        <input type="text" class="form-control" id="no_reg" name="no_reg" value="{{$rajaldata->no_reg}}" hidden>
                                        <input type="text" class="form-control" id="no_rm" name="no_rm" value="{{$rajaldata->no_rm}}" hidden>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="tgl_kunjungan">Tanggal</label>
                                                <input type="date" class="form-control" id="tgl_kunjungan" name="tgl_kunjungan">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="time">Jam</label>
                                                <input type="time" class="form-control" id="time" name="time">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="no_rawat">Id Rawat</label>
                                                <input type="text" class="form-control" id="no_rawat" name="no_rawat" value="{{$rajaldata->no_rawat}}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="no_rm">No. RM</label>
                                                <input type="text" class="form-control" id="no_rm" name="no_rm" value="{{$rajaldata->no_rm}}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="nama_pasien">Nama Pasien</label>
                                                <input type="text" class="form-control" id="nama_pasien" value="{{$rajaldata->nama_pasien}}" name="nama_pasien" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="seks">Jenis Kelamin</label>
                                                <input type="text" class="form-control" id="seks" value="{{$rajaldata->seks}}" name="seks" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="penjab">Penjamin</label>
                                                <input type="text" class="form-control" id="penjab" value="{{$rajaldata->penjab->pj}}" name="penjab" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="tgl_lahir">Tanggal Lahir</label>
                                                <input type="text" class="form-control" value="{{$rajaldata->tgl_lahir}}" id="tgl_lahir" name="tgl_lahir" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="umur">Umur</label>
                                                <input type="text" class="form-control" value="{{$umur}}" id="umur" name="umur" readonly>
                                                <input type="hidden" class="form-control" value="{{ $umurHidden }}" id="umurHidden" name="umurHidden" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pemeriksaan -->
                            <div class="col-md-9 align-items-stretch">
                                {{-- Subyektif --}}
                                <div class="card w-100">
                                    <div class="card-header d-flex p-0">
                                        <ul class="nav nav-pills ml-auto p-2">
                                          <li class="nav-item"><a class="nav-link" href="#tab_1" data-toggle="tab">timelain</a></li>
                                          <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">CPPT</a></li>
                                          <li class="nav-item"><a class="nav-link active" href="#tab_4" data-toggle="tab">Laporan</a></li>
                                        </ul>
                                      </div><!-- /.card-header -->
                                      <div class="card-body">
                                        <div class="tab-content">
                                          <div class="tab-pane" id="tab_1">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- The time line -->
                                                    <div class="timeline">
                                                        <style>
                                                        .obat-list {
                                                            margin: 0;
                                                            padding-left: 15px;
                                                        }

                                                        .obat-list li {
                                                            list-style-type: disc;
                                                        }
                                                        </style>
                                                        <!-- timeline time label -->
                                                        @foreach($timeline_data as $item)
                                                        <div class="time-label">
                                                                <span class="bg-red">{{ \Carbon\Carbon::parse($item['created_at'])->format('d M Y') }}</span>
                                                        </div>
                                                            <div>
                                                                <i class="{{ $item['icon'] }} bg-blue"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($item['created_at'])->format('H:i') }}</span>
                                                                    <h3 class="timeline-header">{{ $item['title'] }}</h3>

                                                                    <div class="timeline-body">
                                                                        {!! $item['content'] !!}
                                                                    </div>
                                                                    <div class="timeline-footer">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                            <!-- END timeline item -->
                                                            <div>
                                                                <i class="fas fa-clock bg-gray"></i>
                                                            </div>
                                                    </div>
                                                </div>
                                                <!-- /.col -->
                                              </div>
                                          </div>
                                          <!-- /.tab-pane -->
                                          <div class="tab-pane" id="tab_3">
                                            <div id="kunjungan-section">
                                                <table id="kunjungan-table" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Tanggal</th>
                                                            <th>Tensi(mmHg)</th>
                                                            <th>Suhu(C)</th>
                                                            <th>Nadi(menit)</th>
                                                            <th>RR(menit)</th>
                                                            <th>Tinggi(cm)</th>
                                                            <th>Berat(Kg)</th>
                                                            <th>SPO2</th>
                                                            <th>L. Perut</th>
                                                            <th>Alergi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($pemeriksaans as $index => $pemeriksaan)
                                                        <tr>
                                                            <td rowspan="11" style="vertical-align:top;white-space: nowrap;">{{ $pemeriksaan->tgl_kunjungan }}<br>{{ $pemeriksaan->time }}</td>
                                                            <td>{{ $pemeriksaan->tensi }}</td>
                                                            <td>{{ $pemeriksaan->suhu }}</td>
                                                            <td>{{ $pemeriksaan->nadi }}</td>
                                                            <td>{{ $pemeriksaan->rr }}</td>
                                                            <td>{{ $pemeriksaan->tinggi_badan }}</td>
                                                            <td>{{ $pemeriksaan->berat_badan }}</td>
                                                            <td>{{ $pemeriksaan->spo2 }}</td>
                                                            <td>{{ $pemeriksaan->lingkar_perut }}</td>
                                                            <td>{{ $pemeriksaan->alergi }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>GCS (E, V, M)</b></td>
                                                            <td colspan="8">{{ $pemeriksaan->nilai_eye->nama }}, {{ $pemeriksaan->nilai_verbal->nama }}, {{ $pemeriksaan->nilai_motorik->nama }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Kesadaran</b></td>
                                                            <td colspan="8"> {{ $pemeriksaan->gcs_nilai->nama }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Lingkar Perut</b></td>
                                                            <td colspan="8"> {{ $pemeriksaan->lingkar_perut }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Subyektif</b></td>
                                                            <td colspan="8">{{ implode(', ', json_decode($pemeriksaan->subyektif)) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Obyektif</b></td>
                                                            {{-- <td colspan="8"> {{ strip_tags($pemeriksaan->htt_pemeriksaan) }} </td> --}}
                                                            <td colspan="8">
                                                                <?php
                                                                $data = $pemeriksaan->htt_pemeriksaan;

                                                                // Tambahkan newline setelah setiap <h3> agar data kelompok baru dimulai di baris baru
                                                                $data = preg_replace('/<\/?h3[^>]*>/', "\n", $data);

                                                                // Ganti semua <h4> dan <h5> dengan spasi agar tetap dalam satu baris
                                                                $data = preg_replace('/<\/?h[4-5][^>]*>/', ' ', $data);

                                                                // Hapus semua tag HTML yang tersisa
                                                                $data = strip_tags($data);

                                                                // Hilangkan spasi berlebih
                                                                $data = trim(preg_replace('/\s+/', ' ', $data));

                                                                // Tampilkan dengan nl2br agar newline (\n) bisa muncul sebagai <br>
                                                                echo nl2br($data);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Cerita Dokter</b></td>
                                                            <td colspan="8"> {{ $pemeriksaan->cerita_dokter }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Assesment</b></td>
                                                            <td colspan="8"> {{ $pemeriksaan->assessmen }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Plan</b></td>
                                                            <td colspan="8"> {{ $pemeriksaan->plan }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Instruksi</b></td>
                                                            <td colspan="8"> {{ $pemeriksaan->instruksi }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Evaluasi</b></td>
                                                            <td colspan="8"> {{ $pemeriksaan->evaluasi }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>obat</b></td>
                                                            <td colspan="9">
                                                                @php
                                                                    $grouped_obat = [];
                                                                    foreach ($obat_pasien as $item) {
                                                                        if ($item->header) {
                                                                            // Jika ada "header", ini adalah awal resep baru
                                                                            $grouped_obat[$item->created_at->format('Y-m-d H:i:s')] = [
                                                                                'type' => 'Resep Dokter',
                                                                                'content' => "<strong>{$item->header}</strong><br>",
                                                                                'created_at' => \Carbon\Carbon::parse($item->created_at),
                                                                                'obat' => [],
                                                                            ];
                                                                        } elseif ($item->nama_obat) {
                                                                            // Jika ada nama obat, masukkan ke resep terakhir
                                                                            $last_key = array_key_last($grouped_obat);
                                                                            if ($last_key) {
                                                                                $grouped_obat[$last_key]['obat'][] = "{$item->nama_obat} - {$item->dosis} {$item->dosis_satuan} ({$item->signa_s} x {$item->signa_x} {$item->signa_besaran}, {$item->signa_keterangan})";
                                                                            } else {
                                                                                // Jika tidak ada header, buat entri sendiri
                                                                                $grouped_obat[$item->created_at->format('Y-m-d H:i:s')] = [
                                                                                    'type' => 'Pemberian Obat',
                                                                                    'icon' => 'fas fa-pills',
                                                                                    'title' => 'Pemberian Obat',
                                                                                    'content' => "{$item->nama_obat} - {$item->dosis} {$item->dosis_satuan} ({$item->signa_s} x {$item->signa_x} {$item->signa_besaran}, {$item->signa_keterangan})",
                                                                                    'created_at' => \Carbon\Carbon::parse($item->created_at),
                                                                                ];
                                                                            }
                                                                        }
                                                                    }
                                                                @endphp

                                                                @foreach ($grouped_obat as $obat)
                                                                    <div>
                                                                        <br>
                                                                        {!! $obat['content'] !!}
                                                                        @if (!empty($obat['obat']))
                                                                            <ul class="obat-list">
                                                                                @foreach ($obat['obat'] as $detail)
                                                                                    <li>{{ $detail }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5><b>Tindakan</b></h5> <!-- Judul Bagian -->
                                                            </td>
                                                            <td colspan="5">
                                                                @foreach($layanan as $index => $data)
                                                                        <ul class="list-unstyled">
                                                                            @foreach(explode(',', $data->jenis_tindakan) as $tindakan)
                                                                                <li>🔹 {{ trim($tindakan) }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    <td colspan="2">{{ $data->doctor->nama_dokter ?? '-' }}</td>
                                                                    <td colspan="2">{{ $data->perawat->nama ?? '-' }}</td>
                                                                @endforeach
                                                            </td>
                                                        </tr>

                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                          </div>
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane active" id="tab_4">
                                                <div class="form-group row">
                                                    <div class="col-md-12 d-flex align-items-center justify-content-center mb-2" style="background-color: #d3d3d3;">
                                                        <h3 class="font">LAPORAN ASESMEN AWAL RAWAT JALAN</h3>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12 d-flex align-items-center">
                                                        <h4 class="font">A. RISIKO JATUH</h4>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-9">
                                                        <div class="form-group row">
                                                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                                                <p class="font mb-0">No.</p>
                                                            </div>

                                                            <div class="col-md-7 d-flex align-items-center justify-content-center">
                                                                <p class="font mb-0">Penilaian / Pengkajian</p>
                                                            </div>

                                                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                                                <p class="font mb-0">Ya</p>
                                                            </div>

                                                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                                                <p class="font mb-0">Tidak</p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                                                <p class="font mb-0">A.</p>
                                                            </div>
                                                            <div class="col-md-7 d-flex align-items-start justify-content-start">
                                                                <div>
                                                                    <p class="font mb-0">Cara berjalan pasien (salah satu atau lebih)</p>
                                                                    <p class="font mb-0">Tidak seimbang/sempoyongan/limbung atau menggunakan alat bantu (kruk, tripot, kursi roda, orang lain)</p>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                                                <input type="checkbox" name="checkbox_a1">
                                                            </div>

                                                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                                                <input type="checkbox" name="checkbox_a2">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                                                <p class="font mb-0">B.</p>
                                                            </div>

                                                            <div class="col-md-7 d-flex align-items-start justify-content-start">
                                                                <p class="font mb-0">Menopang saat akan duduk: tampak memegang pinggiran kursi atau meja/benda lain penopang saat akan duduk</p>
                                                            </div>

                                                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                                                <input type="checkbox" name="checkbox_b1">
                                                            </div>

                                                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                                                <input type="checkbox" name="checkbox_b2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 row">
                                                        <div class="col-md-12 d-flex align-items-center justify-content-center">
                                                            <p class="font mb-0">Tidak Berisiko : a dan b (tidak) <br> Risiko Rendah : a atau b (ya) <br> Risiko Tinggi : a dan b (ya)</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12 d-flex align-items-center mt-2">
                                                        <h4 class="font">B. SKRINNING NYERI</h4>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <div class="col-md-6 d-flex align-items-center justify-content-center">
                                                                <p class="font mb-0">Apakah terdapat keluhan nyeri?</p>
                                                            </div>

                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Tidak</p>
                                                            </div>

                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_ya">
                                                                <p class="font mb-0 ml-2">Ya</p>
                                                            </div>

                                                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                                                <!-- Kosongkan jika tidak ada konten -->
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-1 d-flex align-items-center justify-content-center ml-4">
                                                                <p class="font mb-0">P :</p>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="p" id="p">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-1 d-flex align-items-center justify-content-center ml-4">
                                                                <p class="font mb-0">Q :</p>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="q" id="q">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-1 d-flex align-items-center justify-content-center ml-4">
                                                                <p class="font mb-0">R :</p>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="r" id="r">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-1 d-flex align-items-center justify-content-center ml-4">
                                                                <p class="font mb-0">S :</p>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="s" id="s">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-1 d-flex align-items-center justify-content-center ml-4">
                                                                <p class="font mb-0">T :</p>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="t" id="t">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                                                        <div class="col-md-12">
                                                            <p class="font mb-0">
                                                                P : Provoke (pencetus, faktor yang mempengaruhi gawat/tidaknya, atau beratnya nyeri) <br>
                                                                Q : Quality/kualitas, apakah nyeri seperti tertusuk, tertindih beban, tajam, tumpul, terbakar? <br>
                                                                R : Region (daerah, area perjalanan)  <br>
                                                                S : Severity (keparahan, skala nyeri diukur sesuai dengan tingkat usia dan kondisi/kesadaran pasien) <br>
                                                                T : Timing (waktu, durasi atau lama waktu serangan)
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12 d-flex align-items-center mt-2">
                                                        <h4 class="font">C. RIWAYAT KESEHATAN</h4>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-3 ml-4 d-flex align-items-center">
                                                                <p class="font mb-0">a.	Penyakit yang pernah diderita </p>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" name="s" id="s">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-12 ml-4">
                                                                <p class="font mb-0">b. Operasi yang dialami (Jenis, kapan, komplikasi yang ada) </p>
                                                            </div>
                                                            <div class="col-md-11 ml-4 mt-2">
                                                                <input type="text" class="form-control" name="s" id="s">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3 ml-4">
                                                                <p class="font mb-0">c.	Riwayat penyakit herediter </p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Tidak Ada</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Ada</p>
                                                            </div>
                                                            <div class="col-md-5">
                                                                {{-- KOSONGAN --}}
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-4 ml-4 d-flex align-items-center">
                                                                <p class="font mb-0">d.	Riwayat penyakit dalam keluarga saat ini </p>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" name="s" id="s">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3 ml-4">
                                                                <p class="font mb-0">e.	Ketergantungan terhadap </p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Obat-obatan</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Rokok</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Alkohol</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Tidak ada</p>
                                                            </div>
                                                            <div class="col-md-1">
                                                                {{-- Kosongan --}}
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-6 ml-4">
                                                                <p class="font mb-0">f.	Riwayat pekerjaan (apakah berhubungan dengan zat-zat berbahaya) </p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Tidak</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Ya</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3 ml-4 d-flex align-items-center">
                                                                <p class="font mb-0">g.	Riwayat pengobatan saat di rumah </p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Tidak</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Ya</p>
                                                            </div>
                                                            <div class="col-md-5">
                                                                {{-- KOSONGAN --}}
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-2 ml-4 d-flex align-items-center">
                                                                <p class="font mb-0">h.	Riwayat Alergi </p>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="s" id="s">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>






                                                <div class="form-group row">
                                                    <div class="col-md-12 d-flex align-items-center mt-2">
                                                        <h4 class="font">F. PSIKOLOGIS/SPIRITUAL</h4>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-3 ml-4 d-flex align-items-center">
                                                                <p class="font mb-0">Taat Beribadah </p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Ya</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Tidak</p>
                                                            </div>
                                                            <div class="col-md-5">
                                                                {{-- KOSONGAN --}}
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3-5 ml-5 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Takut terhadap tindakan lingkungan</p>
                                                            </div>
                                                            <div class="col-md-1-5 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Cemas</p>
                                                            </div>
                                                            <div class="col-md-1-5 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Marah/Tegang</p>
                                                            </div>
                                                            <div class="col-md-1-5 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Menangis</p>
                                                            </div>
                                                            <div class="col-md-1 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Sedih</p>
                                                            </div>
                                                            <div class="col-md-1-5 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Senang</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3-5 ml-5 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Tidak mampu menahan diri</p>
                                                            </div>
                                                            <div class="col-md-1-5 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Renda Diri</p>
                                                            </div>
                                                            <div class="col-md-1-5 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Gelisah</p>
                                                            </div>
                                                            <div class="col-md-1-5 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Tenang</p>
                                                            </div>
                                                            <div class="col-md-2-5 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Mudah Tersinggung</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12 d-flex align-items-center mt-2">
                                                        <h4 class="font">G. SOSIAL EKONOMI</h4>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-3 ml-4 d-flex align-items-center">
                                                                <p class="font mb-0">Kebiasaan Bila Sakit </p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Pengobatan alternatif</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Pelayanan kesehatan</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Beli obat di warung</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3 ml-4 d-flex align-items-center">
                                                                <p class="font mb-0">Penggunaan Alat Bantu Diri </p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Tidak</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Alat Bantu Dengar</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Kacamata/Kontak Lensa</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Gigi Palsu</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3 ml-4 d-flex align-items-center">
                                                                <p class="font mb-0">Pasien Tinggal Di </p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Rumah Sendiri</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Rumah Orang Tua</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Kos/Kontrak</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Lainnya</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3 ml-4 d-flex align-items-center">
                                                                <p class="font mb-0">Bantuan Yang Dibutuhkan Pasien </p>
                                                            </div>
                                                            <div class="col-md-1 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Mandi</p>
                                                            </div>
                                                            <div class="col-md-1-5 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">BAB/BAK</p>
                                                            </div>
                                                            <div class="col-md-1 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Makan</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Berjalan Ambulansi</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3 ml-4 d-flex align-items-center">

                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Perawatan Luka</p>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Pemberian Obat</p>
                                                            </div>
                                                            <div class="col-md-4 d-flex align-items-center justify-content-start">
                                                                <input type="checkbox" name="checkbox_b2_tidak">
                                                                <p class="font mb-0 ml-2">Keluarga/Orang yang membantu dirumah</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div><!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>



    <!-- /.content-wrapper -->

    <style>
        .font {
            font-family: 'Times New Roman', Times, serif;
        }

        .col-md-1-5 {
            flex: 0 0 12.5%; /* 1.5 dari 12 kolom (12.5%) */
            max-width: 12.5%;
        }

        .col-md-2-5 {
            flex: 0 0 20.83%; /* 2.5 dari 12 kolom (2.5 / 12 * 100) */
            max-width: 20.83%;
        }

        .col-md-3-5 {
            flex: 0 0 29.17%; /* 3.5 dari 12 kolom (3.5 / 12 * 100) */
            max-width: 29.17%;
        }

    </style>


    {{-- SCRIPT UNTUK TEKANAN NADI --}}
    <script>
        function updateTensi() {
            // Ambil nilai dari input sistol dan distol
            const sistol = document.getElementById('sistol').value.trim();
            const distol = document.getElementById('distol').value.trim();

            // Pastikan kedua input sistol dan distol diisi sebelum melanjutkan
            if (sistol && distol) {
                const sistolValue = parseInt(sistol);
                const distolValue = parseInt(distol);

                // Gabungkan nilai sistol dan distol ke dalam format "sistol/distol"
                const tensiValue = `${sistolValue}/${distolValue}`;
                document.getElementById('tensi').value = tensiValue;

                // Validasi apakah nadi sesuai dengan rentang umur dan apakah nadi adalah angka
                if (isNaN(sistol) || isNaN(distol)) {
                    const message = `Data Tensi Ada Yang Tidak Sesuai.\nMohon isi yang benar!`;

                    // Tampilkan pesan di modal
                    document.getElementById('modalBodyText').innerText = message;
                    $('#confirmationModal').modal('show');

                    // Tangani tombol "Lanjutkan"
                    document.getElementById('modalProceedButton').onclick = function () {
                        document.getElementById('sistol').value = '';
                        document.getElementById('distol').value = '';
                        document.getElementById('tensi').value = '';
                        $('#confirmationModal').modal('hide');
                    };

                    // Tangani tombol "Tidak"
                    document.getElementById('modalCancelButton').onclick = function () {
                        document.getElementById('sistol').value = '';
                        document.getElementById('distol').value = '';
                        document.getElementById('tensi').value = '';
                        $('#confirmationModal').modal('hide');
                    };
                }

                // Tentukan pesan untuk kondisi tertentu
                let message = '';
                if (sistolValue < 120 && distolValue < 80) {
                    message = 'Data Tensi Terdeteksi HIPOTENSI. Apakah Anda ingin melanjutkan?';
                } else if (sistolValue > 140 && distolValue > 90) {
                    message = 'Data Tensi Terdeteksi HIPERTENSI. Apakah Anda ingin melanjutkan?';
                }

                if (message) {
                    // Tampilkan modal konfirmasi dengan pesan yang sesuai
                    document.getElementById('modalBodyText').innerText = message;
                    $('#confirmationModal').modal('show');

                    // Tangani tombol "Lanjutkan"
                    document.getElementById('modalProceedButton').onclick = function () {
                        $('#confirmationModal').modal('hide');
                        // Aksi lanjut, jika diperlukan
                    };

                    // Tangani tombol "Tidak"
                    document.getElementById('modalCancelButton').onclick = function () {
                        document.getElementById('sistol').value = '';
                        document.getElementById('distol').value = '';
                        document.getElementById('tensi').value = '';
                        $('#confirmationModal').modal('hide');
                    };
                }
            }
        }
    </script>

    {{-- SCRIPT UNTUK RR --}}
    <script>
        function validateRR(input) {
            const rrValue = parseInt(input.value.trim()); // Mengambil dan mengubah nilai input menjadi angka

            // Validasi apakah nadi sesuai dengan rentang umur dan apakah nadi adalah angka
            if (isNaN(rrValue)) {
                const message = `Data Respiratory Rate Tidak Sesuai.\nMohon isi yang benar!`;

                // Tampilkan pesan di modal
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tangani tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    input.value = ''; // Menghapus nilai input jika tidak dilanjutkan
                    input.focus();    // Mengembalikan fokus ke input
                    $('#confirmationModal').modal('hide');
                };

                // Tangani tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    input.value = ''; // Menghapus nilai input jika tidak dilanjutkan
                    input.focus();    // Mengembalikan fokus ke input
                    $('#confirmationModal').modal('hide');
                };
            }

            let message = '';
            if (rrValue < 12) {
                message = "Data Respiratory Rate terindikasi terlalu rendah. Apakah Anda ingin melanjutkan?";
            } else if (rrValue > 20) {
                message = "Data Respiratory Rate terindikasi terlalu cepat. Apakah Anda ingin melanjutkan?";
            }

            if (message) {
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    $('#confirmationModal').modal('hide');
                };

                // Tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    input.value = ''; // Menghapus nilai input jika tidak dilanjutkan
                    input.focus();    // Mengembalikan fokus ke input
                    $('#confirmationModal').modal('hide');
                };
            }
        }
    </script>

    {{-- SCRIPT UNTUK SUHU --}}
    <script>
       function validateSuhu(input) {
            let suhuValue = input.value.trim();

            // Cek jika nilai mengandung koma
            if (suhuValue.includes(',')) {
                const message = `Mohon gunakan titik (.) sebagai pemisah desimal, bukan koma !`;

                // Tampilkan pesan di modal
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tangani tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    input.value = ''; // Hapus input
                    $('#confirmationModal').modal('hide');
                };

                // Tangani tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    input.value = ''; // Hapus input
                    $('#confirmationModal').modal('hide');
                };
            }

            const suhuNumber = parseFloat(suhuValue);

            // Validasi apakah nadi sesuai dengan rentang umur dan apakah nadi adalah angka
            if (isNaN(suhuNumber)) {
                const message = `Data Suhu Tidak Sesuai.\nMohon isi yang benar!`;

                // Tampilkan pesan di modal
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tangani tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    input.value = ''; // Hapus input
                    $('#confirmationModal').modal('hide');
                };

                // Tangani tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    input.value = ''; // Hapus input
                    $('#confirmationModal').modal('hide');
                };
            }

            let message = '';
            if (suhuNumber >= 36 && suhuNumber <= 38) {
                message = "Data suhu terindikasi demam dan panas. Apakah Anda ingin melanjutkan?";
            } else if (suhuNumber >= 39) {
                message = "Data suhu terindikasi demam (terlalu tinggi). Apakah Anda ingin melanjutkan?";
            }

            if (message) {
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    $('#confirmationModal').modal('hide');
                };

                // Tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    input.value = ''; // Hapus input
                    $('#confirmationModal').modal('hide');
                };
            }
        }

    </script>

    {{-- SCRIPT UNTUK SpO2 --}}
    <script>
        function validateSpO2(input) {
            const value = parseFloat(input.value.trim());

            // Validasi apakah nadi sesuai dengan rentang umur dan apakah nadi adalah angka
            if (isNaN(value)) {
                const message = `Data spo2 Tidak Sesuai.\nMohon isi yang benar!`;

                // Tampilkan pesan di modal
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tangani tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    input.value = ''; // Hapus input
                    input.focus();    // Kembalikan fokus ke input
                    $('#confirmationModal').modal('hide');
                };

                // Tangani tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    input.value = ''; // Hapus input
                    input.focus();    // Kembalikan fokus ke input
                    $('#confirmationModal').modal('hide');
                };
            }

            if (value < 95 || value > 100) {
                let message = '';

                if (value < 95) {
                    message = "Data SpO2 terdeteksi rendah. SpO2 normalnya adalah 95% atau lebih. Apakah Anda ingin melanjutkan?";
                } else if (value > 100) {
                    message = "Data SpO2 terdeteksi terlalu tinggi. SpO2 normalnya adalah 100% atau kurang. Apakah Anda ingin melanjutkan?";
                }

                // Tampilkan pesan di modal
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tangani tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    $('#confirmationModal').modal('hide');
                    input.dataset.validated = "true"; // Tandai input sebagai divalidasi
                };

                // Tangani tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    input.value = ''; // Hapus input
                    input.focus();    // Kembalikan fokus ke input
                    $('#confirmationModal').modal('hide');
                };
            }
        }

    </script>

    {{-- SCRIPT UNTUK DENYUT NADI --}}
    <script>
     function validateNadi() {
            const nadi = parseInt(document.getElementById('nadi').value.trim());
            const umur = document.getElementById('umurHidden').value.trim();

            // Variabel untuk menyimpan tahun dan bulan
            let tahun = 0;
            let bulan = 0;

            // Regular Expression untuk mengekstrak Tahun dan Bulan
            const regex = /(\d+)\s*Tahun\s*(\d+)\s*Bulan/;

            // Cek apakah format umur sesuai dengan pola "X Tahun Y Bulan"
            const match = umur.match(regex);

            if (match) {
                // Jika cocok, ekstrak tahun dan bulan
                tahun = parseInt(match[1]) || 0;
                bulan = parseInt(match[2]) || 0;
            }

            // Output
            console.log('Tahun:', tahun);
            console.log('Bulan:', bulan);

            let minNadi, maxNadi;

            // Menentukan rentang denyut nadi berdasarkan umur
            if (tahun == 0 && bulan >= 0 && bulan <= 1) {
                minNadi = 70;
                maxNadi = 190;
            } else if (tahun == 0 && bulan >= 1 && bulan <= 11) {
                minNadi = 80;
                maxNadi = 160;
            } else if (tahun >= 1 && tahun <= 2) {
                minNadi = 80;
                maxNadi = 130;
            } else if (tahun >= 3 && tahun <= 4) {
                minNadi = 80;
                maxNadi = 120;
            } else if (tahun >= 5 && tahun <= 6) {
                minNadi = 75;
                maxNadi = 115;
            } else if (tahun >= 7 && tahun <= 9) {
                minNadi = 70;
                maxNadi = 110;
            } else if (tahun >= 10 && tahun <= 19) {
                minNadi = 60;
                maxNadi = 100;
            } else if (tahun >= 20 && tahun <= 35) {
                minNadi = 95;
                maxNadi = 170;
            } else if (tahun >= 36 && tahun <= 50) {
                minNadi = 85;
                maxNadi = 155;
            } else if (tahun > 60) {
                minNadi = 80;
                maxNadi = 130;
            }

            // Validasi apakah nadi sesuai dengan rentang umur dan apakah nadi adalah angka
            if (isNaN(nadi)) {
                const message = `Data Nadi Tidak Sesuai.\nMohon isi yang benar!`;

                // Tampilkan pesan di modal
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tangani tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    document.getElementById('nadi').value = ''; // Kosongkan input
                    document.getElementById('nadi').focus();    // Fokuskan kembali ke input nadi
                    $('#confirmationModal').modal('hide');
                    console.log('Data nadi dihapus.');
                };

                // Tangani tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    document.getElementById('nadi').value = ''; // Kosongkan input
                    document.getElementById('nadi').focus();    // Fokuskan kembali ke input nadi
                    $('#confirmationModal').modal('hide');
                    console.log('Data nadi dihapus.');
                };
            }

            // Validasi apakah nadi sesuai dengan rentang umur
            if (nadi < minNadi || nadi > maxNadi) {
                const message = `Data Nadi Tidak Sesuai.\nRentang Nadi Normal untuk umur ${tahun} Tahun dan ${bulan} Bulan adalah antara ${minNadi} dan ${maxNadi} denyut per menit.\nApakah Anda ingin melanjutkan?`;

                // Tampilkan pesan di modal
                document.getElementById('modalBodyText').innerText = message;
                $('#confirmationModal').modal('show');

                // Tangani tombol "Lanjutkan"
                document.getElementById('modalProceedButton').onclick = function () {
                    $('#confirmationModal').modal('hide');
                    console.log('Melanjutkan dengan data nadi yang tidak sesuai.');
                };

                // Tangani tombol "Tidak"
                document.getElementById('modalCancelButton').onclick = function () {
                    document.getElementById('nadi').value = ''; // Kosongkan input
                    document.getElementById('nadi').focus();    // Fokuskan kembali ke input nadi
                    $('#confirmationModal').modal('hide');
                    console.log('Data nadi dihapus.');
                };
            }
        }

    </script>

    {{-- SCRIPT UNTUK Tinggi dan Berat Badan --}}
    <script>
        function validateTB() {
            // Ambil nilai dari input sistol dan distol
            const tinggi = document.getElementById('tinggi').value.trim();
            const berat = document.getElementById('berat').value.trim();

            // Reset nilai tinggiMeter dan beratKg
            let tinggiMeter = 0;
            let beratKg = 0;

            // Pastikan kedua input tinggi dan berat diisi sebelum melanjutkan
            if (tinggi && berat) {
                // Validasi apakah nadi sesuai dengan rentang umur dan apakah nadi adalah angka
                if (isNaN(tinggi) || isNaN(berat) || tinggi <= 0 || berat <= 0) {
                    const message = `Data Tinggi / Berat Badan Ada Yang Tidak Sesuai.\nMohon isi yang benar!`;

                    // Tampilkan pesan di modal
                    document.getElementById('modalBodyText').innerText = message;
                    $('#confirmationModal').modal('show');

                    // Tangani tombol "Lanjutkan"
                    document.getElementById('modalProceedButton').onclick = function () {
                        document.getElementById('tinggi').value = '';
                        document.getElementById('berat').value = '';
                        document.getElementById('berat').focus();
                        document.getElementById('tinggi').focus();
                        $('#confirmationModal').modal('hide');
                    };

                    // Tangani tombol "Tidak"
                    document.getElementById('modalCancelButton').onclick = function () {
                        document.getElementById('tinggi').value = '';
                        document.getElementById('berat').value = '';
                        document.getElementById('berat').focus();
                        document.getElementById('tinggi').focus();
                        $('#confirmationModal').modal('hide');
                    };
                } else {
                    // Konversi tinggi badan dari cm ke meter
                    tinggiMeter = parseFloat(tinggi) / 100;
                    beratKg = parseFloat(berat);

                    // Hitung BMI menggunakan rumus BMI = berat / (tinggi^2)
                    const bmi = beratKg / (tinggiMeter * tinggiMeter);

                    // Tampilkan hasil BMI di modal atau input lain
                    const bmiMessage = `Data BMI nya adalah: ${bmi.toFixed(2)}`;

                    // Tentukan kategori BMI
                    let bmiCategory = '';
                    if (bmi < 18.5) {
                        bmiCategory = 'Berat badan kurang (Underweight)';
                    } else if (bmi >= 18.5 && bmi <= 24.9) {
                        bmiCategory = 'Berat badan normal';
                    } else if (bmi >= 25 && bmi <= 29.9) {
                        bmiCategory = 'Kelebihan berat badan (overweight)';
                    } else {
                        bmiCategory = 'Obesitas';
                    }

                    // Gabungkan pesan BMI dan kategori
                    const message = bmiMessage + `, Dengan kategori: ${bmiCategory}\nApakah Anda ingin melanjutkan?`;

                    if (message) {
                        // Tampilkan modal konfirmasi dengan pesan yang sesuai
                        document.getElementById('modalBodyText').innerText = message;
                        $('#confirmationModal').modal('show');

                        // Tangani tombol "Lanjutkan"
                        document.getElementById('modalProceedButton').onclick = function () {
                            $('#confirmationModal').modal('hide');
                            // Aksi lanjut, jika diperlukan
                        };

                        // Tangani tombol "Tidak"
                        document.getElementById('modalCancelButton').onclick = function () {
                            document.getElementById('tinggi').value = '';
                            document.getElementById('berat').value = '';
                            document.getElementById('berat').focus();
                            document.getElementById('tinggi').focus();
                            $('#confirmationModal').modal('hide');
                        };
                    }
                }
            }
        }
    </script>

    {{-- SCRIPT AI DOLPHI --}}
    <script>
        // Fungsi untuk mendapatkan data dari form dan menggabungkannya menjadi satu string
        function getFormData() {
            let summernoteContent = document.getElementById('summernote').value;
            // Buat elemen sementara untuk menghapus format HTML
            let tempElement = document.createElement("div");
            tempElement.innerHTML = summernoteContent;

            // Ambil hanya teks tanpa format & gambar
            let pureText = tempElement.innerText || tempElement.textContent;
            let formData = {
                subyektif: document.getElementById('tableData').value,
                tensi: document.getElementById('tensi').value,
                suhu: document.getElementById('suhu').value,
                nadi: document.getElementById('nadi').value,
                rr: document.getElementById('rr').value,
                tinggi: document.getElementById('tinggi').value,
                berat: document.getElementById('berat').value,
                eye: document.getElementById('eye').value,
                verbal: document.getElementById('verbal').value,
                motorik: document.getElementById('motorik').value,
                sadar: document.getElementById('sadar').value,
                spo2: document.getElementById('spo2').value,
                alergi: document.getElementById('alergi').value,
                lingkarPerut: document.getElementById('lingkar_perut').value,
                assessment: document.getElementById('assessmen').value,
                summernote: pureText,
                cerita: document.getElementById('cerita_dokter').value,
            };


            // Gabungkan data menjadi satu teks yang berkesinambungan
            const combinedData = `
                S: ${formData.subyektif}.
                Tensi: ${formData.tensi}, Suhu: ${formData.suhu}°C, Nadi: ${formData.nadi} bpm, RR: ${formData.rr}x/menit.
                TB: ${formData.tinggi} cm, BB: ${formData.berat} kg, LP: ${formData.lingkarPerut} cm.
                GCS: E${formData.eye} V${formData.verbal} M${formData.motorik}, Sadar: ${formData.sadar}, SpO2: ${formData.spo2}%.
                Alergi: ${formData.alergi}.
                Pemeriksaan Head-to-Toe: ${formData.summernote}.
                Keluhan: ${formData.cerita}.
                Assessment: ${formData.assessment}.

            `.trim(); // Menghapus spasi atau baris ekstra

            return { question: combinedData };
        }

     // Fungsi untuk mengirim data ke server
    // Fungsi untuk mengirim data ke server
    function sendDataToServer() {
        // Ambil data form
        const dataToSend = getFormData();
        console.log(JSON.stringify(dataToSend));

        // Mengirim data ke controller Laravel
        fetch('/predict', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF Token
            },
            body: JSON.stringify(dataToSend)
        })
        .then(response => {
            // Periksa apakah respons HTTP berhasil
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json(); // Parsing JSON dari respons
        })
        .then(result => {
            // Cetak hasil JSON ke konsol
            console.log('Response from server:', result);

            // Periksa apakah status dalam respon adalah success
            if (result.status === 'success') {
                const resultText = result.data.text;

                if (resultText) {
                    // Menampilkan hasil di jendela baru
                    openResultInNewWindow(resultText);
                } else {
                    console.warn('No message content found in the response.');
                    alert('No message content found in the response.');
                }
            } else {
                console.error('Error from server:', result.message);
                alert(`Error from server: ${result.message}`);
            }
        })
        .catch(error => {
            console.error('Error occurred:', error.message);
            alert(`Error occurred: ${error.message}`);
        });
    }

    // Fungsi untuk menampilkan hasil pada jendela baru
    function openResultInNewWindow(resultText) {
        const newWindow = window.open("", "_blank", "width=800,height=600");

        if (newWindow) {
            newWindow.document.write(`
                <html>
                <head>
                    <title>Dolphi AI Result</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; color: #333; line-height: 1.6; }
                        h2 { color: #007bff; text-align: center; }
                        pre { background-color: #f4f4f4; padding: 10px; border-radius: 5px; font-size: 14px; white-space: pre-wrap; word-wrap: break-word; }
                    </style>
                </head>
                <body>
                    <h2>Hasil Prediksi Dolphi AI</h2>
                    <pre>${resultText}</pre>
                </body>
                </html>
            `);
            newWindow.document.close();
        } else {
            alert('Popup blocked! Please allow popups for this website.');
        }
    }


        // Event listener untuk tombol 'Bantuan Dholpi AI'
        document.getElementById('ai').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah pengiriman form secara default

            // Kirim data ke server
            sendDataToServer();
        });
    </script>

    {{-- SCRIPT KESADARAN --}}
    <script>
        $(document).ready(function() {
            // Function to calculate and select "sadar" based on sum of eye, verbal, motorik
            function updateSadarSelection() {
                let eyeScore = parseInt($('#eye').val()) || 0;
                let verbalScore = parseInt($('#verbal').val()) || 0;
                let motorikScore = parseInt($('#motorik').val()) || 0;

                // Calculate total score
                let totalScore = eyeScore + verbalScore + motorikScore;

                // Find and select the option in "sadar" that matches the totalScore
                $('#sadar').val(totalScore).trigger('change');
            }

            // Attach event listeners to each dropdown to trigger the update when value changes
            $('#eye, #verbal, #motorik').on('change', updateSadarSelection);
        });

    </script>
    {{-- SCRIPT OBAT --}}
    <script>
        let patientWindow = null; // Variabel untuk menyimpan referensi jendela yang sudah dibuka

        function bukaJendelaPasien(norm) {
            const url = `/layanan/rawat-jalan/soap-dokter/resep-obat/${norm}`;

            // Jika jendela sudah dibuka dan belum ditutup, fokus pada jendela itu
            if (patientWindow && !patientWindow.closed) {
                patientWindow.focus();
            } else {
                // Jika belum ada jendela atau jendela sebelumnya ditutup, buka jendela baru
                patientWindow = window.open(url, "_blank", "width=800,height=600");
            }
        }

    </script>
    {{-- SCRIPT GIGI --}}
    <script>
        let patientWindowanot = null; // Variabel untuk menyimpan referensi jendela yang sudah dibuka

        function bukaJendelaPasienanotomi(norm) {
            const url = `/layanan/rawat-jalan/soap-dokter/odontogram/${norm}`;

            // Jika jendela sudah dibuka dan belum ditutup, fokus pada jendela itu
            if (patientWindowanot && !patientWindowanot.closed) {
                patientWindowanot.focus();
            } else {
                // Jika belum ada jendela atau jendela sebelumnya ditutup, buka jendela baru
                patientWindowanot = window.open(url, "_blank", "width=1280,height=800");
            }
        }

    </script>

    <script>
        function diet(norm) {
            const url = `/regis/diet/${norm}`; // Ganti norm sesuai parameter

            // Membuka jendela baru dengan URL yang sudah disiapkan
            window.open(url, "_blank", "width=800,height=600");
        }
    </script>
    <script>
        function layanan(norm) {
            const url = `/layanan/rawat-jalan/soap-dokter/tindakan/${norm}`; // Ganti norm sesuai parameter

            // Membuka jendela baru dengan URL yang sudah disiapkan
            window.open(url, "_blank" );
        }
    </script>

    <script>
        $(document).ready(function() {
            function toggleTableVisibility() {
                // Check ICD-10 table
                const icd10Table = $(".icd_10 tbody");
                console.log(icd10Table.children("tr").length); // Debug the row count
                if (icd10Table.children("tr").length === 0) {
                    icd10Table.closest(".isi_10").hide(); // Hide the ICD-10 row if no data
                }

                const icd9Table = $(".icd_9 tbody");
                console.log(icd9Table.children("tr").length); // Debug the row count

                if (icd9Table.children("tr").length === 1) {
                    icd9Table.closest(".isi_9").hide();
                }


                const kosongRow = $(".kosong");

                if (icd10Table.children("tr").length === 0 && icd9Table.children("tr").length === 1) {
                    kosongRow.show();  // Show "Data Tidak Ada" row if both tables are empty
                } else {
                    kosongRow.hide();  // Hide "Data Tidak Ada" row if either table has data
                }

            }


            // Initial call to check visibility when the page loads
            toggleTableVisibility();

            // Use this event to recheck visibility when a new row is added or deleted dynamically
            $(document).on('rowAdded rowRemoved', function() {
                toggleTableVisibility();
            });

            // Example event trigger for row addition and removal
            $(document).on('click', '.deleteICD10, .deleteICD9', function() {
                $(this).closest('tr').remove();
                $(document).trigger('rowRemoved');
            });

            // To handle rows added via AJAX or other methods, trigger the 'rowAdded' event after adding a row
            // $(document).trigger('rowAdded');
        });
    </script>

{{-- Script untuk umur dan tgl jam --}}
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

{{-- script untuk membuka card ICD --}}
    <script>
        document.getElementById('toggleICD').addEventListener('click', function() {
            var icdCard = document.getElementById('icdCard');

            // Memeriksa apakah card sedang ditampilkan atau disembunyikan
            if (icdCard.style.display === "none" || icdCard.style.display === "") {
                icdCard.style.display = "block";  // Menampilkan card
            } else {
                icdCard.style.display = "none";  // Menyembunyikan card
            }
        });
    </script>

{{-- Final Script untuk ICD-10 --}}
    <script>
        $(document).ready(function () {
            var selectedICD10 = null;
            var selectedPriorityICD10 = null;

            // Event listener for ICD-10 select dropdown
            $('#icd10').on('change', function () {
                var selectedOption = $(this).find('option:selected');
                selectedICD10 = {
                    code: selectedOption.val(),
                    name: selectedOption.data('nama')
                };
                // Display the selected code on the button
                $('#kodeICD10').text(selectedICD10.code);
            });

            // Event listener for priority dropdown items, specifically for ICD-10
            $('#dropdownMenuButtonICD10').next('.dropdown-menu').find('.dropdown-item').on('click', function () {
                selectedPriorityICD10 = $(this).data('value');
                // Display the selected priority in the span
                $('#prioritas_icd_10').text(selectedPriorityICD10);
            });

            // Event listener for clicking the Accept button
            $('#acceptICD10').on('click', function () {
                if (!selectedICD10 || !selectedPriorityICD10) {
                    alert('Pilih Diagnosa dan Prioritas!');
                    return;
                }

                // Check if the selected ICD-10 already exists in the table
                var exists = false;
                $('.icd_10 tbody tr').each(function () {
                    var code = $(this).find('td:first').text().trim();
                    if (code === selectedICD10.code) {
                        exists = true;
                        return false; // exit loop if found
                    }
                });

                if (exists) {
                    alert('Data sudah ada di tabel.');
                } else {
                    // Make an AJAX request to save the data to the database
                    $.ajax({
                        url: '{{ route("diagnosa.store") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            no_rawat: '{{ $rajaldata->no_rawat }}',
                            kode: selectedICD10.code,
                            prioritas: selectedPriorityICD10,
                            status_penyakit: 'your_status_value_here' // Set status_penyakit accordingly
                        },
                        success: function (response) {
                            if (response.success) {
                                // Add the new row to the table
                                var newRow = '<tr align="center" data-id="' + response.id + '">' +
                                    '<td valign="top" style="border: none;">' + selectedICD10.code + '</td>' +
                                    '<td valign="top" style="border: none;">' + selectedICD10.name + '</td>' +
                                    '<td valign="top" style="border: none;">' + selectedPriorityICD10 + '</td>' +
                                    '<td valign="top" style="border: none;"><button type="button" class="btn btn-danger btn-sm deleteICD10">Hapus</button></td>' +
                                    '</tr>';
                                $('.icd_10 tbody').append(newRow);

                                const icd10Table = $(".icd_10 tbody");
                                const kosongRow = $(".kosong");
                                kosongRow.hide();  // Hide "Data Tidak Ada" row if either table has data
                                icd10Table.closest(".isi_10").show(); // Show if data is present

                                // Reset the fields after adding the data
                                resetFieldsICD10();
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function (xhr) {
                            alert('Error occurred: ' + xhr.responseText);
                        }
                    });
                }
            });

            // Event listener for removing rows from the ICD-10 table and deleting from the database
            $(document).on('click', '.deleteICD10', function () {
                var row = $(this).closest('tr');
                var id = row.data('id'); // Get the ID from the data-id attribute

                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    // Send an AJAX request to delete the record from the database
                    $.ajax({
                        url: '{{ route("diagnosa.destroy") }}', // Route for deleting
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id  // Pass the ID to delete
                        },
                        success: function (response) {
                            if (response.success) {
                                row.remove(); // Remove the row from the table
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function (xhr) {
                            alert('Error occurred: ' + xhr.responseText);
                        }
                    });
                }
            });

            // Function to reset the form fields after accept
            function resetFieldsICD10() {
                $('#icd10').val('').trigger('change');
                $('#kodeICD10').text('KODE ICD 10');
                $('#prioritas_icd_10').text('Pilih');
                selectedICD10 = null;
                selectedPriorityICD10 = null;
            }
        });
    </script>

{{-- Final Script ICD-9 --}}
    <script>
        $(document).ready(function () {
            var selectedICD9 = null;
            var selectedPriority = null;

            // Event listener for ICD-9 select dropdown
            $('#icd9').on('change', function () {
                var selectedOption = $(this).find('option:selected');
                selectedICD9 = {
                    id: selectedOption.val(),
                    code: selectedOption.data('code'),
                    name: selectedOption.data('nama')
                };
                // Display the selected code on the button
                $('#kodeICD9').text(selectedICD9.code);
            });

            // Event listener for priority dropdown items, specifically for ICD-9
            $('#dropdownMenuButtonICD9').next('.dropdown-menu').find('.dropdown-item').on('click', function () {
                selectedPriority = $(this).data('value');
                // Display the selected priority in the span
                $('#prioritas_icd_9').text(selectedPriority);
            });

            // Event listener for clicking the Accept button
            $('#acceptICD9').on('click', function () {
                if (!selectedICD9 || !selectedPriority) {
                    alert('Pilih Diagnosa dan Prioritas!');
                    return;
                }

                // Check if the selected ICD-9 already exists in the table
                var exists = false;
                $('.icd_9 tbody tr').each(function () {
                    var code = $(this).find('td:first').text().trim();
                    if (String(code) === String(selectedICD9.code)) {
                        exists = true;
                        return false; // exit loop if found
                    }
                });

                if (exists) {
                    alert('Data sudah ada di tabel.');
                } else {
                    // Make an AJAX request to save the data to the database
                    $.ajax({
                        url: '{{ route("prosedur.store") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            no_rawat: '{{ $rajaldata->no_rawat }}',
                            kode: selectedICD9.code,
                            prioritas: selectedPriority
                        },
                        success: function (response) {
                            if (response.success) {
                                // Add the new row to the table
                                var newRow = '<tr align="center" data-id="' + response.id + '">' +
                                    '<td valign="top" style="border: none;">' + selectedICD9.code + '</td>' +
                                    '<td valign="top" style="border: none;">' + selectedICD9.name + '</td>' +
                                    '<td valign="top" style="border: none;">' + selectedPriority + '</td>' +
                                    '<td valign="top" style="border: none;"><button type="button" class="btn btn-danger btn-sm deleteICD9">Hapus</button></td>' +
                                    '</tr>';
                                $('.icd_9 tbody').append(newRow);

                                const kosongRow = $(".kosong");
                                const icd9Table = $(".icd_9 tbody");
                                kosongRow.hide();  // Hide "Data Tidak Ada" row if either table has data
                                icd9Table.closest(".isi_9").show();

                                // Reset the fields after adding the data
                                resetFields();
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function (xhr) {
                            alert('Error occurred: ' + xhr.responseText);
                        }
                    });
                }
            });

            // Event listener for removing rows from the ICD-9 table and deleting from the database
            $(document).on('click', '.deleteICD9', function () {
                var row = $(this).closest('tr');
                var kode = row.find('td:first').text().trim(); // Get the ICD-9 code from the first column
                var id = row.data('id'); // Get the ID from the data-id attribute

                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    // Send an AJAX request to delete the record from the database
                    $.ajax({
                        url: '{{ route("prosedur.destroy") }}', // Route for deleting
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,  // Pass the ID to delete
                            kode: kode // (Optional) pass the kode if needed
                        },
                        success: function (response) {
                            if (response.success) {
                                row.remove(); // Remove the row from the table
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function (xhr) {
                            alert('Error occurred: ' + xhr.responseText);
                        }
                    });
                }
            });

            // Function to reset the form fields after accept
            function resetFields() {
                $('#icd9').val('').trigger('change');
                $('#kodeICD9').text('KODE ICD 9');
                $('#prioritas_icd_9').text('Pilih');
                selectedICD9 = null;
                selectedPriority = null;
            }
        });
    </script>

    <script>
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
    </script>


@endsection
