<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/** Returns project execution readiness status. */
class ExecutionReadinessController extends ProjectEndpoint
{
    public function __invoke(string $projectId): JsonResponse
    {
        return $this->guard($projectId) ?? response()->json($this->data->executionReadiness($projectId));
    }
}
