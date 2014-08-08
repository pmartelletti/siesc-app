<?php

namespace Siesc\DataBundle\Controller\Partes;

use Siesc\GeneratorBundle\Controller\AdminResourceController as BaseController;
use Siesc\PartesBundle\Entity\Convenio;
use Siesc\PartesBundle\Factory\ConvenioFactory;
use Siesc\DataBundle\Form\Partes\ConvenioType;
use Siesc\WebBundle\Helper\FormHelper;
use Siesc\WebBundle\Helper\JsonHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvenioController extends BaseController
{

    public function __construct()
    {
        $this->setFormType(new ConvenioType());
        $this->setRoutingPrefix('data_partes_convenio');
        $this->setResourceName('Convenio');
        $this->setTemplatesRoot('SiescWebBundle:Data/Partes/Convenio');
        $this->setFactory(new ConvenioFactory());
        $this->setRepository('SiescPartesBundle:Convenio');
    }

    public function getCargosAction(Request $request)
    {
        /** @var Convenio $convenio */
        $convenio = $this->findOr404($request);

        return new Response(
            FormHelper::collectionToOptions($convenio->getCargos(), true)
        );
    }


}
