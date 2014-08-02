<?php

namespace Siesc\DataBundle\Controller\Partes;

use Siesc\GeneratorBundle\Controller\AdminResourceController as BaseController;
use Siesc\PartesBundle\Factory\CategoriaFactory;
use Siesc\DataBundle\Form\Partes\CategoriaType;

class CategoriaController extends BaseController
{

    public function __construct()
    {
        $this->setFormType(new CategoriaType());
        $this->setRoutingPrefix('data_partes_categoria');
        $this->setResourceName('Categoria');
        $this->setTemplatesRoot('SiescWebBundle:Data/Partes/Categoria');
        $this->setFactory(new CategoriaFactory());
        $this->setRepository('SiescPartesBundle:Categoria');
    }


}
