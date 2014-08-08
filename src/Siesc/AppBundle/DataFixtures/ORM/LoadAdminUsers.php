<?php

namespace Siesc\AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Siesc\Data\CommonBundle\Entity\Docente;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadAdminUsers implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;
    
    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        # set the user type
        $discriminator = $this->container->get('pugx_user.manager.user_discriminator');
        $discriminator->setClass('Siesc\AppBundle\Entity\Docente');
        # create the user
        $userManager = $this->container->get('pugx_user_manager');
        $admin = $userManager->createUser();
        # set the attributes of the user
        $admin->setNombre("Pablo María")
            ->setApellido("Martelletti")
            ->setCuil('2')
            ->setEmail("pmartelletti@gmail.com")
            ->setDireccion("Vidal 3628")
            ->setPlainPassword("admin")
            ->setTelefono("470120246")
            ->setEnabled(true)
            ->addRole('ROLE_SUPER_ADMIN');
        # persist the user
        $userManager->updateUser($admin, true);

        $admin = $userManager->createUser();
        $admin->setNombre("Enrique Carlos")
            ->setApellido("Garcia")
            ->setCuil('23')
            ->setEmail("mail@enriquecgarcia.com.ar")
            ->setDireccion("Holmberg 4102, 2do B")
            ->setPlainPassword("admin")
            ->setTelefono("470120246")
            ->setEnabled(true)
            ->addRole('ROLE_SUPER_ADMIN');
        # persist the user
        $userManager->updateUser($admin, true);

//        $secretario = $userManager->createUser();
//        $secretario->setNombre("Enrique Carlos")
//            ->setApellido("Garcia")
//            ->setCuil('24')
//            ->setEmail("ecgarcia@gmail.com")
//            ->setDireccion("Vidal 3628")
//            ->setPlainPassword("0220404")
//            ->setTelefono("470120246")
//            ->setEnabled(true)
//            ->addRole('ROLE_USER_PARTES');
//
//        $userManager->updateUser($secretario, true);

    }
    
     /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
    
    
}