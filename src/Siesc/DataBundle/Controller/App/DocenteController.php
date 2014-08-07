<?php

namespace Siesc\DataBundle\Controller\App;

use Siesc\AppBundle\Entity\Docente;
use Siesc\DataBundle\Form\App\DocenteImportType;
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

    public function importDocentesAction(Request $request)
    {
        $importForm = $this->createForm(new DocenteImportType());
        $importForm->handleRequest($request);

        if ($importForm->isValid()) {
            $result = $this->get('siesc_data.manager.docente_import')->processUploadedFile($importForm->get('file')->getData());

            $this->get('session')->getBag('flashes')->add('success',
                sprintf('Se han cargado %d docentes correctamente.', $result['ok'])
            );

            foreach($result['errores'] as $error) {
                $data = $error['data'];
                if (isset($data['APELLIDO'])) {
                    $this->get('session')->getBag('flashes')->add('danger',
                        sprintf('%s. La columna del docente %s, %s ha sigo ignorada.', $error['error'], $data['APELLIDO'], $data['NOMBRE'] )
                    );
                } else {
                    $this->get('session')->getBag('flashes')->add('danger',
                        sprintf('Error al procesar el archivo. Verifique que sea un archivo CSV separado por comas.')
                    );
                    break;
                }
            }

            return $this->redirectToIndex();
        }

        return $this->render(sprintf('%s:import.html.twig', $this->templatesRoot), array(
            'form' => $importForm->createView()
        ));
    }

    public function sendCredentialsEmailAction(Request $request)
    {
        /** @var Docente $docente */
        $docente = $this->findOr404($request);
        if (strpos($docente->getEmail(), '@siesc.com.ar')) {
            $this->get('session')->getBag('flashes')->add('danger', 'Debe modificar el mail del usuario antes de poder enviarle sus credenciales.');

            return $this->redirectToResource($docente);
        }
        $tempPassword = md5(uniqid());
        $docente->setPlainPassword($tempPassword);
        $this->get('fos_user.user_manager')->updatePassword($docente);

        $this->get('doctrine.orm.entity_manager')->flush();

        $this->get('siesc_app.mailer.docente')->sendCredentialsEmail($docente, $tempPassword);

        $this->get('session')->getBag('flashes')->add('success', 'Las credencial del usuario se enviaron con exito.');

        return $this->redirect($this->generateUrl('data_app_docente_show', array('id' => $docente->getId())));

    }
}
