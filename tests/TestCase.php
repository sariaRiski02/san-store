<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getToken()
    {
        $response = $this->post("/api/login", [
            "email" => "test@example.com",
            "password" => "test123"
        ]);
        return $response["token"];
    }
}
