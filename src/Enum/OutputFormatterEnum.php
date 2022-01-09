<?php

declare(strict_types=1);

namespace TutNichts\PhpJsEnum\Enum;

use TutNichts\PhpJsEnum\OutputFormatter\IOutputFormatter;
use TutNichts\PhpJsEnum\OutputFormatter\JsClassOutputFormatter;
use TutNichts\PhpJsEnum\OutputFormatter\JsObjectOutputFormatter;
use TutNichts\PhpJsEnum\OutputFormatter\TypeScriptOutputFormatter;

enum OutputFormatterEnum
{
    case JsClass;
    case JsObject;
    case TypeScript;

    public function implementation(): IOutputFormatter
    {
        return match ($this) {
            self::TypeScript => new TypeScriptOutputFormatter(),
            self::JsClass => new JsClassOutputFormatter(),
            self::JsObject => new JsObjectOutputFormatter()
        };
    }
}