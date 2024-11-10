<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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

    public function testLoginMissing()
    {

        // test missing password
        $responseMissingPassword = $this->post("/api/login", [
            "email" => "test@example.com",
        ]);
        $responseMissingPassword->assertStatus(422);
        $responseMissingPassword->assertJson([
            "status" => "error",
            "error" => [
                "password" => ["The password field is required."]
            ]
        ]);
        // test missing password
        $responseMissingEmail = $this->post("/api/login", [
            "password" => "test123",
        ]);
        $responseMissingEmail->assertStatus(422);
        $responseMissingEmail->assertJson([
            "status" => "error",
            "error" => [
                "email" => ["The email field is required."]
            ]
        ]);

        $responseMissingAll = $this->post("api/login");
        $responseMissingAll->assertStatus(422);
        $responseMissingAll->assertJson([
            "status" => "error",
            "error" => [
                "email" => ["The email field is required."],
                "password" => ["The password field is required."]
            ]

        ]);
    }


    public function testLoginFailed()
    {
        // when email wrong
        $wrongEmail = $this->post("/api/login", [
            "email" => "wrong@example.com",
            "password" => "test123",
        ]);

        $wrongEmail->assertStatus(401);
        $wrongEmail->assertJson([
            "status" => "error",
            "error" => "Unauthorized"
        ]);

        // when wrong password
        $wrongPassword = $this->post("/api/login", [
            "email" => "test@example.com",
            "password" => "wrong",
        ]);
        $wrongPassword->assertStatus(401);
        $wrongPassword->assertJson([
            "status" => "error",
            "error" => "Unauthorized"
        ]);

        // when wrong both
        $wrongBoth = $this->post("/api/login", [
            "email" => "wrong@wrong.com",
            "password" => "wrong123",
        ]);

        $wrongBoth->assertStatus(401);
        $wrongBoth->assertJson([
            "status" => "error",
            "error" => "Unauthorized"
        ]);
    }
}
