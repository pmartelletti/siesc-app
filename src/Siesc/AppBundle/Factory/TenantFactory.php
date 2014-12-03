<?php

namespace Siesc\AppBundle\Factory;

use Siesc\AppBundle\Entity\Tenant;

class TenantFactory
{
    /**
     * @param $data
     * @return Tenant
     */
    public function createFrom($data)
    {
        if ($data instanceof Tenant) {
            $resource = $data;
        } else {
            $resource = self::createNew();
        }
        if (isset($data['name'])) {
            $resource->setName($data['name']);
        }
        if (isset($data['subdomain'])) {
            $resource->setCodigo($data['subdomain']);
        }
        return $resource;
    }
    
    public static function createNew()
    {
        return new Tenant();
    }
}

