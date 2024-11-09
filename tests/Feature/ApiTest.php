<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertSame;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testLoginSuccess(): void
    {
        $response = $this->post("/api/login", [
            "email" => "test@example.com",
            "password" => "test123"
        ]);
        $response->assertStatus(200);
        $this->assertSame($response["status"], "success");
    }

    public function testLoginFailed()
    {

        // test missing password
        $responseMissingPassword = $this->post("/api/login", [
            "email" => "test@example.com",
        ]);
        $this->assertSame($responseMissingPassword["status"], "error");
        // test missing password
        $responseMissingEmail = $this->post("/api/login", [
            "password" => "test123",
        ]);
        $this->assertSame($responseMissingEmail["status"], "error");
    }
}
