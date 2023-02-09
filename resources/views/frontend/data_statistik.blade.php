<table id="tb_statistik" name="tb_statistik" class="table table-striped table-hover table-bordered" border="1">
    <thead>
        <tr>
            <th class="text-center" style="width: 10px">
                #
            </th>
            <th>
                Data Statistik
            </th>
            <!-- <th class="text-center" style="width: 20px">
                Upload
            </th> -->
            <th class="text-center" style="width: 10px">
                Action
            </th>
        </tr>
    </thead>
    @foreach ($subtabel as $tabel)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $tabel->title }}</td>
            <!-- <td class="text-center">{!! @date('d/m/Y', strtotime($tabel->updated_at)) !!}</td> -->
            <td class="text-center">
                {{-- <a href="{{ url('/instansi/' . $instansi->name . '/table/' . $tabel->id) }}"
                    class="badge bg-success">View
                </a> --}}
                <button type="button" class="btn badge bg-success" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Views
                </button>
                <a href="{{ url('/Data') . '/' . $instansi->id . '/' . $tabel->file }}"
                    class="badge bg-primary">Download
                </a>
            </td>
        </tr>
    @endforeach
</table>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
