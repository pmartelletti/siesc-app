<?php

namespace Siesc\AppBundle\Entity;


use Tahoe\Bundle\MultiTenancyBundle\Entity\Tenant as BaseTenant;
use Tahoe\Bundle\MultiTenancyBundle\Model\MultiTenantTenantInterface;


class Tenant extends BaseTenant implements MultiTenantTenantInterface
{
    
}
