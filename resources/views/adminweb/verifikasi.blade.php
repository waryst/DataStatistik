@extends('layout.adminweb.index')

@section('pageTitle', 'Data Statistik Sektoral Kabupaten Ponorogo')
@section('title', 'Validasi Data Statistik')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <div class="card card-gray-dark">
                    @if (auth()->user()->role == 'administrator')
                        <div class="card-header">
                            <h3 class="card-title">Validasi Data Statistik</h3>
                        </div>
                        <div class="card-body">
                        @else
                            <div class="card-header">
                                <h3 class="card-title">Verifikasi Data Statistik</h3>
                            </div>
                            <div class="card-body">
                    @endif    
                            <table id="datatable" name="datatable" class="table text-nowrap">
                                <tbody>
                                    @foreach ($hasil as $hasil)
                                        <tr>
                                            <td>
                                                <div class="timeline py-2" style="margin:-30px -20px 0 -20px">
                                                    <div>
                                                        <div class="timeline-item ">
                                                            <span class="time d-none d-sm-block"><i class="fas fa-clock"></i>
                                                                Created {{ $hasil->created_at }}</span>
                                                            <span class="time d-none d-sm-block"><i class="fas fa-clock"></i>
                                                                Updated {{ $hasil->updated_at }}</span>

                                                            <h3 class="timeline-header text-wrap">
                                                                @if (auth()->user()->role == 'administrator')
                                                                    <a href="#">{{ $hasil->instansi->name }} : </a>
                                                                @endif
                                                                
                                                                <span style="font-weight: bold">
                                                                    {{ $hasil->title }}</span>
                                                                @if (trim($hasil->catatan) != '' or trim($hasil->note != ''))
                                                                    <a href="#"
                                                                        onclick="show_note('{{ $hasil->id }}')"
                                                                        class="badge bg-warning btn-sm note my-1 p-1">
                                                                        Catatan
                                                                    </a>
                                                                @endif
                                                            </h3>

                                                            <div class="timeline-body text-wrap">
                                                                {!! $hasil->description !!}
                                                                <br>
                                                                <strong>Status Data :</strong> 
                                                                @if ($hasil->status==1)
                                                                    Data Publik
                                                                @else
                                                                    Data Private
                                                                @endif
                                                                <br>
                                                                <strong>Tipe File :</strong> {!! $hasil->type !!}
                                                            </div>
                                                            <div class="timeline-footer">
                                                                <form class="d-inline"
                                                                    action="/file/{{ $hasil->id }}/{{ $hasil->title }}">
                                                                    {{ csrf_field() }}
                                                                    <button style="border: none" type="submit"
                                                                        class="btn btn-success btn-sm my-1" name="download">
                                                                        <i class="fas fa-cloud-download-alt"></i>
                                                                        Download
                                                                    </button>
                                                                </form>
                                                                @if (auth()->user()->role == 'administrator')
                                                                    @if ($hasil->validasi == 3)
                                                                        <a href="#" class="btn bg-primary btn-sm my-1"
                                                                            onclick="show_verifikasi('{{ $hasil->id }}')">
                                                                            <i class="fas fa-check"></i>
                                                                            Validasi Ulang
                                                                        </a>
                                                                    @else
                                                                        <a href="#" class="btn bg-primary btn-sm my-1"
                                                                            onclick="show_verifikasi('{{ $hasil->id }}')">
                                                                            <i class="fas fa-check"></i>
                                                                            Validasi
                                                                        </a>
                                                                    @endif
                                                                @elseif (auth()->user()->role == 'verifikator')
                                                                    @if ($hasil->verifikator == 3)
                                                                        <a href="#" class="btn bg-primary btn-sm my-1"
                                                                            onclick="show_verifikasi('{{ $hasil->id }}')">
                                                                            <i class="fas fa-check"></i>
                                                                            Verifikasi Ulang
                                                                        </a>
                                                                    @else
                                                                        <a href="#" class="btn bg-primary btn-sm my-1"
                                                                            onclick="show_verifikasi('{{ $hasil->id }}')">
                                                                            <i class="fas fa-check"></i>
                                                                            Verifikasi
                                                                        </a>
                                                                    @endif
                                                                @endif
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
    </section>
    <div class="modal fade" id="editmodal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                @if (auth()->user()->role == 'administrator')
                                    Validasi Data Statistik
                                @elseif (auth()->user()->role == 'verifikator')
                                    Verifikasi Data Statistik
                                @endif
                            </h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="page"></div>
                    </div>
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
        (function() {
            $('.button-simpan').click(function() {
                $('.button-simpan').attr('hidden', 'true');
                $('.loading-simpan').show();
                $('.loading-simpan').attr('disabled', 'true');
                $('.spinner').show();

            })
        })();
        $('#page').on('click', '.button-verifikasi', function(e) {
            $('.button-verifikasi').attr('hidden', 'true');
            $('.loading-simpan').show();
            $('.loading-simpan').attr('disabled', 'true');
            $('.spinner').show();
        });
        function show_verifikasi(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('/statistik') }}/" + id,
                contentType: false,
                processData: false,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if (typeof data.url == "undefined") {
                        $('#page').html(`
                                <form method="POST" action="{{ url('/statistik/note') }}/` + data.pencarian_data.id + `" role="form" id="editform"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                    <div class="card-body my-0 py-0">
                                        <div class="form-group mt-2">
                                            <label for="exampleInputPassword1">Status Data</label>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="row">
                                                        <div class="col-8 col-sm-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="status"
                                                                    id="flexRadioDefault1" value="1" checked>
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                    Disetujui
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-sm-6">
                                                            <div class="form-check float-md-right">
                                                                <input class="form-check-input " type="radio" name="status"
                                                                    id="flexRadioDefault2" value="0">
                                                                <label class="form-check-label float-md-right"
                                                                    for="flexRadioDefault2">
                                                                    Ditolak
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Catatan</label>
                                            <textarea rows="2" class=" form-control" name="catatan" id="catatan">` +
                            data.catatan + ` </textarea>
                                        </div>
                                    </div>
                                    <div class="card-footer mt-0 pt-0">
                                        <button type="submit" class="btn btn-sm bg-gradient-success float-md-right button-verifikasi" name="verifikasi" value="verifikasi">
                                            Verifikasi Data
                                        </button>
                                        <button class="btn btn-sm bg-gradient-success float-md-right loading-simpan">
                                            <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i>
                                                Verifikasi Data
                                            </div>
                                        </button>
                                    </div>
                                </form>
                            `);
                        $('#editmodal').modal('show');
                    } else {
                        window.location = data.url;
                    }
                },
                error: function(data) {}
            });

        }
        $(document).ready(function() {
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

                    if (data.pencarian_data.note.trim() != '' && data.pencarian_data.catatan.trim() != '') {
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
                    } else if (data.pencarian_data.note.trim() != '') {
                        $('#note').html(`                   
                            <div class="form-group">
                                <label for="title">Catatan Wali Data :</label>
                                <div class="ml-4" name="title" id="title">` + data.pencarian_data.note + `</div>
                                </div>
                            </div>
                        `);

                    } else if (data.pencarian_data.catatan.trim() != '') {
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
    </script>

@endsection
