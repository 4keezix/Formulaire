<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class PageLoadTest extends TestCase
{
    public function testPageLoads(): void
    {
        ob_start();
        include __DIR__ . '/../index.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('<title>Maintenance Applicative</title>', $output);
        $this->assertStringContainsString('<form method="post">', $output);
    }
}
