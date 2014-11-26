<?php

namespace Siesc\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tahoe\Bundle\MultiTenancyBundle\Model\TenantAwareInterface;
use Tahoe\Bundle\MultiTenancyBundle\Model\TenantTrait;

/**
 * Colegio
 *
 * @ORM\Table(name="app_colegio")
 * @ORM\Entity
 */
class Colegio implements TenantAwareInterface
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $distrito;

    /**
     * @var string
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $porcentajeAporteEstatal;

    /**
     * @ORM\ManyToOne(targetEntity="Siesc\AppBundle\Entity\Funcion")
     */
    private $funcion;

    /**
     * @ORM\ManyToOne(targetEntity="Siesc\AppBundle\Entity\Direccion", cascade={"all"})
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $cuit;
       
    /**
     * @var MultiTenantTenantInterface
     *
     * @ORM\ManyToOne(targetEntity="Siesc\AppBundle\Entity\Tenant")
     */
    protected $tenant;
    

    public  function __toString() {
        $nombre = $this->getNombre();

        return isset($nombre) ? $nombre : "";
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
     * Set nombre
     *
     * @param string $nombre
     * @return Seccion
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Seccion
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param string $cuit
     *
     * @return $this
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;
        return $this;
    }

    /**
     * @return string
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * @param mixed $direccion
     *
     * @return $this
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $distrito
     *
     * @return $this
     */
    public function setDistrito($distrito)
    {
        $this->distrito = $distrito;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDistrito()
    {
        return $this->distrito;
    }

    /**
     * @param mixed $funcion
     *
     * @return $this
     */
    public function setFuncion($funcion)
    {
        $this->funcion = $funcion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFuncion()
    {
        return $this->funcion;
    }

    /**
     * @param string $porcentajeAporteEstatal
     *
     * @return $this
     */
    public function setPorcentajeAporteEstatal($porcentajeAporteEstatal)
    {
        $this->porcentajeAporteEstatal = $porcentajeAporteEstatal;
        return $this;
    }

    /**
     * @return string
     */
    public function getPorcentajeAporteEstatal()
    {
        return $this->porcentajeAporteEstatal;
    }

    /**
     * @param string $telefono
     *
     * @return $this
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
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