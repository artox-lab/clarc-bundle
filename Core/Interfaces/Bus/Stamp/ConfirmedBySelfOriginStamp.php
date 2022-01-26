<?php
/**
 * Confirmation that the message was originated by the self origin
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\Stamp;

use Symfony\Component\Messenger\Stamp\NonSendableStampInterface;

class ConfirmedBySelfOriginStamp implements NonSendableStampInterface
{

}
