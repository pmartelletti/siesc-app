<?php

namespace Siesc\PartesBundle\Controller;

use Siesc\AppBundle\Entity\Notificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DashboardController extends Controller
{
    public function indexAction(Request $request)
    {

        return $this->render('SiescWebBundle:Partes/Dashboard:index.html.twig', array(
            'stats' => $this->get('siesc.partes.manager_novedad')->getDashboardStats(),
            'novedades_requeridas' => $this->get('siesc.partes.manager_novedad')->getNovedadesPendientes()
        ));
    }

    public function calculoSueldoAction(Request $request)
    {
        $region = $request->get('region');
        $frameSrc = $region == 'capital'  ? "https://docs.google.com/spreadsheets/d/1UpV64h0FXOpisbVJ3MlifVbUX64sog7ZQcfR9wtYNDI/edit?usp=sharing" :
            'https://docs.google.com/spreadsheets/d/14D0i1QA40xp3d1s8Rc36iDAPakt_L0n-jaR6yOWN2a0/edit?usp=sharing';

        return $this->render('SiescWebBundle:Partes/Dashboard:calculo_sueldo.html.twig', array('frameSrc' => $frameSrc));
    }
} 