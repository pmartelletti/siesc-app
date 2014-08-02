<?php

namespace Siesc\PartesBundle\Factory;

use Siesc\PartesBundle\Entity\Cargo;

class CargoFactory
{

    /**
     * @param $data
     * @return Cargo
     */
    public function createFrom($data)
    {
        if ($data instanceof Cargo) {
            $resource = $data;
        } else {
            $resource = self::createNew();
        }
        if (isset($data['nombre'])) {
            $resource->setNombre($data['nombre']);
        }
        return $resource;
    }

    public static function createNew()
    {
        return new Cargo();
    }

}
