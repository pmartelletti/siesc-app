<?php

namespace Siesc\DataBundle\Controller\Partes;

use Siesc\GeneratorBundle\Controller\AdminResourceController as BaseController;
use Siesc\PartesBundle\Factory\CargoFactory;
use Siesc\DataBundle\Form\Partes\CargoType;

class CargoController extends BaseController
{

    public function __construct()
    {
        $this->setFormType(new CargoType());
        $this->setResourceName('Cargo');
        $this->setTemplatesRoot('SiescWebBundle:Data/Partes/Cargo');
        $this->setFactory(new CargoFactory());
        $this->setRepository('SiescPartesBundle:Cargo');
    }


}
