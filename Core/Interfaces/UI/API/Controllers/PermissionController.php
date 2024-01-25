<?php
/**
 * Get all users permissions
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Controllers;

use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Queries\User\FindAllPermissions;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PermissionController extends AbstractApiController
{
    /**
     * Get all permissions for current user
     */
    #[OA\Tag(name: 'User')]
    #[OA\Response(
        response: '200',
        description: 'Permissions list',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'data',
                    type: 'array',
                    items: new OA\Items(type: 'string', example: 'role.permission')
                )
            ]
        )
    )]
    #[Route('/user/permissions', name: 'artox_lab_user_permissions', methods: ['GET'])]
    public function permissions(): Response
    {
        $command     = new FindAllPermissions\Command();
        $permissions = $this->queryBus->query($command);

        return $this->json(['data' => $permissions]);
    }
}
