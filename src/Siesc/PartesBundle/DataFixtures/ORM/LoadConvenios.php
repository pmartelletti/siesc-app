<?php
namespace Siesc\PartesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Siesc\AppBundle\Helper\StringUtils;
use Siesc\PartesBundle\Entity\Convenio;

class LoadConvenios extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $names = array("Planta funcional con Aporte", "Planta funcional sin aporte", "Extraprogramatico", "Administrativo", "Maestranza", "Ateneo I");
        $funciones = array("EI", "EP", "EM");
        foreach($names as $name)
        {
            foreach($funciones as $funcion) {
                $convenio = new Convenio();
                $convenio->setCodigo(sprintf("%s%s", StringUtils::buildAcronym($name), $funcion));
                $convenio->setNombre(sprintf("%s - %s", $name, $funcion));
                $convenio->setFuncion($this->getReference("funcion_" . $funcion));

                $manager->persist($convenio);
                $this->addReference("convenio_".$convenio->getCodigo(), $convenio);
            }
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

} 