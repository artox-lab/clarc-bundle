<?php

/**
 * Constraint: DateTime
 *
 * @author Dmitry Meliukh <d.meliukh@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Validator\Constraints;

use Symfony\Component\Validator\Constraints\DateTime as SymfonyDateTime;

/**
 * Constraint: DateTime
 *
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class DateTime extends SymfonyDateTime
{
}
