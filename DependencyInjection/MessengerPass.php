<?php

namespace ArtoxLab\Bundle\ClarcBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MessengerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition(\ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\EventListener\AddErrorDetailsStampListener::class)) {
            $container->removeDefinition('messenger.failure.add_error_details_stamp_listener');
        }
    }
}
