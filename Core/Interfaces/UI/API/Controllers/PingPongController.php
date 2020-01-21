<?php
/**
 * Ping pong health check controller
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PingPongController extends AbstractController
{
    /**
     * @SWG\Get(
     *     path="/ping",
     *     summary="Ping reuqest",
     *     tags={"HealtCheck"},
     *     description="Ping-Pong health check GET http route",
     *     operationId="ping",
     *     produces={"text/plain"},
     *     @SWG\Response(
     *         response=200,
     *         description="pong",
     *     )
     * )
     */

    /**
     * Health check ping route
     *
     * @return Response
     */
    public function ping() : Response
    {
        return new Response('pong', 200, ['Content-Type' => 'text/plain']);
    }

}
