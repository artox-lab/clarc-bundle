<?php
/**
 * Interface of incoming requests
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Requests;

use Symfony\Component\HttpFoundation\Request;

interface RequestInterface
{

    /**
     * RequestDTOInterface constructor.
     *
     * @param Request $request Incoming request
     */
    public function __construct(Request $request);

}
