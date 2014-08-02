<?php

namespace Siesc\AppBundle\Factory;

use Siesc\AppBundle\Entity\Distrito;

class DistritoFactory
{

    /**
     * @param $data
     * @return Distrito
     */
    public function createFrom($data)
    {
        if ($data instanceof Distrito) {
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
        return new Distrito();
    }

}
