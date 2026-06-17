@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Tambah Mahasiswa</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('mahasiswa.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">NIM</label>
                        <input type="text" name="nim"
                            class="form-control @error('nim') is-invalid @enderror"
                            value="{{ old('nim') }}" placeholder="Contoh: 20210001">
                        @error('nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama"
                            class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="Contoh: budi@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Barang</label>
                        <input type="text" name="jenis_barang"
                            class="form-control @error('jenis_barang') is-invalid @enderror"
                            value="{{ old('jenis_barang') }}" placeholder="Contoh: Laptop, Arduino, Kabel HDMI">
                        @error('jenis_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Angkatan</label>
                        <input type="number" name="angkatan"
                            class="form-control @error('angkatan') is-invalid @enderror"
                            value="{{ old('angkatan') }}" placeholder="Contoh: 2021"
                            min="2000" max="{{ date('Y') }}">
                        @error('angkatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Simpan
                        </button>
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection