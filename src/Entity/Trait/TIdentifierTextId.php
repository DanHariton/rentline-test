<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use App\Entity\Interface\TextIdEnumInterface;
use App\Entity\Interface\TextIdInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * All entities that use TIdentifierTextId trait must implement TextIdInterface.
 * All textIds should be in enums. Enum for textId must implement TextIdEnumInterface.
 *
 * @see TextIdInterface
 * @see TextIdEnumInterface
 */
trait TIdentifierTextId
{
    #[ORM\Column(unique: true, nullable: false)]
    #[Assert\NotBlank]
    private string $textId = '';

    public function getTextId(): TextIdEnumInterface
    {
        $enumClass = $this->getTextIdEnumClass();
        if (! method_exists($enumClass, 'cases')) {
            throw new \LogicException("Method 'cases' does not exist in class {$enumClass}");
        }

        foreach ($enumClass::cases() as $case) {
            if ($case->value() === $this->textId) {
                return $case;
            }
        }

        throw new \UnexpectedValueException("TextId '{$this->textId}' not in enum {$enumClass}");
    }

    public function setTextId(TextIdEnumInterface $textId): static
    {
        $this->textId = $textId->value();

        return $this;
    }
}
