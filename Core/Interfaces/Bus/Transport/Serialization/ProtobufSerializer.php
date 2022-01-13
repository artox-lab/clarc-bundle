<?php

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\Transport\Serialization;

use Google\Protobuf\Internal\Message as ProtobufMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\InvalidArgumentException;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Stamp\NonSendableStampInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class ProtobufSerializer implements SerializerInterface
{
    private const STAMP_HEADER_PREFIX = 'X-Message-Stamp-';

    /**
     * @var string
     */
    private $format;

    public function __construct(string $format = 'json')
    {
        $this->format = $format;
    }

    public function decode(array $encodedEnvelope): Envelope
    {
        if (empty($encodedEnvelope['body']) || empty($encodedEnvelope['headers'])) {
            throw new MessageDecodingFailedException('Encoded envelope should have at least a "body" and some "headers", or maybe you should implement your own serializer.');
        }

        if (empty($encodedEnvelope['headers']['type'])) {
            throw new MessageDecodingFailedException('Encoded envelope does not have a "type" header.');
        }

        $messageClass = $this->getClassFromMessageType($encodedEnvelope['headers']['type']);

        if (false === class_exists($messageClass)) {
            throw new MessageDecodingFailedException(sprintf('Message class "%s" not found during decoding.', $messageClass));
        }

        if (false === is_subclass_of($messageClass, ProtobufMessage::class)) {
            throw new MessageDecodingFailedException(sprintf('Message class "%s" is not a subclass of %s.', $messageClass, ProtobufMessage::class));
        }

        $stamps = $this->decodeStamps($encodedEnvelope);

        $message = new $messageClass;

        try {
            $message->mergeFromJsonString($encodedEnvelope['body']);
        } catch (\Exception $e) {
            throw new MessageDecodingFailedException('Could not decode message: '.$e->getMessage(), $e->getCode(), $e);
        }

        return new Envelope($message, $stamps);
    }

    public function encode(Envelope $envelope): array
    {
        $envelope = $envelope->withoutStampsOfType(NonSendableStampInterface::class);

        if (false === $envelope->getMessage() instanceof ProtobufMessage) {
            throw new InvalidArgumentException(
                sprintf('Message object must be an instance of %s', ProtobufMessage::class)
            );
        }

        $headers = ['type' => $this->getMessageType($envelope)] + $this->encodeStamps($envelope) + $this->getContentTypeHeader();

        return [
            'body' => $envelope->getMessage()->serializeToJsonString(),
            'headers' => $headers,
        ];
    }

    /**
     * Convert message class name to string in snake_case separated by dots
     *
     * @param Envelope $envelope
     *
     * @return string
     */
    private function getMessageType(Envelope $envelope): string
    {
        $class = get_class($envelope->getMessage());
        $type = str_replace('\\', '.', $class);
        $type = preg_replace('/(?<!^|\.)[A-Z]/', '_$0', $type);

        return strtolower($type);
    }

    /**
     * Convert message type string to FQCN class name
     *
     * @param string $type Message type
     *
     * @return string
     */
    private function getClassFromMessageType(string $type): string
    {
        $class = preg_replace_callback('/(?<=^|\.|_)[a-z]/', function ($matches) {
            return strtoupper($matches[0]);
        }, $type);

        return str_replace(['.', '_'], ['\\', ''], $class);
    }

    private function decodeStamps(array $encodedEnvelope): array
    {
        $stamps = [];
        foreach ($encodedEnvelope['headers'] as $name => $value) {
            if (0 !== strpos($name, self::STAMP_HEADER_PREFIX)) {
                continue;
            }

            $stamps[] = $this->safelyUnserialize($value);
        }
        if ($stamps) {
            $stamps = array_merge(...$stamps);
        }

        return $stamps;
    }

    private function encodeStamps(Envelope $envelope): array
    {
        if (!$allStamps = $envelope->all()) {
            return [];
        }

        $headers = [];

        foreach ($allStamps as $class => $stamps) {
            $headers[self::STAMP_HEADER_PREFIX.$class] = serialize($stamps);
        }

        return $headers;
    }

    private function getContentTypeHeader(): array
    {
        $mimeType = $this->getMimeTypeForFormat();

        return null === $mimeType ? [] : ['Content-Type' => $mimeType];
    }

    private function getMimeTypeForFormat(): ?string
    {
        switch ($this->format) {
            case 'json':
                return 'application/json';
            case 'binary':
                return 'application/octet-stream';
        }

        return null;
    }

    private function safelyUnserialize(string $contents)
    {
        if ('' === $contents) {
            throw new MessageDecodingFailedException('Could not decode an empty message using PHP serialization.');
        }

        $signalingException = new MessageDecodingFailedException(sprintf('Could not decode message using PHP serialization: %s.', $contents));
        $prevUnserializeHandler = ini_set('unserialize_callback_func', self::class.'::handleUnserializeCallback');
        $prevErrorHandler = set_error_handler(function ($type, $msg, $file, $line, $context = []) use (&$prevErrorHandler, $signalingException) {
            if (__FILE__ === $file) {
                throw $signalingException;
            }

            return $prevErrorHandler ? $prevErrorHandler($type, $msg, $file, $line, $context) : false;
        });

        try {
            $meta = unserialize($contents);
        } finally {
            restore_error_handler();
            ini_set('unserialize_callback_func', $prevUnserializeHandler);
        }

        return $meta;
    }

    /**
     * @internal
     */
    public static function handleUnserializeCallback(string $class)
    {
        throw new MessageDecodingFailedException(sprintf('Message class "%s" not found during decoding.', $class));
    }
}
