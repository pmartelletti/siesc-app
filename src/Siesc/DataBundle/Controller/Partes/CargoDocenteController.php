<?php

namespace Siesc\DataBundle\Controller\Partes;

use Siesc\GeneratorBundle\Controller\AdminResourceController as BaseController;
use Siesc\PartesBundle\Factory\CargoDocenteFactory;
use Siesc\DataBundle\Form\Partes\CargoDocenteType;

class CargoDocenteController extends BaseController
{

    public function __construct()
    {
        $this->setFormType(new CargoDocenteType());
        $this->setRoutingPrefix('data_partes_cargo_docente');
        $this->setResourceName('Cargo Docente');
        $this->setTemplatesRoot('SiescWebBundle:Data/Partes/CargoDocente');
        $this->setFactory(new CargoDocenteFactory());
        $this->setRepository('SiescPartesBundle:CargoDocente');
    }


}
