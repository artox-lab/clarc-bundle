<?php
/**
 * Add to ignored extra names/namespaces for doctrine/annotation
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\DependencyInjection;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class IgnoreDoctrineAnnotationReaderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container) {
        if (!class_exists(AnnotationReader::class)) {
            return;
        }

        // Protobuf protoc compiler generates message classes with black listed @type annotation
        // @see https://github.com/doctrine/annotations/issues/435
        AnnotationReader::addGlobalIgnoredName('type');
    }
}
