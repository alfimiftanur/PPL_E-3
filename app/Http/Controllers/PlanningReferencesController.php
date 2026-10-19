<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/** API-K-E3-02: ID baseline APPROVED dan ID project plan, dibaca E-5 dan D-3 (usulan). */
class PlanningReferencesController extends ProjectEndpoint
{
    public function __invoke(string $projectId): JsonResponse
    {
        return $this->guard($projectId) ?? response()->json($this->data->planningReferences($projectId));
    }
}
