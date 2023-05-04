@extends('layout.adminweb.index')

@section('title', 'Data Statistik')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-gray-dark">
                        <div class="card-header">
                            <h3 class="card-title">Jumlah Data Statistik Belum Terverifikasi per Instansi</h3>
                        </div>
                        <div class="card-body">

                            <table id="datatable" name="datatable" class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama Dinas</th>
                                        <th class="text-center">Jumlah Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hasil as $hasil)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $hasil->description }}
                                            </td>
                                            <td class="text-center">
                                                {{ $hasil->data }}
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


@endsection
@section('java')
    <script type="text/javascript">
        $(document).ready(function() {
            bsCustomFileInput.init();
        });
        $(function() {
            // Summernote
            $('#deskripsi').summernote({
                disableDragAndDrop: true,
                height: 130,
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

        function add_data() {
            $('#titleError').addClass('d-none');
            $('#deskripsiError').addClass('d-none');
            $('#fileError').addClass('d-none');
            document.getElementById("title").value = "";
            document.getElementById("deskripsi").value = "";
            document.getElementById("file").value = "";
            $('#label_file').html(`<label class = "custom-file-label"
                for = "file" > Pilih file excel/pdf/csv </label>
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
                var status = $('input:radio[name=status]:checked').val();
                var fd = new FormData();
                fd.append('title', title);
                fd.append('deskripsi', deskripsi);
                if (typeof files[0] == "undefined") {
                    fd.append('file', $('#file').val());
                } else {
                    fd.append('file', files[0]);
                }
                fd.append('status', status);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('tabel.store') }}",
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

        function show_note(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('statistik') }}/" + id,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.pencarian_data.validasi == 2 && data.pencarian_data.verifikator == 2) {
                        $('#note').html(`                   
                            <div class="form-group">
                                <label for="title">Catatan Wali Data :</label>
                                <div class="ml-4" name="title" id="title">` + data.pencarian_data.note + `</div>
                                </div>

                                <div class="form-group">
                                <label for="title">Catatan Verifikator :</label>
                                <div class="ml-4" name="title" id="title">` + data.pencarian_data.catatan + `</div>
                            </div>                    
                        `);
                    } else if (data.pencarian_data.validasi == 2) {
                        $('#note').html(`                   
                            <div class="form-group">
                                <label for="title">Catatan Wali Data :</label>
                                <div class="ml-4" name="title" id="title">` + data.pencarian_data.note + `</div>
                                </div>
                            </div>
                        `);

                    } else if (data.pencarian_data.verifikator == 2) {
                        $('#note').html(`                   
                            <div class="form-group">
                                <div class="form-group">
                                <label for="title">Catatan Verifikator :</label>
                                <div class="ml-4" name="title" id="title">` + data.pencarian_data.catatan + `</div>
                            </div> 
                        `);

                    }
                    $("#notemodal").modal('show');
                },
                error: function(data) {}
            });

        }

        function show_edit(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('statistik') }}/" + id,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    $('#page').html(`
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title"> Update Data Statistik </h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                                </div>
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
                                        <label for="edit_file"> Input File Excel/Pdf/CSV
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
                                </div>
                                <div class="card-footer mt-0 pt-0 bg-white">
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
                    `);

                    $("#editmodal").modal('show');
                    $('#edit_description').summernote({
                        disableDragAndDrop: true,
                        height: 130,
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
            var fd = new FormData();
            fd.append('edit_title', edit_title);
            fd.append('description', description);
            if (typeof files[0] == "undefined") {
                fd.append('edit_file', $('#edit_file').val());
            } else {
                fd.append('edit_file', files[0]);
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ url('statistik') }}/" + id,
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
