<?php

namespace Siesc\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tahoe\Bundle\MultiTenancyBundle\Model\TenantAwareInterface;
use Tahoe\Bundle\MultiTenancyBundle\Model\TenantTrait;


/**
 * Curso
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Curso implements TenantAwareInterface
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
     * @ORM\ManyToOne(targetEntity="Colegio")
     */
    private $colegio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="habilitado", type="boolean")
     */
    private $habilitado;
    
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
     * @return Curso
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
     * Set seccion
     *
     * @param integer $seccion
     * @return Curso
     */
    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;
    
        return $this;
    }

    /**
     * Get seccion
     *
     * @return integer 
     */
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * Set habilitado
     *
     * @param boolean $habilitado
     * @return Curso
     */
    public function setHabilitado($habilitado)
    {
        $this->habilitado = $habilitado;
    
        return $this;
    }

    /**
     * Get habilitado
     *
     * @return boolean 
     */
    public function getHabilitado()
    {
        return $this->habilitado;
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