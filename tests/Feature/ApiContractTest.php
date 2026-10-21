<?php

namespace Tests\Feature;

use Tests\TestCase;

/** Verifies that API responses strictly match the JSON files in examples/ (referenced by openapi.yaml). */
class ApiContractTest extends TestCase
{
    private const READY = '01924b1e-7f32-7a81-9b12-45e8a1234567';
    private const NO_KICKOFF = '01924b1e-7f32-7a81-9b12-45e8a1234568';
    private const UNKNOWN = '01924b1e-7f32-7a81-9b12-45e8a9999999';

    private function example(string $file): array
    {
        return json_decode(file_get_contents(base_path("examples/$file")), true, 512, JSON_THROW_ON_ERROR);
    }

    private function api(string $id, string $path, bool $auth = true)
    {
        $headers = $auth ? ['Authorization' => 'Bearer mock-token'] : [];

        return $this->getJson("/api/v1/projects/$id/$path", $headers);
    }

    public function test_api01_200_ready(): void
    {
        $this->api(self::READY, 'execution-readiness')->assertOk()->assertExactJson($this->example('success.json'));
    }

    public function test_api01_200_without_kickoff_and_mom(): void
    {
        $this->api(self::NO_KICKOFF, 'execution-readiness')->assertOk()->assertExactJson($this->example('success-no-mom.json'));
    }

    public function test_api01_404_not_found(): void
    {
        $this->api(self::UNKNOWN, 'execution-readiness')->assertNotFound()->assertExactJson($this->example('error.json'));
    }

    public function test_api01_400_invalid_uuid_v7(): void
    {
        $this->api('INVALID-UUID', 'execution-readiness')->assertStatus(400)
            ->assertJsonPath('code', 'INVALID_PROJECT_ID_FORMAT')
            ->assertJsonStructure(['code', 'message', 'details']);
    }

    public function test_api01_401_missing_token(): void
    {
        $this->api(self::READY, 'execution-readiness', false)->assertUnauthorized()->assertJsonPath('code', 'UNAUTHENTICATED');
    }

    public function test_api02_200_complete(): void
    {
        $this->api(self::READY, 'planning-references')->assertOk()->assertExactJson($this->example('planning-references.json'));
    }

    public function test_api02_200_empty_when_baseline_is_draft(): void
    {
        $this->api(self::NO_KICKOFF, 'planning-references')->assertOk()->assertExactJson($this->example('planning-references-empty.json'));
    }

    public function test_api02_404_not_found(): void
    {
        $this->api(self::UNKNOWN, 'planning-references')->assertNotFound()->assertExactJson($this->example('error.json'));
    }

    public function test_api02_400_invalid_uuid_v7(): void
    {
        $this->api('INVALID-UUID', 'planning-references')->assertStatus(400)->assertJsonPath('code', 'INVALID_PROJECT_ID_FORMAT');
    }

    public function test_api02_401_missing_token(): void
    {
        $this->api(self::READY, 'planning-references', false)->assertUnauthorized();
    }
}
