<?php

namespace Tests\Feature;

// ★ これを追加
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    // ★ これを追加
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // '/' を '/tasks' に変更
        $response = $this->get('/tasks');

        $response->assertStatus(200);
    }
}