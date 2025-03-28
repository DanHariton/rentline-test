<?php

declare(strict_types=1);

namespace App\Mapper;

/**
 * @template TDto of object
 *
 * @phpstan-template TDto of object
 *
 * @template TEntity of object
 *
 * @phpstan-template TEntity of object
 */
interface MapperInterface
{
    /**
     * @param object<TDto> $dto
     *
     * @phpstan-param TDto $dto
     *
     * @param object<TEntity>|null $entity
     *
     * @phpstan-param TEntity|null $entity
     *
     * @return object<TEntity>
     *
     * @phpstan-return TEntity
     */
    public function mapDtoToEntity(object $dto, ?object $entity = null): object;

    /**
     * @param object<TEntity> $entity
     *
     * @phpstan-param TEntity $entity
     *
     * @return object<TDto>
     *
     * @phpstan-return TDto
     */
    public function mapEntityToDto(object $entity): object;
}
