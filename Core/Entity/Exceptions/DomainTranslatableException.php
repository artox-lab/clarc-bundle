<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Exceptions;

use DomainException;
use Symfony\Contracts\Translation\TranslatorInterface;

class DomainTranslatableException extends DomainException implements TranslatableExceptionInterface
{

    /**
     * Translation parameters.
     *
     * @var array<string, string>
     */
    protected array $translationParameters = [];

    /**
     * Translator
     *
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * Set exception translator.
     *
     * @param TranslatorInterface $translator Translator
     *
     * @return void
     */
    public function setTranslator(TranslatorInterface $translator): void
    {
        $this->translator = $translator;
    }

    /**
     * Add parameter.
     *
     * @param string $name  Parameter name
     * @param string $value Parameter value
     *
     * @return void
     */
    public function setTranslationParameter(string $name, string $value): void
    {
        $this->translationParameters[$name] = $value;
    }

    /**
     * Get translated message.
     *
     * @return string
     */
    public function getTranslatedMessage(): string
    {
        return $this->translator->trans($this->getMessage(), $this->translationParameters, 'domain.exception');
    }

}
