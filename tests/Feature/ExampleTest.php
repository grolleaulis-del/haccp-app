<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Un test basique pour vérifier l'application.
     */
    public function test_basic_example(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
