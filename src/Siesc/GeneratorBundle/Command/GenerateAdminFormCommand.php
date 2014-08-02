<?php
namespace Siesc\GeneratorBundle\Command;


use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineFormCommand;
use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use Sensio\Bundle\GeneratorBundle\Command\Validators;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineFormGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Siesc\GeneratorBundle\Generator\DoctrineFormAdminGenerator;

class GenerateAdminFormCommand extends GenerateCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setDefinition(array(
                new InputArgument('entity', InputArgument::REQUIRED, 'The entity class name to initialize (shortcut notation)'),
                new InputArgument('target', InputArgument::REQUIRED, 'The bundle to create the content on'),
            ))
            ->setDescription('Generates a form type class based on a Doctrine entity')
            ->setHelp("Generate Admin form in Admin Dir. Extends de basic doc:gen:form behaviour.")
            ->setName('siesc:generate:admin-form')
        ;
    }

    public function createGenerator()
    {
        return new DoctrineFormAdminGenerator($this->getContainer()->get('filesystem'));
    }
} 