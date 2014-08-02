<?php

namespace Siesc\PartesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Siesc\PartesBundle\Entity\ParteDiario;
use Siesc\PartesBundle\Form\ParteDiarioType;

/**
 * ParteDiario controller.
 *
 * @Route("/partes/partediario")
 */
class ParteDiarioController extends Controller
{

    /**
     * Lists all ParteDiario entities.
     *
     * @Route("/", name="partes_partediario")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        if($this->getRequest()->get('admin') and $this->get('security.context')->isGranted('ROLE_ADMIN_PARTES') ) {
            $entities = $em->getRepository('SiescPartesBundle:ParteDiario')->findAll();
        } else {
            $entities = $em->getRepository('SiescPartesBundle:ParteDiario')->findBySecretario($this->getUser());
        }

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ParteDiario entity.
     *
     * @Route("/", name="partes_partediario_create")
     * @Method("POST")
     * @Template("SiescPartesBundle:ParteDiario:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ParteDiario();
        $entity->setSecretario($this->getUser());
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('partes_partediario_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a ParteDiario entity.
    *
    * @param ParteDiario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ParteDiario $entity)
    {
        $form = $this->createForm(new ParteDiarioType(), $entity, array(
            'action' => $this->generateUrl('partes_partediario_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ParteDiario entity.
     *
     * @Route("/new", name="partes_partediario_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ParteDiario();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ParteDiario entity.
     *
     * @Route("/{id}", name="partes_partediario_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiescPartesBundle:ParteDiario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ParteDiario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ParteDiario entity.
     *
     * @Route("/{id}/edit", name="partes_partediario_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiescPartesBundle:ParteDiario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ParteDiario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a ParteDiario entity.
    *
    * @param ParteDiario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ParteDiario $entity)
    {

        $form = $this->createForm(new ParteDiarioType(), $entity, array(
            'action' => $this->generateUrl('partes_partediario_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ParteDiario entity.
     *
     * @Route("/{id}", name="partes_partediario_update")
     * @Method("PUT")
     * @Template("SiescPartesBundle:ParteDiario:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiescPartesBundle:ParteDiario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ParteDiario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('partes_partediario_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ParteDiario entity.
     *
     * @Route("/{id}", name="partes_partediario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SiescPartesBundle:ParteDiario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ParteDiario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('partes_partediario'));
    }

    /**
     * Creates a form to delete a ParteDiario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partes_partediario_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
