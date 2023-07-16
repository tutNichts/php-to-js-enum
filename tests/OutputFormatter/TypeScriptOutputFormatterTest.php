<?php

declare(strict_types=1);

namespace TutNichts\PhpJsEnum\Tests\OutputFormatter;

use PHPUnit\Framework\TestCase;
use TutNichts\PhpJsEnum\OutputFormatter\TypeScriptOutputFormatter;

final class TypeScriptOutputFormatterTest extends TestCase
{
    /** @test */
    public function it_can_generate_a_valid_typescript_enum_output(): void
    {
        $formatter = new TypeScriptOutputFormatter();

        $content = $formatter->getOutputContent('TestEnum', [
            'TestCase1' => 'TestCase1Value',
            'TestCase2' => 1
        ]);

        $this->assertEquals(<<<JS
export default enum TestEnum {
	TestCase1 = 'TestCase1Value',
	TestCase2 = 1,
}
JS. PHP_EOL, $content);
    }
}