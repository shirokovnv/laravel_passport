<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\v1\AuthController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessful(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response = $this->actingAs($user)->getJson('api/v1/auth/logout');
        $response->assertStatus(Response::HTTP_OK);
    }
}
