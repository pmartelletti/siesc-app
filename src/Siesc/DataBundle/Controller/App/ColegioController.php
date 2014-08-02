<?php

namespace Siesc\DataBundle\Controller\App;

use Siesc\GeneratorBundle\Controller\AdminResourceController as BaseController;
use Siesc\AppBundle\Factory\ColegioFactory;
use Siesc\DataBundle\Form\App\ColegioType;

class ColegioController extends BaseController
{

    public function __construct()
    {
        $this->setFormType(new ColegioType());
        $this->setRoutingPrefix('data_app_colegio');
        $this->setResourceName('Colegio');
        $this->setTemplatesRoot('SiescWebBundle:Data/App/Colegio');
        $this->setFactory(new ColegioFactory());
        $this->setRepository('SiescAppBundle:Colegio');
    }


}
