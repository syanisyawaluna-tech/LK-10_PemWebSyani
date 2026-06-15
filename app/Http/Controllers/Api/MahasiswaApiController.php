<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class MahasiswaApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::latest()->paginate(10);
        return response()->json([
            'success' => true,
            'message' => 'Daftar data mahasiswa berhasil diambil',
            'data' => $mahasiswas
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim'      => 'required|string|max:20|unique:mahasiswas',
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:mahasiswas',
            'jurusan'  => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:' . date('Y'),
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        $mahasiswa = Mahasiswa::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil ditambahkan',
            'data' => $mahasiswa
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Detail data mahasiswa berhasil diambil',
            'data' => $mahasiswa
        ], 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'nim'      => 'required|string|max:20|unique:mahasiswas,nim,' . $id,
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:mahasiswas,email,' . $id,
            'jurusan'  => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:' . date('Y'),
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        $mahasiswa->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil diperbarui',
            'data' => $mahasiswa
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }
        $mahasiswa->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil dihapus'
        ], 200);
    }
}