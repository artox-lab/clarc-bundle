<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Transformers\User\Navigation;

use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Navigation\NavigationItem;
use League\Fractal\TransformerAbstract;

class NavigationItemTransformer extends TransformerAbstract
{
    public function transform(NavigationItem $item): array
    {
        return [
            'icon'     => $item->icon(),
            'title'    => $item->title(),
            'link'     => $item->link(),
            'children' => array_map(function (NavigationItem $item) {
                return $this->transform($item);
            }, $item->children()->toArray()),
        ];
    }
}
