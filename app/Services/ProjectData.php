<?php

namespace App\Services;

use App\Models\Baseline;
use App\Models\BaselineItem;
use App\Models\Kickoff;
use App\Models\MomKickoff;
use App\Models\Project;
use App\Models\ProjectPlan;

/**
 * Data provider for cross-service OpenAPI endpoints.
 * Prioritizes querying MySQL database via Eloquent, with graceful fallback to seed JSON.
 */
class ProjectData
{
    public const UUID_V7 = '/^[0-9a-f]{8}-[0-9a-f]{4}-7[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';

    private array $data;

    public function __construct(?string $path = null)
    {
        $path ??= base_path('data/seed.json');
        $this->data = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
    }

    public static function isValidId(string $id): bool
    {
        return preg_match(self::UUID_V7, $id) === 1;
    }

    public function exists(string $projectId): bool
    {
        try {
            if (Project::where('project_id', $projectId)->exists()) {
                return true;
            }
        } catch (\Throwable) {
            // Database not reachable or unmigrated; proceed with JSON fallback
        }

        return in_array($projectId, $this->data['knownProjects'] ?? [], true);
    }

    /** Returns project execution readiness status. */
    public function executionReadiness(string $projectId): array
    {
        try {
            $kickoff = Kickoff::where('project_id', $projectId)->latest('kickoff_id')->first();
            $projectExists = Project::where('project_id', $projectId)->exists();

            if ($kickoff || $projectExists) {
                $mom = $kickoff ? MomKickoff::where('kickoff_id', $kickoff->kickoff_id)->latest('mom_id')->first() : null;
                $done = $mom !== null && $mom->status === 'COMPLETED';

                return [
                    'projectId' => $projectId,
                    'kickoffId' => $kickoff ? (string) $kickoff->kickoff_id : null,
                    'momId' => $mom ? (string) $mom->mom_id : null,
                    'status' => $mom->status ?? null,
                    'completedAt' => $done && $mom->completed_at ? $mom->completed_at->setTimezone('Asia/Jakarta')->format('Y-m-d\TH:i:sP') : null,
                    'readyForExecution' => $done,
                ];
            }
        } catch (\Throwable) {
            // Database not reachable; proceed with JSON fallback
        }

        $kickoff = $this->last($this->data['kickoffs'], fn ($k) => $k['projectId'] === $projectId);
        $mom = $kickoff
            ? $this->last($this->data['moms'], fn ($m) => $m['kickoffId'] === $kickoff['id'])
            : null;
        $done = $mom !== null && $mom['status'] === 'COMPLETED';

        return [
            'projectId' => $projectId,
            'kickoffId' => $kickoff ? (string) $kickoff['id'] : null,
            'momId' => $mom ? (string) $mom['id'] : null,
            'status' => $mom['status'] ?? null,
            'completedAt' => $done ? $mom['completedAt'] : null,
            'readyForExecution' => $done,
        ];
    }

    /** Returns latest APPROVED baseline and project plan references; DRAFT baselines are excluded. */
    public function planningReferences(string $projectId): array
    {
        try {
            $baseline = Baseline::where('project_id', $projectId)
                ->where('status', 'APPROVED')
                ->orderByDesc('version')
                ->first();

            $plan = ProjectPlan::where('project_id', $projectId)->latest('plan_id')->first();
            $projectExists = Project::where('project_id', $projectId)->exists();

            if ($baseline || $plan || $projectExists) {
                $items = [];
                if ($baseline) {
                    $dbItems = BaselineItem::where('baseline_id', $baseline->baseline_id)->get();
                    foreach ($dbItems as $item) {
                        $items[] = [
                            'baselineItemId' => $item->baseline_item_id,
                            'name' => $item->name,
                            'type' => $item->type,
                        ];
                    }
                }

                return [
                    'projectId' => $projectId,
                    'baselineId' => $baseline ? (string) $baseline->baseline_id : null,
                    'baselineVersion' => $baseline->version ?? null,
                    'approvedAt' => $baseline && $baseline->approved_at ? $baseline->approved_at->setTimezone('Asia/Jakarta')->format('Y-m-d\TH:i:sP') : null,
                    'planId' => $plan ? (string) $plan->plan_id : null,
                    'baselineItems' => $items,
                    'targetProgress' => $plan->target_progress ?? [],
                ];
            }
        } catch (\Throwable) {
            // Database not reachable; proceed with JSON fallback
        }

        $approved = array_filter(
            $this->data['baselines'],
            fn ($b) => $b['projectId'] === $projectId && $b['status'] === 'APPROVED'
        );
        usort($approved, fn ($a, $b) => $b['version'] <=> $a['version']);
        $baseline = $approved[0] ?? null;
        $plan = $this->last($this->data['plans'], fn ($p) => $p['projectId'] === $projectId);

        return [
            'projectId' => $projectId,
            'baselineId' => $baseline ? (string) $baseline['id'] : null,
            'baselineVersion' => $baseline['version'] ?? null,
            'approvedAt' => $baseline['approvedAt'] ?? null,
            'planId' => $plan ? (string) $plan['id'] : null,
            'baselineItems' => $baseline['items'] ?? [],
            'targetProgress' => $plan['targetProgress'] ?? [],
        ];
    }

    private function last(array $rows, callable $match): ?array
    {
        $found = array_values(array_filter($rows, $match));

        return $found ? $found[count($found) - 1] : null;
    }
}
