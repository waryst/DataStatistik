@extends('layout.adminweb.index')
@section('title', 'Dashboard')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-laptop-house"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Instansi </span>
                            <span class="info-box-number">
                                {{ $instansi->description }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1">
                            <i class="fas fa-chart-pie"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Data Statistik Terverifikasi</span>
                            <span class="info-box-number">{{ $verifieddata }}</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1">
                            <i class="fas fa-chart-pie"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text ">Data Statistik Belum Terverifikasi</span>
                            <span class="info-box-number">{{ $unverifieddata }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- MAP & BOX PANE -->
                    <div class="card">
                        <div class="card-header">
                            @if ($instansi->description == null)
                                <h3 class="card-title">PETA Data Statistik Sektoral Kabupaten Ponorogo</h3>
                            @else
                                <h3 class="card-title">PETA {{ $instansi->description }}</h3>
                            @endif
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="d-md-flex">
                                <div class="p-1 flex-fill" style="overflow: hidden">
                                    <!-- Map will be created here -->
                                    {{-- <div class="position-absolute px-2 py-2" style="right: 0;"> --}}
                                    <?php if ($instansi->logo != null) { ?>
                                    <img src="{{ url('image/logo/' . $instansi->id) }}" style="right: 0;width: 90px"
                                        class="position-absolute px-2 py-2 card-img-top" alt="{{ $instansi->name }}">

                                    <?php } else { ?>
                                    <img src="{{ asset('logo.png') }}" style="right: 0;width: 90px"
                                        class="position-absolute px-2 py-2 card-img-top" alt="{{ $instansi->name }}">

                                    <?php } ?>

                                    {{-- </div> --}}
                                    <div id="world-map-markers" style="height: 325px; overflow: hidden">

                                        @if ($instansi->map == null)
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d505763.25984839204!2d111.24920809385759!3d-7.970457255833439!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e790b859cfee851%3A0x3027a76e352bea0!2sKabupaten%20Ponorogo%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1610428936898!5m2!1sid!2sid"
                                                width="700" height="450" frameborder="0" style="border:0;"
                                                allowfullscreen="" aria-hidden="false" tabindex="0">
                                            </iframe>
                                        @else
                                            {!! $instansi->map !!}
                                        @endif
                                    </div>
                                </div>
                            </div><!-- /.d-md-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box mb-2 py-md-2 bg-warning">
                        <div class="info-box-content">
                            <div class="row">
                                <div class="col-md-12 ">
                                    @if ($instansi->foto_kadin == null)
                                        <img src="{{ asset('user.jpg') }}"
                                            class="rounded-circle mt-2 mx-auto d-block" width="100px">
                                    @else
                                        <img src="{{ url('image/kadin/' . $instansi->id) }}"
                                            class="rounded-circle mt-2 mx-auto d-block" width="100" height="100">
                                    @endif

                                </div>
                                <div class="col-md-12">
                                    <div class="info-box-content mt-3 ml-2">
                                        <span class="info-box-text text-center">Kepala Dinas</span>
                                        <span class="info-box-number text-center">{{ $instansi->nama_kadin }}</span>
                                        <span class="info-box-text text-center">NIP. {{ $instansi->nip }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="info-box mb-2 bg-success">
                        <span class="info-box-icon"><i class="fas fa-user-tie"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah PNS</span>
                            <span class="info-box-number">{{ $instansi->pns }}</span>
                        </div>
                    </div>
                    <div class="info-box mb-2 bg-danger">
                        <span class="info-box-icon"><i class="fas fa-user"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah Non-PNS</span>
                            <span class="info-box-number">{{ $instansi->kontrak }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
