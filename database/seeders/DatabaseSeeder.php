<?php

namespace Database\Seeders;

use App\Models\Baseline;
use App\Models\BaselineItem;
use App\Models\BaselineMatrixRow;
use App\Models\InitialAnalysis;
use App\Models\Kickoff;
use App\Models\MomKickoff;
use App\Models\Project;
use App\Models\ProjectPlan;
use App\Models\RaciTemplate;
use App\Models\ResourceMatrix;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $seedPath = base_path('data/seed.json');
        $uiSeedPath = base_path('data/ui_seed.json');

        $seed = json_decode((string) file_get_contents($seedPath), true);
        $uiSeed = json_decode((string) file_get_contents($uiSeedPath), true);

        // 1. Projects
        $catalog = $uiSeed['projectsCatalog'] ?? [];
        $known = $seed['knownProjects'] ?? [];

        foreach ($catalog as $p) {
            Project::updateOrCreate(
                ['project_id' => $p['projectId']],
                [
                    'canonical_code' => $p['canonicalCode'] ?? null,
                    'project_name' => $p['projectName'] ?? 'Project',
                    'client_name' => $p['clientName'] ?? 'Client',
                    'client_division' => $p['clientDivision'] ?? null,
                    'intake_status' => $p['intakeStatus'] ?? 'diterima PM',
                    'handover_date' => $p['handoverDate'] ?? null,
                    'pm_name' => $p['pmName'] ?? 'Project Manager',
                    'pm_employee_id' => $p['pmEmployeeId'] ?? '01929b4a-5f10-7a22-9d44-3c8f1b2e7a90',
                    'pm_user_id' => $p['pmUserId'] ?? '01924b1e-7f32-7c40-8a01-9c0010100101',
                    'active' => true,
                ]
            );
        }

        foreach ($known as $kId) {
            if (! Project::where('project_id', $kId)->exists()) {
                Project::create([
                    'project_id' => $kId,
                    'project_name' => 'Proyek Terdaftar '.$kId,
                    'client_name' => 'PT Mitra Terdaftar',
                    'intake_status' => 'diterima PM',
                    'active' => true,
                ]);
            }
        }

        // 2. Initial Analysis
        $init = $uiSeed['initialAnalysis'] ?? [];
        if (! empty($init['projectId'])) {
            InitialAnalysis::updateOrCreate(
                ['analysis_id' => 1],
                [
                    'project_id' => $init['projectId'],
                    'project_need' => $init['projectNeed'] ?? 'Portal layanan pelanggan terpadu',
                    'project_condition' => $init['projectCondition'] ?? 'Dokumen kontrak sudah lengkap',
                    'status' => $init['status'] ?? 'Tersimpan',
                    'is_saved' => $init['isSaved'] ?? true,
                    'created_by' => $init['createdBy'] ?? '01924b1e-7f32-7c40-8a01-9c0010100101',
                    'updated_by' => $init['updatedBy'] ?? '01924b1e-7f32-7c40-8a01-9c0010100101',
                ]
            );
        }

        // 3. Baselines & Baseline Items
        $baselines = $seed['baselines'] ?? [];
        foreach ($baselines as $b) {
            $baseline = Baseline::updateOrCreate(
                ['baseline_id' => $b['id']],
                [
                    'project_id' => $b['projectId'],
                    'analysis_id' => 1,
                    'version' => $b['version'],
                    'baseline_date' => Carbon::now('Asia/Jakarta')->format('Y-m-d'),
                    'status' => $b['status'],
                    'approved_by' => $b['status'] === 'APPROVED' ? '01924b1e-7f32-7c40-8a01-9c0010100101' : null,
                    'approved_at' => $b['approvedAt'] ? Carbon::parse($b['approvedAt']) : null,
                    'simulator_mode' => $b['status'] === 'APPROVED' ? 3 : 1,
                    'is_complete' => true,
                    'created_by' => '01924b1e-7f32-7c40-8a01-9c0010100101',
                ]
            );

            if (! empty($b['items']) && is_array($b['items'])) {
                BaselineItem::where('baseline_id', $baseline->baseline_id)->delete();
                foreach ($b['items'] as $item) {
                    BaselineItem::create([
                        'baseline_id' => $baseline->baseline_id,
                        'project_id' => $b['projectId'],
                        'baseline_item_id' => $item['baselineItemId'],
                        'name' => $item['name'],
                        'type' => $item['type'],
                    ]);
                }
            }
        }

        // 4. Baseline Matrix Rows (for baseline 301 from ui_seed)
        $matrices = $uiSeed['baseline']['matrices'] ?? [];
        if (! empty($matrices)) {
            BaselineMatrixRow::where('baseline_id', 301)->delete();
            foreach (['scope', 'deliverable', 'timeline'] as $type) {
                if (isset($matrices[$type])) {
                    foreach ($matrices[$type] as $row) {
                        BaselineMatrixRow::create([
                            'baseline_id' => 301,
                            'baseline_item_id' => $row['code'] ?? null,
                            'matrix_type' => $type,
                            'module' => $row['module'] ?? '',
                            'description' => $row['description'] ?? null,
                            'start_date' => $row['startDate'] ?? null,
                            'end_date' => $row['endDate'] ?? null,
                            'pic_role' => $row['picRole'] ?? 'TL',
                        ]);
                    }
                }
            }
        }

        // 5. Project Plans
        $plans = $seed['plans'] ?? [];
        foreach ($plans as $p) {
            ProjectPlan::updateOrCreate(
                ['plan_id' => $p['id']],
                [
                    'project_id' => $p['projectId'],
                    'planned_date' => '2026-10-19',
                    'due_date_h1' => '2026-10-16',
                    'baseline_id' => 301,
                    'scope_section' => 'Ruang lingkup proyek resmi',
                    'deliverable_section' => 'Daftar hasil kerja terdefinisi',
                    'timeline_section' => 'Jadwal implementasi fase 1-3',
                    'roadmap_section' => 'Peta jalan milestone Q4',
                    'target_progress' => $p['targetProgress'] ?? [],
                    'updated_by' => '01924b1e-7f32-7c40-8a01-9c0010100101',
                ]
            );
        }

        // 6. Kickoffs & MoM
        $kickoffs = $seed['kickoffs'] ?? [];
        foreach ($kickoffs as $k) {
            $kickoff = Kickoff::updateOrCreate(
                ['kickoff_id' => $k['id']],
                [
                    'project_id' => $k['projectId'],
                    'plan_id' => 401,
                    'agenda' => 'Pembukaan, pembahasan scope, timeline, dan alokasi peran.',
                    'material' => 'Slide presentasi kick-off meeting 10 poin.',
                    'created_by' => '01924b1e-7f32-7c40-8a01-9c0010100101',
                ]
            );
        }

        $moms = $seed['moms'] ?? [];
        foreach ($moms as $m) {
            MomKickoff::updateOrCreate(
                ['mom_id' => $m['id']],
                [
                    'kickoff_id' => $m['kickoffId'],
                    'mom_attachment' => 'mom-kickoff-'.$m['id'].'.pdf',
                    'status' => $m['status'],
                    'completed_at' => $m['completedAt'] ? Carbon::parse($m['completedAt']) : null,
                    'recorded_by' => '01924b1e-7f32-7c40-8a01-9c0010100101',
                ]
            );
        }

        // 7. Resource Matrices
        $resources = $uiSeed['dummyResources'] ?? [];
        ResourceMatrix::where('project_id', '01924b1e-7f32-7a81-9b12-45e8a1234567')->delete();
        foreach ($resources as $res) {
            ResourceMatrix::create([
                'project_id' => '01924b1e-7f32-7a81-9b12-45e8a1234567',
                'role' => $res['role'],
                'person_name' => $res['personName'],
                'is_dummy' => $res['isDummy'] ?? true,
                'employee_id' => $res['employeeId'] ?? null,
                'module' => $res['module'],
                'allocation_percent' => $res['allocationPercent'] ?? 100,
                'start_date' => $res['startDate'],
                'end_date' => $res['endDate'],
                'updated_by' => '01924b1e-7f32-7c40-8a01-9c0010100101',
            ]);
        }

        // 8. RACI Templates
        $raciProcesses = [
            1 => ['Intake & Inisiasi Proyek', ['AM' => 'A', 'PM' => 'R', 'TL' => 'C', 'Developer' => 'I']],
            2 => ['Analisis Kebutuhan & Kondisi Awal', ['PM' => 'A', 'TL' => 'R', 'Developer' => 'C']],
            3 => ['Penyusunan Baseline Matriks', ['PM' => 'A', 'TL' => 'R', 'Developer' => 'C']],
            4 => ['Penetapan Tanggal Rencana & H-1', ['PM' => 'A', 'TL' => 'C']],
            5 => ['Estimasi Jam Kerja Pekerjaan', ['TL' => 'A', 'Developer' => 'R', 'PM' => 'I']],
            6 => ['Alokasi Matriks Sumber Daya (SDM)', ['PM' => 'A', 'TL' => 'C']],
            7 => ['Pelaksanaan Kickoff Meeting', ['PM' => 'A', 'TL' => 'C', 'Developer' => 'I']],
            8 => ['Penyusunan & Persetujuan MoM Kickoff', ['PM' => 'A', 'TL' => 'C', 'Developer' => 'I']],
        ];

        foreach ($raciProcesses as $pNo => $pData) {
            [$pName, $roles] = $pData;
            foreach ($roles as $rCode => $rVal) {
                RaciTemplate::updateOrCreate(
                    ['process_no' => $pNo, 'role_code' => $rCode],
                    [
                        'process_name' => $pName,
                        'raci_value' => $rVal,
                    ]
                );
            }
        }
    }
}
