<?= "<?php\n" ?>
/**
 * Find<?php if (empty($return_type_short_class_name) === false): ?> <?= $return_type_short_class_name ?><? endif; ?>: todo: description
 *
 * @author <?= $author . PHP_EOL ?>
 */

declare(strict_types=1);

namespace <?= $namespace; ?>;

use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Queries\AbstractQuery;

class <?= $class_name ?> extends AbstractQuery
{

}