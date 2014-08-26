<?php

namespace Siesc\AcademicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SiescAcademicoBundle:Default:index.html.twig', array('name' => $name));
    }
}
