<?php

namespace Siesc\PartesBundle\Controller;


use Siesc\GeneratorBundle\Controller\AdminResourceController;
use Siesc\PartesBundle\Factory\NovedadFactory;
use Siesc\PartesBundle\Form\NovedadType;
use Siesc\PartesBundle\NovedadTransitions;
use Siesc\PartesBundle\Security\ActionNotAllowedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NovedadesController extends AdminResourceController
{
    public function __construct()
    {
        $this->setFormType('siesc_partes_novedad_form');
        $this->setRoutingPrefix('partes_novedad');
        $this->setResourceName('Novedades');
        $this->setTemplatesRoot('SiescWebBundle:Partes/Novedad');
        $this->setFactory(new NovedadFactory());
        $this->setRepository('SiescPartesBundle:Novedad');
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        if (!$this->isGranted('ROLE_PARTES_RL')) {
            // mostrar solo las del secretario
            $entities = $this->getRepository()->findBy(array('secretario' => $this->getUser()), array('fechaDesde' => 'DESC'));
        } else {
            $entities = $this->getRepository()->findBy(array(), array('createdAt' => 'DESC'));
        }

        return $this->render(sprintf('%s:index.html.twig', $this->templatesRoot), array(
            'entities' => $entities,
            'estados' => NovedadTransitions::$estados
        ));
    }

    public function showAction(Request $request)
    {
        $entity = $this->findOr404($request);

        if ($request->isXmlHttpRequest()) {
            $template = sprintf('%s:_show.html.twig', $this->templatesRoot);
        } else {
            $template = sprintf('%s:show.html.twig', $this->templatesRoot);
        }

        return $this->render($template, array(
            'entity' => $entity,
            'transitions' => $this->get('sm.factory')->get($entity, 'partes_novedad')->getPossibleTransitions()
        ));
    }

    public function editAction(Request $request)
    {
        $novedad = $this->findOr404($request);
        $this->checkAcces($novedad, 'EDITAR');

        return parent::editAction($request);
    }

    public function cambiarEstadoAction(Request $request)
    {
        $novedad = $this->findOr404($request);
        $this->checkAcces($novedad, 'AUTORIZAR');

        $accion = $request->get('accion');
        $transitions = $this->get('sm.factory')->get($novedad, NovedadTransitions::GRAPH);

        if( in_array($accion, $transitions->getPossibleTransitions()) and $transitions->can($accion)) {
            $transitions->apply($accion);
            $this->getDoctrine()->getManager()->flush();
            $this->setFlash('success', 'change_state', array('%accion%' => $accion));

        } else {
            $this->setFlash('danger', 'change_state_error', array('%accion%' => $accion));
        }

        return $this->redirectToResource($novedad);
    }
} 