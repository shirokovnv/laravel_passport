<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\v1\TokenController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Client;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RevokeTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessful(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Client::factory()->asPersonalAccessTokenClient()->create();

        $token = $user->createToken('Personal Access Token');

        $this->assertFalse($token->getToken()->revoked);

        $response = $this->get('api/v1/tokens/revoke', ['Authorization' => 'Bearer ' . $token->accessToken]);
        $response->assertStatus(Response::HTTP_OK);

        $token->getToken()->refresh();
        $this->assertTrue($token->getToken()->revoked);
    }

    public function tesUnauthenticated(): void
    {
        /** @var User $user */
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Client::factory()->asPersonalAccessTokenClient()->create();

        $response = $this->get('api/v1/tokens/revoke', ['Authorization' => 'Bearer Token']);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
