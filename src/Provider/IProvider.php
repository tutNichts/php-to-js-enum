<?php

declare(strict_types=1);

namespace TutNichts\PhpJsEnum\Provider;

use TutNichts\PhpJsEnum\Enum;

interface IProvider
{
    /**
     * @return array<Enum>
     */
    public function findEnums(): array;
}