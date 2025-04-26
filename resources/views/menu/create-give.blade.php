@extends('template.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"></h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{  $menus['name'] }}</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#addpermesionModal">
                                        <i class="fas fa-plus"></i> Add Permesion
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @php
                                    use Carbon\Carbon;
                                    Carbon::setLocale('id');
                                @endphp
                                <table id="premesiontbl" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Url</th>
                                            <th class="text-center">Icon</th>
                                            <th class="text-center">Permesion</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($submenus as $submenus)
                                            <tr>
                                                <td>{{ $submenus->name }}</td>
                                                <td>{{ $submenus->route_name }}</td>
                                                <td>{{ $submenus->icon }}</td>
                                                {{-- <td>{{ $submenu->permission->name }}</td> --}}
                                                <td>
                                                    <!-- Tombol atau Link untuk Aksi "Give" -->
                                                    {{-- <a href="{{ route('menu.create.sub', ['menuId' => $submenu->id]) }}" class="btn btn-primary">Give</a> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <div class="modal fade" id="addpermesionModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

        <form action="{{ route('menu.store.sub', ['menuId' => $menus->id]) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Nama Submenu</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>URL Submenu</label>
                        <input type="text" class="form-control" id="route_name" name="route_name">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Masukkan Icon</label>
                        <input type="text" class="form-control" id="icon" name="icon">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Nama Permission</label>
                        <select name="permissions[]" id="permissions" class="form-control select2bs4" multiple="multiple">
                            <option value="">-- Pilih Permission --</option>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Submenu Level</label>
                        <select name="submenu_level" id="submenu_level" class="form-control">
                            <option value= 0 >Menu Utama</option>
                            @foreach ($submenu as $item)
                                <option value="{{ $item->id }}">Submenu dari {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Sub Menu</label>
                        <select name="submenu" id="submenu" class="form-control" required>
                            <option value="f">-- Tidak --</option>
                            <option value="t">-- Ya --</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Submenu</button>
            </div>
        </form>
            </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="editpermesionModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="editFormpermesion" action="{{ route('permissions.update') }}" method="POST">
                    @csrf
                    <input type="hidden" id="permissionsid" name="permissionsid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Nama Pejabat</label>
                                <input type="text" class="form-control" id="permissionnames" name="permissionnames">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button> <!-- Submit button -->
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletepermesionModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="deleteFormpermesion" action="{{ route('permissions.destroy') }}" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Hapus Data permesion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="permissionsids" name="permissionsids">
                        <div id="deleteTextpermissions"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#premesiontbl").DataTable({
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
