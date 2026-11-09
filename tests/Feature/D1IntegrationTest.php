<?php

namespace Tests\Feature;

use App\Services\ProjectWorkflowService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/** Halaman Ringkasan Data memanggil D-1 (API 7) pada mode real; Http::fake menggantikan D-1. */
class D1IntegrationTest extends TestCase
{
    private const ID = '01924b1e-7f32-7a81-9b12-45e8a1234567';

    protected function setUp(): void
    {
        parent::setUp();
        app(ProjectWorkflowService::class)->resetState();
        config(['services.d1.mode' => 'real', 'services.d1.base_url' => 'http://d1.test/api/v1']);
    }

    public function test_overview_memakai_data_proyek_dari_d1(): void
    {
        Http::fake(['d1.test/*' => Http::response([
            'projectId' => self::ID,
            'canonicalCode' => '202601',
            'projectName' => 'Implementasi Sistem ERP Cloud Phase 1',
            'clientName' => 'PT Fikri Solusi Mandiri',
            'amEmployeeId' => '01929b4a-6e2a-7b3f-8c71-0ab4e3d9f2a1',
            'amName' => 'Fikri Lazuardi Fadilla',
            'pmEmployeeId' => '01929b4a-5f10-7a22-9d44-3c8f1b2e7a01',
            'pmName' => 'Haekal Khadafy',
            'status' => 'REGISTERED',
            'active' => true,
            'indicativeValue' => 950000000,
            'auditLogs' => [],
        ], 200)]);

        $this->get('/projects/overview')
            ->assertOk()
            ->assertSee('Implementasi Sistem ERP Cloud Phase 1')
            ->assertSee('PT Fikri Solusi Mandiri')
            ->assertSee('Haekal Khadafy')
            ->assertDontSee('950000000');

        Http::assertSent(fn ($r) => $r->url() === 'http://d1.test/api/v1/projects/'.self::ID && $r->hasHeader('Authorization'));
    }

    public function test_d1_404_menampilkan_pesan_dan_state_e3_tidak_berubah(): void
    {
        Http::fake(['d1.test/*' => Http::response(['code' => 'PROJECT_NOT_FOUND'], 404)]);
        $before = app(ProjectWorkflowService::class)->getState();

        $this->get('/projects/overview')
            ->assertOk()
            ->assertSee('Data proyek tidak tersedia dari D-1')
            ->assertSee('PROJECT_NOT_FOUND');

        $this->assertSame($before, app(ProjectWorkflowService::class)->getState());
    }

    public function test_d1_tidak_terjangkau_menampilkan_pesan(): void
    {
        Http::fake(function () {
            throw new ConnectionException('Connection refused');
        });

        $this->get('/projects/overview')
            ->assertOk()
            ->assertSee('Data proyek tidak tersedia dari D-1')
            ->assertSee('D1_UNREACHABLE');
    }

    public function test_mode_mock_tidak_memanggil_d1(): void
    {
        config(['services.d1.mode' => 'mock']);
        Http::fake();

        $this->get('/projects/overview')->assertOk();

        Http::assertNothingSent();
    }
}
