<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerificacionEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_can_be_marked_as_verified()
    {
        $user = User::create([
            'name' => 'Maira',
            'last_name' => 'Medina',
            'email' => 'test@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => null,
            'birthdate' => null,
            'tipo_persona_id' => null,
        ]);

        $this->assertFalse($user->hasVerifiedEmail());

        $user->email_verified_at = now();
        $user->save();

        $user->refresh();

        $this->assertTrue($user->hasVerifiedEmail());
    }
}