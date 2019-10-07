<?= "<?php\n" ?>
/**
 * Interactor
 *
 * @author <?= $author . PHP_EOL ?>
 */

declare(strict_types=1);

namespace <?= $namespace; ?>;

use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Commands\AbstractInteractor;

class <?= $class_name ?> extends AbstractInteractor
{

    /**
     * Command handler
     *
     * @param Command $command Command
     *
     * @return void
     */
    public function __invoke(Command $command) : void
    {
        // todo: write logic
    }

}