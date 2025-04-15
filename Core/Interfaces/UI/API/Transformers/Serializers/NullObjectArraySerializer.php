<?php
/**
 * Array Serializer with null value instead empty array in API response for empty objects
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Transformers\Serializers;

use League\Fractal\Serializer\DataArraySerializer;

class NullObjectArraySerializer extends DataArraySerializer
{
    /**
     * {@inheritDoc}
     */
    public function collection(?string $resourceKey, array $data): array
    {
        if ($resourceKey != null) {
            return [$resourceKey => $data];
        }

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function item(?string $resourceKey, array $data): array
    {
        if ($resourceKey != null) {
            return [$resourceKey => $data];
        }

        return $data;
    }

    /**
     * Empty value in response
     *
     * @return null
     */
    public function null(): ?array
    {
        return null;
    }

}
