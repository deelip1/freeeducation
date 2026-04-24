<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

class ArchitectureSmokeTest extends TestCase
{
    public function test_blueprint_contains_expected_directories(): void
    {
        $this->assertDirectoryExists(__DIR__ . '/../../app/Services/Modules');
        $this->assertDirectoryExists(__DIR__ . '/../../app/Services/AI');
        $this->assertDirectoryExists(__DIR__ . '/../../app/Services/Tax');
        $this->assertDirectoryExists(__DIR__ . '/../../app/Http/Controllers/Api/Tools');
        $this->assertDirectoryExists(__DIR__ . '/../../app/Models/Tools');
        $this->assertDirectoryExists(__DIR__ . '/../../resources/views/blog');
    }

    public function test_bootstrap_layout_uses_responsive_table_wrapper_pattern(): void
    {
        $view = file_get_contents(__DIR__ . '/../../resources/views/admin/users/index.blade.php');

        $this->assertStringContainsString('table-responsive', (string) $view);
    }
}
