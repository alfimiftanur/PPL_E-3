<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * Manages dummy project planning state for the web UI and internal API endpoints.
 * Keeps data/seed.json untouched so OpenAPI contract tests remain deterministic.
 */
class ProjectWorkflowService
{
    public const DEFAULT_PROJECT_ID = '01924b1e-7f32-7a81-9b12-45e8a1234567';

    private string $seedPath;
    private string $runtimePath;

    public function __construct()
    {
        $this->seedPath = base_path('data/ui_seed.json');
        $this->runtimePath = storage_path('app/workflow_state.json');
    }

    public function getState(): array
    {
        if (file_exists($this->runtimePath)) {
            $decoded = json_decode((string) file_get_contents($this->runtimePath), true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return $this->resetState();
    }

    public function resetState(): array
    {
        $default = json_decode((string) file_get_contents($this->seedPath), true, 512, JSON_THROW_ON_ERROR);
        $this->persist($default);

        return $default;
    }

    public function saveInitialAnalysis(string $projectNeed, string $projectCondition): array
    {
        $state = $this->getState();
        $now = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s').' WIB';

        $state['initialAnalysis'] = [
            'analysisId' => '1',
            'projectNeed' => $projectNeed,
            'projectCondition' => $projectCondition,
            'status' => 'Tersimpan',
            'isSaved' => true,
            'updatedBy' => 'USR-0101',
            'updatedAt' => $now,
        ];

        $this->persist($state);

        return $state['initialAnalysis'];
    }

    public function clearInitialAnalysis(): array
    {
        $state = $this->getState();

        $state['initialAnalysis'] = [
            'analysisId' => '1',
            'projectNeed' => '',
            'projectCondition' => '',
            'status' => 'Belum dicatat',
            'isSaved' => false,
            'updatedBy' => null,
            'updatedAt' => null,
        ];

        $this->persist($state);

        return $state['initialAnalysis'];
    }

    public function saveBaseline(array $matrices, bool $incrementVersion = true): array
    {
        $state = $this->getState();
        $now = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s').' WIB';

        if (! empty($matrices['scope'])) {
            $state['baseline']['matrices']['scope'] = array_values($matrices['scope']);
        }
        if (! empty($matrices['deliverable'])) {
            $state['baseline']['matrices']['deliverable'] = array_values($matrices['deliverable']);
        }
        if (! empty($matrices['timeline'])) {
            $state['baseline']['matrices']['timeline'] = array_values($matrices['timeline']);
        }

        if ($incrementVersion) {
            $version = (int) ($state['baseline']['version'] ?? 1);
            $state['baseline']['version'] = $version;
            $state['baseline']['versionLabel'] = 'v'.$version.'.0';
        }

        $state['baseline']['baselineDate'] = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $state['baseline']['createdAt'] = $now;
        $state['baseline']['status'] = 'DRAFT';
        $state['baseline']['statusLabel'] = 'Draf Baseline';
        $state['baseline']['statusSub'] = 'Tersimpan pada server';
        $state['baseline']['isComplete'] = true;
        $state['baseline']['simulatorMode'] = 1;

        $this->persist($state);

        return $state['baseline'];
    }

    /**
     * Calculates H-1 working day (Monday-Friday, skipping Saturday & Sunday) and saves the planned date.
     */
    public function savePlannedDate(string $rawDate): ?array
    {
        $parsed = $this->parseDate($rawDate);
        if (! $parsed) {
            return null;
        }

        $h1 = $parsed->copy()->subDay();
        while ($h1->isWeekend()) {
            $h1->subDay();
        }

        $dayNames = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];

        $state = $this->getState();
        $state['projectPlan'] = [
            'planId' => '401',
            'plannedDateInput' => $parsed->format('m/d/Y'),
            'plannedDate' => $parsed->format('Y-m-d'),
            'dueDateH1' => $h1->format('Y-m-d'),
            'dueDayName' => $dayNames[$h1->dayOfWeek],
            'cutoffTime' => '23:59:59 WIB',
            'lastSavedAt' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s').' WIB',
            'authorizedBy' => 'Project Manager',
        ];

        $this->persist($state);

        return $state['projectPlan'];
    }

    public function setSimulatorMode(int $mode): array
    {
        $state = $this->getState();
        $state['baseline']['simulatorMode'] = $mode;

        if ($mode === 1) {
            $state['baseline']['status'] = 'DRAFT';
            $state['baseline']['statusLabel'] = 'Draf Baseline';
            $state['baseline']['statusSub'] = 'Belum difinalisasi';
            $state['baseline']['isComplete'] = true;
            $state['baseline']['completenessLabel'] = 'Lengkap (3/3 Matriks)';
            $state['baseline']['completenessSub'] = 'Scope, Deliverables, Timeline';
            $state['baseline']['approvedBy'] = null;
            $state['baseline']['approvedAt'] = null;
        } elseif ($mode === 2) {
            $state['baseline']['status'] = 'DRAFT';
            $state['baseline']['statusLabel'] = 'Draf Belum Lengkap';
            $state['baseline']['statusSub'] = 'Menunggu kelengkapan matriks';
            $state['baseline']['isComplete'] = false;
            $state['baseline']['completenessLabel'] = 'Belum Lengkap (2/3 Matriks)';
            $state['baseline']['completenessSub'] = 'Timeline Matrix belum diisi';
            $state['baseline']['approvedBy'] = null;
            $state['baseline']['approvedAt'] = null;
        } elseif ($mode === 3) {
            $now = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s').' WIB';
            $state['baseline']['status'] = 'APPROVED';
            $state['baseline']['statusLabel'] = 'Disetujui (APPROVED)';
            $state['baseline']['statusSub'] = 'Acuan resmi terkunci';
            $state['baseline']['isComplete'] = true;
            $state['baseline']['completenessLabel'] = 'Lengkap (3/3 Matriks)';
            $state['baseline']['completenessSub'] = 'Scope, Deliverables, Timeline';
            $state['baseline']['approvedBy'] = 'Project Manager (USR-0101)';
            $state['baseline']['approvedAt'] = $state['baseline']['approvedAt'] ?: '2026-10-14 10:00:00 WIB';
        }

        $this->persist($state);

        return $state['baseline'];
    }

    private function parseDate(string $raw): ?Carbon
    {
        $trimmed = trim($raw);
        try {
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $trimmed)) {
                return Carbon::createFromFormat('m/d/Y', $trimmed, 'Asia/Jakarta')->startOfDay();
            }
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $trimmed)) {
                return Carbon::createFromFormat('Y-m-d', $trimmed, 'Asia/Jakarta')->startOfDay();
            }
        } catch (\Throwable) {
            return null;
        }

        return null;
    }

    private function persist(array $state): void
    {
        $dir = dirname($this->runtimePath);
        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        file_put_contents($this->runtimePath, json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
