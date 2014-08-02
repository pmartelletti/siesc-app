<?php

namespace Siesc\GeneratorBundle\Command;


use Sensio\Bundle\GeneratorBundle\Command\Validators;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateAdminCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('siesc:generate:admin')
            ->setDescription('Generate Admin Resources for a given entity')
            ->addArgument('entity', InputArgument::REQUIRED, 'Entity to use to create Admin')
            ->addArgument('target', InputArgument::REQUIRED, 'Bundle to create the content on')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityShortcut = Validators::validateEntityName($input->getArgument('entity'));
        $targetBundle = Validators::validateBundleName($input->getArgument('target'));
        list($bundle, $entity) = $this->parseShortcutNotation($entityShortcut);
        $bundle = $targetBundle;
        //$entityClass = $this->getContainer()->get('doctrine')->getAliasNamespace($bundle).'\\'.$entity;
        //$metadata = $this->getEntityMetadata($entityClass);
        $bundle   = $this->getApplication()->getKernel()->getBundle($bundle);

        // create admin form
        $output->write('<info>Creating Admin Form...</info>');
        $this->getApplication()->find("siesc:generate:admin-form")->run($input, $output);
        $output->write('<comment>Done!</comment>', true);
        // create factory file
        $output->write("<info>Creating Factory for $entity...</info>");
        $this->getApplication()->find("siesc:generate:factory")->run($input, $output);
        $output->write('<comment>Done!</comment>', true);
        // generate CRUD templates
        $output->write("<info>Creating CRUD Templates ...</info>");
        $this->getApplication()->find('siesc:generate:crud-views')->run($input, $output);
        $output->write('<comment>Done!</comment>', true);
        // generate controllers
        $output->write("<info>Creating CRUD Admin Controllers ...</info>");
        $this->getApplication()->find('siesc:generate:admin-controller')->run($input, $output);
        $output->write('<comment>Done!</comment>', true);
        // DONE!
        $output->writeln("<comment>The Admin Code for $entity was created succesfully in $targetBundle bundle!</comment>");
    }

    private function parseShortcutNotation($shortcut)
    {
        $entity = str_replace('/', '\\', $shortcut);

        if (false === $pos = strpos($entity, ':')) {
            throw new \InvalidArgumentException(sprintf('The entity name must contain a : ("%s" given, expecting something like AcmeBlogBundle:Blog/Post)', $entity));
        }

        return array(substr($entity, 0, $pos), substr($entity, $pos + 1));
    }
} 