<?php

namespace Siesc\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tahoe\Bundle\MultiTenancyBundle\Model\TenantAwareInterface;
use Tahoe\Bundle\MultiTenancyBundle\Model\TenantTrait;


/**
 *
 * Class Notificacion
 * @ORM\MappedSuperclass
 * @ORM\Entity(repositoryClass="Siesc\AppBundle\Entity\Repository\NotificacionRepository")
 * @ORM\Table(name="app_notificacion")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 * "novedad" = "NotificacionNovedad",
 * })
 *
 */
class Notificacion implements TenantAwareInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mensaje", type="text")
     */
    protected $mensaje;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    protected $fecha;

    /**
     * @var Docente
     *
     * @ORM\ManyToOne(targetEntity="Siesc\AppBundle\Entity\Docente")
     */
    protected $destinatario;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $leida;
    
    /**
     * @var MultiTenantTenantInterface
     *
     * @ORM\ManyToOne(targetEntity="Siesc\AppBundle\Entity\Tenant")
     */
    protected $tenant;

    public function __construct()
    {
        $this->leida = false;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mensaje
     *
     * @param string $mensaje
     * @return Notificacion
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get mensaje
     *
     * @return string 
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Notificacion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \Siesc\AppBundle\Entity\Docente $destinatario
     *
     * @return $this
     */
    public function setDestinatario($destinatario)
    {
        $this->destinatario = $destinatario;
        return $this;
    }

    /**
     * @return \Siesc\AppBundle\Entity\Docente
     */
    public function getDestinatario()
    {
        return $this->destinatario;
    }

    /**
     * @param boolean $leida
     *
     * @return $this
     */
    public function setLeida($leida)
    {
        $this->leida = $leida;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getLeida()
    {
        return $this->leida;
    }

    /**
     * @return $this
     */
    public function marcarComoLeida()
    {
        $this->setLeida(true);

        return $this;
    }
                                
    /**
     * @return Siesc\AppBundle\Entity\Tenant
     */
    public function getTenant()
    {
        return $this->tenant;
    }

    /**
     * @param Siesc\AppBundle\Entity\Tenant $tenant
     *
     * @return $this
     */
    public function setTenant($tenant)
    {
        $this->tenant = $tenant;

        return $this;
    }
}
