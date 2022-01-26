# CHANGELOG

## 5.2.12
+ Added built-in transport and buses for communication between services
+ Added `BroadcastingBus` to dispatch message to external services
+ To prevent message validation error added `@type` annotation to ignore list (`IgnoreDoctrineAnnotationReaderPass`)
+ Added messenger middleware for adding amqp routing key `artox_lab_clarc.messenger.middleware.add_amqp_routing_key`
+ Added messenger transport serializer for protobuf messages `artox_lab_clarc.messenger.transport.serializer.protobuf` and `artox_lab_clarc.messenger.transport.serializer.protobuf_self_origin_stamps` with validation of message origin
+ Add `StringSigner` service for sign messages (used in `artox_lab_clarc.messenger.transport.serializer.protobuf_self_origin_stamps`)

## 5.2.11
* Added RBAC - `ArtoxLab\Bundle\ClarcBundle\Core\Entity\Security\AuthorizationChecker`.

## 5.1.1
* Updated `ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\Middleware\ValidationMiddleware`. 
  `HandlerFailedException` won't override original exception
* Added `ArtoxLab\Bundle\ClarcBundle\Core\Entity\Exceptions\DomainHttpException`. 
  Exception extends Symfony's HttpException. Extend DomainHttpException in case
  if you need to return some Exception when front-end part is PHP-rendered
* Remove processing of case when ExceptionSubscriber receive `HandlerFailedException`
  

## 5.1.0

* `CommandBus` moved from `ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\CommandBus\CommandBusInterface`
  to `ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\CommandBus`
* Added `QueryBus` in namespace `ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus`
* Added `EventBus` in namespace `ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus`
* Added `MessageBus` in namespace `ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus`
* Added the `$queryBus` argument in `AbstractApiController::__construct()`
* Added `DomainEventInterface` in namespace `ArtoxLab\Bundle\ClarcBundle\Core\Entity\Bus`
* Removed namespace `ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Messenger`
* Removed `ArtoxLab\Bundle\ClarcBundle\Core\Entity\Bus\CommandBus`
* Removed `ArtoxLab\Bundle\ClarcBundle\Core\Entity\Bus\EventBus`
* Removed `ArtoxLab\Bundle\ClarcBundle\Core\Entity\Bus\QueryBus`

