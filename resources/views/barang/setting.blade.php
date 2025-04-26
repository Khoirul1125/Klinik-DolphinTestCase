@extends('template.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-3 col-md-12">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 card-title">Data Transaksi</h5>
                        </div>
                    </div>
                    <form action="{{ route('gudang.setting.add') }}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row d-flex align-items-center">
                                                <span class="col-md-12 col-form-span">Setup % Untuk Auto Import dari Faktur ke Harga Jual Netto :</span>
                                            </div>
                                            <div class="form-group row d-flex align-items-center">
                                                <label class="col-md-3 col-form-label">H. Jual Net I</label>
                                                <div class="col-md-1 text-center">:</div>
                                                <div class="col-md-2">
                                                    <input type="number" class="form-control" id="hj_1" name="hj_1" value="{{ $setting->hj_1 ?? old('hj_1') }}">
                                                </div>
                                                <div class="col-md-1 text-left">%</div>
                                                <div class="col-md-5 text-center">UGD / IGD</div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center">
                                                <label class="col-md-3 col-form-label">H. Jual Net II</label>
                                                <div class="col-md-1 text-center">:</div>
                                                <div class="col-md-2">
                                                    <input type="number" class="form-control" id="hj_2" name="hj_2" value="{{ $setting->hj_2 ?? old('hj_2') }}">
                                                </div>
                                                <div class="col-md-1 text-left">%</div>
                                                <div class="col-md-5 text-center">Rawat Jalan</div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center">
                                                <label class="col-md-3 col-form-label">H. Jual Net III</label>
                                                <div class="col-md-1 text-center">:</div>
                                                <div class="col-md-2">
                                                    <input type="number" class="form-control" id="hj_3" name="hj_3" value="{{ $setting->hj_3 ?? old('hj_3') }}">
                                                </div>
                                                <div class="col-md-1 text-left">%</div>
                                                <div class="col-md-5 text-center">Rawat Inap</div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center">
                                                <label class="col-md-3 col-form-label">H. Jual Net IV</label>
                                                <div class="col-md-1 text-center">:</div>
                                                <div class="col-md-2">
                                                    <input type="number" class="form-control" id="hj_4" name="hj_4" value="{{ $setting->hj_4 ?? old('hj_4') }}">
                                                </div>
                                                <div class="col-md-1 text-left">%</div>
                                                <div class="col-md-5 text-center">ASURANSI</div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center">
                                                <label class="col-md-3 col-form-label">H. Jual Net V</label>
                                                <div class="col-md-1 text-center">:</div>
                                                <div class="col-md-2">
                                                    <input type="number" class="form-control" id="hj_5" name="hj_5" value="{{ $setting->hj_5 ?? old('hj_5') }}">
                                                </div>
                                                <div class="col-md-1 text-left">%</div>
                                                <div class="col-md-5 text-center">Pasien Umum</div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group row d-flex align-items-center">
                                                <label class="col-md-12 col-form-label">Mode Embalase (Untuk Resep)</label>
                                            </div>
                                            <div class="form-group row d-flex align-items-center">
                                                <label class="col-md-7 col-form-label">Embalase Kelipatan : 1 Poin = Rp.</label>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control" id="embalase" name="embalase" value="{{ $setting->embalase ?? old('embalase') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Footer -->
                                <div class="card-footer text-end bg-light">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

    <script>
        $(document).ready(function() {
            $("#tabelkodedata").DataTable({
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
