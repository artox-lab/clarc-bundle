<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Exceptions;

use Symfony\Contracts\Translation\TranslatorInterface;

interface TranslatableExceptionInterface
{

    /**
     * Set exception translator.
     *
     * @param TranslatorInterface $translator Translator
     *
     * @return void
     */
    public function setTranslator(TranslatorInterface $translator): void;

    /**
     * Add parameter.
     *
     * @param string $name  Parameter name
     * @param string $value Parameter value
     *
     * @return void
     */
    public function setTranslationParameter(string $name, string $value): void;

}
