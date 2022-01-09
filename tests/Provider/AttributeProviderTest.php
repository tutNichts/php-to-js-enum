<?php
declare(strict_types=1);

namespace TutNichts\PhpJsEnum\Tests\Provider;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionEnum;
use TutNichts\PhpJsEnum\Provider\AttributeProvider;
use TutNichts\PhpJsEnum\Tests\TestEnums\AttributeClassSecondTestEnum;
use TutNichts\PhpJsEnum\Tests\TestEnums\AttributeClassTestEnum;
use TutNichts\PhpJsEnum\Tests\TestEnums\AttributeEnumTestEnum;

class AttributeProviderTest extends TestCase
{
    /** @test */
    public function it_can_find_classes_and_enums_with_export_attribute(): void
    {
        $provider = new AttributeProvider([
            __DIR__ . '/../TestEnums'
        ]);

        $findings = $provider->findEnums();

        $this->assertSame((new ReflectionEnum(AttributeEnumTestEnum::class))->getShortName(), $findings[AttributeEnumTestEnum::class]->name);
        $this->assertSame((new ReflectionClass(AttributeClassTestEnum::class))->getShortName(), $findings[AttributeClassTestEnum::class]->name);
    }

    /** @test */
    public function it_ignores_cases_marked_as_ignorables(): void
    {
        $provider = new AttributeProvider([
            __DIR__ . '/../TestEnums'
        ]);

        $findings = $provider->findEnums();

        $this->assertArrayHasKey('TEST_KEY_1', $findings[AttributeClassTestEnum::class]->cases);
        $this->assertArrayNotHasKey('TEST_KEY_2', $findings[AttributeClassTestEnum::class]->cases);

        $this->assertArrayNotHasKey('TEST_KEY_1', $findings[AttributeClassSecondTestEnum::class]->cases);
        $this->assertArrayHasKey('TEST_KEY_2', $findings[AttributeClassSecondTestEnum::class]->cases);

        $this->assertArrayHasKey('TEST_KEY_1', $findings[AttributeEnumTestEnum::class]->cases);
        $this->assertArrayNotHasKey('TEST_KEY_2', $findings[AttributeEnumTestEnum::class]->cases);
    }
}
