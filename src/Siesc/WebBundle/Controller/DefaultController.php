<?php

namespace Siesc\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SiescWebBundle:Default:index.html.twig', array('name' => $name));
    }
}
