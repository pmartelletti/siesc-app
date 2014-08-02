<?php
namespace Siesc\PartesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Siesc\AppBundle\Helper\StringUtils;
use Siesc\PartesBundle\Entity\Convenio;
use Siesc\PartesBundle\Entity\SituacionRevista;

class LoadSituacionRevista extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $names = array("Titular", "Suplente", "Contratado a tiempo determinado", "Periodo de prueba");

        foreach($names as $name)
        {
            $revista = new SituacionRevista();
            $revista->setNombre($name);

            $manager->persist($revista);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 0;
    }

}