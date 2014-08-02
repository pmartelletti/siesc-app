<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pablo
 * Date: 10/30/13
 * Time: 1:42 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Siesc\PartesBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class PartesMenuBuilder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $security = $this->container->get('security.context');

        // Menu will be a navbar menu anchored to right
        $menu = $factory->createItem('root', array(
            'navbar' => true,
        ));

        $menu->addChild('Inicio', array(
            'icon' => 'home',
            'route' => 'siesc_partes_default_index'
        ));

        $partes = $menu->addChild('Partes Diarios', array(
            'icon' => 'list-alt',
            'dropdown' => true,
            'caret' => true,
        ));

        $partes->addChild('Ingresar nuevo', array('route' => 'partes_partediario_new'));
        $partes->addChild('Partes Ingresados', array('route' => 'partes_partediario'));


        if( $security->isGranted(array('ROLE_SUPER_ADMIN', 'ROLES_ADMIN_PARTES'))) {
            // administrar partes
            $partes->addChild('Administrar Partes', array('route' => 'partes_partediario', 'routeParameters' => array('admin' => true)));
            // agregar estadisticas
            $stats = $menu->addChild('Estadisticas', array(
                'icon' => 'stats',
                'dropdown' => true,
                'caret' => true
            ));

            $stats->addChild('Graficos', array('route' => 'partes_partediario'));
            $stats->addChild('Reportes Premio Asistencia', array('route' => 'siesc_partes_estadisticas_premiosasistencia'));
            $stats->addChild('Reportes Horas Extra', array('route' => 'partes_partediario'));
        }




        return $menu;

    }

}