<?php

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

class CreateInstanceCommand extends Command
{
    private $dialog;
    private $formatter;
    /**
     * @var OutputInterface
     */
    private $output;

    protected function configure()
    {
        $this
            ->setName('siesc:instance:create')
            ->setDescription('Install and create SIESC Instance')
            ->addArgument('instance_name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->dialog = $this->getHelperSet()->get('dialog');
        $this->formatter = $this->getHelperSet()->get('formatter');
        $this->output = $output;
        $instanceName = $this->dialog->ask($output, 'Name of the instance: ', null);
        if (!$instanceName) {
            throw new \RunTimeException(
                'The name of the instance cannot be blank.'
            );
        }
        $domain = sprintf('%s.siesc.com.ar', $instanceName);
        // create dokku instance
        $this->createDokkuInstance($instanceName);
        // we create the mandrill subaccount
        $this->createMandrillSubaccount($domain);
        // update config and create fixtures
        $this->updateDokkuConfig($instanceName);

        $this->output->writeln(sprintf("<info>End of installation! You can use new instance at %s.</info>", $domain));
    }

    private function createDokkuInstance($name)
    {
        $this->output->writeln(
            $this->formatter->formatSection('Dokku', sprintf("Creating Dokku instance for %s", $name))
        );
        $this->createDatabaseConfig($name);
        $this->output->writeln('<comment>Updating GIT remote repository</comment>');
        $this->executeLinuxCommand(sprintf('git remote add %s dokku@siesc.com.ar:%s', $name, $name));
        $this->output->writeln('<comment>Creating server instance. Pushing to server.</comment>');
        $this->executeLinuxCommand(sprintf('git push %s master', $name), false);

        $this->output->writeln('<info>Done!</info>');

    }

    private function createDatabaseConfig($name)
    {
        $this->output->writeln('<comment>Creating mysql database</comment>');
        // first we create the folder
        $this->executeLinuxCommand(sprintf('ssh root@siesc.com.ar sudo -u dokku mkdir /home/dokku/%s', $name), false);
        $this->executeLinuxCommand(sprintf('ssh root@siesc.com.ar sudo -u dokku touch /home/dokku/%s/ENV', $name), false);
        // create the database first
        $this->executeLinuxCommand(sprintf('ssh root@siesc.com.ar dokku mysql:create %s', $name), false);
    }

    private function updateDokkuConfig($instanceName)
    {
        // create the database and run fixtures
        $this->output->writeln('<comment>Creating database and running fixtures</comment>');
        $this->executeLinuxCommand(sprintf('ssh root@siesc.com.ar dokku run %s php app/console doc:sch:up --force', $instanceName));
        $this->executeLinuxCommand(sprintf('ssh root@siesc.com.ar dokku run %s php app/console doc:fix:load -n', $instanceName));

        // preguntar nombre de la institucion y esas cosas
        $institucion = implode('-', explode(" ", strtolower($this->dialog->ask($this->output, 'Name of the school: ', null))));
        $code = $this->dialog->ask($this->output, 'Code of the school: ', null);

        $configs = sprintf(
            'MANDRILL_SUBACCOUNT=%s.siesc.com.ar SIESC_INSTITUCION=%s SIESC_INSTITUCION_CODE=%s',
            $instanceName, $institucion, $code
        );

        $this->executeLinuxCommand(sprintf('ssh root@siesc.com.ar dokku config:set %s %s', $instanceName, $configs), true, 'comment');

        // set new relic KEY and name
        $this->output->writeln('<comment>Setting new relic config...</comment>');
        $newRelicId = 'd7d790f1c5628f7920aaef78ad6eafbbdc0d8d08';
        $this->executeLinuxCommand(sprintf('ssh root@siesc.com.ar dokku config:set %s NEW_RELIC_LICENSE_KEY=%s', $instanceName, $newRelicId), true, 'comment');
        $this->executeLinuxCommand(sprintf('ssh root@siesc.com.ar dokku config:set %s NEW_RELIC_APP_NAME=%s', $instanceName, $instanceName), true, 'comment');

        $this->output->writeln('<info>Done!</info>');

    }

    private function createMandrillSubaccount($domain)
    {
        $this->output->writeln(
            $this->formatter->formatSection('Mandrill', sprintf("Creating Mandrill subaccount for %s", $domain))
        );

        $results = $this->getContainer()->get('hip_mandrill.client')->call('/subaccounts/add', array(
            'id' => $domain,
            'name' => $domain
        ));

        $this->output->writeln('<info>Done!</info>');
    }

    private function executeLinuxCommand($command, $verbose = true, $tag = null)
    {
        $results = array();
        exec($command, $results);
        if ($verbose) {
            foreach($results as $result) {
                if ($tag)
                    $this->output->writeln(sprintf('<%s>%s</%s>', $tag, $result, $tag));
                else
                    $this->output->writeln(sprintf('%s', $result));
            }
        }
    }
} 