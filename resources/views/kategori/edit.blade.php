@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($kategori)
            <form method="POST" action="{{ url('/kategori/' . $kategori->kategori_id) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <!-- Input Level Kategori -->
                <div class="form-group row">
                    <label class="col-3 col-form-label">Level Kategori</label>
                    <div class="col-9">
                        <input type="text" class="form-control" name="level_kategori" value="{{ $kategori->level_kategori }}" required>
                        @error('level_kategori')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Pilihan Nama Kategori -->
                <div class="form-group row">
                    <label class="col-3 col-form-label">Nama Kategori</label>
                    <div class="col-9">
                        <select class="form-control" name="nama_kategori" required>
                            <option value="">- Pilih Nama Kategori -</option>
                            @foreach($kategoriOptions as $option)
                                <option value="{{ $option->nama_kategori }}" 
                                    @if($option->nama_kategori == $kategori->nama_kategori) selected @endif>
                                    {{ $option->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('nama_kategori')
                            <small class="text-danger">{{ $__messageOriginal }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="form-group row">
                    <label class="col-3 col-form-label"></label>
                    <div class="col-9">
                        <button type="submit" class="btn btn-primary">Update Kategori</button>
                        <a href="{{ url('/kategori') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </form>
        @else
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                Data kategori tidak ditemukan.
            </div>
            <a href="{{ url('/kategori') }}" class="btn btn-default mt-2">Kembali</a>
        @endif
    </div>
</div>
@endsection