<div class="modal-body">
    <div class="card card-success">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Update Data Statistik</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body my-0 py-0">
                <div class="form-group">
                    <label for="edit_title">Judul Data</label>
                    <input type="text" class="form-control  @error('edit_title') is-invalid @enderror"
                        name="edit_title" id="edit_title" placeholder="Judul Data"
                        value="{{ old('edit_title', $pencarian_data->title) }}">
                    @error('edit_title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi Data</label>
                    <textarea rows="6" class="form-control @error('description') is-invalid @enderror" name="description"
                        id="description" placeholder="description">{{ old('description', $pencarian_data->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="edit_file">Input File Excel/Pdf/CSV</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file  @error('edit_file') is-invalid @enderror"
                            name="edit_file" id="edit_file">
                        <label class="custom-file-label" for="edit_file">Pilih
                            file</label>
                        @error('edit_file')
                            <div class="invalid-feedback text-nowrap pt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="card-footer mt-0 pt-0">
                <button class="btn btn-sm bg-gradient-success float-md-right button-update"
                    onclick="edit({{ $pencarian_data->id }})" name="update" value="update">Update</button>
                <button class="btn btn-sm bg-gradient-success float-md-right loading-update">
                    <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i>
                        Update
                    </div>
                </button>
            </div>
        </div>
    </div>
