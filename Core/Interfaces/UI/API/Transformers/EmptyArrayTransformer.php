<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Transformers;

use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\TransformerAbstract;

final class EmptyArrayTransformer extends TransformerAbstract
{

    /**
     * @param array $data
     *
     * @return ResourceAbstract
     */
    public function transform(array $data): ResourceAbstract
    {
        return $this->null();
    }

}
