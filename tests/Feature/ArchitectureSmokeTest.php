<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

class ArchitectureSmokeTest extends TestCase
{
    public function test_blueprint_contains_engine_directories(): void
    {
        $this->assertDirectoryExists(__DIR__ . '/../../app/Modules/CMS/Services');
        $this->assertDirectoryExists(__DIR__ . '/../../app/Modules/Tools/Services');
        $this->assertDirectoryExists(__DIR__ . '/../../app/Modules/AI/Services');
        $this->assertDirectoryExists(__DIR__ . '/../../app/Modules/ITR/Services');
        $this->assertDirectoryExists(__DIR__ . '/../../app/Modules/Users/Services');
        $this->assertDirectoryExists(__DIR__ . '/../../app/Modules/Admin/Services');
    }

    public function test_blog_url_structure_exists_in_routes(): void
    {
        $routes = file_get_contents(__DIR__ . '/../../routes/web.php');
        $this->assertStringContainsString('/blog/{category}/{slug}', (string) $routes);
    }
}
