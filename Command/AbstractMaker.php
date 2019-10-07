<?php
/**
 * Abstract maker
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Command;

use Symfony\Bundle\MakerBundle\Maker\AbstractMaker as AbstractSymfonyMaker;

abstract class AbstractMaker extends AbstractSymfonyMaker
{

    /**
     * Resolving path of template
     *
     * @param string $path Template relative path
     *
     * @return string
     */
    protected function resolveTemplate(string $path) : string
    {
        return __DIR__ . '/../Resources/skeleton/' . $path;
    }

}
