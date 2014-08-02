<?php

namespace Siesc\PartesBundle\Factory;

use Siesc\PartesBundle\Entity\Convenio;

class ConvenioFactory
{

    /**
     * @param $data
     * @return Convenio
     */
    public function createFrom($data)
    {
        if ($data instanceof Convenio) {
            $resource = $data;
        } else {
            $resource = self::createNew();
        }
        if (isset($data['codigo'])) {
            $resource->setCodigo($data['codigo']);
        }
        if (isset($data['nombre'])) {
            $resource->setNombre($data['nombre']);
        }
        if (isset($data['funcion'])) {
            $resource->setFuncion($data['funcion']);
        }
        return $resource;
    }

    public static function createNew()
    {
        return new Convenio();
    }

}
