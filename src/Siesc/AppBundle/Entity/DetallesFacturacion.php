<?php

namespace Siesc\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tahoe\Bundle\MultiTenancyBundle\Model\MultiTenantTenantInterface;

/**
 * Class DetallesFacturacion
 * @package Siesc\AppBundle\Entity
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class DetallesFacturacion
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
     * @ORM\Column(name="razonSocial", type="string", length=255)
     */
    private $razonSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="condicionIva", type="string", length=255)
     */
    private $condicionIva;

    /**
     * @var string
     *
     * TODO: agregar CUIT validator aca
     *
     * @ORM\Column(name="cuit", type="string", length=255)
     */
    private $cuit;

    /**
     * @var Direccion
     * @ORM\ManyToOne(targetEntity="Direccion", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $domicilio;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * @param string $razonSocial
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;
    }

    /**
     * @return Direccion
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * @param Direccion $domicilio
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;
    }

    /**
     * @return string
     */
    public function getCondicionIva()
    {
        return $this->condicionIva;
    }

    /**
     * @param string $condicionIva
     */
    public function setCondicionIva($condicionIva)
    {
        $this->condicionIva = $condicionIva;
    }

    /**
     * @return string
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * @param string $cuit
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;
    }

    /**
     * @return MultiTenantTenantInterface
     */
    public function getTenant()
    {
        return $this->tenant;
    }

    /**
     * @param MultiTenantTenantInterface $tenant
     */
    public function setTenant($tenant)
    {
        $this->tenant = $tenant;
    }
}