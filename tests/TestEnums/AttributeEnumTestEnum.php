<?php

declare(strict_types=1);

namespace TutNichts\PhpJsEnum\Tests\TestEnums;

use TutNichts\PhpJsEnum\Provider\Attribute\PhpJsEnumAttribute;
use TutNichts\PhpJsEnum\Provider\Attribute\PhpJsEnumIgnoreAttribute;

#[PhpJsEnumAttribute]
enum AttributeEnumTestEnum: string
{
    case TEST_KEY_1 = 'TEST_VALUE_1';
    #[PhpJsEnumIgnoreAttribute]
    case TEST_KEY_2 = 'TEST_VALUE_2';
}