<?php

namespace App\Http\Controllers;

use App\Services\ProjectData;
use App\Services\ProjectWorkflowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectWorkflowController extends ProjectEndpoint
{
    public function __construct(
        ProjectData $data,
        private readonly ProjectWorkflowService $workflow
    ) {
        parent::__construct($data);
    }

    // -------------------------------------------------------------------------
    // Web View Actions
    // -------------------------------------------------------------------------

    public function showInitialAnalysis(): View
    {
        return view('projects.initial-analysis', [
            'activeMenu' => 'initial-analysis',
            'breadcrumb' => 'Analisis Awal',
            'breadcrumbSeparator' => '/',
            'breadcrumbActiveStyle' => 'solid',
            'state' => $this->workflow->getState(),
        ]);
    }

    public function showBaselineSetup(): View
    {
        return view('projects.baseline-setup', [
            'activeMenu' => 'baseline-setup',
            'breadcrumb' => 'Penyusunan Baseline Proyek',
            'breadcrumbSeparator' => '/',
            'breadcrumbActiveStyle' => 'solid',
            'state' => $this->workflow->getState(),
        ]);
    }

    public function showPlannedDate(): View
    {
        return view('projects.planned-date', [
            'activeMenu' => 'planned-date',
            'breadcrumb' => 'Penentuan Tanggal Rencana',
            'breadcrumbSeparator' => '>',
            'breadcrumbActiveStyle' => 'soft',
            'state' => $this->workflow->getState(),
        ]);
    }

    public function showBaselineReview(): View
    {
        $state = $this->workflow->getState();
        $projectId = $state['project']['projectId'];

        return view('projects.baseline-review', [
            'activeMenu' => 'baseline-review',
            'breadcrumb' => 'Peninjauan & Persetujuan Baseline',
            'breadcrumbSeparator' => '>',
            'breadcrumbActiveStyle' => 'soft',
            'state' => $state,
            'planningReferences' => $this->data->planningReferences($projectId),
            'executionReadiness' => $this->data->executionReadiness($projectId),
        ]);
    }

    public function showOverview(): View
    {
        return view('projects.overview', [
            'activeMenu' => 'overview',
            'breadcrumb' => 'Ringkasan Data',
            'breadcrumbSeparator' => '/',
            'breadcrumbActiveStyle' => 'solid',
            'state' => $this->workflow->getState(),
        ]);
    }

    // -------------------------------------------------------------------------
    // REST API Actions (/api/v1/projects/{projectId}/...)
    // -------------------------------------------------------------------------

    public function overview(string $projectId): JsonResponse
    {
        if ($error = $this->guard($projectId)) {
            return $error;
        }

        return response()->json([
            'state' => $this->workflow->getState(),
            'planningReferences' => $this->data->planningReferences($projectId),
            'executionReadiness' => $this->data->executionReadiness($projectId),
        ]);
    }

    public function storeInitialAnalysis(Request $request, string $projectId): JsonResponse
    {
        if ($error = $this->guard($projectId)) {
            return $error;
        }

        $need = trim((string) $request->input('projectNeed', ''));
        $condition = trim((string) $request->input('projectCondition', ''));

        $errors = [];
        if ($need === '') {
            $errors['projectNeed'] = 'Kebutuhan awal wajib diisi.';
        }
        if ($condition === '') {
            $errors['projectCondition'] = 'Kondisi awal wajib diisi.';
        }

        if (! empty($errors)) {
            return response()->json([
                'code' => 'VALIDATION_ERROR',
                'message' => 'Isian wajib belum terpenuhi.',
                'errors' => $errors,
            ], 422);
        }

        $analysis = $this->workflow->saveInitialAnalysis($need, $condition);

        return response()->json([
            'message' => 'Analisis awal tersimpan.',
            'initialAnalysis' => $analysis,
        ]);
    }

    public function clearInitialAnalysis(string $projectId): JsonResponse
    {
        if ($error = $this->guard($projectId)) {
            return $error;
        }

        return response()->json([
            'message' => 'Formulir analisis awal dikosongkan.',
            'initialAnalysis' => $this->workflow->clearInitialAnalysis(),
        ]);
    }

    public function storeBaseline(Request $request, string $projectId): JsonResponse
    {
        if ($error = $this->guard($projectId)) {
            return $error;
        }

        $matrices = (array) $request->input('matrices', []);
        $increment = (bool) $request->input('incrementVersion', true);

        $baseline = $this->workflow->saveBaseline($matrices, $increment);

        return response()->json([
            'message' => 'Baseline versi '.$baseline['version'].' tersimpan.',
            'baseline' => $baseline,
        ]);
    }

    public function storePlannedDate(Request $request, string $projectId): JsonResponse
    {
        if ($error = $this->guard($projectId)) {
            return $error;
        }

        $rawDate = (string) $request->input('plannedDate', '');
        $plan = $this->workflow->savePlannedDate($rawDate);

        if (! $plan) {
            return response()->json([
                'code' => 'INVALID_PLANNED_DATE',
                'message' => 'Tanggal rencana tidak valid.',
            ], 422);
        }

        return response()->json([
            'message' => 'Tanggal rencana dan tenggat H-1 berhasil disimpan.',
            'projectPlan' => $plan,
        ]);
    }

    public function approveBaseline(string $projectId): JsonResponse
    {
        if ($error = $this->guard($projectId)) {
            return $error;
        }

        $state = $this->workflow->getState();
        if (! ($state['baseline']['isComplete'] ?? true)) {
            return response()->json([
                'code' => 'BASELINE_INCOMPLETE',
                'message' => 'Baseline belum lengkap: Timeline Matrix belum diisi.',
            ], 422);
        }

        $baseline = $this->workflow->setSimulatorMode(3);

        return response()->json([
            'message' => 'Baseline disetujui oleh '.$baseline['approvedBy'].' pada '.$baseline['approvedAt'].'.',
            'baseline' => $baseline,
            'planningReferences' => $this->data->planningReferences($projectId),
        ]);
    }

    public function updateSimulatorMode(Request $request, string $projectId): JsonResponse
    {
        if ($error = $this->guard($projectId)) {
            return $error;
        }

        $mode = (int) $request->input('mode', 1);
        if (! in_array($mode, [1, 2, 3], true)) {
            $mode = 1;
        }

        $baseline = $this->workflow->setSimulatorMode($mode);

        return response()->json([
            'message' => 'Mode simulator diperbarui ke Mode '.$mode.'.',
            'baseline' => $baseline,
            'planningReferences' => $this->data->planningReferences($projectId),
        ]);
    }
}
