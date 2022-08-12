<?php
/**
 * String signer
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Services\Signature;

class StringSigner implements SignerInterface
{
    private $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function sign(string $string): string
    {
        return $this->computeHash($string);
    }

    private function computeHash(string $string): string
    {
        return base64_encode(hash_hmac('sha256', $string, $this->secret, true));
    }

    public function validate(string $string, ?string $signature = null): bool
    {
        return hash_equals($this->computeHash($string), $signature);
    }
}
