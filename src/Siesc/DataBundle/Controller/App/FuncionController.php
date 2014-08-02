<?php

namespace Siesc\DataBundle\Controller\App;

use Siesc\GeneratorBundle\Controller\AdminResourceController as BaseController;
use Siesc\AppBundle\Factory\FuncionFactory;
use Siesc\DataBundle\Form\App\FuncionType;

class FuncionController extends BaseController
{

    public function __construct()
    {
        $this->setFormType(new FuncionType());
        $this->setRoutingPrefix('data_app_funcion');
        $this->setResourceName('Funcion');
        $this->setTemplatesRoot('SiescWebBundle:Data/App/Funcion');
        $this->setFactory(new FuncionFactory());
        $this->setRepository('SiescAppBundle:Funcion');
    }


}
