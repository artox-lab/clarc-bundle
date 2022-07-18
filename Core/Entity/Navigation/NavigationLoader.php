<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Navigation;

use Doctrine\Common\Collections\Collection;

interface NavigationLoader
{
    public function load(): Collection;
}
