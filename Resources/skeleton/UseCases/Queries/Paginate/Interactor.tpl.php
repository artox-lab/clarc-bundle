<?= "<?php\n" ?>
/**
 * Query handler
 *
 * @author <?= $author . PHP_EOL ?>
 */

declare(strict_types=1);

namespace <?= $namespace; ?>;

use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Interactors\AbstractInteractor;
use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Interfaces\PaginatorInterface;
<?php if (empty($return_type_full_class_name) === false): ?>use <?= $return_type_full_class_name ?>;<?= PHP_EOL ?><?php endif;?>

class <?= $class_name ?> extends AbstractInteractor
{

    /**
     * Query handler
     *
     * @param Command $command Command
     *
     * @return <?php if (empty($return_type_short_class_name) === false): ?><?= $return_type_short_class_name; ?>[]|<?php endif; ?>PaginatorInterface<?= PHP_EOL ?>
     */
    public function __invoke(Command $command) : PaginatorInterface
    {
        // todo: write logic
    }

}