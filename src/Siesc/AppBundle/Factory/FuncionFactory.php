<?php

namespace Siesc\AppBundle\Factory;

use Siesc\AppBundle\Entity\Funcion;

class FuncionFactory
{

    /**
     * @param $data
     * @return Funcion
     */
    public function createFrom($data)
    {
        if ($data instanceof Funcion) {
            $resource = $data;
        } else {
            $resource = self::createNew();
        }
        if (isset($data['nombre'])) {
            $resource->setNombre($data['nombre']);
        }
        if (isset($data['codigo'])) {
            $resource->setCodigo($data['codigo']);
        }
        return $resource;
    }

    public static function createNew()
    {
        return new Funcion();
    }

}
