@extends('template.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">

                </div>
                <!-- /.row -->
                <!-- Main row -->

                <div class="row">
                    <div class="info-box bg-light p-3 text-center">
                        <div class="info-box-content">
                            <span class="info-box-text d-block" style="font-size: 24px; font-weight: bold;  ">Selamat datang kembali, {{ Auth::user()->name }} !</span>
                            <span class="info-box-number d-block">Kami sangat menghargai dedikasi Anda dalam membantu pasien. Terima kasih atas semua yang Anda lakukan!</span>
                        </div>
                        <hr>
                    </div>
                </div>




                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- {{-- ChartJS --}} -->


@endsection
