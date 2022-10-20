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
     * Empty value in response
     *
     * @return null
     */
    public function null(): ?array
    {
        return null;
    }

}
