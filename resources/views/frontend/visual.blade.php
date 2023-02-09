@extends('layout.main')
@section('pageTitle', 'Data Statistik Sektoral Kabupaten Ponorogo')
@section('content')
    <section>
        <div class="container">
            <div class="section-title text-center mb-5 mb-lg-7 wow fadeInDown" data-wow-delay=".2s">
                <h2 class="font-weight-700 mb-3">Visualisasi</h2>
                <p class="w-95 w-md-80 w-lg-60 w-xl-45 mx-auto">Representasi Visual berupa Diagram, Grafik dari
                    Data Statistik.</p>
            </div>
            <div class="icon-box p-1 m-0 wow fadeInRight" data-wow-delay=".2s">
                <div class="row mx-2 justify-content-end">
                    <div class="col-md-4">
                        <form action="/visual">
                            <div class="input-group mb-3">
                                @if (request('search'))
                                    <input type="text" class="form-control" value="{{ request('search') }}"
                                        placeholder="Pencarian...." name="search">
                                @else
                                    <input type="text" class="form-control" placeholder="Pencarian...." name="search">
                                @endif
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row mt-n3 justify-content-center">
                @foreach ($visuals as $visual)
                    <div class="col-lg-3 mt-3 wow fadeInUp" data-wow-delay=".2s">
                        <div class="card card-style04 border border-width-1 border-radius-8 mt-3">
                            <a href="visual/{{ $visual->slug }}">
                                <img src="{{ url('image/visualisasi/' . $visual->id) }}" class="card-img-top">
                                <div class="card-body">
                                    <p class="mb-0 w-95 w-md-75 w-lg-95 w-xl-80 mx-auto">{{ $visual->title }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center my-5">
                {{ $visuals->links() }}
            </div>
        </div>
    </section>
    @include('partials.footer')
@endsection
