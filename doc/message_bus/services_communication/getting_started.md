# Getting started

In this quickstart you will configure your symfony applications for asynchronous communication.
We will use protobuf serializer for sending messages through the message broker. 

## Requirements:

- Package artox-lab/clarc-bundle:^5.2.10
- AMQP message broker
- Shared protobuf php messages package

### 1. Require messages package

```shell
composer require artox-lab/example-protobuf-messages
```

### 2. Configure messenger `config/packages/messenger.yaml`

```yaml
framework:
    messenger:
        transports:
            broadcasting:
                dsn: '%env(BROADCASTING_MESSENGER_TRANSPORT_DSN)%'
                serializer: artox_lab_clarc.messenger.transport.serializer.protobuf_self_origin_stamps
                options:
                    exchange:
                        name: '%env(BROADCASTING_MESSENGER_TRANSPORT_EXCHANGE)%'
                        type: topic
                    queues: [ ]
            listening:
                dsn: '%env(LISTENING_MESSENGER_TRANSPORT_DSN)%'
                serializer: artox_lab_clarc.messenger.transport.serializer.protobuf_self_origin_stamps
                options:
                    exchange:
                        name: '%env(LISTENING_MESSENGER_TRANSPORT_EXCHANGE)%'
                        type: topic
                    queues:
                        listening_events:
                            binding_keys: [ 'lerna.events.marketplace.v1.#' ]
                failure_transport: failure_listening
            failure_listening:
                dsn: '%env(FAILURE_LISTENING_MESSENGER_TRANSPORT_DSN)%'
                serializer: 'artox_lab_clarc.messenger.transport.serializer.protobuf'
```

### 3. Configure environment variables for transports in `.env` file

```shell
# Broadcasting transport
BROADCASTING_MESSENGER_TRANSPORT_DSN=amqp://user:password@hostname:5672/vhost
BROADCASTING_MESSENGER_TRANSPORT_EXCHANGE=messages-shared-exchange
# Listening transport
LISTENING_MESSENGER_TRANSPORT_DSN=amqp://user:password@hostname:5672/vhost
LISTENING_MESSENGER_TRANSPORT_EXCHANGE=messages-shared-exchange
# Failure listening transport
FAILURE_LISTENING_MESSENGER_TRANSPORT_DSN=doctrine://default
```

### 4. Producing messages

#### Configure routing

```yaml
# config/packages/messenger.yaml
framework:
  messenger:
    routing:
      'Google\Protobuf\Internal\Message': broadcasting
```

In some place of application you should inject `BroadcastingBus` and dispatch message through it.

```php
<?php

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\BroadcastingBus;

class SomeClass
{
    public function __construct(private BroadcastingBus $bus)
    {
    }

    public function __invoke(): void
    {
        $message = new \ArtoxLab\ExampleMessage\V1\Order\Created();
        $message->setId("6b7c804a-19b0-43d5-bc26-6e791346a4a3");

        $this->bus->dispatch($message);
    }
}
```

> **Note**: Clarc bundle is already configured to route `\Google\Protobuf\Internal\Message` to built-in `broadcasting` transport.

### 5. Consuming messages

1. Create message handler

```php
<?php

use \Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class MessageHandler implements MessageHandlerInterface
{
    public function __invoke(\ArtoxLab\ExampleMessage\V1\Order\Created $message)
    {
    }
}
```

2. Run message consumer

```shell
php bin/console messenger:consume listening
```

---

## Cautions
- Don't use the same application **both as producer and consumer** during this guide
- Run consumer **before** dispatching the message (consumer will setup exchange, queues and bindings for further message communications)

# Learn more

- [Consume an external message through a specific bus](consume_an_external_message_through_s_specific_bus.md)
- [Built-in failure transport](built_in_failure_transport.md)
