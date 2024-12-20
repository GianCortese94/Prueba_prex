<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Instalar Passport (solo se necesita una vez)
        $this->artisan('passport:install')
            ->expectsConfirmation('Would you like to run all pending database migrations?', 'yes')
            ->expectsConfirmation('Would you like to create the "personal access" and "password grant" clients?', 'yes');

        // Crear un usuario para autenticación
        $user = User::factory()->create();

        // Autenticar al usuario con Passport
        Passport::actingAs($user, ['*']);
    }
}
