<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SatuData | @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->


    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('asset_adminweb') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('asset_adminweb') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('asset_adminweb') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('asset_adminweb') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('asset_adminweb') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
        href="{{ asset('asset_adminweb') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('asset_adminweb') }}/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('asset_adminweb') }}/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="{{ asset('asset_adminweb') }}/css/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"
        integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"
        integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>

    @stack('css')

    <style>
        iframe {
            width: 100%;
            height: 100%;
        }
    </style>
    <style>
        /* untuk menghilangkan spinner  */
        .spinner {
            display: none;
        }

        .loading,
        .loading-simpan,
        .loading-update,
        .loading-hapus,
        {
        display: none;
        }
    </style>
    <SCRIPT language=Javascript>
        <!--
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            } else {
                return true;
            }

        }
        //
        -->
    </SCRIPT>
</head>

<body class="sidebar-mini layout-navbar-fixed layout-footer-fixed layout-fixed text-sm">

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('asset_adminweb') }}/dist/img/user.jfif" class="img-circle elevation-2"
                        alt="User Image">
                </div>
                <div class="info text-center text-white">
                    {{ auth()->user()->name }}
                </div>
            </div>
            @include('sweetalert::alert')

            @include('layout.adminweb.v_nav')
            {{-- </div> --}}
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                {{-- <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">@yield('title')</h1>
                        </div>
                    </div>
                </div> --}}
            </div>
            @yield('content')
        </div>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('asset_adminweb') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('asset_adminweb') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('asset_adminweb') }}/dist/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('asset_adminweb') }}/plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('asset_adminweb') }}/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('asset_adminweb') }}/dist/js/pages/dashboard3.js"></script>


    <!-- DataTables  & Plugins -->

    <script src="{{ asset('asset_adminweb') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('asset_adminweb') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('asset_adminweb') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('asset_adminweb') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('asset_adminweb') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('asset_adminweb') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('asset_adminweb') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('asset_adminweb') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('asset_adminweb') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('asset_adminweb') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>

    <script src="{{ asset('asset_adminweb') }}/plugins/select2/js/select2.full.min.js"></script>
    <script src="{{ asset('asset_adminweb') }}/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="{{ asset('asset_adminweb') }}/js/sweetalert2.all.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('asset_adminweb') }}/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    @yield('java')
</body>

</html>
