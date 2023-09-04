@extends('layout.adminweb.index')

@section('title', 'Data Publikasi')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-gray-dark">
                        <div class="card-header">
                            <h3 class="card-title">Entry Data Publikasi</h3>
                        </div>
                        <div class="card-body">
                            <div class="pull-right">
                                <button type="button" class="btn btn-primary my-3 " onclick="add_data()"><i
                                        class="fas fa-plus"></i>
                                    Tambah Data</button>
                            </div>
                            <table id="datatable" name="datatable" class="table table-hover text-nowrap">
                                <tbody>
                                    @foreach ($data_public as $data_public)
                                        <tr>
                                            <td>
                                                <div class="timeline py-2" style="margin:-30px -20px 0 -20px">
                                                    <div>
                                                        <div class="timeline-item ">
                                                            <span class="time d-none d-sm-block"><i class="fas fa-clock"></i>
                                                                Created {{ $data_public->created_at }}</span>
                                                            <span class="time d-none d-sm-block"><i class="fas fa-clock"></i>
                                                                Updated {{ $data_public->updated_at }}</span>
                                                            <h3 class="timeline-header text-wrap">
                                                                <span style="font-weight: bold">
                                                                    {{ $data_public->title }}
                                                                </span>
                                                            </h3>
                                                            <div class="row m-2">
                                                                <div class="col-md-3">
                                                                    <div class="card">
                                                                        <img src="{{ url('image/publikasi/' . $data_public->id) }}"
                                                                            class="card-img-top rounded-lg"
                                                                            alt="...">

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <div class="timeline-body text-wrap">
                                                                        {!! str_replace('font-family', '', $data_public->description) !!}
                                                                    </div>
                                                                    <div class="timeline-footer ">
                                                                        <form method="POST"
                                                                            action="{{ url('statistik/' . $data_public->id) }}"
                                                                            class="d-inline">
                                                                            {{ csrf_field() }}

                                                                        </form>
                                                                        <form class="d-inline"
                                                                            action="/public/{{ $data_public->id }}/{{ $data_public->title }}">
                                                                            {{ csrf_field() }}
                                                                            <button style="border: none" type="submit"
                                                                                class="btn btn-success btn-sm py-1"
                                                                                name="download"> Download
                                                                            </button>
                                                                            </a>
                                                                        </form>
                                                                        <a href="#"
                                                                            class="btn bg-primary btn-sm my-1"
                                                                            onclick="show_edit('{{ $data_public->id }}');return false">
                                                                            <i class="far fa-edit"></i> Edit
                                                                        </a>
                                                                        <form
                                                                            action="{{ url('data_publikasi/' . $data_public->id) }}"
                                                                            method="POST"
                                                                            id='delete{{ $data_public->id }}'
                                                                            class="d-inline">
                                                                            @method('delete')
                                                                            @csrf
                                                                            <button
                                                                                class="btn bg-danger btn-sm tombol-hapus"
                                                                                id='{{ $data_public->id }}'
                                                                                data-id='{{ $data_public->id }}'><i
                                                                                    class="far fa-trash-alt"></i> Hapus
                                                                            </button>
                                                                            <button
                                                                                class="btn bg-danger btn-sm loading-hapus"
                                                                                id='loading-hapus{{ $data_public->id }}'
                                                                                data-id='{{ $data_public->id }}'>
                                                                                <div class="spinner"><i role="status"
                                                                                        class="spinner-border spinner-border-sm"></i>
                                                                                    Hapus
                                                                                </div>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                            <h3 class="card-title">Input Data Publikasi</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-danger mt-2" style="display:none"></div>
                        <div class="card-body  my-0 py-0">
                            <div class="form-group">
                                <label for="title">Judul Data</label>
                                <input type="text" class="form-control" name="title" id="title"
                                    placeholder="Judul Data" value="{{ old('title') }}">
                                <span class="text-danger" id="titleError"></span>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi Data</label>
                                <textarea rows="6" class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi">{{ old('deskripsi') }}</textarea>
                                <span class="text-danger" id="deskripsiError"></span>
                            </div>
                            <div class="form-group">
                                <label>Input Cover </label>
                                <div class="custom-cover">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file" name="cover" id="cover">
                                        <div id="label_cover"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Input File </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file" name="file" id="file">
                                    <div id="label_file"></div>
                                    <span class="text-danger" id="fileError"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" id="submit" value="Submit"
                                class="btn btn-sm bg-gradient-primary float-md-right button-update">Simpan</button>
                            <button class="btn btn-sm bg-gradient-primary float-md-right loading-update">
                                <div class="spinner">
                                    <i role="status" class="spinner-border spinner-border-sm">
                                    </i>
                                    Simpan
                                </div>
                            </button>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="editmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title"> Update Data Statistik </h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card card-success p-3">


                            <div id="page"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('java')
    <script type="text/javascript">
        $(function() {
            // Summernote
            $('#deskripsi').summernote({
                disableDragAndDrop: true,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    // ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ]
            });
        })
        $(document).ready(function() {
            bsCustomFileInput.init();
        });

        function add_data() {
            $('#titleError').addClass('d-none');
            $('#deskripsiError').addClass('d-none');
            $('#fileError').addClass('d-none');
            $('#coverError').addClass('d-none');
            document.getElementById("title").value = "";
            document.getElementById("deskripsi").value = "";
            document.getElementById("cover").value = "";
            document.getElementById("file").value = "";
            $('#label_cover').html(` <label class="custom-file-label" for="cover"> Pilih file Gambar</label>
                <span class="text-danger" id="coverError"></span>
                `);
            $('#label_file').html(`<label class = "custom-file-label"
                for = "file" > Pilih file pdf </label>
                `);
            $("#modal_add_new").modal('show');
        }
        $(document).ready(function() {
            $('#submit').click(function() {
                $('.button-update').hide();
                $('.loading-update').show();
                $('.loading-update').attr('disabled', 'true');
                $('.spinner').show();
                var title = $('#title').val();
                var deskripsi = $('#deskripsi').val();
                var files = $('#file')[0].files;
                var covers = $('#cover')[0].files;
                var fd = new FormData();
                fd.append('title', title);
                fd.append('deskripsi', deskripsi);
                if (typeof files[0] == "undefined") {
                    fd.append('file', $('#file').val());
                } else {
                    fd.append('file', files[0]);
                }
                if (typeof covers[0] == "undefined") {
                    fd.append('cover', $('#cover').val());
                } else {
                    fd.append('cover', covers[0]);
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('data.publikasi.store') }}",
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',

                    success: function(data) {
                        $("#modal_add_new").modal('hide');
                        window.location = data.url;
                    },
                    error: function(data) {
                        $('#titleError').addClass('d-none');
                        $('#deskripsiError').addClass('d-none');
                        $('#fileError').addClass('d-none');
                        $('#coverError').addClass('d-none');
                        $('.button-update').show();
                        $('.loading-update').hide();
                        $('.loading-update').attr('disabled', 'true');
                        $('.spinner').hide();
                        var errors = data.responseJSON;
                        if ($.isEmptyObject(errors) == false) {
                            $.each(errors.errors, function(key, value) {
                                var ErrorID = '#' + key + 'Error';
                                $(ErrorID).removeClass("d-none");
                                $(ErrorID).text(value);
                            })
                        }
                    }
                });
            });
            $('.button-simpan').on('click', function(e) {
                $('#button-simpan' + $(this).data('id')).attr('hidden', 'true');
                $('#loading-simpan' + $(this).data('id')).show();
                $('#loading-simpan' + $(this).data('id')).attr('disabled', 'true');
                $('.spinner').show();
            });
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
                        $('#' + $(this).data('id')).attr('hidden', 'true');
                        $('#loading-hapus' + $(this).data('id')).show();
                        $('#loading-hapus' + $(this).data('id')).attr('disabled', 'true');
                        $('.spinner').show();
                    }
                })
            });
            $(function() {
                $("#datatable").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "ordering": false,
                    "columnDefs": [{
                        "targets": [0], //first column / numbering column
                        "orderable": false, //set not orderable
                    }, ],
                });
            });
        });

        function show_edit(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('data_publikasi') }}/" + id,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    $('#page').html(
                        `
                            <div class="row">
                                <div class="col-md-3">
                                        <div class="card" style="width: 11rem;">
                                        <img src="{{ url('image/publikasi/') }}/` +
                        data.pencarian_data.id + `" class="card-img-top" alt="...">
                                        </div>
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file" name="editcover" id="editcover">
                                            <label class="custom-file-label" for="editcover"> Pilih Cover</label>
                                            <span class="text-danger" id="editcoverError"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body my-0 py-0">
                                        <div class="form-group">
                                            <label for="edit_title"> Judul Data </label>
                                            <input type="text" class="form-control" name="edit_title" id="edit_title"
                                                placeholder="Judul Data" value="` + data.pencarian_data.title +
                        `">
                                            <span class="text-danger" id="edit_titleError">
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">
                                                Deskripsi Data </label>
                                            <textarea rows="6" class="form-control" name="edit_description" id="edit_description" placeholder="description">` +
                        data.pencarian_data.description +
                        ` </textarea>
                                            <span class="text-danger" id="descriptionError"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="edit_file"> Input File Pdf
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file" name="edit_file" id="edit_file">
                                                <label class="custom-file-label" for="edit_file">
                                                    Pilih
                                                    file
                                                </label>
                                                <span class="text-danger" id="edit_fileError">
                                                </span>
                                            </div>
                                        </div>

                                        <div class="card-footer mt-0 pt-0">
                                            <button class="btn btn-sm bg-gradient-success float-md-right button-update"
                                                onclick="edit('` + data.pencarian_data.id + `')" name="updateaaa" value="update">
                                                Update
                                            </button>
                                            <button class="btn btn-sm bg-gradient-success float-md-right loading-update">
                                                <div class="spinner">
                                                    <i role="status" class="spinner-border spinner-border-sm">
                                                    </i>
                                                    Update
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `);

                    $("#editmodal").modal('show');
                    $('#edit_description').summernote({
                        disableDragAndDrop: true,
                        toolbar: [
                            // [groupName, [list of button]]
                            ['style', ['style']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['fontname', ['fontname']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            // ['insert', ['link', 'picture', 'video']],
                            ['view', ['fullscreen', 'codeview', 'help']],
                        ]
                    });
                    bsCustomFileInput.init();
                },
                error: function(data) {}
            });

        }

        function edit(id) {
            $('.button-update').hide();
            $('.loading-update').show();
            $('.loading-update').attr('disabled', 'true');
            $('.spinner').show();
            var edit_title = $('#edit_title').val();
            var description = $('#edit_description').val();
            var files = $('#edit_file')[0].files;
            var covers = $('#editcover')[0].files;

            var fd = new FormData();
            fd.append('edit_title', edit_title);
            fd.append('description', description);
            if (typeof files[0] == "undefined") {
                fd.append('edit_file', $('#edit_file').val());
            } else {
                fd.append('edit_file', files[0]);
            }
            if (typeof covers[0] == "undefined") {
                fd.append('editcover', $('#editcover').val());
            } else {
                fd.append('editcover', covers[0]);
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ url('data_publikasi') }}/" + id,
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',

                success: function(data) {
                    $("#editmodal").modal('hide');
                    window.location = data.url;
                },
                error: function(data) {
                    $('#edit_titleError').addClass('d-none');
                    $('#descriptionError').addClass('d-none');
                    $('#edit_fileError').addClass('d-none');
                    $('#edit_fileError').addClass('d-none');
                    $('#editcoverError').addClass('d-none');
                    $('.button-update').show();
                    $('.loading-update').hide();
                    $('.loading-update').attr('disabled', 'true');
                    $('.spinner').hide();
                    var errors = data.responseJSON;
                    if ($.isEmptyObject(errors) == false) {
                        $.each(errors.errors, function(key, value) {
                            var ErrorID = '#' + key + 'Error';
                            $(ErrorID).removeClass("d-none");
                            $(ErrorID).text(value);
                        })
                    }
                }
            });
        }
    </script>

@endsection
