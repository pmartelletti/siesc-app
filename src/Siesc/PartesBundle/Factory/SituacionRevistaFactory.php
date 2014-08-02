<?php

namespace Siesc\PartesBundle\Factory;

use Siesc\PartesBundle\Entity\SituacionRevista;

class SituacionRevistaFactory
{

    /**
     * @param $data
     * @return SituacionRevista
     */
    public function createFrom($data)
    {
        if ($data instanceof SituacionRevista) {
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
        return new SituacionRevista();
    }

}
