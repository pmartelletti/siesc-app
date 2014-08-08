<?php

namespace Siesc\PartesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Siesc\AppBundle\Helper\StringUtils;
use Siesc\PartesBundle\Entity\Convenio;
use Siesc\PartesBundle\Entity\SituacionRevista;
use Siesc\PartesBundle\Entity\TipoNovedad;

class LoadTipoNovedad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $names = array("Inasistencia Justificada", "Inasistencia Injustificada", "Alta", "Baja", "Licencia Sin Sueldo", "Licencia Con Sueldo", "Otros");

        foreach($names as $name)
        {
            $tipo = new TipoNovedad();
            $tipo->setNombre($name);

            $manager->persist($tipo);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 0;
    }

}