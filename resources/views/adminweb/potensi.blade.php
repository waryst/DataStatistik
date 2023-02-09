@extends('layout.adminweb.index')

@section('pageTitle', 'Data Statistik Sektoral Kabupaten Ponorogo')
@section('pageDashboard', 'Potensi Daerah')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="pull-right">
                                <button type="button" class="btn btn-primary my-3" data-toggle="modal"
                                    data-target="#modal_add_new"><i class="fas fa-plus"></i> Tambah Data</button>
                            </div>
                            <table id="datatable" name="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">#</th>
                                        <th class="text-center" style="width: 20%">Foto</th>
                                        <th class="text-center" style="width: 20%">Judul</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center" style="width: 15%">Action</th>
                                        <th hidden>id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($potensi as $potensi)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <img src="{{ asset('Data') . '/' . $potensi->instansi_id . '/potensi/' . $potensi->foto }}"
                                                    class="img-fluid" alt="" style="border-radius: 4px">
                                            </td>
                                            <td>{{ $potensi->judul }}</td>
                                            <td class="text-justify">{{ $potensi->descripsi }}</td>
                                            <td class="text-center">
                                                <button class="btn bg-primary btn-sm edit my-1"
                                                    jenis="<?php echo $potensi->jenis; ?>"
                                                    judul="<?php echo $potensi->judul; ?>"
                                                    discripsi="<?php echo $potensi->descripsi; ?>"
                                                    id="<?php echo $potensi->id; ?>">
                                                    <i class="far fa-edit"></i> </button>
                                                <form action="{{ url('potensi/' . $potensi->id) }}" method="POST"
                                                    id='delete{{ $potensi->id }}' class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn bg-danger btn-sm tombol-hapus"
                                                        id='{{ $potensi->id }}'><i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td hidden></td>
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
    <div class="modal fade" id="modal_add_new" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Input Potensi</h3>
                        </div>
                        <form method="POST" role="form" id="quickForm" action="{{ route('simpan') }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Jenis Potensi</label>
                                    <select class="form-control select2" style="width: 100%;" name="jenis">
                                        <option selected="selected" value="">Pilih</option>
                                        <option value="alam">Alam</option>
                                        <option value="religi">Religi</option>
                                        <option value="kuliner">Kuliner</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Judul</label>
                                    <input type="text" class="form-control" name="judul" id="exampleInputEmail1"
                                        placeholder="Judul">
                                </div>
                                <div class="form-group">
                                    <label for="descripsi">Deskripsi Potensi Daerah</label>
                                    <textarea rows="6" class="form-control" name="descripsi"
                                        placeholder="Deskripsi"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Input Foto</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Pilih File</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary float-right"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
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
                            <h3 class="card-title">Update Potensi Daerah</h3>
                        </div>
                        <form method="POST" role="form" id="editform" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Jenis Potensi</label>
                                    <select class="form-control select2" style="width: 100%;" name="jenis" id="jenis">
                                        <option value=alam>Alam</option>
                                        <option value="religi">Religi</option>
                                        <option value="kuliner">Kuliner</option>
                                    </select>
                                    <div class="form-group">
                                        <label for="title">Judul Potensi</label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Judul Data">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Deskripsi Potensi</label>
                                        <textarea rows="6" class="form-control" name="description" id="description"
                                            placeholder="Deskripsi"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="file">Input Foto</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file" class="custom-file-input" id="file">
                                                <label class="custom-file-label" for="file">Pilih File</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Update</button>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('.edit').click(function() {
                $('#editmodal').modal();
                var id = $(this).attr('id');
                var jenis = $(this).attr('jenis');
                var judul = $(this).attr('judul');
                var diskripsi = $(this).attr('discripsi');

                $('#jenis').val(jenis);
                $('#title').val(judul);
                $('#description').val(diskripsi);
                $('#editform').attr('action', "{{ url('/potensi') }}" + '/' + id)

            })
            $('.tombol-hapus').on('click', function(e) {
                e.preventDefault();
                const id = $(this).attr('id');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data Potensi Daerah akan di hapus!!",
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
                        "targets": [1, 4], //first column / numbering column
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
            });
            bsCustomFileInput.init();
            $('#quickForm').validate({
                rules: {
                    jenis: {
                        required: true,
                    },
                    judul: {
                        required: true,
                    },
                    descripsi: {
                        required: true,
                    },
                    file: {
                        required: true,
                        extension: "jpg|jpeg",
                    },
                },
                messages: {
                    jenis: {
                        required: "Silahkan Pilih Jenis Potensi Daerah",
                    },
                    judul: {
                        required: "Silahkan Isi Judul Potensi Daerah",
                    },
                    descripsi: {
                        required: "Silahkan Masukkan Deskripsi Potensi Daerah",
                    },
                    file: {
                        required: "Silahkan Pilih file terlebih Dahulu",
                        extension: "File yang bisa di upload bertipe jpg atau jpeg"
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
                    file: {
                        extension: "jpg|jpeg",
                    },
                },
                messages: {
                    title: {
                        required: "Silahkan Isi Judul Potensi Daerah",
                    },
                    description: {
                        required: "Silahkan Masukkan Deskripsi Potensi Daerah",
                    },
                    file: {
                        extension: "File yang bisa di upload bertipe jpg atau jpeg"
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
