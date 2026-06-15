<?php
namespace Tests\Feature\Api;
use App\Models\Mahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class MahasiswaApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test get all mahasiswa list.
     */
    public function test_can_get_all_mahasiswa(): void
    {
        Mahasiswa::create([
            'nim' => '123456',
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => '2024'
        ]);
        $response = $this->getJson('/api/mahasiswa');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => ['id', 'nim', 'nama', 'email', 'jurusan', 'angkatan', 'created_at', 'updated_at']
                    ]
                ]
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Daftar data mahasiswa berhasil diambil'
            ]);
    }
    /**
     * Test create new mahasiswa with valid data.
     */
    public function test_can_create_mahasiswa(): void
    {
        $payload = [
            'nim' => '654321',
            'nama' => 'Jane Doe',
            'email' => 'jane@example.com',
            'jurusan' => 'Sistem Informasi',
            'angkatan' => 2025
        ];
        $response = $this->postJson('/api/mahasiswa', $payload);
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Data mahasiswa berhasil ditambahkan',
                'data' => [
                    'nim' => '654321',
                    'nama' => 'Jane Doe',
                    'email' => 'jane@example.com',
                    'jurusan' => 'Sistem Informasi',
                    'angkatan' => '2025'
                ]
            ]);
        $this->assertDatabaseHas('mahasiswas', [
            'nim' => '654321',
            'email' => 'jane@example.com'
        ]);
    }
    /**
     * Test create new mahasiswa validation errors.
     */
    public function test_cannot_create_mahasiswa_with_invalid_data(): void
    {
        $payload = [
            'nim' => '', // required
            'nama' => '', // required
            'email' => 'invalid-email', // invalid format
            'jurusan' => '', // required
            'angkatan' => 1999 // min: 2000
        ];
        $response = $this->postJson('/api/mahasiswa', $payload);
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validasi gagal'
            ])
            ->assertJsonStructure(['errors' => ['nim', 'nama', 'email', 'jurusan', 'angkatan']]);
    }
    /**
     * Test get single mahasiswa by id.
     */
    public function test_can_get_single_mahasiswa(): void
    {
        $mahasiswa = Mahasiswa::create([
            'nim' => '112233',
            'nama' => 'Alice',
            'email' => 'alice@example.com',
            'jurusan' => 'Desain Komunikasi Visual',
            'angkatan' => '2023'
        ]);
        $response = $this->getJson("/api/mahasiswa/{$mahasiswa->id}");
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Detail data mahasiswa berhasil diambil',
                'data' => [
                    'id' => $mahasiswa->id,
                    'nim' => '112233',
                    'nama' => 'Alice'
                ]
            ]);
    }
    /**
     * Test return 404 when student not found.
     */
    public function test_returns_404_when_mahasiswa_not_found(): void
    {
        $response = $this->getJson('/api/mahasiswa/999');
        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ]);
    }
    /**
     * Test update mahasiswa data.
     */
    public function test_can_update_mahasiswa(): void
    {
        $mahasiswa = Mahasiswa::create([
            'nim' => '445566',
            'nama' => 'Bob',
            'email' => 'bob@example.com',
            'jurusan' => 'Teknik Elektro',
            'angkatan' => '2022'
        ]);
        $payload = [
            'nim' => '445566', // same nim is allowed for self
            'nama' => 'Bob Updated',
            'email' => 'bob_new@example.com',
            'jurusan' => 'Teknik Elektro Baru',
            'angkatan' => 2023
        ];
        $response = $this->putJson("/api/mahasiswa/{$mahasiswa->id}", $payload);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Data mahasiswa berhasil diperbarui',
                'data' => [
                    'id' => $mahasiswa->id,
                    'nama' => 'Bob Updated',
                    'email' => 'bob_new@example.com',
                    'jurusan' => 'Teknik Elektro Baru',
                    'angkatan' => '2023'
                ]
            ]);
        $this->assertDatabaseHas('mahasiswas', [
            'id' => $mahasiswa->id,
            'nama' => 'Bob Updated',
            'email' => 'bob_new@example.com'
        ]);
    }
    /**
     * Test delete mahasiswa data.
     */
    public function test_can_delete_mahasiswa(): void
    {
        $mahasiswa = Mahasiswa::create([
            'nim' => '778899',
            'nama' => 'Charlie',
            'email' => 'charlie@example.com',
            'jurusan' => 'Fisika',
            'angkatan' => '2021'
        ]);
        $response = $this->deleteJson("/api/mahasiswa/{$mahasiswa->id}");
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Data mahasiswa berhasil dihapus'
            ]);
        $this->assertDatabaseMissing('mahasiswas', [
            'id' => $mahasiswa->id
        ]);
    }
}
