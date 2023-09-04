@extends('layout.adminweb.index')

@section('title', 'Data Instansi')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="pull-right">
                                <button type="button" class="btn btn-primary my-3" data-toggle="modal"
                                    data-target="#modal_add_new"><i class="fas fa-plus"></i> Tambah Data</button>
                            </div>
                            <table id="datatable" name="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 7%">#</th>
                                        <th style="width: 30%">Nama Instansi</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center" style="width: 15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($instansi as $instansi)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $instansi->name }}</td>
                                            <td>
                                                {{ $instansi->description }}
                                            </td>
                                            <td class="text-center">
                                                <abbr title="Edit Nama dan Deskripsi Instansi"> <button
                                                        class="btn bg-primary btn-sm edit my-1" judul="<?php echo $instansi->name; ?>"
                                                        discripsi="<?php echo $instansi->description; ?>" id="<?php echo $instansi->id; ?>">
                                                        <i class="far fa-edit"></i> </button></abbr>
                                                <abbr title="Data User"> <a
                                                        href="{{ url("/data_instansi/daftar_user/$instansi->name") }}"
                                                        class="btn bg-gradient-info btn-sm my-1"> <i
                                                            class="fas fa-users"></i>
                                                    </a></abbr>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Input Data Instansi</h3>
                        </div>
                        <form method="POST" role="form" id="quickForm" action="{{ url('/data_instansi') }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Instansi</label>
                                    <input type="text" class="form-control" name="judul" id="exampleInputEmail1"
                                        placeholder="Nama Instansi">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Deskripsi Instansi</label>
                                    <input type="text" class="form-control" name="deskripsi" id="exampleInputPassword1"
                                        placeholder="Deskripsi">
                                </div>
                            </div>
                            <div class="card-footer">
                                {{-- <button type="submit" class="btn btn-primary">Simpan</button> --}}
                                <button class="btn btn-primary button-simpan" type="submit">
                                    Simpan </button>
                                <button class="btn btn-primary loading-simpan">
                                    <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i>
                                        Simpan
                                    </div>
                                </button>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Update Data Instansi</h3>
                        </div>
                        <form method="POST" role="form" id="editform" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="title">Nama Instansi</label>
                                    <input type="text" class="form-control" name="title" id="title"
                                        placeholder="Nama Instansi">
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi Instansi</label>
                                    <input type="text" class="form-control" name="description" id="description"
                                        placeholder="Deskripsi">
                                </div>

                                <div class="card-footer">
                                    <button class="btn btn-success button-prevent" type="submit">
                                        Update </button>
                                    <button class="btn btn-success loading">
                                        <div class="spinner"><i role="status"
                                                class="spinner-border spinner-border-sm"></i>
                                            Update
                                        </div>
                                    </button>
                                    <button type="button" class="btn btn-secondary float-right"
                                        data-dismiss="modal">Close</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('java')
    <script>
        (function() {
            $('.button-simpan').click(function() {
                $('.button-simpan').attr('hidden', 'true');
                $('.loading-simpan').show();
                $('.loading-simpan').attr('disabled', 'true');
                $('.spinner').show();

            })

            $('.edit').on('click', function() {
                $('#editmodal').modal();
                var id = $(this).attr('id');
                var judul = $(this).attr('judul');
                var diskripsi = $(this).attr('discripsi');

                $('#title').val(judul);
                $('#description').val(diskripsi);
                console.log(id);
                $('.button-prevent').attr('id', id);
            })
            $('.button-prevent').click(function() {
                var id = $(this).attr('id');
                $('#editform').attr('action', "{{ url('/data_instansi') }}" + '/' + id)
                $('.button-prevent').attr('hidden', 'true');
                $('.loading').show();
                $('.loading').attr('disabled', 'true');
                $('.spinner').show();
            })
        })();
        $(document).ready(function() {
            $('.tombol-hapus').on('click', function(e) {
                e.preventDefault();
                const id = $(this).attr('id');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data Instansi akan di hapus!!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus Data!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete' + id).submit();
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
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            bsCustomFileInput.init();
            $('#quickForm').validate({
                rules: {
                    judul: {
                        required: true,
                    },
                    deskripsi: {
                        required: true,
                    },
                },
                messages: {
                    judul: {
                        required: "Masukkan Nama Instansi",
                    },
                    deskripsi: {
                        required: "Deskripsi Harus Di isi",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            $('#editform').validate({
                rules: {
                    title: {
                        required: true,
                    },
                    description: {
                        required: true,
                    },
                },
                messages: {
                    title: {
                        required: "Masukkan Nama Instansi",
                    },
                    description: {
                        required: "Deskripsi Harus Di isi",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
