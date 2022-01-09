<?php

declare(strict_types=1);

namespace TutNichts\PhpJsEnum;

use TutNichts\PhpJsEnum\Enum\OutputFormatterEnum;
use function is_null;

final class Enum
{
    /**
     * @param string $sourceClass
     * @param string $name
     * @param string|null $path
     * @param OutputFormatterEnum|null $outputFormatter
     * @param array<string, string|int> $cases
     */
    public function __construct(
        public readonly string $sourceClass,
        public readonly string $name,
        public readonly ?string $path,
        public readonly ?OutputFormatterEnum $outputFormatter,
        public readonly array $cases
    )
    {
    }

    public function exportPath(string $defaultPath, string $defaultOutputExtension): string
    {
        if (is_null($this->path)) {
            return rtrim($defaultPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $this->name . $defaultOutputExtension;
        }

        preg_match('/\.\w{2,3}$/', $this->path, $extensionMatch);

        if (empty($extensionMatch)) {
            $extension = $this->outputFormatter?->implementation()->getFileExtension() ?? $defaultOutputExtension;
            return rtrim($this->path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $this->name . $extension;
        }

        return $this->path;
    }
}