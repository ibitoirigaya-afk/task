<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        // 修正：ルートパスへのGETリクエストが200を返すか
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}