<?php

namespace Siesc\GeneratorBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Siesc\GeneratorBundle\Generator\FactoryGenerator;

class GenerateFactoryCommand extends GenerateCommand
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
            ->setDescription('Generates a form type class based on a Doctrine entity')
            ->setHelp("Generate Admin form in Admin Dir. Extends de basic doc:gen:form behaviour.")
            ->setName('siesc:generate:factory')
        ;
    }

    public function createGenerator()
    {
        return new FactoryGenerator();
    }
} 