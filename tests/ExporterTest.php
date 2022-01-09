<?php
declare(strict_types=1);

namespace TutNichts\PhpJsEnum\Tests;

use PHPUnit\Framework\TestCase;
use TutNichts\PhpJsEnum\Exporter;
use TutNichts\PhpJsEnum\OutputFormatter\TypeScriptOutputFormatter;
use TutNichts\PhpJsEnum\Provider\AttributeProvider;

class ExporterTest extends TestCase
{
    /** @test */
    public function it_can_export_files(): void
    {
        $exporter = new Exporter(
            new AttributeProvider([__DIR__ . '/TestEnums']),
            new TypeScriptOutputFormatter(),
            __DIR__ . '/ExportTestOutput'
        );

        $this->assertCount(3, $exporter->export());
    }
}
