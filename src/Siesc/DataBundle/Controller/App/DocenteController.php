<?php

namespace Siesc\DataBundle\Controller\App;

use Siesc\GeneratorBundle\Controller\AdminResourceController as BaseController;
use Siesc\AppBundle\Factory\DocenteFactory;
use Siesc\DataBundle\Form\App\DocenteType;

class DocenteController extends BaseController
{

    public function __construct()
    {
        $this->setFormType(new DocenteType());
        $this->setRoutingPrefix('data_app_docente');
        $this->setResourceName('Docente');
        $this->setTemplatesRoot('SiescWebBundle:Data/App/Docente');
        $this->setFactory(new DocenteFactory());
        $this->setRepository('SiescAppBundle:Docente');
    }


}
