@extends('layout.adminweb.index')
@section('title', 'Profil Instansi')

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Umum</h3>
                        </div>
                        <form method="POST" role="form" action="{{ url('/profil') }}" id="post_instansi"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nama Instansi</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" disabled
                                                value="{{ $instansi->name }}" placeholder="Nama Instansi">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Deskripsi Instansi</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" disabled
                                                value="{{ $instansi->description }}" placeholder="Deskripsi">
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Alamat Instansi</label>
                                            <input type="text" class="form-control" name="alamat" id="alamat"
                                                value="{{ $instansi->alamat }}" placeholder="Alamat Instansi">
                                        </div>
                                        <div class="form-group">
                                            <label for="peta">Peta Instansi</label>
                                            <input type="text" class="form-control" name="peta" id="peta"
                                                value="{{ $instansi->map }}" placeholder="Sematkan Peta Dari Google Map">
                                        </div>

                                        <div class="form-group">
                                            <label for="instansi">Logo Instansi</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="instansi"
                                                        id="instansi">
                                                    <label class="custom-file-label" for="instansi">Pilih Logo
                                                        Instansi bertipe png</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="card-deck mt-3">
                                                        <div class="card">
                                                            <?php if ($instansi->logo != null) { ?>
                                                            <img src="{{ url('image/logo/' . $instansi->id) }}"
                                                                class="card-img-top" alt="{{ $instansi->name }}">

                                                            <?php } else { ?>
                                                            <img src="{{ asset('logo.png') }}" class="card-img-top"
                                                                alt="{{ $instansi->name }}">

                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="kepala">Nama Kepala Dinas</label>
                                            <input type="text" class="form-control" name="kepala" id="kepala"
                                                value="{{ $instansi->nama_kadin }}" placeholder="Nama Kepala Dinas">
                                        </div>
                                        <div class="form-group">
                                            <label for="nip">NIP Kepala Dinas</label>
                                            <input type="text" class="form-control" name="nip" id="nip"
                                                value="{{ $instansi->nip }}" placeholder="NIP Kepala Dinas"
                                                onKeyPress="return isNumberKey(event)">
                                        </div>
                                        <div class="form-group">
                                            <label for="kepala_dinas">Photo Kepala Dinas</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="kepala_dinas"
                                                        name="kepala_dinas">
                                                    <label class="custom-file-label" for="kepala_dinas">Pilih Photo bertipe
                                                        jpg atau jpeg</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="card-deck mt-3">
                                                        <div class="card">
                                                            <?php if ($instansi->foto_kadin != null) { ?>
                                                            <img src="{{ url('image/kadin/' . $instansi->id) }}"
                                                                class="card-img-top" alt="{{ $instansi->nama_kadin }}">
                                                            <?php } else { ?>
                                                            <img src="{{ asset('user.jpg') }}" class="card-img-top"
                                                                alt="{{ $instansi->nama_kadin }}">
                                                            <?php } ?>



                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pns">Jumlah Pegawai PNS</label>
                                            <input type="text" class="form-control" id="pns" name="pns"
                                                value="{{ $instansi->pns }}" placeholder="PNS"
                                                onKeyPress="return isNumberKey(event)">
                                        </div>
                                        <div class="form-group">
                                            <label for="nonpns">Jumlah Pegawai Non-PNS</label>
                                            <input type="text" class="form-control" id="kontrak" name="kontrak"
                                                value="{{ $instansi->kontrak }}" placeholder="Non-PNS"
                                                onKeyPress="return isNumberKey(event)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Simpan</button>
                            </div>
                        </form>
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
            $('#post_instansi').validate({
                rules: {
                    alamat: {
                        required: true,
                        minlength: 5,
                    },
                    instansi: {
                        extension: "png",
                    },
                    kepala_dinas: {
                        extension: "jpg|jpeg",
                    },
                    kepala: {
                        required: true,
                    },
                    nip: {
                        required: true,
                        minlength: 18,
                    },
                },
                messages: {
                    alamat: {
                        required: "Silahkan Masukkan Alamat Instansi",
                        minlength: "Judul Minimal 5 Huruf",
                    },
                    instansi: {
                        extension: "File yang bisa di upload bertipe png"
                    },
                    kepala_dinas: {
                        extension: "File yang bisa di upload bertipe jpg atau jpeg"
                    },
                    kepala: {
                        required: "Silahkan Masukkan Nama Kepala Dinas"
                    },
                    nip: {
                        required: "Silahkan Masukkan NIP Kepala Dinas",
                        minlength: "NIP Minimal 18 Digit",
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
