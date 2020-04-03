<?php
/**
 * Subscribe on exceptions in API
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\EventListeners;

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Exceptions\ValidationFailedException;
use DomainException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Throwable;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * Translator
     *
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * ExceptionSubscriber constructor.
     *
     * @param TranslatorInterface $traslator Translator
     */
    public function __construct(TranslatorInterface $traslator)
    {
        $this->translator = $traslator;
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

    /**
     * Handle exception in API
     *
     * @param ExceptionEvent $event Exception event
     *
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = $this->makeResponse($exception);

        $event->setResponse($response);
    }

    /**
     * Convert exception to response
     *
     * @param Throwable $exception Exception
     *
     * @return Response
     */
    protected function makeResponse(Throwable $exception) : Response
    {
        if (($code = $exception->getCode()) < 100) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $data = [];

        if ($exception instanceof HandlerFailedException && empty($exception->getNestedExceptions()) === false) {
            $data = [
                'status' => $exception->getCode(),
                'errors' => [],
            ];

            foreach ($exception->getNestedExceptions() as $nestedException) {
                $message = $this->translator->trans($nestedException->getMessage(), [], 'exceptions');

                if ($nestedException instanceof DomainException) {
                    $data['errors']['domain'][] = $message;
                    continue;
                }

                $data['errors']['unexpected'][] = $message;
            }
        }

        if ($exception instanceof ValidationFailedException) {
            $data = [
                'status' => $exception->getCode(),
                'errors' => $exception->getValidationErrors(),
            ];
        }

        if ($exception instanceof HttpException) {
            $code = $exception->getStatusCode();

            $data = [
                'status' => $exception->getStatusCode(),
                'errors' => ['http' => [$exception->getMessage()]],
            ];
        }

        if (empty($data) === true) {
            $data = [
                'status' => $exception->getCode(),
                'errors' => ['unexpected' => [$this->translator->trans($exception->getMessage(), [], 'exceptions')]],
                'trace'  => $exception->getTrace(),
            ];
        }

        return new JsonResponse($data, $code);
    }

}
