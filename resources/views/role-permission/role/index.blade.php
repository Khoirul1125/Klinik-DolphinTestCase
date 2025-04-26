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
                                <h3 class="card-title">Data Role</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#addroleModal">
                                        <i class="fas fa-plus"></i> Add Role
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @php
                                    use Carbon\Carbon;
                                    Carbon::setLocale('id');
                                @endphp
                                <table id="roletbl" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Role</th>
                                            <th>Permesion</th>
                                            <th width="40%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    @if(isset($rolesWithPermissions[$role->id]))
                                                        @foreach ($rolesWithPermissions[$role->id] as $permission)
                                                            <span class="badge bg-info">{{ $permission->permission_name }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">Tidak ada permission</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="#" data-toggle="modal" data-target="#editroleModal" data-id="{{ $role->id }}" data-nama-role="{{ $role->name }}" class="edit-data-role"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    <a href="{{ route('role.give', ['roleId' => $role->id]) }}" class="delete-data-role"> <i class="fa-regular fa-address-book"></i></a>
                                                    <a href="#" data-toggle="modal" data-target="#deleteroleModal" data-id="{{ $role->id }}" data-nama-role="{{ $role->name }}" class="delete-data-role"><i class="fa-regular fa-trash-can"></i></a>
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


    <div class="modal fade" id="addroleModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Baru Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('role.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Nama Role</label>
                                    <input type="text" class="form-control" id="rolename" name="rolename">
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




    <div class="modal fade" id="editroleModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('role.update') }}" method="POST">
                        @csrf
                        <input type="hidden" id="roleid" name="roleid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Nama Role</label>
                                    <input type="text" class="form-control" id="rolenames" name="rolenames">
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

    <div class="modal fade" id="deleteroleModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form  action="{{ route('role.destroy') }}" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Hapus Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="roleids" name="roleids">
                        <div id="deleteTextrole"></div>
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
            $("#roletbl").DataTable({
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
    <script>
        $(document).on('click', '.edit-data-role', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama-role');

            $('#roleid').val(id);
            $('#rolenames').val(nama);
        });

        $('#editFormrole').on('submit', function(e) {
        e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    $('#editroleModal').modal('hide');
                    alert.fire({
                        icon: 'success',
                        title: response.message
                    });
                    window.location.href = '{{ route('role') }}';
                },
                error: function(xhr) {
                     toastr.error('Terjadi kesalahan saat menyimpan kendaraan.');
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.delete-data-role', function() {
            var id = $(this).data('id');
            var name = $(this).data('nama-role');

            $('#roleids').val(id);
            $('#deleteTextrole').html("<span>Apa anda yakin ingin menghapus Role <b>" + name + "</b></span>");
        });
    </script>
@endsection
