<?php
/**
 * Abstract request
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Requests;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractRequest implements RequestInterface
{
    /**
     * Request params
     *
     * @var array
     */
    protected $params = [];

    /**
     * AbstractRequest constructor.
     *
     * @param Request $request Incoming request
     */
    public function __construct(Request $request)
    {
        $attrs = array_keys($this->getRules());

        foreach ($attrs as $attr) {
            $this->params[$attr] = $request->get($attr, null);
        }
    }

    /**
     * Request's validation rules, where:
     * keys - names of request parameters
     * values - array of constraints
     *
     * @return array
     */
    abstract public function getRules() : array;

    /**
     * Request's params
     *
     * @return array
     */
    public function getRequestParams() : array
    {
        return $this->params;
    }

    /**
     * Groups
     *
     * @return array
     */
    public function getGroups() : array
    {
        return [];
    }

}
