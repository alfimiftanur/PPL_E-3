<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/** API-K-E3-01: kesiapan eksekusi proyek, dibaca E-4. */
class ExecutionReadinessController extends ProjectEndpoint
{
    public function __invoke(string $projectId): JsonResponse
    {
        return $this->guard($projectId) ?? response()->json($this->data->executionReadiness($projectId));
    }
}
