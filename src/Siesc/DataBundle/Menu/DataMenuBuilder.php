<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pablo
 * Date: 10/29/13
 * Time: 7:03 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Siesc\DataBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class DataMenuBuilder extends ContainerAware
{
    public function modulesMenu(FactoryInterface $factory, array $options)
    {

        $security = $this->container->get('security.context');

        // Menu will be a navbar menu anchored to right
        $menu = $factory->createItem('root', array(
            'navbar' => true,
        ));

        if ($security->isGranted(array('ROLE_SUPER_ADMIN', 'ROLE_ADMIN_DATA'))) {
            // we construct the data module menu
            $dataModule = $menu->addChild('SIESC Data', array(
                'dropdown' => true,
                'caret' => true,
            ));

            $dataModule->addChild('Docentes', array('route' => 'admin_siesc_app_docente_list'));
            $dataModule->addChild('Cursos', array('route' => 'admin_siesc_app_curso_list'));
            $dataModule->addChild('Secciones', array('route' => 'admin_siesc_app_seccion_list'));
            $dataModule->addChild('Ciclos Lectivos', array('route' => 'admin_siesc_app_ciclolectivo_list'));

        }

        if ($security->isGranted(array('ROLE_SUPER_ADMIN', 'ROLE_ADMIN_PARTES'))) {
            // we construct the partes module menu
            $partesModule = $menu->addChild('SIESC Partes', array(
                'dropdown' => true,
                'caret' => true,
            ));

            $partesModule->addChild('Cargos', array('route' => 'admin_siesc_partes_cargo_list'));
            $partesModule->addChild('Cargos Docentes', array('route' => 'admin_siesc_partes_cargodocente_list'));
            $partesModule->addChild('Tipos de Inasistencias', array('route' => 'admin_siesc_partes_tipoinasistencia_list'));
            $partesModule->addChild('Motivos de Inasistencias', array('route' => 'admin_siesc_partes_motivoinasistencia_list'));
        }

        return $menu;
    }

}