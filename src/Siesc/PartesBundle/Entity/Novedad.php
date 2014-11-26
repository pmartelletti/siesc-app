<?php

namespace Siesc\PartesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Siesc\AppBundle\Entity\Docente;
use Siesc\AppBundle\Entity\NotificacionNovedad;
use Gedmo\Mapping\Annotation as Gedmo;
use Tahoe\Bundle\MultiTenancyBundle\Model\TenantAwareInterface;
use Tahoe\Bundle\MultiTenancyBundle\Model\TenantTrait;


/**
 * Novedad
 *
 * @ORM\Table(name="partes_novedad")
 * @ORM\Entity
 */
class Novedad implements TenantAwareInterface
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
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * Sets createdAt.
     *
     * @param  \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Returns createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets updatedAt.
     *
     * @param  \DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Returns updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @var Docente
     *
     * @ORM\ManyToOne(targetEntity="Siesc\AppBundle\Entity\Docente")
     */
    private $secretario;

    /**
     * @var TipoNovedad
     *
     * @ORM\ManyToOne(targetEntity="TipoNovedad")
     */
    private $tipo;

    /**
     * @var CargoDocente
     *
     * @ORM\ManyToOne(targetEntity="CargoDocente", fetch="EAGER", cascade={"all"})
     */
    private $cargoDocente;

    /**
     * @var SituacionRevista
     *
     * @ORM\ManyToOne(targetEntity="SituacionRevista")
     */
    private $revista;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaDesde", type="date")
     */
    private $fechaDesde;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaHasta", type="date")
     */
    private $fechaHasta;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text")
     */
    private $observaciones;

    /**
     * @var string
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     * @var CierreNovedades
     *
     * @ORM\ManyToOne(targetEntity="CierreNovedades", inversedBy="novedades", cascade={"all"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $cierre;

    /**
     * @var NotificacionNovedad[]
     * @ORM\OneToMany(targetEntity="Siesc\AppBundle\Entity\NotificacionNovedad", mappedBy="novedad")
     */
    private $eventos;
    
    /**
     * @var MultiTenantTenantInterface
     *
     * @ORM\ManyToOne(targetEntity="Siesc\AppBundle\Entity\Tenant")
     */
    protected $tenant;

    
    public function __construct()
    {
        // default state
        $this->estado = "nueva";
        $this->eventos = new ArrayCollection();
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
     * Set fechaDesde
     *
     * @param \DateTime $fechaDesde
     * @return Novedad
     */
    public function setFechaDesde($fechaDesde)
    {
        $this->fechaDesde = $fechaDesde;

        return $this;
    }

    /**
     * Get fechaDesde
     *
     * @return \DateTime 
     */
    public function getFechaDesde()
    {
        return $this->fechaDesde;
    }

    /**
     * Set fechaHasta
     *
     * @param \DateTime $fechaHasta
     * @return Novedad
     */
    public function setFechaHasta($fechaHasta)
    {
        $this->fechaHasta = $fechaHasta;

        return $this;
    }

    /**
     * Get fechaHasta
     *
     * @return \DateTime 
     */
    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Novedad
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param \Siesc\PartesBundle\Entity\CargoDocente $cargoDocente
     *
     * @return $this
     */
    public function setCargoDocente($cargoDocente)
    {
        $this->cargoDocente = $cargoDocente;
        return $this;
    }

    /**
     * @return \Siesc\PartesBundle\Entity\CargoDocente
     */
    public function getCargoDocente()
    {
        return $this->cargoDocente;
    }

    /**
     * @param \Siesc\PartesBundle\Entity\SituacionRevista $revista
     *
     * @return $this
     */
    public function setRevista($revista)
    {
        $this->revista = $revista;
        return $this;
    }

    /**
     * @return \Siesc\PartesBundle\Entity\SituacionRevista
     */
    public function getRevista()
    {
        return $this->revista;
    }

    /**
     * @param \Siesc\PartesBundle\Entity\TipoNovedad $tipo
     *
     * @return $this
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * @return \Siesc\PartesBundle\Entity\TipoNovedad
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $estado
     *
     * @return $this
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    public function __toString()
    {
        return sprintf('%s - %s', $this->getTipo(), $this->getCargoDocente()->getDocente());
    }

    /**
     * @param \Siesc\PartesBundle\Entity\CierreNovedades $cierre
     *
     * @return $this
     */
    public function setCierre($cierre)
    {
        $this->cierre = $cierre;
        return $this;
    }

    /**
     * @return \Siesc\PartesBundle\Entity\CierreNovedades
     */
    public function getCierre()
    {
        return $this->cierre;
    }

    /**
     * @param \Siesc\AppBundle\Entity\Docente $secretario
     *
     * @return $this
     */
    public function setSecretario($secretario)
    {
        $this->secretario = $secretario;
        return $this;
    }

    /**
     * @return \Siesc\AppBundle\Entity\Docente
     */
    public function getSecretario()
    {
        return $this->secretario;
    }

    /**
     * @param \Siesc\AppBundle\Entity\NotificacionNovedad[] $eventos
     *
     * @return $this
     */
    public function setEventos($eventos)
    {
        $this->eventos = $eventos;
        return $this;
    }

    /**
     * @return \Siesc\AppBundle\Entity\NotificacionNovedad[]
     */
    public function getEventos()
    {
        return $this->eventos;
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
