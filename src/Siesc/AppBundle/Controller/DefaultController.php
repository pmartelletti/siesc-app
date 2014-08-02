<?php

namespace Siesc\AppBundle\Controller;

use Siesc\AppBundle\Entity\Notificacion;
use Siesc\AppBundle\Entity\NotificacionNovedad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->get('siesc_app.module_enabler')->renderAvailableServices();
    }

    public function userNotificacionsAction($max = 5)
    {
        $repo = $this->getDoctrine()->getRepository('SiescAppBundle:Notificacion');
        $unreads = $repo->findUnreadsForUser($this->getUser());
        $limit = max($unreads, $max);
        $notificaciones = $repo->findByDestinatario($this->getUser(), array('fecha' => 'DESC'), $limit);

        return $this->render('SiescWebBundle:Widgets:notificaciones_menu.html.twig', array(
            'notificaciones' => $notificaciones,
            'unreads' => $unreads
        ));
    }


    /**
     * @param Notificacion $notificacion
     * @ParamConverter("notificacion", class="SiescAppBundle:Notificacion")
     */
    public function readNotificationAction(Notificacion $notificacion)
    {
        $notificacion->marcarComoLeida();
        // we flush the changes
        $this->get('doctrine.orm.entity_manager')->flush();

        // we redirect to the correspondant URL
        if ($notificacion instanceof NotificacionNovedad)
        {
            return $this->redirect($this->generateUrl('partes_novedad_show', array(
                'id' => $notificacion->getNovedad()->getId()
            )) . "#notificacion-" . $notificacion->getId());
        }
        // we go back to the page where they click
        return $this->redirect($this->get('request')->headers->get('referer'));
    }
}
