<?php

namespace Siesc\DataBundle\Controller\Partes;

use Siesc\GeneratorBundle\Controller\AdminResourceController as BaseController;
use Siesc\PartesBundle\Factory\TipoNovedadFactory;
use Siesc\DataBundle\Form\Partes\TipoNovedadType;

class TipoNovedadController extends BaseController
{

    public function __construct()
    {
        $this->setFormType(new TipoNovedadType());
        $this->setRoutingPrefix('data_partes_tipo_novedad');
        $this->setResourceName('Tipo Novedad');
        $this->setTemplatesRoot('SiescWebBundle:Data/Partes/TipoNovedad');
        $this->setFactory(new TipoNovedadFactory());
        $this->setRepository('SiescPartesBundle:TipoNovedad');
    }


}
