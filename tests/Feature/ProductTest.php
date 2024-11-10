<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testAddProductSuccess()
    {
        $response = $this->post("/api/product", [
            "name" => "testPrduct",
            "code" => "1234224332",
            "price" => "20000",
            "quantity" => "10"
        ], [
            'Authorization' => 'Bearer ' . $this->getToken(),
        ]);

        // $response->assertStatus(200);
        $response->assertJson([
            "status" => "success",
            "data" => [
                "name" => "testPrduct",
                "code" => "1234224332",
                "price" => 220000,
                "quantity" => "10"
            ]
        ]);

        $this->artisan("migrate:fresh --seed");
    }

    public function testAddProductFailed()
    {
        // failed |  required field is empty
        $response = $this->post("/api/product", [
            "name" => "",
            "code" => "",
            "price" => "",
            "quantity" => "10"
        ], [
            'Authorization' => 'Bearer ' . $this->getToken(),
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            "status" => "error",
            "error" => [
                "name" => [
                    "The name field is required."
                ],
                "code" => [
                    "The code field is required."
                ],
                "price" => [
                    "The price field is required."
                ]
            ]

        ]);

        $this->artisan("migrate:fresh --seed");
    }

    public function testHaventApiToken()
    {
        // failed |  required field is empty
        $response = $this->postJson("/api/product", [
            "name" => "testProduct Missing",
            "code" => "304304",
            "price" => 3483439,
            "quantity" => 10
        ]);
        $response->assertStatus(401);
        $response->assertJson([
            "message" => "Unauthenticated.",
            // "status" => "error",
        ]);
    }

    public function testFailedToken()
    {
        // failed |  required field is wrong
        $response = $this->withHeaders([
            "Authorization" => "salah"
        ])->postJson("/api/product", [
            "name" => "testProduct Missing",
            "code" => "304304",
            "price" => 3483439,
            "quantity" => 10
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            "message" => "Unauthenticated.",

        ]);


        $this->artisan("migrate:fresh --seed");
    }
}
