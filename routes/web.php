<?php

use App\Http\Controllers\ProjectWorkflowController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/projects/initial-analysis');

Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/initial-analysis', [ProjectWorkflowController::class, 'showInitialAnalysis'])->name('initial-analysis');
    Route::get('/baseline-setup', [ProjectWorkflowController::class, 'showBaselineSetup'])->name('baseline-setup');
    Route::get('/planned-date', [ProjectWorkflowController::class, 'showPlannedDate'])->name('planned-date');
    Route::get('/baseline-review', [ProjectWorkflowController::class, 'showBaselineReview'])->name('baseline-review');
    Route::get('/overview', [ProjectWorkflowController::class, 'showOverview'])->name('overview');
});
