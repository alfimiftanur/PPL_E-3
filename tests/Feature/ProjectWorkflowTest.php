<?php

namespace Tests\Feature;

use App\Services\ProjectWorkflowService;
use Tests\TestCase;

class ProjectWorkflowTest extends TestCase
{
    private const PROJECT_ID = '01924b1e-7f32-7a81-9b12-45e8a1234567';

    protected function setUp(): void
    {
        parent::setUp();
        app(ProjectWorkflowService::class)->resetState();
    }

    private function authHeaders(): array
    {
        return ['Authorization' => 'Bearer mock-token'];
    }

    public function test_all_four_web_ui_pages_render_ok(): void
    {
        $this->get('/projects/initial-analysis')->assertOk()->assertSee('Pencatatan Analisis Awal Proyek');
        $this->get('/projects/baseline-setup')->assertOk()->assertSee('Penyusunan Baseline Proyek');
        $this->get('/projects/planned-date')->assertOk()->assertSee('Penentuan Tanggal Rencana Project Plan');
        $this->get('/projects/baseline-review')->assertOk()->assertSee('Peninjauan dan Persetujuan Baseline Proyek');
    }

    public function test_api_overview_returns_project_state_and_references(): void
    {
        $this->getJson('/api/v1/projects/'.self::PROJECT_ID.'/overview', $this->authHeaders())
            ->assertOk()
            ->assertJsonStructure([
                'state' => ['project', 'initialAnalysis', 'baseline', 'projectPlan'],
                'planningReferences' => ['projectId', 'baselineId', 'baselineVersion', 'approvedAt', 'planId'],
                'executionReadiness' => ['projectId', 'kickoffId', 'momId', 'status', 'completedAt', 'readyForExecution'],
            ]);
    }

    public function test_api_initial_analysis_validation_and_save(): void
    {
        // Rejects empty fields with 422
        $this->postJson('/api/v1/projects/'.self::PROJECT_ID.'/initial-analysis', [
            'projectNeed' => '',
            'projectCondition' => '',
        ], $this->authHeaders())
            ->assertStatus(422)
            ->assertJsonPath('errors.projectNeed', 'Kebutuhan awal wajib diisi.')
            ->assertJsonPath('errors.projectCondition', 'Kondisi awal wajib diisi.');

        // Saves valid analysis
        $this->postJson('/api/v1/projects/'.self::PROJECT_ID.'/initial-analysis', [
            'projectNeed' => 'Migrasi core transaction ke microservices',
            'projectCondition' => 'Server CentOS 9 Stream siap',
        ], $this->authHeaders())
            ->assertOk()
            ->assertJsonPath('initialAnalysis.status', 'Tersimpan')
            ->assertJsonPath('initialAnalysis.isSaved', true);
    }

    public function test_api_initial_analysis_keeps_created_fields_on_update(): void
    {
        $url = '/api/v1/projects/'.self::PROJECT_ID.'/initial-analysis';

        // Buat
        $first = $this->postJson($url, [
            'projectNeed' => 'Kebutuhan A',
            'projectCondition' => 'Kondisi A',
        ], $this->authHeaders())
            ->assertOk()
            ->json('initialAnalysis');

        $this->assertNotEmpty($first['createdAt']);
        $this->assertNotEmpty($first['createdBy']);

        // Ubah
        $second = $this->postJson($url, [
            'projectNeed' => 'Kebutuhan A',
            'projectCondition' => 'Kondisi B',
        ], $this->authHeaders())
            ->assertOk()
            ->json('initialAnalysis');

        // createdBy dan createdAt tetap, isi berubah, ID tetap
        $this->assertSame($first['createdAt'], $second['createdAt']);
        $this->assertSame($first['createdBy'], $second['createdBy']);
        $this->assertSame('Kondisi B', $second['projectCondition']);
        $this->assertSame('1', $second['analysisId']);
    }

    public function test_api_planned_date_calculates_h_minus_1_working_day_skipping_weekend(): void
    {
        // Monday 2026-10-19 -> H-1 working day is Friday 2026-10-16
        $this->postJson('/api/v1/projects/'.self::PROJECT_ID.'/planned-date', [
            'plannedDate' => '10/19/2026',
        ], $this->authHeaders())
            ->assertOk()
            ->assertJsonPath('projectPlan.plannedDate', '2026-10-19')
            ->assertJsonPath('projectPlan.dueDateH1', '2026-10-16')
            ->assertJsonPath('projectPlan.dueDayName', 'Jumat');

        // Invalid date returns 422
        $this->postJson('/api/v1/projects/'.self::PROJECT_ID.'/planned-date', [
            'plannedDate' => 'invalid-date',
        ], $this->authHeaders())
            ->assertStatus(422)
            ->assertJsonPath('message', 'Tanggal rencana tidak valid.');
    }

    public function test_api_baseline_simulator_and_approval_flow(): void
    {
        // Mode 2 (incomplete) blocks approval with 422
        $this->postJson('/api/v1/projects/'.self::PROJECT_ID.'/baselines/simulator-mode', [
            'mode' => 2,
        ], $this->authHeaders())->assertOk();

        $this->postJson('/api/v1/projects/'.self::PROJECT_ID.'/baselines/approve', [], $this->authHeaders())
            ->assertStatus(422)
            ->assertJsonPath('code', 'BASELINE_INCOMPLETE');

        // Mode 1 (complete draft) allows approval -> status becomes APPROVED
        $this->postJson('/api/v1/projects/'.self::PROJECT_ID.'/baselines/simulator-mode', [
            'mode' => 1,
        ], $this->authHeaders())->assertOk();

        $this->postJson('/api/v1/projects/'.self::PROJECT_ID.'/baselines/approve', [], $this->authHeaders())
            ->assertOk()
            ->assertJsonPath('baseline.status', 'APPROVED');
    }
}
