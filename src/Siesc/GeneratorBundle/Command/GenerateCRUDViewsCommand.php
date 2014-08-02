<?php
namespace Siesc\GeneratorBundle\Command;

use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Siesc\GeneratorBundle\Generator\CRUDViewsGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Sensio\Bundle\GeneratorBundle\Command\Validators;

class GenerateCRUDViewsCommand extends GenerateCommand
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
            ->setHelp("Generate Admin CRUD templates in Admin Dir. Extends de basic doc:gen:form behaviour.")
            ->setName('siesc:generate:crud-views')
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entity = Validators::validateEntityName($input->getArgument('entity'));
        list($bundle, $entity) = $this->parseShortcutNotation($entity);

        $entityClass = $this->getContainer()->get('doctrine')->getAliasNamespace($bundle).'\\'.$entity;
        $metadata = $this->getEntityMetadata($entityClass);
        $bundle   = $this->getApplication()->getKernel()->getBundle($bundle);
        // we set WebBundle as default targetBundle
        try {
            $targetBundle   = $this->getApplication()->getKernel()->getBundle("SiescWebBundle");
        } catch(\InvalidArgumentException $e) {
            // if webbundle does not exists, we use the target bundle
            $targetBundle = Validators::validateBundleName($input->getArgument('target'));
            $targetBundle   = $this->getApplication()->getKernel()->getBundle($targetBundle);
        }
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

    public function createGenerator()
    {
        return new CRUDViewsGenerator();
    }
} 