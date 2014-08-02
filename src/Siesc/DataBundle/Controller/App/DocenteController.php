<?php

namespace Siesc\DataBundle\Controller\App;

use Siesc\AppBundle\Entity\Docente;
use Siesc\GeneratorBundle\Controller\AdminResourceController as BaseController;
use Siesc\AppBundle\Factory\DocenteFactory;
use Siesc\DataBundle\Form\App\DocenteType;
use Symfony\Component\HttpFoundation\Request;

class DocenteController extends BaseController
{

    public function __construct()
    {
        $this->setFormType(new DocenteType());
        $this->setRoutingPrefix('data_app_docente');
        $this->setResourceName('Docente');
        $this->setTemplatesRoot('SiescWebBundle:Data/App/Docente');
        $this->setFactory(new DocenteFactory());
        $this->setRepository('SiescAppBundle:Docente');
    }

    public function sendCredentialsEmailAction(Request $request)
    {
        /** @var Docente $docente */
        $docente = $this->findOr404($request);
        $tempPassword = md5(uniqid());
        $docente->setPlainPassword($tempPassword);
        $this->get('fos_user.user_manager')->updatePassword($docente);

        $this->get('doctrine.orm.entity_manager')->flush();

        $this->get('siesc_app.mailer.docente')->sendCredentialsEmail($docente, $tempPassword);

        $this->get('session')->getBag('flashes')->add('success', 'Las credencial del usuario se enviaron con exito.');

        return $this->redirect($this->generateUrl('data_app_docente_show', array('id' => $docente->getId())));

    }
}
