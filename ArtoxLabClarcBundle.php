<?php
/**
 * Symfony bundle within Clean Architecture
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle;

use ArtoxLab\Bundle\ClarcBundle\DependencyInjection\IgnoreDoctrineAnnotationReaderPass;
use ArtoxLab\Bundle\ClarcBundle\DependencyInjection\MessengerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ArtoxLabClarcBundle extends Bundle
{
    const CONFIG_BUNDLE_NAMESPACE = 'artox_lab_clarc';

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new IgnoreDoctrineAnnotationReaderPass());
        $container->addCompilerPass(new MessengerPass());
    }
}
