<?php
/**
 * Allow decoding stamps only from self origin
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\Transport\Serialization;

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\Stamp\ConfirmedBySelfOriginStamp;
use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Services\Signature\SignerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class SelfOriginStampsSerializerDecorator implements SerializerInterface
{
    private const MESSAGE_ORIGIN_SIGNATURE_HEADER_KEY = 'X-Message-Origin-Signature';

    private SerializerInterface $serializer;
    private SignerInterface $signer;
    private string $stampHeaderPrefix;

    public function __construct(SerializerInterface $serializer, SignerInterface $signer, string $stampsHeaderPrefix)
    {
        $this->serializer = $serializer;
        $this->signer = $signer;
        $this->stampHeaderPrefix = $stampsHeaderPrefix;
    }

    public function decode(array $encodedEnvelope): Envelope
    {
        if ($this->isSelfOrigin($encodedEnvelope)) {
            return $this->serializer->decode($encodedEnvelope);
        }

        $encodedEnvelope = $this->removeStampsInEncodedEnvelope($encodedEnvelope);

        return ($this->serializer->decode($encodedEnvelope))
            ->with(new ConfirmedBySelfOriginStamp());
    }

    public function encode(Envelope $envelope): array
    {
        $encodedEnvelope = $this->serializer->encode($envelope);

        return $this->addOriginSignatureToEncodedEnvelope($encodedEnvelope);
    }

    private function addOriginSignatureToEncodedEnvelope(array $encodedEnvelope): array
    {
        $encodedEnvelope['headers'][self::MESSAGE_ORIGIN_SIGNATURE_HEADER_KEY] = $this->signer->sign($encodedEnvelope['body']);

        return $encodedEnvelope;
    }

    private function removeStampsInEncodedEnvelope(array $encodedEnvelope): array
    {
        $encodedEnvelope['headers'] = array_filter($encodedEnvelope['headers'], function ($name) {
            return 0 !== strpos($name, $this->stampHeaderPrefix);
        }, ARRAY_FILTER_USE_KEY);

        return $encodedEnvelope;
    }

    /**
     * Validate origin signature
     */
    private function isSelfOrigin(array $encodedEnvelope): bool
    {
        if (empty($encodedEnvelope['headers'][self::MESSAGE_ORIGIN_SIGNATURE_HEADER_KEY])) {
            return false;
        }

        return $this->signer->validate($encodedEnvelope['body'], $encodedEnvelope['headers'][self::MESSAGE_ORIGIN_SIGNATURE_HEADER_KEY]);
    }
}
