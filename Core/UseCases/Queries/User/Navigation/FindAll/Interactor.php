<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Queries\User\Navigation\FindAll;

use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Navigation\NavigationStorage;
use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Commands\AbstractInteractor;
use Doctrine\Common\Collections\Collection;

class Interactor extends AbstractInteractor
{
    private NavigationStorage $navigationStorage;

    public function __construct(NavigationStorage $navigationStorage)
    {
        $this->navigationStorage = $navigationStorage;
    }

    public function __invoke(Command $command): Collection
    {
        return $this->navigationStorage->all();
    }
}
