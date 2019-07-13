<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testUserCanRegisterWithValidData()
    {
        $response = $this->json('POST', '/api/auth/register', [
            'name' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'SecretPass',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Successful registration'
            ]);
    }

    public function testUserCanLoginWithCorrectCredentials()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('SecretPass')
        ]);

        $response = $this->json('POST', '/api/auth/login', [
            'email' => $user->email,
            'password' => 'SecretPass'
        ]);

        $response->assertStatus(200);
    }

    public function testRefreshUserToken()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('SecretPass')
        ]);

        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/refresh');

        $response->assertStatus(200);
    }

    public function testUserCantLoginWithIncorrectCredentials()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('SecretPass')
        ]);

        $response = $this->json('POST', '/api/auth/login', [
            'email' => $user->email,
            'password' => 'RandomPassword'
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
                'message' => 'Email or password incorrect'
            ]);
    }
}
