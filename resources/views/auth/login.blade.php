<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Masuk ke aplikasi LK-10 untuk mengelola data mahasiswa Informatika.">
    <title>Masuk — LK-10</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-wrapper">
        <h1 class="page-title">Masuk</h1>

        <div class="auth-card">
            {{-- Brand icon --}}
            <div class="brand-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11 11-4.925 11-11S18.075 1 12 1zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm0 13.5a8.5 8.5 0 0 1-6.535-3.073C6.74 14.48 9.259 13.5 12 13.5s5.26.98 6.535 2.927A8.5 8.5 0 0 1 12 19.5z"/>
                </svg>
            </div>

            {{-- Header text --}}
            <div class="card-header-text">
                <p class="card-title">Masuk ke Data Mahasiswa Informatika Peminjaman Alat Lab Riset</p>
                <p class="card-subtitle">Pilih metode login untuk melanjutkan</p>
            </div>

            {{-- Error messages --}}
            @if($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Auth buttons --}}
            <div class="auth-buttons">
                {{-- Tombol WorkOS AuthKit --}}
                <a href="{{ route('auth.redirect') }}" class="btn-auth btn-authkit" id="btn-authkit">
                    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" fill="none">
                        <rect width="32" height="32" rx="8" fill="#6366F1"/>
                        <path d="M8 11l4.5 10 3.5-7 3.5 7L24 11" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Masuk dengan AuthKit
                </a>
            </div>
        </div>

        <p class="auth-footer">
            Dilindungi oleh <a href="https://workos.com" target="_blank" rel="noopener">WorkOS</a> — mendukung SSO Enterprise, Email, GitHub, Microsoft &amp; Apple.
        </p>
    </div>
</body>
</html>
