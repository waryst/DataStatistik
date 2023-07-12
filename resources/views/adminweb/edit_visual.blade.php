@extends('layout.adminweb.index')
@section('title', 'Visualisasi Data Statistik')

@section('content')
    <meta name="_token" content="{{ csrf_token() }}">

    <style type="text/css">
        img {
            display: block;
            max-width: 100%;
        }

        .preview {
            overflow: hidden;
            width: 160px;
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }

        .modal-lg {
            max-width: 1000px !important;
        }
    </style>
    <div class="content">
        <div class="container-fluid">
            <form action="/visualisasi_data/post" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <section class="col-md-9">
                        <div class="card">
                            <div class="card-header border-0">
                                <h3 class="card-title">
                                    Edit Visualisasi
                                </h3>
                                <!-- card tools -->
                                <div class="card-tools">
                                    <button type="button" class="btn btn-sm" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="form-group">
                                    <label for="title">Judul</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" placeholder="Masukkan Judul"
                                        value="{{ old('title') }}" required autofocus>
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="image">Gambar</label>
                                    <div class="custom-file">
                                        <input type="file" class="image  @error('image') is-invalid @enderror"
                                            name="image" id="file">
                                        <label class="custom-file-label" for="file">Pilih
                                            file</label>
                                        @error('image')
                                            <div class="invalid-feedback text-nowrap pt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="visual">Data Visualisasi</label>
                                    <input type="text" class="form-control @error('visual') is-invalid @enderror"
                                        id="visual" name="visual" placeholder="Masukkan Tabeliew"
                                        value="{{ old('visual') }}" required autofocus>
                                    @error('visual')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="summernote">Isi Visualisasi</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <textarea id="summernote" name="deskripsi">{{ old('deskripsi') }}</textarea>
                                                    @error('deskripsi')
                                                        <p class="text-danger text-xs">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <button type="submit" class="btn btn-sm bg-gradient-primary" name="draf"
                                    value="draf">Save
                                    Draf</button>

                                <button type="submit" class="btn btn-sm bg-gradient-primary float-md-right" name="simpan"
                                    value="simpan">Save Publish</button>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Sesuaikan Gambar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-12">
                                <img id="image" src="" style="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary float-start" id="cancel">Cancel</button>
                    <button type="button" class="btn btn-primary" id="tutup">OK</button>


                </div>
            </div>
        </div>
    </div>
@endsection
@section('java')

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>
    <script>
        $(function() {
            // Summernote
            $('#summernote').summernote({
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
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection
