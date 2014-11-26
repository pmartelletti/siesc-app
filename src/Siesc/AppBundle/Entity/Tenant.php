<?php

namespace Siesc\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tahoe\Bundle\MultiTenancyBundle\Entity\Tenant as BaseTenant;
use Tahoe\Bundle\MultiTenancyBundle\Model\MultiTenantTenantInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="tenant")
 *
 */
class Tenant extends BaseTenant implements MultiTenantTenantInterface
{
    
}
