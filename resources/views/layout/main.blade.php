<!DOCTYPE html>
<html lang="en">

<head>

    <!-- metas -->
    <meta charset="utf-8">
    <meta name="author" content="Chitrakoot Web" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="keywords" content="Startup Agency and SasS Business Template" />
    <meta name="description" content="Data Statistik Ponorogo" />

    <!-- title  -->
    <title>Data Statistik</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('assets') }}/img/logos/favicon.png" />
    <link rel="apple-touch-icon" href="{{ asset('assets') }}/img/logos/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets') }}/img/logos/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets') }}/img/logos/apple-touch-icon-114x114.png" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"></script>
    <link rel="stylesheet" href="{{ asset('assets') }}/css/dataTables.min.css" />

    <!-- plugins -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/plugins.css" />

    <!-- search css -->
    <link rel="stylesheet" href="{{ asset('assets') }}/search/search.css" />

    <!-- quform css -->
    <link rel="stylesheet" href="{{ asset('assets') }}/quform/css/base.css">
    <style>

    </style>

    <!-- theme core css -->
    <link href="{{ asset('assets') }}/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>

<body>
    <div id="preloader"></div>
    <div class="main-wrapper">
        <header class="position-absolute w-100 sm-position-relative transparent-header">
            <div class="navbar-default bg-primary-90">
                <!-- start top search -->
                <div class="top-search bg-black-opacity-light">
                    <div class="container lg-container">
                        <form class="search-form" action="search.html" method="GET" accept-charset="utf-8">
                            <div class="input-group">
                                <span class="input-group-addon cursor-pointer">
                                    <button class="search-form_submit fas fa-search text-white" type="submit"></button>
                                </span>
                                <input type="text" class="search-form_input form-control" name="s"
                                    autocomplete="off" placeholder="Type & hit enter...">
                                <span class="input-group-addon close-search"><i class="fas fa-times mt-2"></i></span>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end top search -->

                <div class="container lg-container">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-12">
                            <div class="menu_area alt-font">
                                <nav class="navbar navbar-expand-lg navbar-light p-0">
                                    <div class="navbar-header navbar-header-custom">
                                        <!-- start logo -->
                                        <a href="/" class="navbar-brand inner-logo"><img id="logo"
                                                src="{{ asset('assets') }}/img/logos/logo-white.png" alt="logo"></a>
                                        <!-- end logo -->
                                    </div>
                                    <div class="navbar-toggler"></div>
                                    <!-- start menu area -->
                                    <ul class="navbar-nav ms-auto" id="nav" style="display: none;">
                                        <li><a href="/">Beranda</a> </li>
                                        <li><a href="{{ url('/visual') }}">Visualisasi</a></li>
                                        <li><a href="{{ url('/publikasi') }}">Publikasi</a></li>
                                        <li><a href="{{ url('/datasets') }}">Datasets</a></li>
                                        <li><a href="{{ url('/instansi') }}">Instansi</a></li>
                                        @guest
                                            <li><a href="{{ url('/login') }} ">Sign In</a></li>
                                        @endguest
                                        @auth
                                            @if (auth()->user()->role == 'administrator')
                                                <li><a href="{{ url('/verifikasi') }}">Member</a>
                                                </li>
                                            @else
                                                <li><a href="{{ url('/dashboard') }}">Member</a>
                                                </li>
                                            @endif
                                        @endauth
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>


    </div>



    @yield('content')

    <!-- ======= Footer ======= -->

    <a href="#!" class="scroll-to-top"><i class="fas fa-angle-up" aria-hidden="true"></i></a>

    <!-- all js include start -->
    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery.min.js"></script>

    <!-- popper js -->
    <script src="{{ asset('assets') }}/js/popper.min.js"></script>

    <!-- bootstrap -->
    <script src="{{ asset('assets') }}/js/bootstrap.min.js"></script>

    <!-- jquery -->
    <script src="{{ asset('assets') }}/js/core.min.js"></script>

    <!-- search -->
    <script src="{{ asset('assets') }}/search/search.js"></script>

    <!-- custom scripts -->
    <script src="{{ asset('assets') }}/js/main.js"></script>

    <!-- form plugins js -->
    <script src="{{ asset('assets') }}/quform/js/plugins.js"></script>

    <!-- form scripts js -->
    <script src="{{ asset('assets') }}/quform/js/scripts.js"></script>

    <!-- all js include end -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>


    <script src="{{ asset('asset_adminweb') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('asset_adminweb') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('asset_adminweb') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('asset_adminweb') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(function() {
                $("#datatable").DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
                $('#tb_statistik').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "columnDefs": [{
                        "targets": [0], //first column / numbering column
                        "orderable": false, //set not orderable
                    }, ],
                    "info": true,
                    "autoWidth": true,
                    "responsive": true,
                });
            });
        });
    </script>
</body>

</html>
