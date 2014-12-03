<?php

namespace Siesc\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Siesc\AppBundle\Entity\Tenant;
use Siesc\DataBundle\Form\App\TenantType;

class TenantController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('SiescAppBundle:Tenant')->findAll(); 
        
        return $this->render('SiescAdminBundle:Tenant:index.html.twig', ['entities'=>$entities]);
    }
    
    /**
     * Creates a new Tenant entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Tenant();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('siesc_tenant_edit', array('id' => $entity->getId())));
        }

        return $this->render('SiescAdminBundle:Tenant:new.html.twig', ['entity' => $entity, 'form'   => $form->createView()]);
    }

    /**
    * Creates a form to create a Tenant entity.
    *
    * @param Tenant $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Tenant $entity)
    {
        $form = $this->createForm(new TenantType(), $entity, array(
            'action' => $this->generateUrl('siesc_tenant_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Tenant entity.
     *
     */
    public function newAction()
    {
        $entity = new Tenant();
        $form   = $this->createCreateForm($entity);

        return $this->render('SiescAdminBundle:Tenant:new.html.twig', ['entity' => $entity, 'form'   => $form->createView()]);
    }

    /**
     * Finds and displays a Tenant entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiescAppBundle:Tenant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tenant entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SiescAdminBundle:Tenant:show.html.twig', ['entity' => $entity, 'delete_form' => $deleteForm->createView()]);
    }

    /**
     * Displays a form to edit an existing Tenant entity.
     *
     */
    public function editAction($id)
    {
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiescAppBundle:Tenant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tenant entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SiescAdminBundle:Tenant:edit.html.twig', ['entity' => $entity, 'edit_form'   => $editForm->createView(), 'delete_form' => $deleteForm->createView()]);
    }

    /**
    * Creates a form to edit a Tenant entity.
    *
    * @param Tenant $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Tenant $entity)
    {

        $form = $this->createForm(new TenantType(), $entity, array(
            'action' => $this->generateUrl('siesc_tenant_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Tenant entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiescAppBundle:Tenant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tenant entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('siesc_tenant_edit', array('id' => $id)));
        }

        return $this->render('SiescAdminBundle:Tenant:edit.html.twig', ['entity' => $entity, 'edit_form'   => $editForm->createView(), 'delete_form' => $deleteForm->createView()]);
    }
    /**
     * Deletes a Tenant entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SiescAppBundle:Tenant')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tenant entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('siesc_tenant_index'));
    }

    /**
     * Creates a form to delete a Tenant entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('siesc_tenant_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
