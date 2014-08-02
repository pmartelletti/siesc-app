<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pablo
 * Date: 10/29/13
 * Time: 3:44 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Siesc\AppBundle\Menu;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class AppMenuBuilder extends ContainerAware
{



    public function userMenu(FactoryInterface $factory, array $options)
    {

        $user = $this->container->get('security.context')->getToken()->getUser();

        // Menu will be a navbar menu anchored to right
        $menu = $factory->createItem('root', array(
            'navbar' => true,
            'pull-right' => true,
        ));

        // Create a dropdown with a caret
        $dropdown = $menu->addChild($user->getFullName(), array(
            'icon' => 'user',
            'dropdown' => true,
            'caret' => true,
        ));

        // Create a dropdown header
        $dropdown->addChild('Panel de Servicios', array('route' => 'siesc_app_default_index', 'icon' => 'dashboard'));
        $dropdown->addChild('Ver mi perfil', array('route' => 'fos_user_profile_show', 'icon' => 'cog'));
        $dropdown->addChild('Cerrar Sesion', array('route' => 'fos_user_security_logout', 'icon' => 'off'));

        return $menu;
    }

    public function userMenuLegacy(FactoryInterface $factory, array $options)
    {
        // TODO: implement bootstrap 2 version
    }

}