@extends('layout.adminweb.index')

@section('title', 'Data Statistik')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-gray-dark">
                        @if (auth()->user()->role == 'administrator')
                            <div class="card-header">
                                <h3 class="card-title">Data Statistik</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-4">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-success elevation-1">
                                                <i class="fas fa-chart-pie"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Jumlah Data Valid</span>
                                                <span class="info-box-number">{{ $nav['data_valid'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4">
                                        <a href="{{ url('/verifikasi') }}">
                                            <div class="info-box mb-3">
                                                <span class="info-box-icon bg-warning elevation-1">
                                                    <i class="fas fa-chart-pie"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Jumlah Data Belum Tervalidasi</span>
                                                    <span class="info-box-number">{{ $nav['jumlah_validasi_all'] }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="clearfix hidden-md-up"></div>

                                    <div class="col-12 col-sm-6 col-md-4">
                                        <a href="{{ url('/unverified') }}">
                                            <div class="info-box mb-3">
                                                <span class="info-box-icon bg-danger elevation-1">
                                                    <i class="fas fa-chart-pie"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text ">Jumlah Data Belum Terverifikasi</span>
                                                    <span class="info-box-number">{{ $nav['data_unverified'] }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="card-header">
                                    <h3 class="card-title">Entry Data Statistik</h3>
                                </div>
                                <div class="card-body">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-primary my-3 " onclick="add_data()"><i
                                                class="fas fa-plus"></i>
                                            Tambah Data</button>
                                    </div>
                        @endif

                        <table id="datatable" name="datatable" class="table text-nowrap">
                            <tbody>
                                @foreach ($data_statistik as $data_statistik)
                                    <tr>
                                        <td>
                                            <div class="timeline py-2" style="margin:-30px -20px 0 -20px">
                                                <div>
                                                    <div class="timeline-item ">
                                                        <span class="time d-none d-sm-block"><i class="fas fa-clock"></i>
                                                            Created {{ $data_statistik->created_at }}</span>
                                                        <span class="time d-none d-sm-block"><i class="fas fa-clock"></i>
                                                            Updated {{ $data_statistik->updated_at }}</span>
                                                        <h3 class="timeline-header text-wrap">
                                                            @if (auth()->user()->role == 'administrator')
                                                                <a href="#">{{ $data_statistik->instansi->name }}
                                                                    :
                                                                </a>
                                                            @endif
                                                            <span style="font-weight: bold">
                                                                {{ $data_statistik->title }}</span>
                                                            @if (auth()->user()->role == 'administrator')
                                                            @elseif ($data_statistik->verifikator == 0)
                                                                <span class="badge bg-danger">
                                                                    Menunggu Verifikasi</span>
                                                            @elseif($data_statistik->verifikator == 1)
                                                                @if ($data_statistik->validasi == 0)
                                                                    <span class="badge bg-danger">
                                                                        Validasi Wali Data</span>
                                                                @elseif($data_statistik->validasi == 1)
                                                                    <span class="badge bg-primary">Terverifikasi</span>
                                                                @elseif($data_statistik->validasi == 2)
                                                                    <a href="#"
                                                                        onclick="show_note('{{ $data_statistik->id }}')"
                                                                        class="badge bg-warning btn-sm note my-1 p-1">
                                                                        Catatan
                                                                    </a>
                                                                @elseif($data_statistik->validasi == 3)
                                                                    <span class="badge bg-info">
                                                                        Validasi Ulang Wali Data</span>
                                                                @endif
                                                            @elseif($data_statistik->verifikator == 2)
                                                                <a href="#"
                                                                    onclick="show_note('{{ $data_statistik->id }}')"
                                                                    class="badge bg-warning btn-sm note my-1 p-1">
                                                                    Catatan
                                                                </a>
                                                            @elseif($data_statistik->verifikator == 3)
                                                                <span class="badge bg-info">
                                                                    Verifikasi Ulang</span>
                                                            @endif
                                                        </h3>
                                                        <div class="timeline-body text-wrap">
                                                            {!! str_replace('style', '', $data_statistik->description) !!}
                                                            @if (auth()->user()->role == 'administrator')
                                                                <br>
                                                                <strong>Status Data :</strong>
                                                                @if ($data_statistik->status == 1)
                                                                    Data Publik
                                                                @else
                                                                    Data Private
                                                                @endif
                                                                <br>
                                                                <strong>Tipe File :</strong> {!! $data_statistik->type !!}
                                                            @endif
                                                            <p class="mt-2">
                                                                <strong>Viewer :</strong> {{ $data_statistik->view }}
                                                                <strong> | Download :</strong>
                                                                {{ $data_statistik->download }}
                                                        </div>
                                                        @if (auth()->user()->role == 'administrator')
                                                            <div class="timeline-footer">
                                                                <form class="d-inline"
                                                                    action="/file/{{ $data_statistik->id }}">
                                                                    {{ csrf_field() }}
                                                                    <button style="border: none" type="submit"
                                                                        class="btn btn-success btn-sm py-1" name="download">
                                                                        <i class="fas fa-cloud-download-alt"></i>
                                                                        Download
                                                                    </button>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <div class="timeline-footer">
                                                                <form method="POST"
                                                                    action="{{ url('statistik/' . $data_statistik->id) }}"
                                                                    class="d-inline">
                                                                    {{ csrf_field() }}
                                                                    @if ($data_statistik->status == 1)
                                                                        <button style="border: none" type="submit"
                                                                            class="btn bg-info btn-sm button-simpan"
                                                                            id='button-simpan{{ $data_statistik->id }}'
                                                                            data-id='{{ $data_statistik->id }}'
                                                                            name="show" value="show"><i
                                                                                class="fas fa-eye p-1"></i>
                                                                            Public </button>
                                                                        <button class="btn bg-info btn-sm loading-simpan"
                                                                            id='loading-simpan{{ $data_statistik->id }}'
                                                                            data-id='{{ $data_statistik->id }}'>
                                                                            <div class="spinner"><i role="status"
                                                                                    class="spinner-border spinner-border-sm"></i>
                                                                                Public
                                                                            </div>
                                                                        </button>
                                                                    @else
                                                                        <button style="border: none" type="submit"
                                                                            class="btn bg-secondary btn-sm button-simpan"
                                                                            id='button-simpan{{ $data_statistik->id }}'
                                                                            data-id='{{ $data_statistik->id }}'
                                                                            name="unshow" value="unshow"><i
                                                                                class="fas fa-eye-slash p-1"></i>Private</button>
                                                                        <button
                                                                            class="btn bg-secondary btn-sm loading-simpan"
                                                                            id='loading-simpan{{ $data_statistik->id }}'
                                                                            data-id='{{ $data_statistik->id }}'>
                                                                            <div class="spinner"><i role="status"
                                                                                    class="spinner-border spinner-border-sm"></i>
                                                                                Private
                                                                            </div>
                                                                        </button>
                                                                    @endif
                                                                </form>
                                                                <form class="d-inline"
                                                                    action="/file/{{ $data_statistik->id }}">
                                                                    {{ csrf_field() }}
                                                                    <button style="border: none" type="submit"
                                                                        class="btn btn-success btn-sm py-1"
                                                                        name="download">
                                                                        <i class="fas fa-cloud-download-alt"></i>
                                                                        Download
                                                                    </button>
                                                                    </a>
                                                                </form>
                                                                <a href="#" class="btn bg-primary btn-sm my-1"
                                                                    onclick="show_edit('{{ $data_statistik->id }}');return false">
                                                                    <i class="far fa-edit"></i> Edit
                                                                </a>
                                                                <form
                                                                    action="{{ url('statistik/' . $data_statistik->id) }}"
                                                                    method="POST" id='delete{{ $data_statistik->id }}'
                                                                    class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button class="btn bg-danger btn-sm tombol-hapus"
                                                                        id='{{ $data_statistik->id }}'data-id='{{ $data_statistik->id }}'><i
                                                                            class="far fa-trash-alt"></i> Hapus
                                                                    </button>
                                                                    <button class="btn bg-danger btn-sm loading-hapus"
                                                                        id='loading-hapus{{ $data_statistik->id }}'data-id='{{ $data_statistik->id }}'>
                                                                        <div class="spinner"><i role="status"
                                                                                class="spinner-border spinner-border-sm"></i>
                                                                            Hapus
                                                                        </div>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
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
                            <h3 class="card-title">Input Data Statistik</h3>
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
                                <label for="exampleInputPassword1">Visibility Data</label>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="row">
                                            <div class="col-8 col-sm-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status"
                                                        id="flexRadioDefault1" value="1" checked>
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        Publik
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-6">
                                                <div class="form-check float-md-right">
                                                    <input class="form-check-input " type="radio" name="status"
                                                        id="flexRadioDefault2" value="0">
                                                    <label class="form-check-label float-md-right"
                                                        for="flexRadioDefault2">
                                                        Private
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
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
                        <div class="card-footer bg-white">
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
                    <div id="page"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="notemodal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="position-relative p-3 bg-white" style="height: 180px">
                    <div class="ribbon-wrapper ribbon-xl">
                        <div class="ribbon bg-warning text-lg">
                            Catatan
                        </div>
                    </div>
                    <div id="note"></div>
                </div>
            </div>
        </div>
    </div>


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
