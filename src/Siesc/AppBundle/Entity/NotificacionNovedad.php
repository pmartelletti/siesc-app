<?php
namespace Siesc\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Siesc\PartesBundle\Entity\Novedad;

/**
 * Class NotificacionNovedad
 * @ORM\Entity
 *
 */
class NotificacionNovedad extends Notificacion
{
    /**
     * @var Docente
     *
     * @ORM\ManyToOne(targetEntity="Siesc\AppBundle\Entity\Docente")
     */
    private $encargado;


    /**
     * @var Novedad
     * @ORM\ManyToOne(targetEntity="Siesc\PartesBundle\Entity\Novedad", inversedBy="eventos", cascade={"all"})
     */
    private $novedad;

    /**
     * @param \Siesc\AppBundle\Entity\Docente $encargado
     *
     * @return $this
     */
    public function setEncargado($encargado)
    {
        $this->encargado = $encargado;
        return $this;
    }

    /**
     * @return \Siesc\AppBundle\Entity\Docente
     */
    public function getEncargado()
    {
        return $this->encargado;
    }

    /**
     * @param mixed $novedad
     *
     * @return $this
     */
    public function setNovedad($novedad)
    {
        $this->novedad = $novedad;
        return $this;
    }

    /**
     * @return Novedad
     */
    public function getNovedad()
    {
        return $this->novedad;
    }
}
