<?php

declare(strict_types=1);

namespace TutNichts\PhpJsEnum;

use ReflectionClass;
use ReflectionEnum;
use SplFileInfo;

final class ReflectionHelper
{
    public static function reflectionObjectByFile(SplFileInfo|string $file): ReflectionClass|ReflectionEnum|null
    {
        if (is_string($file)) {
            $file = new SplFileInfo($file);
        }

        $content = file_get_contents($file->getRealPath() ?: '');
        if ($content === false) {
            return null;
        }

        preg_match('/^namespace\s(.*);\n/m', $content, $namespaceMatch);
        preg_match('/^(?:\w+\s)?(class|enum)\s(\w+)/m', $content, $objectNameMatch);

        if (empty($objectNameMatch)) {
            return null;
        }

        /** @var class-string $objectName */
        $objectName = $namespaceMatch[1] . '\\' . $objectNameMatch[2];

        return match ($objectNameMatch[1]) {
            'class' => new ReflectionClass($objectName),
            'enum' => new ReflectionEnum($objectName),
            default => null
        };
    }
}