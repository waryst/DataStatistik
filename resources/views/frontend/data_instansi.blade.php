@extends('layout.main')

@section('pageTitle', 'Data Statistik Sektoral Kabupaten Ponorogo')

@section('content')

    <!-- ======= Hero Section ======= -->

    <!-- End Hero -->
    <section>
        <div class="container lg-container">
            <div class="section-title text-center mb-5 mb-lg-7 wow fadeInDown" data-wow-delay=".2s">
                <h2 class="font-weight-700 mb-3">Dinas dan Instansi</h2>
                <p class="w-95 w-md-80 w-lg-60 w-xl-45 mx-auto">Produsen Data Statistik di Kabupaten Ponorogo.</p>
            </div>
            <div class="icon-box p-1 m-0 wow fadeInRight" data-wow-delay=".2s">
                <div class="row mx-2 justify-content-end">
                    <div class="col-md-4">
                        <form action="/instansi">
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
                @foreach ($instansi as $data)
                    <div class="col-lg-3 mt-3 wow fadeInUp" data-wow-delay=".2s">
                        <a href="{{ url('/instansi') }}/{{ $data['name'] }}">
                            <div class="card card-style04 border border-width-2 border-radius-8 pb-0">
                                <div class="card-header">
                                    @if ($data->logo == null)
                                        <img src="{{ asset('logo.png') }}" class="card-img-top">
                                    @else
                                        <img src="{{ url('image/logo/' . $data->id) }}" class="card-img-top">
                                    @endif
                                </div>
                                <div class="my-2">
                                    <h1 class="card-text fs-6 ">
                                        {{ $data->name }}
                                    </h1>
                                    {{ App\models\DataStatistik::where('instansi_id', $data->id)->where('validasi', 1)->where('status', 1)->count() }}
                                    Datasets
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center my-5">
                {{ $instansi->links() }}
            </div>
        </div>
    </section>


 @include('partials.mainfooter')
@endsection
