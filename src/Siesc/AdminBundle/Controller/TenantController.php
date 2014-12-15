<?php

namespace Siesc\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Siesc\GeneratorBundle\Controller\AdminResourceController as BaseController;
use Siesc\AppBundle\Factory\TenantFactory;
use Siesc\DataBundle\Form\App\TenantType;
use Tahoe\Bundle\MultiTenancyBundle\Entity\TenantUser;
use Siesc\AppBundle\Entity\User;
use Tahoe\Bundle\MultiTenancyBundle\Handler\TenantUserHandler;
use Tahoe\Bundle\MultiTenancyBundle\Factory\TenantUserFactory;

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
    
    /**
     * get user by tenant  
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function userTenantAction(Request $request, $id)
    {
        $em         = $this->getDoctrine();
        $repository = $em->getRepository('SiescAppBundle:User');
        $tenant     = $em->getRepository('SiescAppBundle:Tenant')->findOneById($id);
        $user       = [];
        
        $query = $this->getDoctrine()->getManager()->createQuery(
            'SELECT u.id AS user_id
               FROM TahoeMultiTenancyBundle:TenantUser tu
               JOIN tu.user u
              WHERE tu.tenant = :id AND (tu.roles LIKE :role_1 OR tu.roles LIKE :role_2 )'
        )->setParameter('id', $id)
        ->setParameter('role_1', '%"ROLE_SUPER_ADMIN"%')
        ->setParameter('role_2', '%"ROLE_ADMIN_DATA"%');
        
        $tenant_query = $query->getResult();
        
        foreach ($tenant_query AS $tu){
            $user[] = $tu['user_id'];    
        }
        
        $query_user = $repository->getUserInTenant($user);
        
        $user_not_tenat = $repository->getUserNotInTenant($user);
         
        return $this->render('SiescAdminBundle:Tenant:user_tenant.html.twig',['user_tenant'=>$query_user, 'user_not_tenat'=>$user_not_tenat, 'tenant'=>$tenant]);
    }

    public function docentesAction(Request $request, $id)
    {
        $tenant = $this->findOr404($request);
        $docentes = $this->get('doctrine.orm.entity_manager')->getRepository('SiescAppBundle:Docente')->findForTenant($tenant);

        return $this->render('@SiescAdmin/Tenant/docentes.html.twig',[
            'docentes' => $docentes
        ]);
    }

    public function alumnosAction(Request $request, $id)
    {

    }
    
    public function addUserTenantAction(Request $request, $id_tenant, $id_user)
    {
        $em          = $this->getDoctrine()->getManager();
        $user        = $em->getRepository('SiescAppBundle:User')->findOneById($id_user);
        $tenant      = $em->getRepository('SiescAppBundle:Tenant')->findOneById($id_tenant);
        $tenant_user = $em->getRepository('TahoeMultiTenancyBundle:TenantUser');
        
        $is_tenant_user = $tenant_user->findOneBy(array('tenant' => $tenant,'user' => $user));
        
        if(!$is_tenant_user){
            $tenant_user_handler = new TenantUserHandler($em, new TenantUserFactory(), $tenant_user);
            $tenant_user_handler->addUserToTenant($user, $tenant);
            $em->flush();
            foreach ($user->getRoles() AS $r){
                $tenant_user_handler->addRoleToUserInTenant($r, $user, $tenant);
            }        
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Se agregó el usuario a la organización');
        }else{
            $this->get('session')->getFlashBag()->add('notice', 'El usuario ya existe en la organización');
        }
        return $this->redirect($this->generateUrl('siesc_tenant_user_tenant',['id'=>$id_tenant]));
    }    
    
    
    public function deleteUserTenantAction(Request $request, $id_tenant, $id_user)
    {
        $em          = $this->getDoctrine()->getManager();
        $user        = $em->getRepository('SiescAppBundle:User')->findOneById($id_user);
        $tenant      = $em->getRepository('SiescAppBundle:Tenant')->findOneById($id_tenant);
        $tenant_user = $em->getRepository('TahoeMultiTenancyBundle:TenantUser');
        
        $is_tenant_user = $tenant_user->findOneBy(array('tenant' => $tenant,'user' => $user));
         if($is_tenant_user){
            $tenant_user_handler = new TenantUserHandler($em, new TenantUserFactory(), $tenant_user);
            $tenant_user_handler->removeUserFromTenant($user, $tenant);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Se elimino el usuario a la organización');
        }else{
            $this->get('session')->getFlashBag()->add('notice', 'El usuario no existe en la organización');
        }
        return $this->redirect($this->generateUrl('siesc_tenant_user_tenant',['id'=>$id_tenant]));
    }
    
}
