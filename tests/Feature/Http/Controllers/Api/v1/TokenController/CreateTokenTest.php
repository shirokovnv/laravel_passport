<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\v1\TokenController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Client;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessful(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Client::factory()->asPersonalAccessTokenClient()->create();

        $response = $this->postJson(
            'api/v1/tokens/create',
            [
                'email' => 'test@example.com',
                'password' => 'password'
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'token'
        ]);

        // Check master password
        config(['auth.passwords.master_password_hash' => '$2y$04$wWOe8VigV55/cT.M4N6mwOrBbv4tLheJdQiMaID/vsBMw2bjtHnQO']);

        $response = $this->postJson(
            'api/v1/tokens/create',
            [
                'email' => 'test@example.com',
                'password' => 'master'
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testValidationErrors(): void
    {
        $response = $this->postJson(
            'api/v1/tokens/create',
            [
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testAuthenticationError(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Client::factory()->asPersonalAccessTokenClient()->create();

        $response = $this->postJson(
            'api/v1/tokens/create',
            [
                'email' => 'test@example.com',
                'password' => 'wrong password'
            ]
        );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
