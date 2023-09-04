@extends('layout.main')

@section('pageTitle', 'Data Statistik Sektoral Kabupaten Ponorogo')

@section('content')

    <section>
        <div class="container">
            <div class="section-title text-center mb-5 mb-lg-7 wow fadeInDown" data-wow-delay=".2s">
                <h2 class="font-weight-700 mb-3">Publikasi</h2>
            </div>
            <div class="icon-box p-1 m-0" data-aos="fade-up" data-aos-delay="100">
                <div class="row mx-2 justify-content-end">
                    <div class="col-md-4">
                        <form action="/publikasi">
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
            <div class="row my-5">
                @foreach ($publikasi as $publik)
                    <div class="col-lg-6 mt-3 wow fadeInUp" data-wow-delay=".2s">
                        <div class="card card-style04 border border-width-1 border-radius-8 mt-3">
                            <p class="fs-5">{{ $publik->title }}</p>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="card">

                                        <img src="{{ url('image/publikasi/' . $publik->id) }}" class="card-img-top">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div style="text-align: left">{!! str_replace('font-size', 'font-size: 15px;', $publik->description) !!}</div>

                                    <div class="timeline-footer d-flex justify-content-start">
                                        <form class="d-inline" action="/public/{{ $publik->id }}/{{ $publik->title }}">
                                            {{ csrf_field() }}
                                            <button style="border: none" type="submit" class="btn btn-success btn-sm py-1"
                                                name="download"> Download
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center my-5">
                {{ $publikasi->links() }}
            </div>
        </div>
    </section>
    @include('partials.footer')
@endsection
