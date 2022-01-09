<?php
declare(strict_types=1);

namespace TutNichts\PhpJsEnum\OutputFormatter;

interface IOutputFormatter
{
    /**
     * @param string $name
     * @param array<string, string|int> $enums
     * @return string
     */
    public function getOutputContent(string $name, array $enums): string;

    public function getFileExtension(): string;
}