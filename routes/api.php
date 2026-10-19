<?php

use App\Http\Controllers\PlanningReferencesController;
use App\Http\Controllers\ExecutionReadinessController;
use Illuminate\Support\Facades\Route;

// Laravel menambahkan awalan /api, sehingga path akhir: /api/v1/projects/{projectId}/...
Route::prefix('v1/projects/{projectId}')->middleware('mock.token')->group(function () {
    Route::get('execution-readiness', ExecutionReadinessController::class);   // API-K-E3-01
    Route::get('planning-references', PlanningReferencesController::class);   // API-K-E3-02
});
