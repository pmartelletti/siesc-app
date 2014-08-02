<?php

namespace Siesc\AppBundle\Factory;

use Siesc\AppBundle\Entity\Colegio;

class ColegioFactory
{

    /**
     * @param $data
     * @return Colegio
     */
    public function createFrom($data)
    {
        if ($data instanceof Colegio) {
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
        if (isset($data['porcentajeAporteEstatal'])) {
            $resource->setPorcentajeAporteEstatal($data['porcentajeAporteEstatal']);
        }
        if (isset($data['telefono'])) {
            $resource->setTelefono($data['telefono']);
        }
        if (isset($data['cuit'])) {
            $resource->setCuit($data['cuit']);
        }
        if (isset($data['distrito'])) {
            $resource->setDistrito($data['distrito']);
        }
        if (isset($data['funcion'])) {
            $resource->setFuncion($data['funcion']);
        }
        if (isset($data['direccion'])) {
            $resource->setDireccion($data['direccion']);
        }
        return $resource;
    }

    public static function createNew()
    {
        return new Colegio();
    }

}
