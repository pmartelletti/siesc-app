<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pablo
 * Date: 11/11/13
 * Time: 10:28 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Siesc\AppBundle\Command;

use Sensio\Bundle\GeneratorBundle\Manipulator\RoutingManipulator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Sensio\Bundle\GeneratorBundle\Manipulator\KernelManipulator;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;

class InstallCommand extends Command {

    private $dialog;
    private $formatter;
    private $modules = array(
        'SIESC Data',
        'SIESC Academico',
        'SIESC Partes',
        'SIESC Web'
    );

    protected function configure()
    {
        $this
            ->setName('siesc:modules:install')
            ->setDescription('Install SIESC Commands')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->dialog = $this->getHelperSet()->get('dialog');
        $this->formatter = $this->getHelperSet()->get('formatter');
        $this->askAdminToken($output);
        // if the token is correct, continue executing
        $modules = $this->askModulesInstalled($output);
        $this->addComposerRequirements($modules, $output);
        $this->updateDependencies($output);
        $output->writeln("<info>End of installation! You can use the system right now.");
    }

    private function addComposerRequirements(array $modules = array(), OutputInterface $output) {
        //$command = $this->getContainer()->get('kernel')->getRootDir() . "/../composer.json";
        $requirements = array(
            'SIESC Partes' => array("siesc/partes-bundle:dev-master", "Siesc\\PartesBundle\SiescPartesBundle", "@SiescPartesBundle/Resources/config/config.yml", "partes", "@SiescPartesBundle/Resources/config/routing.yml"),
            'SIESC Data' => array("siesc/data-bundle:dev-master", "Siesc\\DataBundle\SiescDataBundle", "@SiescDataBundle/Resources/config/config.yml", "data", "@SiescDataBundle/Resources/config/routing.yml")
        );
        foreach($modules as $req) {
            //echo sprintf("composer require '%s' --no-update", $requirements[$req]); exit;
            $message = exec(sprintf("composer require '%s' --no-update", $requirements[$req][0]));
            $formattedLine = $this->formatter->formatSection(
                sprintf("%s installation", $req),
                $message
            );
            $output->writeln($formattedLine);
            $this->updateKernel($output, $this->getContainer()->get('kernel'), $requirements[$req][1]);
            $this->updateBundleConfig($output, $requirements[$req]);
            $this->updateRouting($output, $requirements[$req]);
        }

    }

    protected function updateKernel(OutputInterface $output, KernelInterface $kernel, $bundle)
    {
        $auto = true;
        $output->writeln('Enabling the module inside the Kernel: ');
        $manip = new KernelManipulator($kernel);
        try {
            $ret = $auto ? $manip->addBundle($bundle) : false;

            if (!$ret) {
                $reflected = new \ReflectionObject($kernel);

                return array(
                    sprintf('- Edit <comment>%s</comment>', $reflected->getFilename()),
                    '  and add the following bundle in the <comment>AppKernel::registerBundles()</comment> method:',
                    '',
                    sprintf('    <comment>new %s(),</comment>', $bundle),
                    '',
                );
            }
        } catch (\RuntimeException $e) {
            return array(
                sprintf('Bundle <comment>%s</comment> is already defined in <comment>AppKernel::registerBundles()</comment>.', $bundle),
                '',
            );
        }
    }

    private function updateDependencies(OutputInterface $output) {
        $output->writeln('<info>Downloading and installing modules...</info>');
        $message = exec("composer update");
        $formattedLine = $this->formatter->formatSection(
            'Modules Installation',
            $message
        );
        $output->writeln($formattedLine);
    }

    private function askModulesInstalled(OutputInterface $output) {

        $modules = $this->modules;

        $selected = $this->dialog->select(
            $output,
            'Please, select the modules to be installed',
            $this->modules,
            0,
            false,
            'El modulo "%s" no existe',
            true // enable multiselect
        );

        $selectedModules = array_map(function($c) use ($modules) {
            return $modules[$c];
        }, $selected);

        return $selectedModules;
    }

    private function askAdminToken(OutputInterface $output) {
        $this->dialog->askHiddenResponseAndValidate(
            $output,
            'Pleas, provide the ADMIN token credentials: ',
            function ($answer) {
                if ('459e9cce1b67c7481ce236a5e3efc60d' !== md5($answer) ) {
                    throw new \RunTimeException(
                        'The Admin token is invalid. Installation cancelled.'
                    );
                }
                return $answer;
            },
            2
        );
    }

    protected function updateBundleConfig(OutputInterface $output, $bundle)
    {

        $output->writeln('Importing the module config resource: ');
        $filename = $this->getContainer()->getParameter('kernel.root_dir').'/config/config.yml';
        $yaml = Yaml::parse($filename);
        $yaml['imports'][] = array(
            "resource" => $bundle[2]
        );

        if(isset($yaml['siesc_app'])) {
            if(!in_array($bundle[3], $yaml['siesc_app']['modules_enabled'])) {
                $yaml['siesc_app']['modules_enabled'][] = "$bundle[3]";
            }
        } else {
            $yaml['siesc_app'] = array(
                'modules_enabled' => array(
                    "$bundle[3]"
                )
            );
        }
        file_put_contents($filename, Yaml::dump($yaml));
    }

    protected function updateRouting(OutputInterface $output, $bundle)
    {
        $auto = true;
        $output->writeln('Importing the module routing resource: ');
        $filename = $this->getContainer()->getParameter('kernel.root_dir').'/config/routing.yml';

        $yaml = Yaml::parse($filename);
        if(!isset($yaml['siesc_'.$bundle[3]])) {
            $yaml['siesc_'.$bundle[3]] = array(
                'resource' => $bundle[4],
                'prefix' => "/"
            );
        }
        file_put_contents($filename, Yaml::dump($yaml));

    }

}