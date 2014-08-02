<?php

namespace Siesc\PartesBundle\Controller;

use Siesc\PartesBundle\Form\PremiosAsistenciaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


/** @Route("/partes/estadisticas") */
class EstadisticasController extends Controller
{

    /**
     * @Route("/premiosasistencia")
     *@Template()
     */
    public function premiosAsistenciaAction(Request $request) {
        $form = $this->createForm(new PremiosAsistenciaType());

        $form->handleRequest($request);

        $results = null;
        if ($form->isValid()) {
            $data = $form->getData();
            $periodo = sprintf("%s - %s", $data['desde']->format("d-m-Y"), $data['hasta']->format('d-m-Y'));
            $seccion = $data['seccion'];
            // calculo los resultados aca
            $results = $this->get('siesc_partes.estadisticas.manager')->calcularPremioPorPeriodo($form->getData(), 450, 5);
        }

        return array(
            'form' => $form->createView(),
            'results' => $results,
            'periodo' => $periodo,
            'seccion' => $seccion
        );
    }

}
