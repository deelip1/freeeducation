<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

class ArchitectureSmokeTest extends TestCase
{
    public function test_blueprint_contains_expected_directories(): void
    {
        $this->assertDirectoryExists(__DIR__ . '/../../app/Services/Modules');
        $this->assertDirectoryExists(__DIR__ . '/../../database/migrations');
        $this->assertDirectoryExists(__DIR__ . '/../../resources/views');
    }
}
