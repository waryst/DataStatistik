@extends('layout.head')

@section('pageTitle', 'Data Statistik Sektoral Kabupaten Ponorogo')

@section('content')
    <section id="pencarian" class="d-flex align-items-center mb-5">
        <div class="container mt-4">
            <p class="fs-3 mb-4">Hasil Pencarian Dengan kata kunci <strong>" {{ $nama }} " </strong></p>
            <div class="row">

                <table id="datapencarian" name="datapencarian" class="table table-striped table-bordered table-hover"
                    border="1">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">#</th>
                            <th style="width: 15%">Instansi</th>
                            <th> Deskripsi</th>
                            <!--<th class="text-center" style="width: 20%"> Update</th> -->
                            <th> Action</th>
                        </tr>
                    </thead>
                    @foreach ($hasil as $hasil)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $hasil->name }}</td>
                            <td>{{ $hasil->title }}</td>
                            <td class="justify-content-center">
                                <button type="button" class="btn badge bg-success d-none d-sm-block" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" data-title="{{ $hasil->title }}"
                                    data-instansi="{{ $hasil->instansi_id }}" data-file="{{ $hasil->file }}">Views</button>
                                <a href="{{ url('/Data') . '/' . $hasil->instansi_id . '/' . $hasil->file }}"
                                    class="badge bg-primary p-1">Download
                                </a>

                            </td>

                        </tr>
                    @endforeach
                </table>
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
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var judul = button.getAttribute('data-title')
            var instansi_id = button.getAttribute('data-instansi')
            var file = button.getAttribute('data-file')
            // If necessary, you could initiate an AJAX request here
            // and then do the updating in a callback.
            //
            // Update the modal's content.
            var modalTitle = exampleModal.querySelector('.modal-title')
            var modalBodyInput = exampleModal.querySelector('.modal-body input')
            $.get("{{ url('instansi') }}/" + instansi_id + '/' + file, {}, function(data, status) {
                $("#page").html(data);

            })
            // var link = exampleModal.querySelector('.modal-body input')

            modalTitle.textContent = judul
        })
    </script>


@endsection
