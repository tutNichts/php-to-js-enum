<?php

declare(strict_types=1);

namespace TutNichts\PhpJsEnum;

use TutNichts\PhpJsEnum\OutputFormatter\IOutputFormatter;
use TutNichts\PhpJsEnum\Provider\IProvider;

class Exporter
{
    public function __construct(
        private IProvider        $provider,
        private IOutputFormatter $defaultOutputFormatter,
        private string           $defaultExportPath
    )
    {
    }

    /**
     * @return array<string>
     *
     * @description Returns a list of paths of the exported enums
     */
    public function export(): array
    {
        $enums = $this->provider->findEnums();

        return collect($enums)
            ->each(fn(Enum $enum) => $this->exportEnum($enum))
            ->map(fn(Enum $enum): string => $enum->exportPath($this->defaultExportPath, $this->defaultOutputFormatter->getFileExtension()))
            ->toArray();
    }

    private function exportEnum(Enum $enum): void
    {
        $outputFormatter = $enum->outputFormatter?->implementation() ?? $this->defaultOutputFormatter;
        $exportFilePath = $enum->exportPath($this->defaultExportPath, $outputFormatter->getFileExtension());

        preg_match('/^(.*)\/\S+\.\w{2,3}$/', $exportFilePath, $patchMatches);

        if (file_exists($exportFilePath)) {
            unlink($exportFilePath);
        }

        if (!is_dir($patchMatches[1])) {
            mkdir($patchMatches[1], 0777, true);
        }

        file_put_contents($exportFilePath, $outputFormatter->getOutputContent($enum->name, $enum->cases));
    }
}