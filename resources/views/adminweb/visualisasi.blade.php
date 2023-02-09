@extends('layout.adminweb.index')
@section('title', 'Validasi Data Statistik')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body py-0">
                            <a href="/visualisasi_data/create" class="btn btn-sm btn-primary mb-3">
                                <i class="fas fa-plus"></i> Visualisasi Data
                            </a>
                            <table id="news" class="table table-sm  dtr-inline table-head-fixed " role="grid"
                                aria-describedby="news_info">
                                <thead>
                                    <tr role="row">
                                        <th style="width:10%"class="text-center">#</th>
                                        <th>Judul</th>
                                        <th class="text-center" style="width:10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visual as $news)
                                        <tr>
                                            <td class="
                                            text-center">
                                                {{ $loop->iteration }}</td>
                                            <td>{{ $news->title }}</td>

                                            <td class="text-center text-nowrap">
                                                <form action="/visualisasi_data/{{ $news->slug }}" class="d-inline"
                                                    method="post">
                                                    @method('put')
                                                    @csrf
                                                    @if ($news->publish_at != null)
                                                        <button style="border: none" class="badge bg-info" name="show"
                                                            value="show"><i class="fas fa-eye p-1"></i></button>
                                                    @else
                                                        <button style="border: none" class="badge bg-info" name="unshow"
                                                            value="unshow"><i class="fas fa-eye-slash p-1"></i></button>
                                                    @endif
                                                </form>
                                                <a href="/adminweb/news/{{ $news->slug }}/edit"
                                                    class="badge bg-warning"><i class="far fa-edit p-1"></i>
                                                </a>
                                                <form action="/visualisasi_data/{{ $news->slug }}" method="post"
                                                    class="d-inline" id='delete{{ $news->slug }}'>
                                                    @method('delete')
                                                    @csrf
                                                    <button class="badge bg-danger border-0 tombol-hapus"
                                                        id='{{ $news->slug }}'><i class="far fa-trash-alt p-1"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
@section('java')
    <script>
        $(document).ready(function() {

            $('.tombol-hapus').on('click', function(e) {
                e.preventDefault();
                const id = $(this).attr('id');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data Berita  akan di hapus!!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus Data!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete' + id).submit();
                    }
                })
            });
        })
        $(function() {
            $('#news').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
