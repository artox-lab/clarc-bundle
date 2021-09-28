<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Gateways;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Doctrine\ORM\Mapping\MappingException;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class DoctrineUuidGenerator extends AbstractIdGenerator
{
    /**
     * @throws MappingException
     */
    public function generate(EntityManager $em, $entity): UuidInterface
    {
        if ($entity === null) {
            throw new InvalidArgumentException(sprintf('Empty entity for %s', self::class));
        }

        $class   = $em->getClassMetadata($entity::class);
        $idNames = $class->getIdentifier();

        if (count($idNames) === 0) {
            throw MappingException::noIdDefined($entity::class);
        }

        if (count($idNames) > 1) {
            throw MappingException::generatorNotAllowedWithCompositeId();
        }

        $idName  = array_shift($idNames);
        $idField = $class->reflFields[$idName] ?? null;

        if ($idField === null) {
            throw MappingException::invalidMapping($idName);
        }

        $idValue = $idField->getValue($entity);

        return $idValue ?? Uuid::uuid4();
    }
}
