@extends('layout.main')
@section('pageTitle', 'Data Statistik Sektoral Kabupaten Ponorogo')

@section('content')
    @include('partials.hero')

    <section class="md">
        <div class="container lg-container">
            <div class="section-title text-center mb-5 mb-lg-7 wow fadeInDown" data-wow-delay=".2s">
                <h2 class="font-weight-700 mb-3">Visualisasi</h2>
                <p class="w-95 w-md-80 w-lg-60 w-xl-45 mx-auto">Representasi Visual berupa Diagram, Grafik dari
                    Data Statistika.</p>
            </div>
            <div class="row mt-n3 justify-content-center">
                @foreach ($visual as $visual)
                    <div class="col-lg-4 mt-3 wow fadeInUp" data-wow-delay=".2s">
                        <div class="card card-style04 border border-width-1 border-radius-8">
                            <div class="card-header">
                                <img src="{{ url('image/visualisasi/' . $visual->id) }}" class="card-img-top">
                            </div>
                            <a href="visual/{{ $visual->slug }}">
                                <div class="card-body">
                                    <p class="mb-0 w-95 w-md-75 w-lg-95 w-xl-80 mx-auto">{{ $visual->title }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex section-title mt-4 justify-content-center wow fadeInUp" data-wow-delay=".2s">
                <a href="/visual" class="btn btn-outline-primary">Selengkapnya </a>
            </div>
        </div>

        <div class="container lg-container mt-5">

            {{-- <div class="section-title text-center mb-5 mb-lg-7 wow fadeInDown" data-wow-delay=".2s">
                <h2 class="font-weight-700 mb-3">You deserve better business</h2>
                <p class="w-95 w-md-80 w-lg-60 w-xl-45 mx-auto">You need offer an experience that is not available
                    elsewhere. Clean and creative HTMl template.</p>
            </div> --}}

            <div class="row align-items-center mb-5">
                <div class="col-lg-6 col-md-12 mb-4 mb-lg-0 text-center wow fadeInLeft" data-wow-delay=".1s">
                    <img src="{{ asset('assets') }}/img/content/data.png" alt="...">
                </div>
                <div class="col-lg-6 col-md-12 wow fadeInRight" data-wow-delay=".1s">
                    <div class="content d-flex flex-column justify-content-center">
                        <div class="row">
                            <div class="col-md-12 d-md-flex ">
                                <p><strong>Satu
                                        Data Indonesia</strong> adalah kebijakan Pemerintah Indonesia untuk
                                    mendukung proses
                                    pengambilan keputusan berbasis data. Untuk mewujudkan hal tersebut, maka
                                    diperlukan
                                    pemenuhan atas data pemerintah yang akurat, terbuka, dan interoperabel atau
                                    mudah
                                    dibagipakaikan antar pengguna data

                            </div>
                            <div class="col-md-6 d-md-flex ">
                                <div class="card card-style12 text-start">
                                    <div class="icon-box4 bg1 d-flex align-content-center flex-wrap justify-content-center">
                                        <div>
                                            <i class="fas fa-database fa-2x  align-content-center" style="color:#f9b152"></i>
                                            <span class="countup fs-3" style="color:#f9b152">{{ $jumlah_DataStatistik }}</span>
                                        </div>
                                    </div>
                                    <p>
                                        <strong>DataSets</strong> Data Statistik yang terkumpul dan sudah tervalidasi
                                        oleh verifikator maupun Wali data
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 d-md-flex ">
                                <div class="card card-style12 text-start" >
                                    <div class="icon-box4 bg4 d-flex align-content-center flex-wrap justify-content-center">
                                        <div>
                                            <i class="fas fa-building fa-2x " style="color:#2b87ca"></i>
                                            <span class="countup " style="color:#2b87ca">{{ $jumlah_instansi }}</span>
                                        </div>
                                    </div>
                                    <p>
                                        <strong>Produsen Data</strong> Dinas maupun Instansi yang menjadi rujukan sumber
                                        data Statistik
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="container lg-container">
            <div class="section-title text-center mb-5 mb-lg-7 wow fadeInDown" data-wow-delay=".2s">
                <h2 class="font-weight-700 mb-3">Dinas dan Instansi</h2>
                <p class="w-95 w-md-80 w-lg-60 w-xl-45 mx-auto">Produsen Data Statistik di Kabupaten Ponorogo.</p>
            </div>
            <section class="md pt-0">
                <div class="section-clients pb-4">
                    <div class="container wow fadeInUp" data-wow-delay=".2s">
                        <div class="owl-carousel owl-theme border border-width-3 border-radius-8 clients-style2"
                            id="clients">

                            @foreach ($instansi as $data)
                                <div class="col-md-1-5 card-style04 my-4">
                                    <a href="{{ url('/instansi') }}/{{ $data['name'] }}">
                                        <div class="item">
                                            @if ($data->logo == null)
                                                <img src="{{ asset('logo.png') }}">
                                            @else
                                                <img src="{{ url('image/logo/' . $data->id) }}">
                                            @endif
                                            <h1 class="text-center fs-6 ">
                                                {{ $data->name }}
                                            </h1>
                                            <p class="text-center ">
                                                {{ App\models\DataStatistik::where('instansi_id', $data->id)->where('validasi', 1)->where('status', 1)->count() }}
                                                Datasets
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex section-title mt-4 justify-content-center wow fadeInUp" data-wow-delay=".2s">
                            <a href="/instansi" class="btn btn-outline-danger">Selengkapnya </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
    @include('partials.mainfooter')
@endsection

