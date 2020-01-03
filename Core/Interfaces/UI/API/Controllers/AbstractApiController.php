<?php
/**
 * Abstract controller for API methods
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Controllers;

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\CommandBus\CommandBusInterface;
use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Interfaces\PaginatorInterface;
use League\Fractal\Manager;
use League\Fractal\Pagination\PagerfantaPaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\Serializer;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;
use Pagerfanta\Adapter\FixedAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AbstractApiController extends AbstractController
{
    /**
     * Command bus
     *
     * @var CommandBusInterface
     */
    protected $commandBus;

    /**
     * Fractal serializer
     *
     * @var SerializerAbstract
     */
    protected $fractalSerializer;

    /**
     * AbstractApiController constructor.
     *
     * @param Serializer          $fractalSerializer Fractal serializer
     * @param CommandBusInterface $commandBus        Command bus
     */
    public function __construct(Serializer $fractalSerializer, CommandBusInterface $commandBus)
    {
        $this->fractalSerializer = $fractalSerializer;
        $this->commandBus        = $commandBus;
    }

    /**
     * Response of creating resource
     *
     * @param null  $data    Data
     * @param int   $status  Status code of response
     * @param array $headers Headers
     * @param array $context Serializer's context
     *
     * @return Response
     */
    public function created($data = null, int $status = 201, array $headers = [], array $context = []) : Response
    {
        return $this->json($data, $status, $headers, $context);
    }

    /**
     * Response without content
     *
     * @param int $status Status code of response
     *
     * @return Response
     */
    public function noContent(int $status = 204) : Response
    {
        return $this->json(null, $status);
    }

    /**
     * Transform data to API resources
     *
     * @param array|PaginatorInterface $data        Data
     * @param TransformerAbstract      $transformer Transformer
     *
     * @return array
     */
    protected function transform($data, TransformerAbstract $transformer) : array
    {
        if ($data instanceof PaginatorInterface) {
            $adapter   = new FixedAdapter($data->getTotal(), $data->getResults());
            $paginator = new Pagerfanta($adapter);
            $paginator->setAllowOutOfRangePages(true);
            $paginator->setMaxPerPage($data->getLimit());
            $paginator->setCurrentPage($data->getCurrentPage());

            $results = $paginator->getCurrentPageResults();

            $paginatorAdapter = new PagerfantaPaginatorAdapter(
                $paginator,
                function (int $page) {
                    $request     = $this->container->get('request_stack')->getCurrentRequest();
                    $router      = $this->container->get('router');
                    $route       = $request->attributes->get('_route');
                    $inputParams = $request->attributes->get('_route_params');
                    $newParams   = array_merge($inputParams, $request->query->all());
                    $newParams['page'] = $page;

                    return $router->generate($route, $newParams, 0);
                }
            );
            $resource         = new Collection($results, $transformer);
            $resource->setPaginator($paginatorAdapter);
        } else if (is_array($data) === true && is_numeric(key($data)) === true) {
            $resource = new Collection($data, $transformer);
        } else {
            $resource = new Item($data, $transformer);
        }

        $fractal = new Manager();
        $fractal->setSerializer($this->fractalSerializer);

        return $fractal->createData($resource)->toArray();
    }

}
