<?php
namespace Siesc\GeneratorBundle\Command;


use Symfony\Component\Console\Input\InputArgument;
use Siesc\GeneratorBundle\Generator\DoctrineControllerAdminGenerator;

class GenerateAdminControllerCommand extends GenerateCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setDefinition(array(
                new InputArgument('entity', InputArgument::REQUIRED, 'The entity class name to initialize (shortcut notation)'),
                new InputArgument('target', InputArgument::REQUIRED, 'The bundle to create the content on')
            ))
            ->setDescription('Generates a controller class based on a Doctrine entity')
            ->setHelp("Generate Admin CRUD controller in Admin Dir.")
            ->setName('siesc:generate:admin-controller')
        ;
    }

    public function createGenerator()
    {
        return new DoctrineControllerAdminGenerator();
    }
} 