<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_coordinator_can_not_authenticate_using_the_default_login_screen(): void
    {
        $coordinator = User::factory()->create([
            'role' => 'coordinator',
            'coordinator_course' => 'Análise e Desenvolvimento de Sistemas (ADS)',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $coordinator->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
    }

    public function test_coordinator_can_authenticate_only_with_the_assigned_course(): void
    {
        $coordinator = User::factory()->create([
            'role' => 'coordinator',
            'coordinator_course' => 'Análise e Desenvolvimento de Sistemas (ADS)',
        ]);

        $invalidResponse = $this->from('/coordinator/login')->post('/coordinator/login', [
            'email' => $coordinator->email,
            'password' => 'password',
            'course' => 'Química',
        ]);

        $this->assertGuest();
        $invalidResponse->assertRedirect('/coordinator/login');
        $invalidResponse->assertSessionHasErrors('course');

        $validResponse = $this->post('/coordinator/login', [
            'email' => $coordinator->email,
            'password' => 'password',
            'course' => 'Análise e Desenvolvimento de Sistemas (ADS)',
        ]);

        $this->assertAuthenticated();
        $this->assertSame('Análise e Desenvolvimento de Sistemas (ADS)', session('coordinator_course'));
        $validResponse->assertRedirect(route('coordinator.calendar.index'));
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
