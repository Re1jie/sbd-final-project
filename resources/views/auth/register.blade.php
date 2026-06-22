@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center fw-bold">Register Client</div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register.process') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="NAMA" class="form-control" value="{{ old('NAMA') }}" required>
                            @error('NAMA') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="EMAIL" class="form-control" value="{{ old('EMAIL') }}" required>
                            @error('EMAIL') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Pengiriman</label>
                            <textarea name="ALAMAT" class="form-control" rows="3" required>{{ old('ALAMAT') }}</textarea>
                            @error('ALAMAT') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="PASSWORD" class="form-control" required>
                            @error('PASSWORD') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="PASSWORD_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Daftar Akun</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection