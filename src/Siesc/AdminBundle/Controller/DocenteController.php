<?php

namespace Siesc\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Siesc\AppBundle\Entity\Docente;
use Siesc\DataBundle\Form\App\DocenteType;

class DocenteController extends Controller
{
    /**
     * Creates a new Docente entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Docente();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $tempPassword = md5(uniqid());
            $entity->setPlainPassword($tempPassword);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('siesc_docente_edit', array('id' => $entity->getId())));
        }

        return $this->render('SiescAdminBundle:Docente:new.html.twig', ['entity' => $entity, 'form'   => $form->createView()]);
    }

    /**
    * Creates a form to create a Docente entity.
    *
    * @param Docente $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Docente $entity)
    {
        $form = $this->createForm(new DocenteType(), $entity, array(
            'action' => $this->generateUrl('siesc_docente_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Docente entity.
     *
     */
    public function newAction()
    {
        $entity = new Docente();
        $form   = $this->createCreateForm($entity);

        return $this->render('SiescAdminBundle:Docente:new.html.twig', ['entity' => $entity, 'form'   => $form->createView()]);
    }

    /**
     * Finds and displays a Docente entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiescAppBundle:Docente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SiescAdminBundle:Docente:show.html.twig', ['entity' => $entity, 'delete_form' => $deleteForm->createView()]);
    }

    /**
     * Displays a form to edit an existing Docente entity.
     *
     */
    public function editAction($id)
    {
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiescAppBundle:Docente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docente entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SiescAdminBundle:Docente:edit.html.twig', ['entity' => $entity, 'edit_form'   => $editForm->createView(), 'delete_form' => $deleteForm->createView()]);
    }

    /**
    * Creates a form to edit a Docente entity.
    *
    * @param Docente $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Docente $entity)
    {

        $form = $this->createForm(new DocenteType(), $entity, array(
            'action' => $this->generateUrl('siesc_docente_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Docente entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiescAppBundle:Docente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('siesc_docente_edit', array('id' => $id)));
        }

        return $this->render('SiescAdminBundle:Docente:edit.html.twig', ['entity' => $entity, 'edit_form'   => $editForm->createView(), 'delete_form' => $deleteForm->createView()]);
    }
    /**
     * Deletes a Docente entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SiescAppBundle:Docente')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Docente entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('siesc_user_index'));
    }

    /**
     * Creates a form to delete a Docente entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('siesc_docente_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
