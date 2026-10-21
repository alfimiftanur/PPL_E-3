<?php

namespace App\Services;

/**
 * Seed data source from data/seed.json (stateless/no database).
 * In production, this service queries the project database tables.
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
        return in_array($projectId, $this->data['knownProjects'], true);
    }

    /** Returns project execution readiness status. */
    public function executionReadiness(string $projectId): array
    {
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
        ];
    }

    private function last(array $rows, callable $match): ?array
    {
        $found = array_values(array_filter($rows, $match));

        return $found ? $found[count($found) - 1] : null;
    }
}
