<?php
/**
 * Command validation middleware
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Messenger\Middleware;

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Exceptions\CommandValidationFailedException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ValidationStamp;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationMiddleware implements MiddlewareInterface
{
    /**
     * Validator
     *
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * ValidationMiddleware constructor.
     *
     * @param ValidatorInterface $validator Validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle
     *
     * @param Envelope       $envelope Envelope
     * @param StackInterface $stack    Stack
     *
     * @return Envelope
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();
        $groups  = null;

        if ($validationStamp = ($envelope->last(ValidationStamp::class) === true)) {
            $groups = $validationStamp->getGroups();
        }

        $violations = $this->validator->validate($message, null, $groups);

        if (count($violations) > 0) {
            throw new CommandValidationFailedException($violations);
        }

        return $stack->next()->handle($envelope, $stack);
    }

}
