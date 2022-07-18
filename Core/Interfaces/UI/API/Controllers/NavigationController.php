<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Controllers;

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Transformers\User\Navigation\NavigationTransformer;
use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Queries\User\Navigation;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class NavigationController extends AbstractApiController
{
    /**
     * Navigation list for authenticated user
     *
     * @OA\Tag(name="User")
     *
     * @OA\Response(
     *     response="200",
     *     description="Navigation list for authenticated user",
     *     @OA\JsonContent(
     *        @OA\Property(
     *          property="data",
     *          type="object",
     *          @OA\AdditionalProperties(
     *              type="object",
     *              required={"title"},
     *              @OA\Property(
     *                  property="icon",
     *                  type="string",
     *                  example="icon_name"
     *              ),
     *              @OA\Property(
     *                  property="title",
     *                  type="string",
     *                  example="Title"
     *              ),
     *              @OA\Property(
     *                  property="link",
     *                  type="string",
     *                  example="link"
     *              ),
     *              @OA\Property(
     *                  property="children",
     *                  type="object",
     *                  required={"title"},
     *                  @OA\Property(
     *                      property="icon",
     *                      type="string",
     *                      example="icon_name"
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      example="Title"
     *                  ),
     *                  @OA\Property(
     *                      property="link",
     *                      type="string",
     *                      example="link"
     *                  )
     *              )
     *          )
     *        )
     *     )
     * )
     */
    public function userNavigation(): Response
    {
        $command     = new Navigation\FindAll\Command();
        $navigations = $this->queryBus->query($command);

        return $this->json($this->transform($navigations, new NavigationTransformer()));
    }
}
