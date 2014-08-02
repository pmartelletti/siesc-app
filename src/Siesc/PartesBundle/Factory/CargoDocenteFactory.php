<?php

namespace Siesc\PartesBundle\Factory;

use Siesc\PartesBundle\Entity\CargoDocente;

class CargoDocenteFactory
{

    /**
     * @param $data
     * @return CargoDocente
     */
    public function createFrom($data)
    {
        if ($data instanceof CargoDocente) {
            $resource = $data;
        } else {
            $resource = self::createNew();
        }
        if (isset($data['horas'])) {
            $resource->setHoras($data['horas']);
        }
        if (isset($data['fechaAlta'])) {
            $resource->setFechaAlta($data['fechaAlta']);
        }
        if (isset($data['fechaBaja'])) {
            $resource->setFechaBaja($data['fechaBaja']);
        }
        if (isset($data['docente'])) {
            $resource->setDocente($data['docente']);
        }
        if (isset($data['convenio'])) {
            $resource->setConvenio($data['convenio']);
        }
        if (isset($data['categoria'])) {
            $resource->setCategoria($data['categoria']);
        }
        if (isset($data['colegio'])) {
            $resource->setColegio($data['colegio']);
        }
        return $resource;
    }

    public static function createNew()
    {
        return new CargoDocente();
    }

}
