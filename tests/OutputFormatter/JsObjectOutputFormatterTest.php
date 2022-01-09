<?php

declare(strict_types=1);

namespace TutNichts\PhpJsEnum\Tests\OutputFormatter;

use PHPUnit\Framework\TestCase;
use TutNichts\PhpJsEnum\OutputFormatter\JsObjectOutputFormatter;

final class JsObjectOutputFormatterTest extends TestCase
{
    /** @test */
    public function it_can_generate_a_valid_javascript_object_output(): void
    {
        $formatter = new JsObjectOutputFormatter();

        $content = $formatter->getOutputContent('TestEnum', [
            'TestCase1' => 'TestCase1Value',
            'TestCase2' => 1
        ]);

        $this->assertEquals(<<<JS
export const TestEnum = {
	TestCase1: 'TestCase1Value',
	TestCase2: 1,
}
JS. PHP_EOL, $content);
    }
}