<?php

namespace Siesc\PartesBundle\Factory;

use Siesc\PartesBundle\Entity\Categoria;

class CategoriaFactory
{

    /**
     * @param $data
     * @return Categoria
     */
    public function createFrom($data)
    {
        if ($data instanceof Categoria) {
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
        if (isset($data['requiereHoras'])) {
            $resource->setRequiereHoras($data['requiereHoras']);
        }
        if (isset($data['topeHoras'])) {
            $resource->setTopeHoras($data['topeHoras']);
        }
        if (isset($data['requiereAsignatura'])) {
            $resource->setRequiereAsignatura($data['requiereAsignatura']);
        }
        if (isset($data['funcion'])) {
            $resource->setFuncion($data['funcion']);
        }
        return $resource;
    }

    public static function createNew()
    {
        return new Categoria();
    }

}
