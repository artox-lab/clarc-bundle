<?php
/**
 * Abstract interactor
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Commands;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

abstract class AbstractInteractor implements MessageHandlerInterface
{

}
