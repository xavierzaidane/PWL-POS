@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Tambah Kategori</h3>
    </div>
    
    <div class="card-body">
        <form method="POST" action="{{ url('/kategori') }}" class="form-horizontal">
            @csrf
            
            <!-- Level Kategori -->
            <div class="form-group row">
                <label class="col-2 col-form-label">Level Kategori</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="level_kategori" name="level_kategori" value="{{ old('level_kategori') }}" required>
                    @error('level_kategori')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Nama Kategori -->
            <div class="form-group row">
                <label class="col-2 col-form-label">Nama Kategori</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" required>
                    @error('nama_kategori')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group row">
                <div class="col-10 offset-2">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('kategori') }}">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
