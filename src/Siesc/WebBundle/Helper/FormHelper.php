<?php

namespace Siesc\WebBundle\Helper;


class FormHelper
{
    public static function collectionToOptions($collection, $addOption = false)
    {
        $res = "<option value=''>-</option>";
        foreach($collection as $item) {
            $res .= sprintf("<option value='%s'>%s</option>", $item->getId(), $item);
        }
        if ($addOption) {
            $res .= "<option value='add-cargo'>Agregar Cargo Docente al convenio</option>";
        }
        return $res;
    }
} 