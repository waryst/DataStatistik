@extends('layout.adminweb.index')

@section('pageTitle', 'Data Statistik Sektoral Kabupaten Ponorogo')
@section('pageDashboard', "Data User $cek_id->name")

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="pull-right">
                                <button type="button" class="btn btn-primary my-3" data-toggle="modal"
                                    data-target="#modal_add_new"><i class="fas fa-plus"></i> Tambah Data User</button>
                            </div>
                            <table id="datatable" name="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 7%">#</th>
                                        <th class="text-center" style="width: 20%">Nama</th>
                                        <th class="text-center" style="width: 20%">Email (Username)</th>
                                        <th class="text-center" style="width: 10%">Privilege</th>
                                        <th class="text-center" style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $users)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $users->name }}</td>
                                            <td>{{ $users->email }}</td>
                                            <td class="text-center">
                                                @if ($users->role == 'administrator')
                                                    Wali Data
                                                @elseif ($users->role == 'verifikator')
                                                    Verifikator
                                                @elseif ($users->role == 'admin')
                                                    Operator
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <abbr title="Edit Nama / User"><button
                                                        class="btn bg-primary btn-sm edit my-1" nama="<?php echo $users->name; ?>"
                                                        user="<?php echo $users->email; ?>" hak="<?php echo $users->role; ?>"
                                                        id="<?php echo $users->id; ?>">
                                                        <i class="far fa-edit"></i> </button></abbr>
                                                <form action="{{ url("/data_instansi/reset_user/$users->id") }}"
                                                    method="POST" id='reset{{ $users->id }}' class="d-inline">
                                                    @csrf
                                                    <abbr title="Reset Password"><button
                                                            class="btn bg-info btn-sm reset my-1" id='{{ $users->id }}'>
                                                            <i class="fas fa-user-cog"></i>
                                                        </button></abbr>
                                                </form>
                                                <form action="{{ url("/data_instansi/hapus_user/$users->id") }}"
                                                    method="POST" id='hapus{{ $users->id }}' class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <abbr title="Hapus Data User"><button
                                                            class="btn bg-danger btn-sm hapus my-1"
                                                            id='{{ $users->id }}'>
                                                            <i class="far fa-trash-alt"></i></i>
                                                        </button></abbr>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal_add_new" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Data User</h3>
                        </div>
                        <form method="POST" role="form" id="quickForm"
                            action="{{ url("/data_instansi/daftar_user/$cek_id->id") }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Operator </label>
                                    <input type="text" class="form-control" required name="judul"
                                        id="exampleInputEmail1" placeholder="Nama Operator">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Email (Username)</label>
                                    <input type="text" class="form-control" required name="deskripsi"
                                        id="exampleInputPassword1" placeholder="Email">
                                </div>
                                @if (auth()->user()->role == 'administrator')
                                    <div class="form-group">
                                        <label for="hak">Verifikator</label>
                                        <input type="checkbox" name="hak" data-bootstrap-switch data-on-color="success">
                                    </div>
                                @endif
                                <div class="form-group" style="font-size: 20px">
                                    Password Default : <strong> 1234567 </strong>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editmodal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Update Data User</h3>
                        </div>
                        <form method="POST" role="form" id="editform" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="title">Nama Operator</label>
                                    <input type="text" class="form-control" required name="title" id="title"
                                        placeholder="Nama Operator">
                                </div>
                                <div class="form-group">
                                    <label for="description">Email (Username)</label>
                                    <input type="text" class="form-control" required name="description"
                                        id="description" placeholder="Email">
                                </div>
                                @if (auth()->user()->role == 'administrator')
                                    <div class="form-group">
                                        <label for="hak">Verifikator</label>
                                        <div id="hak_admin"></div>
                                    </div>
                                @endif
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

@endsection
@section('java')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.edit').click(function() {
                $('#editmodal').modal();
                var id = $(this).attr('id');
                var judul = $(this).attr('nama');
                var diskripsi = $(this).attr('user');
                if ($(this).attr('hak') == 'verifikator') {
                    $('#hak_admin').html(`
                    <input type="checkbox" name="hak" data-bootstrap-switch  checked data-on-color="success">          
                    `);
                } else if ($(this).attr('hak') == 'admin') {
                    $('#hak_admin').html(`
                    <input type="checkbox" name="hak" data-bootstrap-switch   data-on-color="success">          
                    `);
                }
                $("input[data-bootstrap-switch]").each(function() {
                    $(this).bootstrapSwitch('state', $(this).prop('checked'));
                });
                $('#title').val(judul);
                $('#description').val(diskripsi);
                $('#editform').attr('action', "{{ url('/data_instansi/edit_user') }}" + '/' + id)

            })
            $('.reset').on('click', function(e) {
                e.preventDefault();
                const id = $(this).attr('id');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data Password  akan di Reset!!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Reset Password!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#reset' + id).submit();
                    }
                })
            });
            $('.hapus').on('click', function(e) {
                e.preventDefault();
                const id = $(this).attr('id');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data User  akan di Hapus Permanen!!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus User!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#hapus' + id).submit();
                    }
                })
            });

            $("#datatable").DataTable({
                "responsive": true,
                "autoWidth": false,
                "columnDefs": [{
                    "targets": [3], //first column / numbering column
                    "orderable": false, //set not orderable
                }, ],
            });

        });
    </script>
    <script src="{{ asset('asset_adminweb') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

    <script>
        $(function() {
            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });

        })
    </script>

@endsection
