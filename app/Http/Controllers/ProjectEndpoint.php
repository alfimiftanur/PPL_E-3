<?php

namespace App\Http\Controllers;

use App\Services\ProjectData;
use Illuminate\Http\JsonResponse;

/** Pemeriksaan bersama kedua endpoint: format projectId (400) lalu keberadaan proyek (404). */
abstract class ProjectEndpoint extends Controller
{
    public function __construct(protected ProjectData $data)
    {
    }

    protected function guard(string $projectId): ?JsonResponse
    {
        if (! ProjectData::isValidId($projectId)) {
            return response()->json([
                'code' => 'INVALID_PROJECT_ID_FORMAT',
                'message' => 'Format projectId tidak valid.',
                'details' => ['projectId harus berformat UUID v7'],
            ], 400);
        }

        if (! $this->data->exists($projectId)) {
            return response()->json([
                'code' => 'PROJECT_NOT_FOUND',
                'message' => 'Proyek tidak ditemukan.',
            ], 404);
        }

        return null;
    }
}
