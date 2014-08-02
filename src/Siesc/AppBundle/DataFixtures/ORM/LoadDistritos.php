<?php
namespace Siesc\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Siesc\AppBundle\Entity\Distrito;

class LoadDistritos extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 5; $i++)
        {
            $distrito = new Distrito();
            $distrito->setNombre(sprintf("Distrito Nro %s", $i+1));

            $manager->persist($distrito);
            $this->addReference("distrito_".$i, $distrito);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 0;
    }

} 