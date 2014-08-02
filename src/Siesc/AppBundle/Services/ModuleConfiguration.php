<?php
namespace Siesc\AppBundle\Services;


use Symfony\Bundle\TwigBundle\TwigEngine;

class ModuleConfiguration
{

    const SERVICES_TEMPLATE = "SiescAppBundle:Modules:chooseModule.html.twig";

    static $modulesData = array(
        'data' => array(
            'logo' => 'bundles/siescapp/images/siesc-data.png',
            'route' => 'data_index',
            'name' => 'SIESC Data'
        ),
        'partes' => array(
            'logo' => 'bundles/siescapp/images/siesc-partes.png',
            'route' => 'partes_index',
            'name' => 'SIESC Partes'
        ),
        'academico' => array(
            'logo' => 'bundles/siescapp/images/siesc-academico.png',
            'route' => 'siesc_academico_default_index',
            'name' => 'SIESC Academico'
        )
    );

    private $enabledModules;
    private $templater;

    public function __construct(TwigEngine $templater, array $modules = array())
    {
        $this->templater = $templater;
        $this->enabledModules = $modules;
    }

    public function renderAvailableServices($template = null)
    {
        if (!isset($template)) {
            $template = self::SERVICES_TEMPLATE;
        }

        return $this->templater->renderResponse($template, array('modules' => $this->getDataForAvailableModules()));
    }

    private function getDataForAvailableModules()
    {
        return array_intersect_key(self::$modulesData, array_flip($this->enabledModules));
    }

}