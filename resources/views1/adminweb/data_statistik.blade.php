@extends('layout.adminweb.index')

@section('title', "Data Statistik $cek_id->name")

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
                                        <th style="width: 30%">Judul</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center" style="width: 15%">Action</th>
                                        <th hidden>id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_statistik as $data_statistik)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $data_statistik->title }}</td>
                                            <td>
                                                {{ $data_statistik->description }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ url('Data/' . $data_statistik->instansi_id . '/' . $data_statistik->file) }}"
                                                    class="btn btn-success btn-sm py-1"><i class="fas fa-file-excel"></i>
                                                </a>
                                                <a href="#" class="btn bg-primary btn-sm edit my-1"> <i
                                                        class="far fa-edit"></i>
                                                </a>
                                                <form
                                                    action="{{ url('data_instansi/update_data_statistik/' . $data_statistik->id) }}"
                                                    method="POST" id='delete{{ $data_statistik->id }}' class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn bg-danger btn-sm tombol-hapus"
                                                        id='{{ $data_statistik->id }}'><i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td hidden>{{ $data_statistik->id }}</td>
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
                            <h3 class="card-title">Input Data Statistik {{ $cek_id->name }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <form method="POST" role="form" id="quickForm"
                            action="{{ url("/data_instansi/data_statistik/$cek_id->id") }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Judul Data</label>
                                    <input type="text" class="form-control" name="judul" id="exampleInputEmail1"
                                        placeholder="Judul Data">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Deskripsi Data</label>
                                    <textarea rows="6" class="form-control" name="deskripsi" id="exampleInputPassword1" placeholder="Deskripsi"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Input File Excel</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input"
                                                id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Pilih
                                                File</label>
                                        </div>
                                    </div>
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
    <div class="modal fade" id="editmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Update Data Statistik {{ $cek_id->name }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <form method="POST" role="form" id="editform" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Judul Data</label>
                                    <input type="text" class="form-control" name="title" id="title"
                                        placeholder="Judul Data">
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi Data</label>
                                    <textarea rows="6" class=" form-control" name="description" id="description" placeholder="Deskripsi"> </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="file">Input File Excel</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input"
                                                id="file">
                                            <label class="custom-file-label" for="file">Pilih File</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Update</button>
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
@endsection
@section('java')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.tombol-hapus').on('click', function(e) {
                e.preventDefault();
                const id = $(this).attr('id');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data Statistik akan di hapus!!",
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
            $(function() {
                $("#datatable").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "columnDefs": [{
                        "targets": [3, 4], //first column / numbering column
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
                var table = $('#datatable').DataTable();
                table.on('click', '.edit', function() {

                    $tr = $(this).closest('tr');
                    if ($($tr).hasClass('child')) {
                        $tr = $tr.prev('.parent');
                    }
                    var data = table.row($tr).data();
                    console.log(data);
                    $('#title').val(data[1]);
                    $('#description').val(data[2]);
                    $('#editform').attr('action',
                        "{{ url('/data_instansi/update_data_statistik') }}" +
                        '/' +
                        data[4])

                    $('#editmodal').modal('show');

                });

            });
            bsCustomFileInput.init();
            $('#quickForm').validate({
                rules: {
                    judul: {
                        required: true,
                        minlength: 5,
                    },
                    deskripsi: {
                        required: true,
                    },
                    file: {
                        required: true,
                        extension: "xls|xlsx",
                    },
                },
                messages: {
                    judul: {
                        required: "Judul Harus Di isi Sesuai Isi File Excel",
                        minlength: "Judul Minimal 5 Huruf",
                    },
                    deskripsi: {
                        required: "Deskripsi Harus Di isi Sesuai Isi File Excel",
                    },
                    file: {
                        required: "Silahkan Pilih file terlebih Dahulu",
                        extension: "File yang bisa di upload bertipe xls atau xlxs"
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
                        minlength: 5,
                    },
                    description: {
                        required: true,
                    },
                    file: {
                        extension: "xls|xlsx",
                    },
                },
                messages: {
                    title: {
                        required: "Judul Harus Di isi Sesuai Isi File Excel",
                        minlength: "Judul Minimal 5 Huruf",
                    },
                    description: {
                        required: "Deskripsi Harus Di isi Sesuai Isi File Excel",
                    },
                    file: {
                        extension: "File yang bisa di upload bertipe xls atau xlxs"
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
