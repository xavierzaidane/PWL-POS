@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Kategori</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('kategori/create') }}">Tambah Kategori</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Filter Kategori -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="level_kategori" name="level_kategori">
                                <option value="">- Semua -</option>
                                @foreach($kategoris as $item)
                                    <option value="{{ $item->level_kategori }}">{{ $item->level_kategori }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Pilih Level Kategori</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <table class="table table-bordered table-striped table-hover table-sm" id="table_kategori">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Level Kategori</th>
                        <th>Nama Kategori</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
<script>
$(document).ready(function() {
    var dataKategori = $('#table_kategori').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('kategori/list') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: function(d) {
                d.level_kategori = $('#level_kategori').val();
            },
            error: function(xhr, error, thrown) {
                console.log(xhr.responseText);
                alert("Error loading data. Check console for details.");
            }
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: "level_kategori", orderable: true, searchable: true },
            { data: "nama_kategori", orderable: true, searchable: true },
            { data: "action", orderable: false, searchable: false }
        ]
    });

    $('#level_kategori').on('change', function(){
        dataKategori.ajax.reload();
    });
});
</script>
@endpush
