<?php
/**
 * Subscribe on exceptions in API
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\EventListeners;

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Exceptions\ValidationFailedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{

    /**
     * Handle exception in API
     *
     * @param ExceptionEvent $event Exception event
     *
     * @return void
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getException();

        if (($code = $exception->getCode()) === 0) {
            $code = Response::HTTP_BAD_GATEWAY;
        }

        $data = [
            'status' => $exception->getCode(),
            'errors' => $exception->getMessage(),
            'trace'  => $exception->getTraceAsString(),
        ];

        if (($exception instanceof ValidationFailedException) === true) {
            $data = [
                'status' => $exception->getCode(),
                'errors' => $exception->getValidationErrors(),
            ];
        }

        $event->setResponse(
            new JsonResponse(
                $data,
                $code
            )
        );
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents() : array
    {
        return [KernelEvents::EXCEPTION => 'onKernelException'];
    }

}
