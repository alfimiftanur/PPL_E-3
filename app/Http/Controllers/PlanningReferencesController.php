<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/** Returns latest approved baseline ID and project plan ID for a project. */
class PlanningReferencesController extends ProjectEndpoint
{
    public function __invoke(string $projectId): JsonResponse
    {
        return $this->guard($projectId) ?? response()->json($this->data->planningReferences($projectId));
    }
}
