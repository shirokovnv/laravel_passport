<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\v1\TokenController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Laravel\Passport\Client;
use Laravel\Passport\Token;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RevokeAllTokensTest extends TestCase
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

        $accessToken1 = $user->createToken('Personal Access Token')->accessToken;
        $accessToken2 = $user->createToken('Personal Access Token')->accessToken;
        $accessToken3 = $user->createToken('Personal Access Token')->accessToken;

        $randomToken = Arr::random([$accessToken1, $accessToken2, $accessToken3]);

        $user->tokens()->each(function(Token $token) {
            $this->assertFalse($token->revoked);
        });

        $response = $this->get('api/v1/tokens/revoke_all', ['Authorization' => 'Bearer ' . $randomToken]);
        $response->assertStatus(Response::HTTP_OK);

        $user->tokens()->each(function(Token $token) {
            $this->assertTrue($token->revoked);
        });
    }

    public function tesUnauthenticated(): void
    {
        /** @var User $user */
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Client::factory()->asPersonalAccessTokenClient()->create();

        $response = $this->get('api/v1/tokens/revoke_all', ['Authorization' => 'Bearer Token']);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
