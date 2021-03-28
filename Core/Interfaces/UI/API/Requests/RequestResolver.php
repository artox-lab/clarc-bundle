<?php
/**
 * Request resolver: mapping incoming request to specified request (DTO)
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Requests;

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Exceptions\RequestValidationFailedException;
use Generator;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
        if (is_null($argument->getType()) === true) {
            return false;
        }

        if (class_exists($argument->getType()) === false) {
            return false;
        }

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
     * @return Generator<AbstractRequest|mixed>
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        // Creating new instance of custom request DTO.
        $class = $argument->getType();
        $dto   = new $class($request);

        if ($dto instanceof AbstractRequest) {
            $errors = $this->validator->validate(
                $dto->getRequestParams(),
                new Assert\Collection($dto->getRules()),
                new Assert\GroupSequence($dto->getGroups())
            );
        } else {
            $errors = $this->validator->validate($dto);
        }

        // Throw bad request exception in case of invalid request data.
        if (count($errors) > 0) {
            throw new RequestValidationFailedException($errors);
        }

        yield $dto;
    }

}
