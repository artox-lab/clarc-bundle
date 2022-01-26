# Built-in failure transport

Clarc bundle already have built-in **failure transport** : `failure_listening`

This transport configured to work with `artox_lab_clarc.messenger.transport.serializer.protobuf` serializer.

You can use it in built-in `listening` transport:

Edit `config/packages/messenger.yaml`:

```yaml
framework:
    messenger:
        transports:
            listening:
                failure_transport: failure_listening
```

By default, built-in failure transport DSN is configurable by `FAILURE_LISTENING_MESSENGER_TRANSPORT_DSN` environment variable.

If you want to customize configuration of this transport, edit `config/packages/messenger.yaml`:

```yaml
framework:
    messenger:
        transports:
            failure_listening:
                dsn: '%env(FAILURE_LISTENING_MESSENGER_TRANSPORT_DSN)%'
                serializer: 'artox_lab_clarc.messenger.transport.serializer.protobuf'
```

For more information about retry & failures please visit https://symfony.com/doc/current/messenger#retries-failures
