<?php

declare(strict_types=1);

namespace App\Entity\Interface;

use App\Entity\Trait\TIdentifierTextId;

/**
 * All entities that use TIdentifierTextId trait must implement TextIdInterface.
 * All textIds should be in enums. Enum for textId must implement TextIdEnumInterface.
 *
 * @see TextIdInterface
 * @see TIdentifierTextId
 */
interface TextIdEnumInterface extends \UnitEnum
{
    public function value(): string;
}
