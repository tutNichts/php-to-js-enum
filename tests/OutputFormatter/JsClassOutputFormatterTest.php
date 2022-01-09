<?php

declare(strict_types=1);

namespace TutNichts\PhpJsEnum\Tests\OutputFormatter;

use PHPUnit\Framework\TestCase;
use TutNichts\PhpJsEnum\OutputFormatter\JsClassOutputFormatter;

final class JsClassOutputFormatterTest extends TestCase
{
    /** @test */
    public function it_can_generate_a_valid_javascript_class_output(): void
    {
        $formatter = new JsClassOutputFormatter();

        $content = $formatter->getOutputContent('TestEnum', [
            'TestCase1' => 'TestCase1Value',
            'TestCase2' => 1
        ]);

        $this->assertEquals(<<<JS
export class TestEnum {
	static TestCase1 = 'TestCase1Value';
	static TestCase2 = 1;
}
JS. PHP_EOL, $content);
    }
}