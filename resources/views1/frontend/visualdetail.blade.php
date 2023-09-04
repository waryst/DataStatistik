@extends('layout.main')

@section('pageTitle', 'Data Statistik Sektoral Kabupaten Ponorogo')

@section('content')
    <section class="mb-5">
        <div class="container lg-container">
            <div class="section-title text-center mb-5 mb-lg-7 wow fadeInDown" data-wow-delay=".2s">
                <h2 class="font-weight-700 mb-3">Visualisasi</h2>
                <p class="w-95 w-md-80 w-lg-60 w-xl-45 mx-auto">Representasi Visual berupa Diagram, Grafik dari
                    Data Statistik.</p>
            </div>
            <div class="row mt-n3 justify-content-center">

                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-md-7">
                        <div class="card">
                            {{-- <img src="{{ asset('storage/' . $visual->image) }} " class="img-fluid"> --}}
                            <p class="card-text">{!! $visual->visual !!}</p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h5 class="card-title" style="color:#444444;font-weight: bold">
                            {{ $visual->title }}</h5>
                        <p class="card-text">{!! $visual->deskripsi !!}</p>
                    </div>
                </div>
            </div>
    </section>
@include('partials.footer')
@endsection
