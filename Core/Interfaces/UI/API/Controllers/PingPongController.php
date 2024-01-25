<?php
/**
 * Ping pong health check controller
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Controllers;

use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PingPongController extends AbstractController
{
    /**
     * Health check ping route
     */
    #[Route(path: '/ping', name: 'artox_lab_ping', methods: ['GET'])]
    #[OA\Tag(name: 'HealthCheck')]
    #[OA\Response(response: '200', description: 'pong')]
    public function ping() : Response
    {
        return new Response('pong', 200, ['Content-Type' => 'text/plain']);
    }
}
