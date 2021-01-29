<?php
/**
 * Make UseCase\Queries: Find, List or Paginate
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Command\Maker;

use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Commands\AbstractInteractor;
use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Interfaces\PaginatorInterface;
use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Queries\AbstractQuery;
use Exception;
use HaydenPierce\ClassFinder\ClassFinder;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class MakeUseCaseQuery extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     *
     * @return string
     */
    public static function getCommandName(): string
    {
        return 'make:use-case:query';
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
        $command->setDescription('Creates new App\UseCase\Query: Find, List or Paginate');
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
        $dependencies->addClassDependency(AbstractQuery::class, 'clarc-bundle');
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

        $question = new Question('Specify name of Query (without App\UseCase\Queries namespace)');
        $name     = $io->askQuestion($question);

        $question = new ChoiceQuestion('Choose type of query', ['Find', 'List', 'Paginate'], 'Find');
        $type     = $io->askQuestion($question);

        $returnType = '';

        if (empty($classes = $this->searchAllDTOClasses()) === false) {
            $question   = new ChoiceQuestion('Choose type of returning DTO', $classes);
            $returnType = $io->askQuestion($question);
        }

        $commandFullClassName    = 'App\UseCases\Queries\\' . trim($name, ' \\') . '\Command';
        $interactorFullClassName = 'App\UseCases\Queries\\' . trim($name, ' \\') . '\Interactor';

        $generator->generateClass(
            $commandFullClassName,
            $this->resolveTemplate('UseCases/Queries/' . $type . '/Command.tpl.php'),
            [
                'return_type_short_class_name' => Str::getShortClassName($returnType),
                'author'                       => $author,
            ]
        );
        $generator->generateClass(
            $interactorFullClassName,
            $this->resolveTemplate('UseCases/Queries/' . $type . '/Interactor.tpl.php'),
            [
                'return_type_full_class_name'  => $returnType,
                'return_type_short_class_name' => Str::getShortClassName($returnType),
                'author'                       => $author,
            ]
        );
        $generator->writeChanges();

        $this->writeSuccessMessage($io);
        $io->text(['Next: Open your new query & interactor and add your logic.']);
    }

    /**
     * Finding all defined DTO
     *
     * @throws Exception
     *
     * @return array
     */
    protected function searchAllDTOClasses(): array
    {
        $dto = ClassFinder::getClassesInNamespace('App\Entities\DTO', ClassFinder::RECURSIVE_MODE);

        if (empty($dto) === true) {
            return [];
        }

        return $dto;
    }

}
