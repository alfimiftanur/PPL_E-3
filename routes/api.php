<?php

use App\Http\Controllers\ExecutionReadinessController;
use App\Http\Controllers\PlanningReferencesController;
use App\Http\Controllers\ProjectWorkflowController;
use Illuminate\Support\Facades\Route;

// Laravel prefixes API routes with /api, resulting in: /api/v1/projects/{projectId}/...
Route::prefix('v1/projects/{projectId}')->middleware('mock.token')->group(function () {
    // Cross-service contract endpoints (openapi.yaml)
    Route::get('execution-readiness', ExecutionReadinessController::class);
    Route::get('planning-references', PlanningReferencesController::class);

    // Module workflow endpoints (used by the web interface)
    Route::get('overview', [ProjectWorkflowController::class, 'overview']);
    Route::post('initial-analysis', [ProjectWorkflowController::class, 'storeInitialAnalysis']);
    Route::delete('initial-analysis', [ProjectWorkflowController::class, 'clearInitialAnalysis']);
    Route::post('baselines', [ProjectWorkflowController::class, 'storeBaseline']);
    Route::post('baselines/approve', [ProjectWorkflowController::class, 'approveBaseline']);
    Route::post('baselines/simulator-mode', [ProjectWorkflowController::class, 'updateSimulatorMode']);
    Route::post('planned-date', [ProjectWorkflowController::class, 'storePlannedDate']);
});
