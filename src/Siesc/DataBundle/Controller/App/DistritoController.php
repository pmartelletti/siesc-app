<?php

namespace Siesc\DataBundle\Controller\App;

use Siesc\GeneratorBundle\Controller\AdminResourceController as BaseController;
use Siesc\AppBundle\Factory\DistritoFactory;
use Siesc\DataBundle\Form\App\DistritoType;

class DistritoController extends BaseController
{

    public function __construct()
    {
        $this->setFormType(new DistritoType());
        $this->setRoutingPrefix('data_app_distrito');
        $this->setResourceName('Distrito');
        $this->setTemplatesRoot('SiescWebBundle:Data/App/Distrito');
        $this->setFactory(new DistritoFactory());
        $this->setRepository('SiescAppBundle:Distrito');
    }


}
