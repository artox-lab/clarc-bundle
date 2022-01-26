<?php
/**
 * Signer interface
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Services\Signature;

interface SignerInterface
{
    public function sign(string $string): string;

    public function validate(string $string, ?string $signature = null): bool;
}
