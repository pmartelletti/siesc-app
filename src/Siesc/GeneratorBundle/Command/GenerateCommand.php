<?php

namespace Siesc\GeneratorBundle\Command;


use Doctrine\Bundle\DoctrineBundle\Mapping\MetadataFactory;
use Sensio\Bundle\GeneratorBundle\Command\Validators;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class GenerateCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entity = Validators::validateEntityName($input->getArgument('entity'));
        $targetBundle = Validators::validateBundleName($input->getArgument('target'));
        list($bundle, $entity) = $this->parseShortcutNotation($entity);

        $entityClass = $this->getContainer()->get('doctrine')->getAliasNamespace($bundle).'\\'.$entity;
        $metadata = $this->getEntityMetadata($entityClass);
        $bundle   = $this->getApplication()->getKernel()->getBundle($bundle);
        $targetBundle   = $this->getApplication()->getKernel()->getBundle($targetBundle);

        $generator = $this->createGenerator();
        $generator->setSkeletonDirs($this->getApplication()->getKernel()
            ->locateResource("@SiescGeneratorBundle/Resources/skeleton/"));
        $generator->generate($bundle, $targetBundle, $entity, $metadata[0]);

        if ($generator->getClassName()) {
            $output->writeln(sprintf(
                'The new %s.php class file has been created under %s.',
                $generator->getClassName(),
                $generator->getClassPath()
            ));
        }
    }

    abstract function createGenerator();

    protected function parseShortcutNotation($shortcut)
    {
        $entity = str_replace('/', '\\', $shortcut);

        if (false === $pos = strpos($entity, ':')) {
            throw new \InvalidArgumentException(sprintf('The entity name must contain a : ("%s" given, expecting something like AcmeBlogBundle:Blog/Post)', $entity));
        }

        return array(substr($entity, 0, $pos), substr($entity, $pos + 1));
    }

    protected function getEntityMetadata($entity)
    {
        $factory = new MetadataFactory($this->getContainer()->get('doctrine'));

        return $factory->getClassMetadata($entity)->getMetadata();
    }
} 