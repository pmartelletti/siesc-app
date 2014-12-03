<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function __construct($environment, $debug)
    {
        date_default_timezone_set( 'Europe/Paris' );
        parent::__construct($environment, $debug);
    }

    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new PUGX\MultiUserBundle\PUGXMultiUserBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Genemu\Bundle\FormBundle\GenemuFormBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new winzou\Bundle\StateMachineBundle\winzouStateMachineBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new \Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new \Hip\MandrillBundle\HipMandrillBundle(),
            // SIESC BUNDLES
            new Siesc\AppBundle\SiescAppBundle(),
            new Siesc\PartesBundle\SiescPartesBundle(),
            new Siesc\DataBundle\SiescDataBundle(),
            //new Siesc\AcademicoBundle\SiescAcademicoBundle(),
            //new Siesc\AdmisionesBundle\SiescAdmisionesBundle(),
            new Siesc\WebBundle\SiescWebBundle(),
            //new Siesc\CourseManagementBundle\SiescCourseManagementBundle(),
            new \Siesc\GeneratorBundle\SiescGeneratorBundle(),
            new Tahoe\Bundle\MultiTenancyBundle\TahoeMultiTenancyBundle(),
            new Siesc\AdminBundle\SiescAdminBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Bazinga\Bundle\FakerBundle\BazingaFakerBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
