<?php

declare(strict_types=1);

namespace TutNichts\PhpJsEnum\OutputFormatter;

class TypeScriptOutputFormatter implements IOutputFormatter
{
    /**
     * @param string $name
     * @param array<string, string|int> $enums
     * @return string
     */
    public function getOutputContent(string $name, array $enums): string
    {
        $enumOutput = join(
            PHP_EOL . "\t",
            array_reduce(
                array_keys($enums),
                fn(array $carry, string $key): array => [...$carry, "{$key} = " . (is_string($enums[$key]) ? "'{$enums[$key]}'" : $enums[$key]) . ','],
                []
            )
        );

        return <<<JS
export enum $name {
	$enumOutput
}
JS. PHP_EOL;
    }

    public function getFileExtension(): string
    {
        return '.ts';
    }
}