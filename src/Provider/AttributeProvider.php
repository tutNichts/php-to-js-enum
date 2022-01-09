<?php

declare(strict_types=1);

namespace TutNichts\PhpJsEnum\Provider;

use ReflectionClass;
use ReflectionClassConstant;
use ReflectionEnum;
use ReflectionEnumBackedCase;
use SplFileInfo;
use Symfony\Component\Finder\Finder;
use TutNichts\PhpJsEnum\Enum;
use TutNichts\PhpJsEnum\Provider\Attribute\PhpJsEnumAttribute;
use TutNichts\PhpJsEnum\Provider\Attribute\PhpJsEnumIgnoreAttribute;
use TutNichts\PhpJsEnum\ReflectionHelper;
use function is_null;

class AttributeProvider implements IProvider
{
    /**
     * @param array<string> $directories
     */
    public function __construct(
        private array $directories
    )
    {
    }

    /**
     * @return array<Enum>
     */
    public function findEnums(): array
    {
        return collect($this->findFiles())
            ->map(fn(SplFileInfo $file): null|ReflectionEnum|ReflectionClass => ReflectionHelper::reflectionObjectByFile($file))
            ->filter(fn(null|ReflectionEnum|ReflectionClass $reflectionObject): bool => !is_null($reflectionObject) && !empty($reflectionObject->getAttributes(PhpJsEnumAttribute::class)))
            ->map(fn(ReflectionEnum|ReflectionClass $reflectionObject): Enum => $this->convertReflectionObjectToEnum($reflectionObject))
            ->mapWithKeys(fn(Enum $enum): array => [$enum->sourceClass => $enum])
            ->toArray();
    }

    /**
     * @return array<SplFileInfo>
     */
    private function findFiles(): array
    {
        return iterator_to_array((new Finder())->files()->in($this->directories)->name('*.php')->getIterator(), false);
    }

    private function convertReflectionObjectToEnum(ReflectionClass|ReflectionEnum $reflectionObject): Enum
    {
        [$attribute] = $reflectionObject->getAttributes(PhpJsEnumAttribute::class);

        return new Enum(
            $reflectionObject->getName(),
            $reflectionObject->getShortName(),
            $attribute->getArguments()['path'] ?? null,
            $attribute->getArguments()['outputFormat'] ?? null,
            $reflectionObject instanceof ReflectionEnum
                ? $this->getCasesOfEnum($reflectionObject)
                : $this->getCasesOfClass($reflectionObject)
        );
    }

    /**
     * @param ReflectionEnum $enum
     * @return array<string, string|int>
     */
    private function getCasesOfEnum(ReflectionEnum $enum): array
    {
        return collect($enum->getCases())
            ->filter(fn(ReflectionEnumBackedCase $case): bool => empty($case->getAttributes(PhpJsEnumIgnoreAttribute::class)))
            ->mapWithKeys(fn(ReflectionEnumBackedCase $case): array => [$case->getName() => $case->getBackingValue()])
            ->toArray();
    }

    /**
     * @param ReflectionClass $class
     * @return array<string, string|int>
     */
    private function getCasesOfClass(ReflectionClass $class): array
    {
        return collect(array_keys($class->getConstants()))
            ->map(fn(string $constant): ReflectionClassConstant => new ReflectionClassConstant($class->getName(), $constant))
            ->filter(fn(ReflectionClassConstant $constant): bool => empty($constant->getAttributes(PhpJsEnumIgnoreAttribute::class)))
            ->mapWithKeys(fn(ReflectionClassConstant $constant): array => [$constant->getName() => $constant->getValue()])
            ->toArray();
    }
}