<?php

namespace Tests\Feature;

use App\Services\ProjectWorkflowService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Pengujian integrasi modul F-2 (Master SDM & Tenaga Ahli):
 * Memvalidasi pengambilan data pegawai kanonis untuk melengkapi nama PM dan penanganan error graceful.
 */
class F2IntegrationTest extends TestCase
{
    private const PROJECT_ID = '01924b1e-7f32-7a81-9b12-45e8a1234567';
    private const EMPLOYEE_ID = '01929b4a-5f10-7a22-9d44-3c8f1b2e7a90';

    protected function setUp(): void
    {
        parent::setUp();
        app(ProjectWorkflowService::class)->resetState();
        config([
            'services.d1.mode' => 'mock',
            'services.f2.mode' => 'real',
            'services.f2.base_url' => 'http://f2.test/api/v1',
            'services.f2.token' => 'token-coo',
        ]);
    }

    public function test_overview_memperkaya_nama_pm_dari_f2(): void
    {
        Http::fake([
            'f2.test/api/v1/referensi/sdm/*' => Http::response([
                'employeeId' => self::EMPLOYEE_ID,
                'nomorPegawai' => 'SDM-2026-001',
                'namaLengkap' => 'Sandy Walsh',
                'jabatanId' => '01929b4a-83a1-7d55-8b12-9f7c2e4a6b10',
                'namaJabatan' => 'Project Manager',
                'statusKerja' => 'karyawan',
            ], 200),
        ]);

        $this->get('/projects/overview')
            ->assertOk()
            ->assertSee('Sandy Walsh')
            ->assertSee('Sumber data SDM: F-2');

        Http::assertSent(fn ($r) => str_contains($r->url(), 'referensi/sdm') && $r->hasHeader('Authorization'));
    }

    public function test_f2_404_menampilkan_pesan_dan_halaman_tetap_berjalan(): void
    {
        Http::fake([
            'f2.test/api/v1/referensi/sdm/*' => Http::response(['code' => 404, 'message' => 'EMPLOYEE_NOT_FOUND'], 404),
        ]);

        $this->get('/projects/overview')
            ->assertOk()
            ->assertSee('Referensi SDM F-2 tidak terjangkau')
            ->assertSee('EMPLOYEE_NOT_FOUND');
    }

    public function test_f2_tidak_terjangkau_menampilkan_pesan_tanpa_crash(): void
    {
        Http::fake(function () {
            throw new ConnectionException('Connection refused');
        });

        $this->get('/projects/overview')
            ->assertOk()
            ->assertSee('Referensi SDM F-2 tidak terjangkau')
            ->assertSee('F2_UNREACHABLE');
    }

    public function test_mode_mock_tidak_memanggil_f2(): void
    {
        config(['services.f2.mode' => 'mock']);
        Http::fake();

        $this->get('/projects/overview')->assertOk();

        Http::assertNothingSent();
    }
}
