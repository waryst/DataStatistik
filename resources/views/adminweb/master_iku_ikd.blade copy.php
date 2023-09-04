@extends('layout.adminweb.index')

@section('title', 'Data Instansi')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Indikator Kinerja Utama
                    </div>
                    <div class="d-flex flex-row bd-highlight">
                        <div class="card-body col-md-6 border-right border-color-dark-gray">
                            <div class="pull-right">
                                <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                    data-target="#modal_add_new"><i class="fas fa-plus"></i> Tambah Data</button>
                            </div>
                            <table id="datatable" name="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center align-middle">Indikator</th>
                                        <th class="text-center align-middle">Pengampu</th>
                                        <th class="text-center align-middle">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($iku as $iku)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $iku->indikator }}</td>
                                            <td>{{ $iku->instansi->name }}</td>
                                            <td>

                                                <a href="#" onclick="show_edit('{{ $iku->id }}');return false"
                                                    class="badge bg-info"><i class="far fa-edit p-1"></i>
                                                </a>
                                                <form
                                                    action="{{ url('hapusindikator/' . $iku->id) }}"
                                                    method="post" class="d-inline" id='delete{{ $iku->id }}'>
                                                    @method('delete')
                                                    @csrf
                                                    <button class="badge bg-danger border-0 tombol-hapus"
                                                        id='{{ $iku->id }}'><i class="far fa-trash-alt p-1"></i>
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="card-body col-md-6 m-0 p-0">
                            <div class="card-header py-">
                                Setting Tahun
                            </div>
                            <div class="pull-right p-3">
                                <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                    data-target="#modal_add_new"><i class="fas fa-plus"></i> Tambah Data Tahun</button>
                            </div>
                        </div>
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
                        <h3 class="card-title">Input Data Indikator Kinerja Utama</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="indikator">Indikator</label>
                            <input type="text" class="form-control" name="indikator" id="indikator" placeholder="">
                            <span class="text-danger" id="indikatorError"></span>
                        </div>
                        <div class="form-group">
                            <label>Pengampu</label>
                            <select name="dinas" id="dinas" class="form-control select2" style="width: 100%">
                                <option value="">Pilih </option>
                                @foreach($instansi as $instansi)
                                    <option value="{{ $instansi->id }}">{{ $instansi->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="dinasError"></span>
                        </div>


                    </div>
                    <div class="card-footer">
                        <button type="button" id="submit" value="Submit"
                            class="btn btn-sm bg-gradient-primary button-simpan float-right">Simpan</button>
                        <button class="btn btn-primary loading-simpan float-right">
                            <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i>
                                Simpan
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editmodal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Update Data Indikator Kinerja Utama</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="editindikator">Indikator</label>
                                <input type="text" class="form-control" name="editindikator" id="editindikator"
                                    placeholder="">
                                <span class="text-danger" id="editindikatorError"></span>
                            </div>
                            <div class="form-group">
                                <label>Pengampu</label>
                                <span id="page"></span>
                                <span class="text-danger" id="editdinasError"></span>
                            </div>


                        </div>
                        <div class="card-footer">
                            <span id="update"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
    @section('java')
    <script>
        $(document).ready(function () {
            $('#submit').click(function () {
                $('.button-simpan').hide();
                $('.loading-simpan').show();
                $('.loading-simpan').attr('disabled', 'true');
                $('.spinner').show();
                var indikator = $('#indikator').val();
                var dinas = $('#dinas').val();
                var fd = new FormData();
                fd.append('indikator', indikator);
                fd.append('dinas', dinas);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ url('saveindikator') }}",
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',

                    success: function (data) {
                        window.location = data.url;

                    },
                    error: function (data) {
                        $('#indikator').removeClass('is-invalid');
                        $('#dinas').removeClass('is-invalid');
                        $('#indikatorError').addClass('d-none');
                        $('#dinasError').addClass('d-none');
                        $('.button-simpan').show();
                        $('.loading-simpan').hide();
                        $('.loading-simpan').attr('disabled', 'true');
                        $('.spinner').hide();
                        var errors = data.responseJSON;
                        if ($.isEmptyObject(errors) == false) {
                            $.each(errors.errors, function (key, value) {
                                var ErrorID = '#' + key + 'Error';
                                var InputID = '#' + key;
                                $(InputID).addClass("is-invalid");
                                $(ErrorID).removeClass("d-none");
                                $(ErrorID).text(value);
                            })
                        }
                    }
                });

            });

            $("#datatable").DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });


        });

        function edit(id) {
            var editindikator = $('#editindikator').val();
            var editdinas = $('#editdinas').val();
            var fd = new FormData();
            fd.append('editindikator', editindikator);
            fd.append('editdinas', editdinas);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ url('editindikator') }}/" + id,
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',

                success: function (data) {
                    window.location = data.url;

                },
                error: function (data) {
                    $('#editindikator').removeClass('is-invalid');
                    $('#editdinas').removeClass('is-invalid');
                    $('#editindikatorError').addClass('d-none');
                    $('#editdinasError').addClass('d-none');

                    var errors = data.responseJSON;
                    if ($.isEmptyObject(errors) == false) {
                        $.each(errors.errors, function (key, value) {
                            var ErrorID = '#' + key + 'Error';
                            var InputID = '#' + key;
                            // alert(ErrorID);
                            $(InputID).addClass("is-invalid");
                            $(ErrorID).removeClass("d-none");
                            $(ErrorID).text(value);
                        })
                    }




                }
            });
        };
        $('.tombol-hapus').on('click', function (e) {
            e.preventDefault();
            const id = $(this).attr('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data Indikator Kinerja Utama akan di hapus!!",
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

        function show_edit(id) {
            $("#editmodal").modal('show');

            $.ajax({
                type: "GET",
                url: "{{ url('showindikator') }}/" + id,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    $("#editindikator").val(data.pencarian_data.indikator);
                    $('#page').html(`
                        <select name="editdinas" id="editdinas" class="form-control select2" style="width: 100%">
                            <option
                                value="` + data.pencarian_data.instansi_id + `">` + data.pencarian_data.instansi.name +
                        `</option>
                        </select>`);
                    $('#update').html(`
                        <button type="button" onclick="edit('` + data.pencarian_data.id + `')"
                                class="btn btn-sm bg-gradient-success button-simpan float-right">Update</button>

                        
                        `);
                    $.each(data.data_instansi, function (key, value) {
                        $('#editdinas').append(`<option
                         value="` + value.id + `">` + value.name +
                            `</option>`);
                    })
                    $(".select2").select2();
                },
                error: function (data) {}
            });

        }
        $(function () {
            $(".select2").select2();
        });

    </script>
    @endsection
