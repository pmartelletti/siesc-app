<?php

namespace Siesc\PartesBundle\Twig;


use Siesc\PartesBundle\NovedadTransitions;

class TransitionsExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('siesc_transition_button', array($this, 'transitionButton'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('siesc_estado_button', array($this, 'estadoButton'), array('is_safe' => array('html'))),
        );
    }

    public function estadoButton($estado) {
        $text = ucwords(implode(' ', explode('_', $estado)));
        $color = 'info';
        // cambiar los estados por algo de color
        switch($estado) {
            case 'autorizada':
                $color = 'primary';
                break;
            case 'liquidada':
                $color = 'success';
                break;
            case 'rechazada':
                $color = 'danger';
                break;
            case 'pendiente_cambios':
            case 'desautorizada':
                $color = 'warning';
                break;
        }

        return sprintf('<div class="label label-%s pull-right">%s</div>', $color, $text);
    }

    public function transitionButton($transition, $route)
    {
        $button = '<a href="%s" class="btn btn-%s"><i class="icon-checkbox-partial"></i> %s</a>';
        $text = ucwords(implode(' ', explode('_', $transition)));
        switch($transition){
            case NovedadTransitions::SIESC_AUTORIZAR:
            case NovedadTransitions::SIESC_GENERAR_REPORTE:
            case NovedadTransitions::SIESC_PEDIR_CAMBIOS:
            case NovedadTransitions::SIESC_ENVIAR_CAMBIOS:
                $button = sprintf($button, $route, 'success', $text);
                break;
            case NovedadTransitions::SIESC_RECHAZAR:
            case NovedadTransitions::SIESC_DESAUTORIZAR:
                $button = sprintf($button, $route, 'danger', $text);
                break;
        }

        return $button;
    }

    public function getName()
    {
        return 'siesc_transitions_extension';
    }
} 