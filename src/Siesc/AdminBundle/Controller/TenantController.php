<?php

namespace Siesc\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Siesc\GeneratorBundle\Controller\AdminResourceController as BaseController;
use Siesc\AppBundle\Factory\TenantFactory;
use Siesc\DataBundle\Form\App\TenantType;

class TenantController extends BaseController
{
    public function __construct()
    {
        $this->setFormType(new TenantType());
        $this->setRoutingPrefix('siesc_tenant');
        $this->setResourceName('Tenant');
        $this->setTemplatesRoot('SiescAdminBundle:Tenant');
        $this->setFactory(new TenantFactory());
        $this->setRepository('SiescAppBundle:Tenant');
    }
    
    /**
     * Deletes a Docente entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SiescAppBundle:Tenant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Docente entity.');
        }

        $em->remove($entity);
        $em->flush();
       
        return $this->redirect($this->generateUrl('siesc_tenant'));
    }
}
