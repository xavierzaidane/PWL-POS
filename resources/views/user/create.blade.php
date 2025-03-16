@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    
    <div class="card-body">
        <form method="POST" action="{{ url('/user') }}" class="form-horizontal">
            @csrf
            
            <!-- Level Selection -->
            <div class="form-group row">
                <label class="col-2 col-form-label">Level</label>
                <div class="col-10">
                    <select class="form-control" id="level_id" name="level_id" required>
                        <option value="">- Select Level -</option>
                        @foreach($level ?? [] as $item)
                        @endforeach
                    </select>
                    @error('level_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <!-- Username -->
            <div class="form-group row">
                <label class="col-2 col-form-label">Username</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                    @error('username')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <!-- Name -->
            <div class="form-group row">
                <label class="col-2 col-form-label">Name</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <!-- Password -->
            <div class="form-group row">
                <label class="col-2 col-form-label">Password</label>
                <div class="col-10">
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="form-group row">
                <div class="col-10 offset-2">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('user') }}">Return</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection