<?php
namespace Siesc\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Siesc\AppBundle\Entity\Funcion;

class LoadFunciones extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $funciones = array(
            "EI" => "Inicial",
            "EP" => "Educacion Primaria",
            "ES" => "Educacion Superior",
            "EM" => "Educacion Media",
            "EE" => "Educacion Especial",
            "SA" => "Secundaria Agropecuaria",
            "ET" => "Educacion Tecnica",
        );
        foreach($funciones as $codigo => $nombre)
        {
            $funcion = new Funcion();
            $funcion->setNombre($nombre);
            $funcion->setCodigo($codigo);

            $manager->persist($funcion);
            $this->addReference(sprintf("funcion_%s", $codigo), $funcion);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 0;
    }

} 