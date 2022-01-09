<?php

declare(strict_types=1);

namespace TutNichts\PhpJsEnum\Tests\TestEnums;

use TutNichts\PhpJsEnum\Enum\OutputFormatterEnum;
use TutNichts\PhpJsEnum\Provider\Attribute\PhpJsEnumAttribute;
use TutNichts\PhpJsEnum\Provider\Attribute\PhpJsEnumIgnoreAttribute;

#[PhpJsEnumAttribute(path: __DIR__ . '/../ExportTestOutput', outputFormat: OutputFormatterEnum::JsObject)]
final class AttributeClassSecondTestEnum
{
    #[PhpJsEnumIgnoreAttribute]
    public const TEST_KEY_1 = 'TEST_VALUE_1';
    public const TEST_KEY_2 = 'TEST_VALUE_2';
}