# CHANGELOG

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
