@extends('layout.adminweb.index')

@section('title', 'Data Statistik')
@push('css')
    <style>
        .table {}

        .table th:nth-child(1),
        .table td:nth-child(1) {
            position: sticky;
            left: 0;
            background-color: #f2edef;
            color: #373737;
        }

        .table th:nth-child(2),
        .table td:nth-child(2) {
            position: sticky;
            left: 31px;
            background-color: #f2edef;
            color: #373737;
        }



        .table td {
            white-space: nowrap;
        }
    </style>
@endpush
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-gray-dark">
                        <div class="card-header">
                            <h3 class="card-title">Entry Data Statistik</h3>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-hover" data-fixed-columns="false" data-fixed-number="3">
                                    <thead>
                                        <tr>
                                            <th class="align-middle text-center">#</th>
                                            <th class="align-middle text-center" style="height: 100px">Indikator Kinerja
                                                Utama</th>

                                            @foreach ($tahun as $th)
                                                <th colspan="2" class="text-center">{{ $th->tahun }}</th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th class="align-middle text-center"></th>
                                            <th r class="align-middle text-center"></th>
                                            @foreach ($tahun as $th)
                                                <td class="text-center">Target</td>
                                                <td class="text-center">Capaian</td>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($iku as $iku)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $iku->indikator }}</td>
                                                @foreach ($tahun as $data_tahun)
                                                    <td class="text-center">0</td>
                                                    <td class="text-center">0</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
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
        });



        $(document).ready(function() {

            $(function() {
                $("#datatable").DataTable({
                    "paging": false,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": false,
                    "info": false,
                    "autoWidth": false,
                    "responsive": true,

                });
            });
        });
    </script>

@endsection
