<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use WorkOS\WorkOS;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected WorkOS $workos;

    public function __construct()
    {
        $this->workos = new WorkOS(
            apiKey: config('services.workos.api_key'),
            clientId: config('services.workos.client_id'),
);
    }

    /**
     * Redirect langsung ke halaman login AuthKit WorkOS (hosted UI).
     * Tidak perlu tampilan kustom — WorkOS yang menyediakan UI-nya.
     */
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('mahasiswa.index');
        }

        $authorizationUrl = $this->workos->userManagement()->getAuthorizationUrl(
            redirectUri: config('services.workos.redirect_uri'),
            provider: \WorkOS\Resource\UserManagementAuthenticationProvider::Authkit,
        );

        return redirect()->away($authorizationUrl);
    }

    /**
     * Tangani callback dari WorkOS setelah user berhasil login.
     */
    public function callback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Kode otorisasi tidak diterima dari WorkOS.']);
        }

        try {
            $authResponse = $this->workos->userManagement()->authenticateWithCode(
                code: $request->input('code'),
            );

            // Simpan session ID WorkOS untuk proses logout
            $sessionId = null;
            $tokenParts = explode('.', $authResponse->accessToken);
            if (count($tokenParts) >= 2) {
                $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $tokenParts[1])), true);
                $sessionId = $payload['sid'] ?? null;
            }
            if ($sessionId) {
                $request->session()->put('workos_session_id', $sessionId);
            }

            $workosUser = $authResponse->user;

            $name = trim(($workosUser->firstName ?? '') . ' ' . ($workosUser->lastName ?? ''));
            if (empty($name)) {
                $name = $workosUser->email;
            }

            // Cari atau buat user lokal berdasarkan email
            $user = User::firstOrCreate(
                ['email' => $workosUser->email],
                [
                    'name'     => $name,
                    'password' => bcrypt(Str::random(32)),
                ]
            );

            // Update nama jika sudah ada dan nama baru tersedia
            if ($user->wasRecentlyCreated === false && $name !== $workosUser->email) {
                $user->update(['name' => $name]);
            }

            Auth::login($user);

            return redirect()->route('mahasiswa.index')
                ->with('success', 'Selamat datang, ' . $user->name . '!');

        } catch (\Throwable $e) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Login gagal: ' . $e->getMessage()]);
        }
    }

    /**
     * Logout user dari aplikasi Laravel.
     */
    public function logout(Request $request)
    {
        $sessionId = $request->session()->get('workos_session_id');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($sessionId) {
            try {
                $logoutUrl = $this->workos->userManagement()->getLogoutUrl(
                    sessionId: $sessionId,
                    returnTo: route('login')
                );
                return redirect()->away($logoutUrl);
            } catch (\Throwable $e) {
                // Fallback jika gagal
            }
        }

        return redirect()->route('login');
    }
}
