<?php

namespace Siesc\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Siesc\AppBundle\Entity\User;
use Siesc\AppBundle\Entity\Tenant;

class HomeController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
 
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
 
        return $this->render(
            'SiescAdminBundle:Home:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }
    
    public function homeAction()
    {
        $em     = $this->getDoctrine()->getManager();
        $user   = $em->getRepository('SiescAppBundle:User')->findAll();
        $tenant = $em->getRepository('SiescAppBundle:Tenant')->findAll();
        return $this->render('SiescAdminBundle:Home:home.html.twig', ['user'=>$user, 'tenant'=>$tenant]);
    }
}
