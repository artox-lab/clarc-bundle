<?php
/**
 * Abstract controller for API methods
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Controllers;

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Transformers\Serializers\NullObjectArraySerializer;
use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Interfaces\PaginatorInterface;
use League\Fractal\Manager;
use League\Fractal\Pagination\PagerfantaPaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Pagerfanta\Adapter\FixedAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractApiController extends AbstractController
{

    /**
     * Transform data to API resources
     *
     * @param array|PaginatorInterface $data        Data
     * @param TransformerAbstract     $transformer Transformer
     *
     * @return array
     */
    protected function transform($data, TransformerAbstract $transformer) : array
    {
        if ($data instanceof PaginatorInterface) {
            $adapter   = new FixedAdapter($data->total(), $data->items());
            $paginator = new Pagerfanta($adapter);
            $paginator->setMaxPerPage($data->limit());
            $paginator->setCurrentPage($data->currentPage());

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
        } elseif (is_array($data) === true && is_numeric(key($data)) === true) {
            $resource = new Collection($data, $transformer);
        } else {
            $resource = new Item($data, $transformer);
        }

        $fractal = new Manager();
        $fractal->setSerializer($this->getParameter('artox_lab_clarc.api.serializer'));

        return $fractal->createData($resource)->toArray();
    }

}
