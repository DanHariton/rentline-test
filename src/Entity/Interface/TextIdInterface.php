<?php

declare(strict_types=1);

namespace App\Entity\Interface;

/**
 * All entities that use TIdentifierTextId trait must implement this interface.
 * All textIds should be in enums. Enum for textId must implement TextIdEnumInterface.
 *
 * @see TextIdEnumInterface
 * @see TIdentifierTextId
 */
interface TextIdInterface
{
    public function getTextIdEnumClass(): string;
}
