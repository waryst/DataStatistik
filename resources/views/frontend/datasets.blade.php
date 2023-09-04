@extends('layout.main')

@section('pageTitle', 'Data Statistik Sektoral Kabupaten Ponorogo')

@section('content')

    <style>
        .container{
            font-size: 13px !important;
            
        }
        .card-body *{
            font-weight: 400 !important;
        }
        .border-radius-4 {
            border-radius: 0 !important;
        }

        .border-width-3 {
            border: 1px solid rgb(222, 226, 230) !important;
            margin-bottom: 10px;
        }

    </style>
    <section>
        <div class="container lg-container mb-5">
            <div class="row">
                <div class="col-md-4 justify-content-center mb-3 ">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('logo.png') }}">
                                <div class="mt-3">
                                    <h5 class="mt-2">Pemerintah Daerah Kabupaten Ponorogo</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative"
                            style="height: 329px;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d505763.25984839204!2d111.24920809385759!3d-7.970457255833439!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e790b859cfee851%3A0x3027a76e352bea0!2sKabupaten%20Ponorogo%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1610428936898!5m2!1sid!2sid"
                                width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""
                                aria-hidden="false" tabindex="0">
                            </iframe>
                        </div>
                    </div>
                    <div class="card mt-3" style="font-size: 13px">
                        <div class="section-item-title-link px-2">
                            <h3>Situs Terkait</h3>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h7 class="mb-0">Pemerintah Kab. Ponorogo</h7>
                                    <span class="text-secondary"><a href="https://ponorogo.go.id/">
                                            Ponorogo.go.id</a></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h7 class="mb-0">Tentang Ponorogo</h7>
                                    <span class="text-secondary"><a href="https://ponorogo.go.id/berita/">Berita
                                            Ponorogo</a></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h7 class="mb-0">Diskominfo Kab. Ponorogo</h7>
                                    <span class="text-secondary"><a href="https://kominfo.ponorogo.go.id/"> Kominfo
                                        </a></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div id="accordion" class="accordion-style01">
                        <table id="tb_statistik" name="tb_statistik" class="table">
                      
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="page" style="overflow: auto"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var exampleModal = document.getElementById('exampleModal')
        exampleModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget
            var judul = button.getAttribute('data-title')
            var resource = button.getAttribute('data-resource')

            var modalTitle = exampleModal.querySelector('.modal-title')
            var modalBodyInput = exampleModal.querySelector('.modal-body input')
            $.get("{{ url('data') }}/lihatdata" + '/' + resource, {}, function(data,
                status) {
                $("#page").html(data);
            })
            modalTitle.textContent = judul
        })
    </script>
    @include('partials.mainfooter')
@endsection
@push('java')
    <script type="text/javascript">
        $(document).ready(function() {
            $(function() {
                $('#tb_statistik').DataTable({
                    paging: true,
                    serverSide: true,
                    processing: true,
                    ajax: 'datasets/json',
                    columns: [ {
                        data: 'title',
                        name: 'title',
                        visible: false,
                    }, {
                        data: 'opsi',
                        name: 'opsi'
                    }, ],
                });
            });
                // $('#tb_statistik').DataTable({
                //     "paging": true,
                //     "lengthChange": true,
                //     "searching": true,
                //     "ordering": false,
                //     "columnDefs": [{
                //         "targets": [0], //first column / numbering column
                //         "orderable": false, //set not orderable
                //     }, ],
                //     "info": true,
                //     "autoWidth": true,
                //     "responsive": true,
                // });
        });
    </script>
@endpush
