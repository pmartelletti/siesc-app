<?php

namespace Siesc\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tahoe\Bundle\MultiTenancyBundle\Entity\Tenant as BaseTenant;
use Tahoe\Bundle\MultiTenancyBundle\Model\MultiTenantTenantInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_tenant")
 *
 */
class Tenant extends BaseTenant implements MultiTenantTenantInterface
{
    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $contactEmail;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $contactName;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $contactPhone;

    /**
     * @var DetallesFacturacion
     * @ORM\ManyToOne(targetEntity="DetallesFacturacion", cascade={"all"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $detallesFacturacion;

    /**
     * @return string
     */
    public function getContactPhone()
    {
        return $this->contactPhone;
    }

    /**
     * @param string $contactPhone
     */
    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = $contactPhone;
    }

    /**
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * @param string $contactEmail
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    }

    /**
     * @return string
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * @param string $contactName
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    }

    /**
     * @return DetallesFacturacion
     */
    public function getDetallesFacturacion()
    {
        return $this->detallesFacturacion;
    }

    /**
     * @param DetallesFacturacion $detallesFacturacion
     */
    public function setDetallesFacturacion($detallesFacturacion)
    {
        $this->detallesFacturacion = $detallesFacturacion;
    }
}
