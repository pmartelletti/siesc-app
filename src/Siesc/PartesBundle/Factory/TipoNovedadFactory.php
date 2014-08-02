<?php

namespace Siesc\PartesBundle\Factory;

use Siesc\PartesBundle\Entity\TipoNovedad;

class TipoNovedadFactory
{

    /**
     * @param $data
     * @return TipoNovedad
     */
    public function createFrom($data)
    {
        if ($data instanceof TipoNovedad) {
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
        return new TipoNovedad();
    }

}
