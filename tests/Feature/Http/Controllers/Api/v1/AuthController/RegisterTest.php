<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\v1\AuthController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessful(): void
    {
        $response = $this->postJson(
            'api/v1/auth/register',
            [
                'name' => 'John Doe',
                'email' => 'test@example.com',
                'password' => 'password'
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'id', 'name', 'email'
        ]);
    }

    public function testValidationErrors(): void
    {
        $response = $this->postJson(
            'api/v1/auth/register',
            [
                'name' => 'John Doe',
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
