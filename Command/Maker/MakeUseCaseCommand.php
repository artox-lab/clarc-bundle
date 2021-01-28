<?php
/**
 * Make UseCase\Commands: generates classes of command and interactor
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Command\Maker;

use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Commands\AbstractCommand;
use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Commands\AbstractInteractor;
use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Interfaces\PaginatorInterface;
use Exception;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;

class MakeUseCaseCommand extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     *
     * @return string
     */
    public static function getCommandName(): string
    {
        return 'make:use-case:command';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     *
     * @param Command            $command     Command
     * @param InputConfiguration $inputConfig Configuration
     *
     * @return void
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command->addArgument(
            'author',
            null,
            'Author of generated classes',
            ($_SERVER['AUTHOR'] ?? null)
        );
        $command->setDescription('Creates new App\UseCase\Command');
    }

    /**
     * Configure any library dependencies that your maker requires.
     *
     * @param DependencyBuilder $dependencies Dependencies
     *
     * @return void
     */
    public function configureDependencies(DependencyBuilder $dependencies): void
    {
        $dependencies->addClassDependency(AbstractCommand::class, 'clarc-bundle');
        $dependencies->addClassDependency(AbstractInteractor::class, 'clarc-bundle');
        $dependencies->addClassDependency(PaginatorInterface::class, 'clarc-bundle');
    }

    /**
     * Called after normal code generation: allows you to do anything.
     *
     * @param InputInterface $input     Input interface
     * @param ConsoleStyle   $io        Output interface
     * @param Generator      $generator Class generator
     *
     * @throws Exception
     *
     * @return void
     */
    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $author = $input->getArgument('author');

        $question = new Question('Specify name of Command (without App\UseCase\Commands namespace)');
        $name     = $io->askQuestion($question);

        $commandFullClassName    = 'App\UseCases\Commands\\' . trim($name, ' \\') . '\Command';
        $interactorFullClassName = 'App\UseCases\Commands\\' . trim($name, ' \\') . '\Interactor';

        $generator->generateClass(
            $commandFullClassName,
            $this->resolveTemplate('UseCases/Commands/Command.tpl.php'),
            ['author' => $author]
        );
        $generator->generateClass(
            $interactorFullClassName,
            $this->resolveTemplate('UseCases/Commands/Interactor.tpl.php'),
            ['author' => $author]
        );
        $generator->writeChanges();

        $this->writeSuccessMessage($io);
        $io->text(['Next: Open your new command & interactor and add your logic.']);
    }

}
