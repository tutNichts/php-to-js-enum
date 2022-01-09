<?php

declare(strict_types=1);

namespace TutNichts\PhpJsEnum\Provider\Attribute;

use Attribute;
use TutNichts\PhpJsEnum\Enum\OutputFormatterEnum;

#[Attribute(Attribute::TARGET_CLASS)]
class PhpJsEnumAttribute
{
    public function __construct(
        public readonly ?string $path = null,
        public readonly ?OutputFormatterEnum $outputFormat = null
    )
    {
    }
}