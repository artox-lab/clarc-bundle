<?php
/**
 * Symfony bundle within Clean Architecture
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ArtoxLabClarcBundle extends Bundle
{
    const CONFIG_BUNDLE_NAMESPACE = 'artox_lab_clarc';
}