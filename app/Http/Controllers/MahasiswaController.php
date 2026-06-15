<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::latest()->paginate(10);
        return view('mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim'      => 'required|string|max:20|unique:mahasiswas',
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:mahasiswas',
            'jurusan'  => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        Mahasiswa::create($request->all());

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(int $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'nim'      => 'required|string|max:20|unique:mahasiswas,nim,' . $id,
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:mahasiswas,email,' . $id,
            'jurusan'  => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($request->all());

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(int $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}