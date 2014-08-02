<?php
namespace Siesc\PartesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Siesc\AppBundle\Helper\StringUtils;
use Siesc\PartesBundle\Entity\Categoria;

class LoadCategoria extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $names = ["Profesor", "Preceptor", "Director", "Secretario"];
        $funciones = ["EI", "EP", "EM"];
        foreach($names as $name)
        {
            foreach($funciones as $funcion) {
                $categoria = new Categoria();
                $categoria->setNombre(sprintf("%s - %s", $name, $funcion));
                $categoria->setFuncion($this->getReference('funcion_' . $funcion));
                $categoria->setCodigo(StringUtils::buildAcronym($categoria->getNombre()));
                $categoria->setRequiereHoras(false);
                $categoria->setRequiereAsignatura(false);

                $manager->persist($categoria);
                $this->addReference("categoria_". StringUtils::slugify($categoria->getNombre()), $categoria);
            }
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

} 