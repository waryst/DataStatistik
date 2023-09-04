@extends('layout.adminweb.index')
@section('title', 'Ganti Password')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Update Password
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.password.edit') }}">
                            @method('patch')
                            @csrf
                            <div class="form-group row">
                                <label for="current_password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password Lama') }}</label>
                                <div class="col-md-6">
                                    <input id="current_password" type="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        name="current_password" required autocomplete="current_password">

                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password Baru') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Ulang Password Baru') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
{{-- @section('java')
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
                        extension: "png",
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
                        extension: "File yang bisa di upload bertipe png"
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
@endsection --}}
