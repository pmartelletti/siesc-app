<?php

namespace Siesc\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Siesc\AppBundle\Entity\User;
use Siesc\AppBundle\Entity\Docente;
use Siesc\AppBundle\Entity\Alumno;
//use Siesc\AppBundle\Form\TenantType;

class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $docentes = $em->getRepository('SiescAppBundle:Docente')->findAll(); 
        $alumnos = $em->getRepository('SiescAppBundle:Alumno')->findAll(); 
        
        return $this->render('SiescAdminBundle:User:index.html.twig', ['docentes'=>$docentes, 'alumnos'=>$alumnos]);
    }
}
