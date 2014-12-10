<?php

namespace Siesc\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Siesc\GeneratorBundle\Controller\AdminResourceController as BaseController;
use Siesc\AppBundle\Factory\DocenteFactory;
use Siesc\DataBundle\Form\App\DocenteType;

class DocenteController extends BaseController
{
    public function __construct()
    {
        $this->setFormType(new DocenteType());
        $this->setRoutingPrefix('siesc_docente');
        $this->setResourceName('Docente');
        $this->setTemplatesRoot('SiescAdminBundle:Docente');
        $this->setFactory(new DocenteFactory());
        $this->setRepository('SiescAppBundle:Docente');
    }
    /**
     * Deletes a Docente entity.
     */
    public function deleteAction(Request $request, $id)
    {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SiescAppBundle:Docente')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Docente entity.');
            }

            $em->remove($entity);
            $em->flush();

        return $this->redirect($this->generateUrl('siesc_user_index'));
    }

}
