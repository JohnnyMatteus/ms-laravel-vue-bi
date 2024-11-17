<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Executa as migrações antes de cada teste
        $this->artisan('migrate:fresh', ['--seed' => true]);
    }
}
