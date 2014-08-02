<?php

namespace Siesc\DataBundle\Controller\Partes;

use Siesc\GeneratorBundle\Controller\AdminResourceController as BaseController;
use Siesc\PartesBundle\Factory\SituacionRevistaFactory;
use Siesc\DataBundle\Form\Partes\SituacionRevistaType;

class SituacionRevistaController extends BaseController
{

    public function __construct()
    {
        $this->setFormType(new SituacionRevistaType());
        $this->setRoutingPrefix('data_partes_situacion_revista');
        $this->setResourceName('Situacion Revista');
        $this->setTemplatesRoot('SiescWebBundle:Data/Partes/SituacionRevista');
        $this->setFactory(new SituacionRevistaFactory());
        $this->setRepository('SiescPartesBundle:SituacionRevista');
    }


}
