<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Transformers\User\Navigation;

use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Navigation\Navigation;
use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Navigation\NavigationItem;
use Doctrine\Common\Collections\Collection;
use League\Fractal\TransformerAbstract;

class NavigationTransformer extends TransformerAbstract
{
    public function transform(Collection $collection): array
    {
        $result = [];

        /** @var Navigation $navigation */
        foreach ($collection as $navigation) {
            $navigationName = $navigation->name();

            $result[$navigationName] = array_map(function (NavigationItem $item) use ($navigation) {
                $items = (new NavigationItemTransformer())->transform($item);

                if (!$navigation->isShowOrphanedRoot() && count($items['children']) === 0) {
                    return [];
                }

                return $items;
            }, $navigation->items()->toArray());

            $result[$navigationName] = array_filter($result[$navigationName]);
        }

        return array_filter($result);
    }
}
