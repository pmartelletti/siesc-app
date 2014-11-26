<?php

namespace Siesc\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tahoe\Bundle\MultiTenancyBundle\Model\TenantAwareInterface;
use Tahoe\Bundle\MultiTenancyBundle\Model\TenantTrait;

/**
 * Direccion
 *
 * @ORM\Table(name="app_direccion")
 * @ORM\Entity
 */
class Direccion implements TenantAwareInterface
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
     * @ORM\Column(name="calle", type="string", length=255)
     */
    private $calle;

    /**
     * @var integer
     *
     * @ORM\Column(name="altura", type="integer")
     */
    private $altura;

    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=255)
     */
    private $localidad;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoPostal", type="string", length=255)
     */
    private $codigoPostal;

    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=255)
     */
    private $provincia;
    
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
     * Set calle
     *
     * @param string $calle
     * @return Direccion
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set altura
     *
     * @param integer $altura
     * @return Direccion
     */
    public function setAltura($altura)
    {
        $this->altura = $altura;

        return $this;
    }

    /**
     * Get altura
     *
     * @return integer 
     */
    public function getAltura()
    {
        return $this->altura;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     * @return Direccion
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set codigoPostal
     *
     * @param string $codigoPostal
     * @return Direccion
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return string 
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     * @return Direccion
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    public function __toString()
    {
        return sprintf("%s %d, %s %s, %s",
            $this->calle, $this->altura, $this->codigoPostal, $this->localidad, $this->provincia
        );
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
