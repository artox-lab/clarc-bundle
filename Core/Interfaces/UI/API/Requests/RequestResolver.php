<?php
/**
 * Request resolver: mapping incoming request to specified request (DTO)
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Requests;

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Exceptions\RequestValidationFailedException;
use Generator as Generator;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestResolver implements ArgumentValueResolverInterface
{
    /**
     * Validator
     *
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * RequestResolver constructor.
     *
     * @param ValidatorInterface $validator Validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Verify that request implemented from specified interface
     *
     * @param Request          $request  Incoming request
     * @param ArgumentMetadata $argument Meta
     *
     * @return bool
     * @throws ReflectionException
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        $reflection = new ReflectionClass($argument->getType());

        if ($reflection->implementsInterface(RequestInterface::class) === true) {
            return true;
        }

        return false;
    }

    /**
     * Resolving basic request to specified request (DTO)
     *
     * @param Request          $request  Incoming request
     * @param ArgumentMetadata $argument Meta
     *
     * @return Generator
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        // Creating new instance of custom request DTO.
        $class = $argument->getType();
        $dto   = new $class($request);

        // Throw bad request exception in case of invalid request data.
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new RequestValidationFailedException($errors);
        }

        yield $dto;
    }

}
