<?php

namespace Siesc\PartesBundle\Controller;


use Siesc\GeneratorBundle\Controller\AdminResourceController;
use Siesc\PartesBundle\CierreNovedadTransitions;
use Siesc\PartesBundle\Entity\CierreNovedades;
use Siesc\PartesBundle\Factory\CierreNovedadesFactory;
use Siesc\PartesBundle\Factory\NovedadFactory;
use Siesc\PartesBundle\NovedadTransitions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CierreNovedadesController extends AdminResourceController
{
    public function __construct()
    {
        $this->setRoutingPrefix('partes_cierre_novedades');
        $this->setResourceName('Cierre Novedades');
        $this->setTemplatesRoot('SiescWebBundle:Partes/CierreNovedades');
        $this->setRepository('SiescPartesBundle:CierreNovedades');
        $this->setFactory(new CierreNovedadesFactory());
    }

    public function newAction(Request $request)
    {
        /** @var CierreNovedades $cierre */
        $cierre = $this->getFactory()->createNew();
        $cierre->setEncargado($this->getUser());
        $cierre->setFechaCierre(new \DateTime());
        $em = $this->get('doctrine.orm.entity_manager');

        $em->persist($cierre);
        $em->flush();
        $this->setFlash('success', 'create');

        return $this->redirectToResource($cierre);
    }

    public function showAction(Request $request)
    {
        $entity = $this->findOr404($request);

        return $this->render(sprintf('%s:show.html.twig', $this->templatesRoot), array(
            'entity' => $entity,
            'novedades' => $this->getDoctrine()->getRepository('SiescPartesBundle:Novedad')->findBy(array(
                    'cierre' => null,
                    'estado' => 'autorizada'
                ))
        ));
    }

    public function liquidarNovedadAction(Request $request)
    {
        /** @var CierreNovedades $cierre */
        $cierre = $this->findOr404($request);
        $novedad = $this->findNovedadOr404($request->get('novedad_id'));

        if ($cierre->hasNovedad($novedad)) {
            $transitions = $this->get('sm.factory')->get($novedad, NovedadTransitions::GRAPH);
            $transitions->apply('generar_reporte');
            // aplicamos el cambio al cierre
            $this->get('sm.factory')->get($cierre, CierreNovedadTransitions::GRAPH)->apply('liquidar_parcialmente');
            // guardamos los cambios
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getBag('flashes')->add('success', 'La novedad fue liquidada correctamente.');

        }

        return $this->redirectToResource($cierre);
    }
    public function liquidarNovedadesAction(Request $request)
    {
        /** @var CierreNovedades $cierre */
        $cierre = $this->findOr404($request);
        foreach($cierre->getNovedades() as $novedad) {
            $transitions = $this->get('sm.factory')->get($novedad, NovedadTransitions::GRAPH);
            if ($transitions->can('generar_reporte')) {
                $transitions->apply('generar_reporte');
            }
        }
        // aplicamos el cambio al cierre
        $this->get('sm.factory')->get($cierre, CierreNovedadTransitions::GRAPH)->apply('liquidar_totalmente');
        // guardamos los cambios
        $this->getDoctrine()->getManager()->flush();
        $this->get('session')->getBag('flashes')->add('success', 'Todas las novedades del reporte fueron liquidadas correctamente.');

        return $this->redirectToResource($cierre);
    }

    public function addNovedadAction(Request $request)
    {
        /** @var CierreNovedades $cierre */
        $cierre = $this->findOr404($request);
        $novedad = $this->findNovedadOr404($request->get('novedad_id'));

        $cierre->addNovedad($novedad);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('SiescWebBundle:Partes/CierreNovedades:novedadesList.html.twig', array(
            'novedades' => $cierre->getNovedades(),
            'type' => 'remove'
        ));
    }

    public function removeNovedadAction(Request $request)
    {
        /** @var CierreNovedades $cierre */
        $cierre = $this->findOr404($request);
        $novedad = $this->findNovedadOr404($request->get('novedad_id'));

        $cierre->removeNovedad($novedad);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('SiescWebBundle:Partes/CierreNovedades:novedadesList.html.twig', array(
            'novedades' => $this->getDoctrine()->getRepository('SiescPartesBundle:Novedad')->findBy(array(
                    'cierre' => null,
                    'estado' => 'autorizada'
                )),
            'type' => 'add'
        ));

    }

    private function findNovedadOr404($id)
    {
        $novedad = $this->getDoctrine()->getRepository('SiescPartesBundle:Novedad')
            ->findOneBy(array('id' => $id, 'estado' => 'autorizada'));

        if (!$novedad) {
            throw $this->createNotFoundException(sprintf('Unable to find %s entity.', 'novedad'));
        }

        return $novedad;
    }
}
