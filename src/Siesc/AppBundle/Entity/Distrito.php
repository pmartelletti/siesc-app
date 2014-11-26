<?php

namespace Siesc\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tahoe\Bundle\MultiTenancyBundle\Model\TenantAwareInterface;
use Tahoe\Bundle\MultiTenancyBundle\Model\TenantTrait;

/**
 * Distrito
 *
 * @ORM\Table(name="app_distrito")
 * @ORM\Entity
 */
class Distrito implements TenantAwareInterface
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
     * @var MultiTenantTenantInterface
     *
     * @ORM\ManyToOne(targetEntity="Siesc\AppBundle\Entity\Tenant")
     */
    protected $tenant;

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
     * @return Distrito
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

    public function __toString()
    {
        return $this->getNombre();
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
