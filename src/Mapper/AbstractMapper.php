<?php

declare(strict_types=1);

namespace App\Mapper;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @template TDto of object
 *
 * @phpstan-template TDto of object
 *
 * @template TEntity of object
 *
 * @phpstan-template TEntity of object
 *
 * @implements MapperInterface<TDto, TEntity>
 *
 * @phpstan-implements MapperInterface<TDto, TEntity>
 */
abstract class AbstractMapper implements MapperInterface
{
    #[Required]
    public ValidatorInterface $validator;

    #[Required]
    public TranslatorInterface $translator;

    #[Required]
    public EntityManagerInterface $em;

    /**
     * @throws ValidationFailedException
     */
    public function validate(mixed $value): void
    {
        $violations = $this->validator->validate($value);

        if (count($violations) > 0) {
            throw new ValidationFailedException($value, $violations);
        }
    }

    /**
     * @throws ValidationFailedException
     */
    protected function throwNotNullException(string $fieldName): never
    {
        throw new ValidationFailedException($this, new ConstraintViolationList([new ConstraintViolation("$fieldName should not be null.", null, [], $this, $fieldName, null)]));
    }

    protected function ensureType(?object $object, string $expectedType): void
    {
        if ($object !== null && ! $object instanceof $expectedType) {
            throw new \InvalidArgumentException("Expected instance of $expectedType");
        }
    }
}
