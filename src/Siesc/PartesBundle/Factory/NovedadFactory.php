<?php

namespace Siesc\PartesBundle\Factory;

use Siesc\PartesBundle\Entity\Novedad;

class NovedadFactory
{

    /**
     * @param $data
     * @return Novedad
     */
    public function createFrom($data)
    {
        if ($data instanceof Novedad) {
            $resource = $data;
        } else {
            $resource = self::createNew();
        }
        if (isset($data['fechaDesde'])) {
            $resource->setFechaDesde($data['fechaDesde']);
        }
        if (isset($data['fechaHasta'])) {
            $resource->setFechaHasta($data['fechaHasta']);
        }
        if (isset($data['observaciones'])) {
            $resource->setObservaciones($data['observaciones']);
        }
        if (isset($data['tipo'])) {
            $resource->setTipo($data['tipo']);
        }
        if (isset($data['cargoDocente'])) {
            $resource->setCargoDocente($data['cargoDocente']);
        }
        if (isset($data['revista'])) {
            $resource->setRevista($data['revista']);
        }
        if (isset($data['funcion'])) {
            $resource->setFuncion($data['funcion']);
        }
        return $resource;
    }

    public static function createNew()
    {
        return new Novedad();
    }

}
